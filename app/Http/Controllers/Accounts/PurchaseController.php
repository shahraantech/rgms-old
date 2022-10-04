<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\AccountHead;
use App\Models\CoaMapping;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Level_1;
use App\Models\Product;
use App\Models\Society;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Purchase;
use Google\Service\AndroidPublisher\Resource\Purchases;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Null_;


class PurchaseController extends Controller
{
    public function index(Request $request)
    {


        if ($request->isMethod('post')) {

             $input = $request->all();
            $rules = array(
                'vendor_id' => 'required',
                'project_id' => 'required',
                'item_id' => 'required',
                'reg_no' => 'required',
                'qty' => 'required',
                'price' => 'required',
                'sale_price' => 'required',
                'grand_total' => 'required',
            );
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            //cheking file already exist or not

            if ($input['item_id'] != '') {
                for ($c = 0; $c < count($input['item_id']); $c++) {
                    $pur = Purchase::where('project_id', $request->project_id)->where('reg_no', $input['reg_no'][$c])->get();
                    if ($pur->count() > 0) {
                        return response()->json(['errors' => 'This File# Already Exist'], 200);

                    }
                }
            }

            $ac_type = 'vendors';
            $account_id = $request->vendor_id;
            $pur_date = $request->pur_date;

            $amount = $request->grand_total;
            $narration = $request->comments;


            $inv = new Invoice();
            $inv->ac_id = $account_id;
            $inv->auth_id = Auth::id();
            $inv->ac_type = $ac_type;
            $inv->inv_type = 'purchase';
            $inv->amount = $amount;
            $inv->amount_type = 'cr';
            $inv->comment = $request->comments;
            $inv->date = $pur_date;
            $inv->save();
            $inv_id = $inv->id;


            $location_id=Employee::getEmpBranchId();
            $vGroup=Vendor::getVendorGroup($account_id);
            //update balance
            $current_balance = updateCustomerVendorBalance($request->vendor_id, $ac_type = $ac_type, $amount, $trans_type = 'cr');

            //update Account Head balance
           //$data=Level_1::chekCoaLevel($request);
            $purchase=CoaMapping::getModuleHeadAndLevel('purchase');
            $vendor=CoaMapping::getModuleHeadAndLevel('vendors');

            //save transaction
            $trans_id = saveTransaction($inv_id, $mode = 'purchase', $file_id = NULL, $against = NULL, $location_id, $amount, $narration, $pur_date, $trans_type = 'purchase');


            // save ledger for credits
            saveLedger($trans_id->id,$vendor['lHeadId'], $account_id, $ac_type, $ledger_type = 'cr', $amount, $current_balance,$vendor['coa_level']);
            // save ledger for debits
            saveLedger($trans_id->id, $purchase['lHeadId'], $account_id = NULL, $ac_type = 'coa-head', $ledger_type = 'dr', $amount, 0,$purchase['coa_level']);

            //saveLedger();
            if ($input['item_id'] != '') {

                for ($c = 0; $c < count($input['item_id']); $c++) {


                    // update stock
                    //$pur = Purchase::where('item_id', $input['item_id'][$c])->where('reg_no',$input['reg_no'][$c])->first();
                    $pur = Purchase::where('project_id', $request->project_id)->where('reg_no', $input['reg_no'][$c])->get();
                    //if ($pur && $pur->avl_qty > 0) {
                    if ($pur->count() > 0) {
                        return response()->json(['errors' => 'This File# Already Exist'], 200);
                        return Redirect::back()->withSuccess(['success', 'Same File# Already Exist']);
                        //updateStock($input['item_id'][$c], 1, $action = 1);
                    } else {

                        if ($input['reg_no'][$c]) {
                            //reg no with alpha bets

                            $alphabet =Purchase::getAlphaBetOfRegNo($input['reg_no'][$c]);
                            $digits= Purchase::getRegNoDigits($input['reg_no'][$c]);

                            for ($q = 0; $q < $input['qty'][$c]; $q++) {
                                $digitsInc=$digits+$q;
                                $regNew=$alphabet.$digitsInc;

                                $pur = new Purchase();
                                $pur->inv_no = $inv->id;
                                $pur->item_id = $input['item_id'][$c];
                                $pur->project_id = $request->project_id;
                                $pur->reg_no =$regNew;// $input['reg_no'][$c] + $q;
                                $pur->qty = 1;
                                $pur->avl_qty = 1;
                                $pur->pur_price = $input['price'][$c];
                                $pur->stamp= $input['stamp'][$c];
                                $pur->v_group = $vGroup;
                                $pur->sale_price = $input['sale_price'][$c];
                                $pur->save();
                            }
                        } else {

                            $pur = new Purchase();
                            $pur->inv_no = $inv->id;
                            $pur->item_id = $input['item_id'][$c];
                            $pur->qty = $input['qty'][$c];
                            $pur->avl_qty = $input['qty'][$c];
                            $pur->price = $input['price'][$c];
                            $pur->sale_price = $input['sale_price'][$c];
                            $pur->save();
                        }
                    }
                }
            }
            return response()->json(['success' => 'Record save successfully'], 200);
            return Redirect::back()->withSuccess(['success', 'Purchase items save successfully']);
        }

        $data['vendors'] = Vendor::all();
        $data['society'] = Society::all();
        $data['products'] = Product::all();
        $data['ac_heads'] = AccountHead::all();
        $data['l1Head'] = Level_1::getLevel1();
        $data['invNo'] = Invoice::max('id');
        $data['invNo'] += 1;

        return view('accounts.purchase.index', compact('data'));
    }

    //getPurchase
    public function getPurchase(Request $request)
    {
            $qry = Invoice::with('supplier')
            ->where('inv_type', 'purchase')
            ->where('auth_id', Auth::id())
            ->orderBy('id', 'DESC');
            if ($request->isMethod('post')) {

            $qry->when($request->from, function ($query, $from) {
                return $query->where('invoices.created_at', '>=', $from);
            });

            $qry->when($request->to, function ($query, $to) {
                return $query->where('invoices.created_at', '<=', $to);
            });
        }
            $data['purchaseList'] = $qry->get();
            return view('accounts.purchase.purchase-list')->with(compact('data'));
    }


    public function viewPurchase($inv_id)
    {
        $data['purchase'] = Purchase::where('inv_no', $inv_id)->get();
        $data['products'] = Product::all();
        return view('accounts.purchase.view-purchase', compact('data'));
    }

    public function viewPurchaseDelete(Request $request)
    {
        $pur = Purchase::find($request->id);
        if ($pur->delete()) {
            return response()->json([
                'success' => 'purchase deleted successfully',
            ]);
        }
    }

    public function viewPurchaseEdit(Request $request)
    {
        $pur = Purchase::find($request->id);
        $prod = Product::all();
        return response()->json([
            'pur' => $pur,
            'prod' => $prod,
        ]);
    }

    public function viewPurchaseUpdate(Request $request)
    {
        $pur = Purchase::find($request->purchase_id);
        $pur->item_id = $request->item_id;
        $pur->qty = $request->qty;
        $pur->pur_price = $request->pur_price;
        $pur->sale_price = $request->sale_price;
        if ($pur->save()) {
            return response()->json(['success' => 'purchase  updated successully'], 200);
        }
    }


    //getProductPriceAndInfo

    public function getProductPriceAndInfo(Request $request){
        $purchase_id=$request->purchase_id;
        $res=Purchase::getProductPriceAndInfo($purchase_id);
        if($res){
            return $res;
        }else{
            return 0;
        }

    }
}
