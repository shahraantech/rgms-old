<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Level_1;
use App\Models\Level_2;
use App\Models\Level_3;
use App\Models\Level_4;
use App\Models\Level_5;
use App\Models\Purchase;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    //saleReport


    public function saleReport(Request $request)
    {
         $data['sale_invoices'] = Invoice::join('clients', 'clients.id', 'invoices.ac_id')
            ->where('invoices.ac_type', 'clients')
            ->where('inv_type', 'sale')
            ->where('invoices.auth_id', Auth::id())
            ->select('clients.name', 'invoices.*')
            ->orderBy('invoices.id', 'DESC')
            ->get();
        return view('accounts.reports.sale-report')->with(compact('data'));
    }


    //purchaseReport

    public function purchaseReport(Request $request)
    {


        $qry = Invoice::join('vendors', 'vendors.id', 'invoices.ac_id');
        $qry = $qry->where('invoices.ac_type', 'vendors');
        $qry = $qry->where('inv_type', 'purchase');
        $qry = $qry->select('vendors.name', 'invoices.*');
        $qry = $qry->orderBy('invoices.id', 'DESC');
        $data['purchase_invoices'] = $qry->get();

        return view('accounts.reports.purchase-report')->with(compact('data'));
    }


    //invoiceDetails
    public function invoiceDetails($inv_id,$inv_type)
    {

        if ($inv_type == 'purchase-details') {
            $qry = Purchase::query();
            $qry = $qry->join('products', 'products.id', 'purchases.item_id');
            $qry = $qry->where('purchases.inv_no', decrypt($inv_id));
        } else {
            $qry = InvoiceItem::query();
            $qry = $qry->with('product');
            $qry = $qry->join('purchases', 'invoice_items.purchase_id', 'purchases.id');
            $qry = $qry->where('invoice_items.inv_no', decrypt($inv_id));
        }
         $data['invoice_items'] = $qry->get();
         $data['invoice'] ='Sale';
        return view('accounts.reports.invoice-details')->with(compact('data'));
    }


    //dailySummary

    public function dailySummary(Request $request)
    {

        //Multiple Filter Query...
        $qry = Transaction::query();

        if ($request->isMethod('post')) {

            $qry = $qry->when($request->ac_type, function ($query, $ac_type) {
                return $query->where('transactions.ac_type', $ac_type);
            });

            $qry = $qry->when($request->ac_id, function ($query, $ac_id) {
                return $query->where('transactions.ac_id', $ac_id);
            });

            $qry = $qry->when($request->from, function ($query, $from) {
                return  $query->whereDay('transactions.created_at', date('d', strtotime($from)));
            });
        }

        $qry->OrderBy('id','DESC');
        $qry->where('inv_id',0);
        $data['transaction'] = $qry->get();
        return view('accounts.reports.daily-summary')->with(compact('data'));
    }

    //lossProfitReport
    public function lossProfitReport(Request $request)
    {

        $data['purchase'] = Invoice::where('inv_type', 'purchase')->sum('amount');
        $data['sale'] = Invoice::where('inv_type', 'sale')->sum('amount');
        $data['exp'] = Transaction::where('mode', 'expense')->sum('amount');

        return view('accounts.reports.loss-profit-report')->with(compact('data'));
    }

    //coaReport

    public function coaReport(Request $request)
    {

        return view('accounts.reports.coa-report');
    }

    //todaySummary

    public function todaySummary(Request $request)
    {
        $data['payAbale'] = Invoice::where('inv_type', 'purchase')->join('vendors', 'vendors.id', 'invoices.ac_id')
            ->select('invoices.*', 'vendors.name')
            ->whereDate('invoices.created_at', Carbon::today())
            ->orderBy('id','DESC')
            ->get();

        // today paid
        $qry= Transaction::query();
        $qry->where('inv_id',0);
        $qry->where('trans_type','cr');
        $qry->where('mode','!=','expense');
//        $qry->orWhere([['ac_type','CLIENTS'],['ac_type','VENDORS']]);
        $qry->OrderBy('id','DESC');
        $qry->whereDate('created_at', Carbon::today());
         $data['todayPaid']= $qry->get();

        // today Received
        $qry= Transaction::query();
        $qry->where('inv_id',0);
        $qry->where('trans_type','dr');
        $qry->where('mode','!=','deposit');
//        $qry->orWhere([['ac_type','CLIENTS'],['ac_type','VENDORS']]);
        $qry->whereDate('created_at', Carbon::today());
        $qry->OrderBy('id','DESC');
        $data['todayReceipts']= $qry->get();

         $data['receiveAble'] = Invoice::where('inv_type', 'sale')->join('clients', 'clients.id', 'invoices.ac_id')
            ->select('invoices.*', 'clients.name')
            ->whereDate('invoices.created_at', Carbon::today())
            ->get();

         $data['bankPayments'] = Transaction::join('account_summaries', 'account_summaries.transaction_id', 'transactions.id')
            ->join('banks', 'banks.id', 'account_summaries.bank_branch_id')
            ->select('transactions.*', 'banks.bank_name')
            ->where('transactions.mode', 'cheque')
            ->where('transactions.trans_type', 'cr')
            ->get();

        $data['bankReceipts'] = Transaction::join('account_summaries', 'account_summaries.transaction_id', 'transactions.id')
            ->join('banks', 'banks.id', 'account_summaries.bank_branch_id')
            ->select('transactions.*', 'banks.bank_name')
            ->where('transactions.mode', 'cheque')
            ->where('transactions.trans_type', 'dr')
            ->get();

        $data['exp'] = Transaction::with('acname.actype','headname')->where('mode', 'expense')->get();

        return view('accounts.reports.today-summary')->with(compact('data'));
    }


    //monthlyProfitLossReport
    public function monthlyProfitLossReport(Request $request)
    {
        $qry = Invoice::query();
        if ($request->isMethod('post')) {

            $qry->when($request->search_month, function ($query, $search_month) {
                return $query->whereMonth('created_at', $search_month);
            });

            $qry->when($request->year, function ($query, $year) {
                return $query->whereYear('created_at', $year);
            });
        }

         $qry = $qry->where('inv_type', 'sale')->get();
        $data['profitReport'] = collect([]);

        foreach ($qry as $inv) {

             $inv_item = InvoiceItem::with('product')->where('inv_no', $inv->id)->get();
            foreach ($inv_item as $inv_item) {

                $pur = Purchase::where('item_id', $inv_item->item_id)->where('id', $inv_item->purchase_id)->select('pur_price', 'sale_price')->first();
                $profit =  ($pur->sale_price * $inv_item->qty) - ($pur->pur_price * $inv_item->qty);
                $array = array(
                    'p_name' => $inv_item->product['item'],
                    'qty' => $inv_item->qty,
                    'pur_price' => $pur->pur_price,
                    'sale_price' => $pur->sale_price,
                    'profit' => $profit,
                    'created_at' => $inv_item->created_at,
                );
                $data['profitReport']->push($array);
            }
        };

        return view('accounts.reports.monthly-loss-profit-report')->with(compact('data'));
    }

    //balance sheet
    public function balanceSheet($head_id,$level){

        $data['coa'] = collect([]);

        if($level==1) {
            $level1 = Level_1::get();
            foreach ($level1 as $l1) {
               $lBalance = Level_1::getLevelBalance($l1->id, $level);

                $array = array(
                    'coa_level' => 2,
                    'coa_head_id' => $l1->id,
                    'coa_head' => $l1->level_head,
                    'coa_balance' => $lBalance,
                );
                $data['coa']->push($array);
            }
        }

        if($level==2) {

            $level2 = Level_2::where('level_one_id',$head_id)->get();
            foreach ($level2 as $l2) {
                $lBalance = Level_1::getLevelBalance($l2->id, $level);
                $array = array(
                    'coa_level' => 3,
                    'coa_head_id' => $l2->id,
                    'coa_head' => $l2->level_two_head,
                    'coa_balance' => $lBalance,
                );
                $data['coa']->push($array);
            }
        }


        if($level==3) {

              $level3 = Level_3::where('level_two_id',$head_id)->get();
            foreach ($level3 as $l3) {
                $lBalance = Level_1::getLevelBalance($l3->id, $level);
                $array = array(
                    'coa_level' =>4,
                    'coa_head_id' => $l3->id,
                    'coa_head' => $l3->level_three_head,
                    'coa_balance' => $lBalance,
                );
                $data['coa']->push($array);
            }
        }


        if($level==4) {
            $level4 = Level_4::where('level_three_id',$head_id)->get();
            foreach ($level4 as $l4) {
                $lBalance = Level_1::getLevelBalance($l4->id, $level);
                $array = array(
                    'coa_level' =>5,
                    'coa_head_id' => $l4->id,
                    'coa_head' => $l4->level_four_head,
                    'coa_balance' => $lBalance,
                );
                $data['coa']->push($array);
            }
        }


        if($level==5) {
            $level5 = Level_5::where('level_four_id',$head_id)->get();
            foreach ($level5 as $l5) {
                $lBalance = Level_1::getLevelBalance($l5->id, $level);
                $array = array(
                    'coa_level' =>6,
                    'coa_head_id' => $l5->id,
                    'coa_head' => $l5->level_five_head,
                    'coa_balance' => $lBalance,
                );
                $data['coa']->push($array);
            }
        }

        return view('accounts.reports.balance-sheet')->with(compact('data'));
    }

    //commissionReport

    public function commissionReport(Request $request){

        $comm=Commission::getCommission();
        $data['commission'] = collect([]);

            foreach ( $comm as $row) {
                $emp=Employee::find($row->sp_id);
                $array = array(
                    'sp_name' => $emp->name,
                    'inv' => $row->inv_id,
                    'commission' => $row->commision_amount,
                    'status' => $row->status,
                    'date' => $row->created_at,

                );
                $data['commission']->push($array);
            }
        return view('accounts.reports.commission-reports')->with(compact('data'));
    }
}
