<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\AccountHead;
use App\Models\ApprochedLeads;
use App\Models\AssignedLeads;
use App\Models\City;
use App\Models\Client;
use App\Models\CoaMapping;
use App\Models\Commission;
use App\Models\Employee;
use App\Models\Freelancer;
use App\Models\InvoiceItem;
use App\Models\Lead;
use App\Models\LeadSetting;
use App\Models\LeadsMarketing;
use App\Models\Level_1;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Invoice;
use App\Models\SocialPlatform;
use App\Models\Society;
use App\Models\Temprature;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{

    public function index(Request $request)
    {
        if ($request->isMethod('post')) {

            $input = $request->all();
            $ac_type = 'clients';
            $client_id = $request->client_id;
            $amount = $request->grand_total;
            $narration = $request->comments;
            $sale_date = $request->sale_date;

            $inv = new Invoice();

            $inv->ac_id = $request->client_id;
            $inv->auth_id = Auth::id();
            $inv->ac_type = $ac_type;
            $inv->inv_type = 'sale';
            $inv->amount = $request->grand_total;
            $inv->amount_type = 'dr';
            $inv->discount = $request->disc_amount;
            $inv->discount_perc = $request->disc_perc;
            $inv->date = $request->sale_date;
            $inv->comment =$narration;
            $inv->save();
            $inv_id = $inv->id;


            //update balance
            $current_balance = updateCustomerVendorBalance($client_id, $ac_type = $ac_type, $amount, $trans_type = 'dr');

            //update Account Head balance
            //$data=Level_1::chekCoaLevel($request);
            $sale = CoaMapping::getModuleHeadAndLevel('sale');
            $customer = CoaMapping::getModuleHeadAndLevel('clients');
            $head_balance = updateAccountHeadBalance($sale['lHeadId'], $amount, $trans_type = 'cr', $sale['coa_level']);
            //$head_balance = updateAccountHeadBalance($customer['lHeadId'], $amount, $trans_type = 'cr', $customer['coa_level']);
            //save transaction
            $location_id = Employee::getEmpBranchId();
            $trans_id = saveTransaction($inv_id, $mode = 'sale', $file_id = NULL, $against = NULL, $location_id, $amount, $narration, $sale_date, $trans_type = 'sale');


            // save ledger for credits for client
            saveLedger($trans_id->id, $customer['lHeadId'], $client_id, $ac_type, $ledger_type = 'dr', $amount, $current_balance, $customer['coa_level']);
            // save ledger for debits
            saveLedger($trans_id->id, $sale['lHeadId'], $account_id = NULL, $ac_type = 'coa-head', $ledger_type = 'cr', $amount, $head_balance, $sale['coa_level']);

            if ($input['item_id'] != '') {

                for ($c = 0; $c < count($input['item_id']); $c++) {

                    //update stock
                    updateStock($input['item_id'][$c], $input['qty'][$c], $action = 0);
                    if ($input['item_id'][$c] != NULL) {
                        //
                        $pur = Purchase::find($input['item_id'][$c]);

                        $pur = Purchase::find($input['item_id'][$c]);

                        $invIt = new InvoiceItem();
                        $invIt->inv_no = $inv->id;
                        $invIt->item_id = $pur->item_id;
                        $invIt->qty = $input['qty'][$c];
                        $invIt->purchase_id = $input['item_id'][$c];
                        $invIt->save();
                    }
                }
            }
            return response()->json(['success' => 'Record save successfully'], 200);
            return Redirect::back()->withSuccess(['success', 'Purchase items save successfully']);
        }
        $data['l1Head'] = Level_1::getLevel1();
        $data['clients'] = Client::all();
        $data['ac_heads'] = AccountHead::all();
        $data['items'] = Purchase::getStock();
        if ($res = Invoice::latest('id')->first()) {
            $data['inv_no'] = $res->id + 1;
        } else {
            $data['inv_no'] = 1;
        }

        return view('accounts.sale.index')->with(compact('data'));
    }
    //bulkSale
    public function bulkSale(Request $request)
    {
        if ($request->isMethod('post')) {

            $input = $request->all();
            $ac_type = 'clients';
            $client_id = $request->client_id;
            $amount = $request->grand_total;
            $narration = $request->comments;
            $sale_date = $request->sale_date;
            $inventoryType =$request->inventory_type;;

            $inv = new Invoice();

            $inv->ac_id = $request->client_id;
            $inv->auth_id = Auth::id();
            $inv->ac_type = $ac_type;
            $inv->inv_type = 'sale';
            $inv->amount = $request->grand_total;
            $inv->amount_type = 'dr';
            $inv->discount = $request->disc_amount;
            $inv->discount_perc = $request->disc_perc;
            $inv->date = $request->sale_date;
            $inv->comment = $narration;
            $inv->save();
            $inv_id = $inv->id;


            //$data=Level_1::chekCoaLevel($request);
            $sale = CoaMapping::getModuleHeadAndLevel('sale');
            $customer = CoaMapping::getModuleHeadAndLevel('clients');

            //save transaction
            $location_id = Employee::getEmpBranchId();
            $trans_id = saveTransaction($inv_id, $mode = 'sale', $file_id = NULL, $against = NULL, $location_id, $amount, $narration, $sale_date, $trans_type = 'sale');


            // save ledger for credits for client
            saveLedger($trans_id->id, $customer['lHeadId'], $client_id, $ac_type, $ledger_type = 'dr', $amount, 0, $customer['coa_level']);
            // save ledger for debits
            saveLedger($trans_id->id, $sale['lHeadId'], $account_id = NULL, $ac_type = 'coa-head', $ledger_type = 'cr', $amount, 0, $sale['coa_level']);

            if ($input['item_id'] != '') {

                for ($c = 0; $c < count($input['item_id']); $c++) {

                    for ($i = 0; $i < $input['qty'][$c]; $i++) {
                        if ($input['item_id'][$c] != NULL) {

                            $qry = Purchase::Query();
                            ($inventoryType==1)?$qry=$qry->where('v_group', 1):'';
                            ($inventoryType==2)?$qry=$qry->where('v_group', 2):'';
                            $qry=$qry->where('item_id', $input['item_id'][$c])->where('avl_qty', '>', 0);
                                $pur=$qry->first();
                            //update stock
                            updateStock($pur->id, 1, $action = 0);

                            $invIt = new InvoiceItem();
                            $invIt->inv_no = $inv->id;
                            $invIt->item_id = $input['item_id'][$c];
                            $invIt->qty = 1;
                            $invIt->purchase_id = $pur->id;
                            $invIt->save();
                        }
                    }
                }
            }
            return response()->json(['success' => 'Record save successfully'], 200);
            return Redirect::back()->withSuccess(['success', 'Purchase items save successfully']);
        }


        $data['clients'] = Client::all();
        $data['items'] = Purchase::getStockForBulkSale();
        if ($res = Invoice::latest('id')->first()) {
            $data['inv_no'] = $res->id + 1;
        } else {
            $data['inv_no'] = 1;
        }

        return view('accounts.sale.bulk-sale')->with(compact('data'));
    }
    //regularSale
    public function regularSale(Request $request)
    {
        if ($request->isMethod('post')) {

            $input = $request->all();
            $ac_type = 'clients';
            $amount = $request->grand_total;
            $remarks = $request->remarks;
            $sale_date = $request->sale_date;

            $client_id = Client::saveClients($request);
            $sale = CoaMapping::getModuleHeadAndLevel('sale');
            $customer = CoaMapping::getModuleHeadAndLevel('clients');
            $commission = CoaMapping::getModuleHeadAndLevel('commission');
            //save transaction
            $location_id = Employee::getEmpBranchId();


            $inv = new Invoice();

            $inv->ac_id = $client_id;
            $inv->auth_id = Auth::id();
            $inv->ac_type = $ac_type;
            $inv->inv_type = 'sale';
            $inv->amount = $request->grand_total;
            $inv->amount_type = 'cr';
            $inv->discount = $request->disc_amount;
            $inv->discount_perc = $request->disc_perc;
            $inv->date = $request->sale_date;
            $inv->comment = $remarks;
            $inv->save();
            $inv_id = $inv->id;


            if ($input['item_id'] != '') {

                for ($c = 0; $c < count($input['item_id']); $c++) {

                    //update stock
                    updateStock($input['item_id'][$c], $input['qty'][$c], $action = 0);
                    if ($input['item_id'][$c] != NULL) {

                        $pur = Purchase::find($input['item_id'][$c]);

                        $invIt = new InvoiceItem();
                        $invIt->inv_no = $inv->id;
                        $invIt->item_id = $pur->item_id;
                        $invIt->qty = $input['qty'][$c];
                        $invIt->purchase_id = $input['item_id'][$c];
                        $invIt->save();
                    }
                }
            }


            $trans_id = saveTransaction($inv_id, $mode = 'sale', $file_id = NULL, $against = NULL, $location_id, $amount, $remarks, $sale_date, $trans_type = 'sale');
            // save ledger for debit for client
            saveLedger($trans_id->id, $customer['lHeadId'], $client_id, $ac_type, $ledger_type = 'dr', $amount, 0, $customer['coa_level']);
//            // save ledger for credits
            saveLedger($trans_id->id, $sale['lHeadId'], $account_id = NULL, $ac_type = 'coa-head', $ledger_type = 'cr', $amount, 0, $sale['coa_level']);

            if ($request->sale_through == 1) {
                $saveComm = Commission::saveCommission($inv_id, $request->dealer_id, $request->sp_id, $request->sp_commission, $request->sp_commission_amount, $client_id);
                // save ledger for commission
                saveLedger($trans_id->id, $commission['lHeadId'], NULL, $ac_type = 'coa-head', 'cr', $amount, 0, $commission['coa_level']);
            }
            return response()->json(['success' => 'Record save successfully'], 200);

        }
        $data['clients'] = Client::all();
        $data['ac_heads'] = AccountHead::all();
        $data['items'] = Purchase::getStock();
        $data['salesPerson'] = getCSR();
        $data['leadsMarketings'] = LeadsMarketing::getAllLeads();
        $data['freeLancers'] = Freelancer::getFreeLancers();
        $data['dealers'] = Client::getDealersAsClients();
        $data['city'] = City::getAllCity();

        return view('accounts.sale.regular-sale')->with(compact('data'));
    }
    //getAvailStock
    public function getAvailStock(Request $request)
    {

        $purchase_id = $request->purchase_id;
        $inv_type = $request->inventory_type;
         $qry = Purchase::Query();
        ($inv_type==1)?$qry=$qry->where('purchases.v_group', 1):'';
        ($inv_type==2)?$qry=$qry->where('purchases.v_group', 2):'';
        $res=$qry-> where('id',$purchase_id)->first();
        return $res;
    }
    //getAvailStockAndSubTotal
    public function getAvailStockAndSubTotal(Request $request)
    {

        $item_id = $request->item_id;
        $inv_type = $request->inventory_type;
        $qty = $request->qty;

        $qry = Purchase::Query();
        $qry=$qry->where('item_id', $item_id);
        ($inv_type==1)?$qry=$qry->where('v_group', 1):'';
        ($inv_type==2)?$qry=$qry->where('v_group', 2):'';
        $qry=$qry->where('avl_qty', '>', 0);
        $avl_qty=$qry->sum('avl_qty');;
        if ($avl_qty < $qty) {
            return response()->json(['error' => 'Stock Low']);
        }

        $qry = Purchase::Query();
        $qry=$qry->where('item_id', $item_id);
        ($inv_type==1)?$qry=$qry->where('v_group', 1):'';
        ($inv_type==2)?$qry=$qry->where('v_group', 2):'';
        $qry=$qry->where('avl_qty', '>', 0);
        $pro=$qry->get();
        $c = 0;
        $subTotal = 0;
        foreach ($pro as $row) {
            $c++;
            if ($c <= $qty) {
                $subTotal = $subTotal + $row->sale_price;
            }
        }
        return response()->json(['subTotal' => $subTotal]);


    }
    //getLeadsMarketings
    public function getLeadsMarketings(Request $request)
    {
        return $res = LeadsMarketing::getAllLeads();
    }
    //saleToLead
    public function saleToLead(Request $request)
    {

        $data['client_id'] = saveLeadClient($request->id);
        if ($request->isMethod('post')) {


            $input = $request->all();
            $ac_type = 'clients';

            $inv = new Invoice();
            $inv->ac_id = $request->client_id;
            $inv->ac_type = $ac_type;
            $inv->inv_type = 'sale';
            $inv->amount = $request->grand_total;
            $inv->amount_type = 'dr';
            $inv->save();
            $inv_id = $inv->id;
            //save transaction

            $current_balance = updateBalance($request->client_id, $ac_type, $amount = $request->grand_total, $trans_type = 'cr');
            //save transaction
            saveTransaction($inv_id, $inv->amount, $transType = 'cr', $ac_id = $request->client_id, $ac_type, $balance = $current_balance, $trans_mode = NULL, $desc = NULL);


            if ($input['item_id'] != '') {

                for ($c = 0; $c < count($input['item_id']); $c++) {
                    //update stock
                    updateStock($input['item_id'][$c], $input['qty'][$c], $action = 0);

                    if ($input['item_id'][$c] != NULL) {

                        $invIt = new InvoiceItem();
                        $invIt->inv_no = $inv->id;
                        $invIt->item_id = $input['item_id'][$c];
                        $invIt->qty = $input['qty'][$c];
                        $invIt->discount = $input['discount'][$c];

                        $invIt->save();
                    }
                }
            }


            return Redirect::back()->withSuccess(['success', 'Purchase items save successfully']);
        }


        $data['clients'] = Client::all();
        $data['items'] = Purchase::with('products')->where('purchases.avl_qty', '>', 0)->get();
        if ($res = Invoice::latest('id')->first()) {
            $data['inv_no'] = $res->id + 1;
        } else {
            $data['inv_no'] = 1;
        }

        return view('accounts.sale.index')->with(compact('data'));
    }
    //customerForm
    public function customerForm($lead_id)
    {
        $data['city'] = City::getAllCity();
        $data['society'] = Society::all();
        $data['items'] = Product::all();
        $data['lead_id'] = decrypt($lead_id);
        $data['leadInfo'] = LeadsMarketing::getLeadsInfo(decrypt($lead_id));
        return view('call-center.sales.customer-form')->with(compact('data'));
    }
    public function customerFormSave(Request $request)
    {
        $request->all();
        $amount = 0;

        $client = new Client();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->cnic = $request->cnic;
        $client->contact = $request->contact;
        $client->city = $request->city_id;
        $client->open_bal = $amount;
        $client->f_name = $request->f_name;
        $client->cnic_image = '';
        $client->project = $request->project_id;
        $client->plot_size = $request->product_id;
        $client->is_dependent = $request->dependent;
        $client->profession = $request->profession;
        $client->age = $request->age;
        $client->marital_status = $request->marital_status;
        $client->sale_price = $request->sale_price;
        $client->processing_fee = $request->processing_fee;
        $client->lead_id = $request->lead_id;

        if ($client->save()) {

            $data = CoaMapping::getModuleHeadAndLevel('clients');
            //save transaction
            $trans_id = saveTransaction(0, 'open balance', NULL, NULL, 1, $amount, 'Customer Account Open', date('Y-m-d'), $trans_type = 'open balance');
            // save ledger for credits for client
            saveLedger($trans_id->id, $data['lHeadId'], $client->id, 'clients', 'dr', $amount, $client->open_bal, $data['coa_level']);
            return response()->json([
                'status' => 200,
                'message' => 'cleint added successfully',
            ]);
        }
    }
    //walkinCustomer
    public function walkinCustomer(Request $request)
    {
        $data['platforms'] = SocialPlatform::all();
        $data['city'] = City::all();
        $data['temp'] = Temprature::all();
        $data['employee'] = Employee::where('status', 1)->get();

        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = array(
                'name' => 'required',
                'contact' => 'required',
                'source_id' => 'required',
                'city_id' => 'required',
            );
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()]);
            }

            if (LeadsMarketing::where('contact', $request->contact)->first()) {
                return response()->json(['errors' => 'This lead already exist'], 200);
            }

            $lead = new LeadsMarketing();
            $lead->name = $request->name;
            $lead->contact = $request->contact;
            $lead->city_id = $request->city_id;
            $lead->platform_id = $request->source_id;
            $lead->user_id = Auth::user()->id;


            if ($lead->save()) {

                $lead_id = encrypt($lead->id);
                return redirect('customer-form/' . $lead_id);
                return response()->json(['success' => 'Lead save successfully'], 200);
            }
        }
        return view('call-center.sales.walkin-customer')->with(compact('data'));
    }
    public function walkinCustomerList()
    {
        $clients = Client::all();
        return view('call-center.sales.walkin-customer-list', get_defined_vars());
    }
    //deliveryNote
    public function deliveryNote($inv_id)
    {
        $data['invType']='SALE';
        $inv_no = decrypt($inv_id);
        $inv = Invoice::find($inv_no);
        $client = Client::find($inv->ac_id);
        $data['clientInfo'] = array(
            'clientName' => $client->name,
            'contact' => $client->contact,
            'address' => $client->address,
            'date' => $inv->date,
            'inv_no' => $inv->id,
        );

        $invItem = InvoiceItem::with('product')->where('inv_no', $inv_no)
            ->groupBy('item_id')->get();
        $data['fileNo']=collect();
        $data['deliveryNotes']=collect([]);
        foreach ($invItem as $invItem) {
            $qty=InvoiceItem::where('inv_no', $inv_no)->where('item_id',$invItem->item_id)->sum('qty');
             $invItemForRegNo=InvoiceItem::where('inv_no', $inv_no)->where('item_id',$invItem->item_id)->get();


             foreach ($invItemForRegNo as $invItemForRegNo) {
                 $pur = Purchase::with('products')->find($invItemForRegNo->purchase_id);
                 $arr = array($pur->reg_no);
                 $data['fileNo']->push($arr);
                 $society = Society::find($pur->project_id);
             }
            $res= str_replace('"', '', $data['fileNo']);
           $filesNo= str_replace (array('[', ']'), '' , $res);


            $arr=array(
                'projectName'=>$society->project_name,
                'qty'=>$qty,
                'files'=>$filesNo,
                'item'=>$pur->products['item'],
            );
            $data['deliveryNotes']->push($arr);
            $data['fileNo']=collect();

        }
        return view('accounts.printer.print-delivery-note')->with(compact('data'));
    }
    //purchaseDeliveryNote
    public function purchaseDeliveryNote($inv_id)
    {
        $data['invType']='PURCHASE';
        $inv_no = decrypt($inv_id);
        $inv = Invoice::find($inv_no);
        $client = Vendor::find($inv->ac_id);
        $data['clientInfo'] = array(
            'clientName' => $client->name,
            'contact' => $client->contact,
            'address' => $client->address,
            'date' => $inv->date,
            'inv_no' => $inv->id,
        );

          $invItem=Purchase::with('products')->where('inv_no', $inv_no)->groupBy('item_id')->get();
        $data['fileNo']=collect();
        $data['deliveryNotes']=collect([]);
        foreach ($invItem as $invItem) {

            $qty=Purchase::where('inv_no',$inv_no)->where('item_id',$invItem->item_id)->sum('qty');
            $filesNo=Purchase::where('inv_no',$inv_no)->where('item_id',$invItem->item_id)->pluck('reg_no');

            $res= str_replace('"', '', $filesNo);
            $filesRegNo= str_replace (array('[', ']'), '' , $res);

            $society =Society::find($invItem->project_id);
             $arr=array(
                'projectName'=>$society->project_name,
                'qty'=>$qty,
                'files'=>$filesRegNo,
                'item'=>$invItem->products['item'],
            );
            $data['deliveryNotes']->push($arr);

        }

        return view('accounts.printer.print-delivery-note')->with(compact('data'));
    }

    //getInventoryOntheBaseOfDealerGroup

    public function getInventoryOntheBaseOfDealerGroup(Request $request)
    {
        $res='';
        $inventType = $request->inventory_type;
        $sale_type = $request->sale_type;
        if($sale_type=='bulk') {
            $res = Purchase::getStockForBulkSale($inventType);
        }
        if($sale_type=='dealer-sale') {
            $res= Purchase::getStock($inventType);
        }
        return $res;
    }
    }

