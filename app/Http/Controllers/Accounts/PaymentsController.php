<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountHead;
use App\Models\BankBranch;
use App\Models\BankCheque;
use App\Models\Client;
use App\Models\CoaMapping;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Ledger;
use App\Models\Level_1;
use App\Models\Product;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Bank;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PaymentsController extends Controller
{
    //payments
    public function payments(Request $request)
    {

        if ($request->isMethod('post')) {

            $request->all();
            $bank_id = $request->bank_id;
            $amount = $request->payment_amount;
            $trans_mode = $request->trans_mode;
            $account_id = $request->ac_id;
            $ac_type = $request->ac_type;
            $company_account_id = $request->company_account_id;
            $date = $request->payment_date;


            $location_id = Employee::getEmpBranchId();
            //save transaction
            $trans = saveTransaction($inv_id = 0, $trans_mode, $file_id = NULL, $against = NULL, $location_id = $location_id, $amount, $request->desc, $date, $trans_type = 'payment',$request->payment_mode);
            //update vendor/customer balance
            $cutomerVendBalance = updateCustomerVendorBalance($account_id, $ac_type, $amount, $trans_type = 'dr');


            if ($trans_mode == 'cash') {
                $data = Account::getAccountHeadId($company_account_id);
            }

            $vendorCustomer = CoaMapping::getModuleHeadAndLevel($ac_type);

            if ($trans_mode != 'cash') {

                if ($request->payment_mode == 2) {
                    BankCheque::saveBankCheque($trans->id, $request);
                }

                if ($request->cheque_status == 1 or $request->cheque_status == NULL) {

                     $data = Account::getBankHeadId($bank_id);
                    // save ledger for bank debits
                    saveLedger($trans->id, $data['lHeadId'], $bank_id, 'bank', $ledger_type = 'cr', $amount, 0, $data['coa_level']);
                }
                // save ledger for c/v account
                saveLedger($trans->id, $vendorCustomer['lHeadId'], $account_id, $ac_type, $ledger_type = 'dr', $amount, $cutomerVendBalance, $vendorCustomer['coa_level']);

            }

            if ($trans_mode == 'cash') {

                //Update company Account
                $compAc = updateCompanyAccount($company_account_id, 'cr', $amount);


                // save ledger for vendor debits
                saveLedger($trans->id, $vendorCustomer['lHeadId'], $account_id, $ac_type, $ledger_type = 'dr', $amount, $cutomerVendBalance, $vendorCustomer['coa_level']);
                // save ledger for account head credits
                saveLedger($trans->id, $data['lHeadId'], $company_account_id, $ac_type = 'company-account', $ledger_type = 'cr', $amount, $compAc->balance, $data['coa_level']);
            }

            return response()->json(['success' => 'Payment added successfully!']);
        }

        $qry = Transaction::query();
        $qry = $qry->join('ledgers', 'transactions.id', 'ledgers.transaction_id');
        $qry = $qry->where('transactions.trans_type', '=', 'payment');
        $qry = $qry->where('transactions.auth_id', Auth::id());
        $qry = $qry->where(function ($q) {
            $q->where('ac_type', 'clients')->orWhere('ac_type', 'vendors');
        });
        $qry = $qry->orderBy('transactions.id', 'DESC');
        $qry = $qry->select('transactions.*', 'ledgers.ac_type', 'ledgers.account_id');
        $data['transaction'] = $qry->get();

        $data['banks'] = BankBranch::getBankBranchBalance();
        $data['accounts'] = Account::getAccounts();
        $data['l1Head'] = Level_1::getLevel1();

        return view('accounts.payments.payments')->with(compact('data'));
    }

    //receipt
    public function receipt(Request $request)
    {


        if ($request->isMethod('post')) {
            $request->all();

            $bank_id = $request->bank_id;
            $company_account_id = $request->company_account_id;
            $amount = $request->payment_amount;
            $date = $request->date;
            $account_id = $request->ac_id;
            $ac_type = $request->ac_type;
            $ac_head_id = $request->ac_head_id;
            $trans_mode = $request->trans_mode;
            $against = $request->against;


            //update vendor/customer balance
            $cutomerVendBalance = updateCustomerVendorBalance($account_id, $ac_type, $amount, $trans_type = 'cr');

            $location_id = Employee::getEmpBranchId();
            if ($company_account_id) {
                $data = Account::getAccountHeadId($company_account_id);
            }


            $vendorCustomer = CoaMapping::getModuleHeadAndLevel($ac_type);
            //$head_balance=updateAccountHeadBalance($data['lHeadId'],$amount,$trans_type='cr',$data['coa_level']);
            //save transaction
            $trans = saveTransaction($inv_id = 0, $trans_mode, $file_id = NULL, $against, $location_id, $amount, $request->desc, $date, $trans_type = 'receipt', $request->payment_mode);

            if ($trans_mode != 'cash') {

                if ($request->payment_mode == 2) {
                    BankCheque::saveBankCheque($trans->id, $request);
                }

                if ($request->cheque_status == 1 or $request->cheque_status == NULL) {
                    $branchBalance = updateBranchBalance($bank_id, $trans_type = 'dr', $amount);
                    $data = Account::getBankHeadId($bank_id);
                    // save ledger for bank debits
                    saveLedger($trans->id, $data['lHeadId'], $bank_id, 'bank', $ledger_type = 'dr', $amount, $branchBalance, $data['coa_level']);
                }

                // save ledger for c/v account
                saveLedger($trans->id, $vendorCustomer['lHeadId'], $account_id, $ac_type, $ledger_type = 'cr', $amount, $cutomerVendBalance, $vendorCustomer['coa_level']);

            }

            if ($trans_mode == 'cash') {

                //Update company Account
                $compAc = updateCompanyAccount($company_account_id, 'dr', $amount);


                // save ledger for account head credits
                saveLedger($trans->id, $data['lHeadId'], $company_account_id, 'company-account', $ledger_type = 'dr', $amount, $compAc->balance, $data['coa_level']);
                // save ledger for vendor debits
                saveLedger($trans->id, $vendorCustomer['lHeadId'], $account_id, $ac_type, $ledger_type = 'cr', $amount, $cutomerVendBalance, $vendorCustomer['coa_level']);
            }

            return response()->json(['success' => 'Amount received successfully!', 'trans_id' => $trans->id]);
        }

        $qry = Transaction::query();
        $qry = $qry->join('ledgers', 'transactions.id', 'ledgers.transaction_id');
        $qry = $qry->where('transactions.trans_type', '=', 'receipt');
        $qry = $qry->where('transactions.auth_id', Auth::id());

        $qry = $qry->where(function ($q) {
            $q->where('ac_type', 'clients')->orWhere('ac_type', 'vendors');
        });
        $qry = $qry->orderBy('transactions.id', 'DESC');
        $qry = $qry->select('transactions.*', 'ledgers.ac_type', 'ledgers.account_id');
        $data['transaction'] = $qry->get();

        $data['banks'] = BankBranch::getBankBranchBalance();
        $data['accounts'] = Account::getAccounts();

        $data['l1Head'] = Level_1::getLevel1();

        return view('accounts.payments.receipts')->with(compact('data'));
    }

    // JV

    public function jv(Request $request)
    {
        if ($request->isMethod('post')) {
             $request->all();
            $amount=$request->amount;

            $location_id = Employee::getEmpBranchId();
            $crAc=Ledger::getCrAccountIdForJv($request);
            $drAc=Ledger::getDrAccountIdForJv($request);

            $trans = saveTransaction($inv_id = 0, 'jv', $file_id = NULL, $against = NULL,$location_id,$amount, $request->remarks, date('Y-m-d'), $trans_type = 'jv');
            // Ledger for Credits
            saveLedger($trans->id, $crAc['headIdAndLevel']['lHeadId'], $crAc['crAccountId'], $crAc['acType'],   'cr', $amount, 0, $crAc['headIdAndLevel']['coa_level']);
            // Ledger for dr
            saveLedger($trans->id, $drAc['headIdAndLevel']['lHeadId'], $drAc['drAccountId'], $drAc['acType'],   'dr', $amount, 0, $drAc['headIdAndLevel']['coa_level']);
            return response()->json(['success' => 'JV created successfully!']);
        }

        $jv=Transaction::where('mode','jv')->orderBy('id','DESC')->get();
        $data['jv'] = collect([]);
        foreach($jv as $jv) {
            $crLedger = Ledger::getCrLedgerAccordingTrans($jv->id);
            $drLedger = Ledger::getDrLedgerAccordingTrans($jv->id);
            $crName = Account::getAcNameAcordingAcType($crLedger['account_id'], $crLedger['ac_type'], $crLedger['coa_level']);
            $drName = Account::getAcNameAcordingAcType($drLedger['account_id'], $drLedger['ac_type'], $drLedger['coa_level']);

            $arr=array(
                'id'=>$jv->id,
                'dr'=>$drName,
                'cr'=>$crName,
                'amount'=>$jv->amount,
                'remarks'=>$jv->desc,
                'date'=>$jv->date,
            );
            $data['jv']->push($arr);
        }

     $data['customer']=Client::getClients();
     $data['banks']=BankBranch::getBankBranches();
     $data['accounts']=Account::getAccounts();
     $data['vendors']=Vendor::getAllVendors();
     $data['level4'] = Level_1::getLevel4();
     $data['liability'] = Level_1::getLevel4();
     $data['assets'] = Level_1::getLevel4();

        return view('accounts.payments.jv')->with(compact('data'));
    }

    //editJv

    public function editJv($trans_id)
    {
         $data['trans'] = Transaction::find($trans_id);
         $data['ledger'] = Ledger::getAllLedgers($trans_id);
        $data['clients'] = Client::getClients();
        $data['vendors'] = Vendor::getAllVendors();
        $data['accounts'] = Account::getAccounts();
        $data['banks'] = BankBranch::getBankBranches();

        $mode = $data['trans']->mode;
        $amount = $data['trans']->amount;

        $desc = $data['trans']->desc;

        $cr_vendor_ac_id=0;
        $dr_vendor_ac_id=0;
        $cr_client_ac_id=0;
        $dr_client_ac_id=0;
        $cr_company_ac_id=0;
        $dr_company_ac_id=0;
        $cr_bank_ac_id=0;
        $dr_bank_ac_id=0;

        foreach ($data['ledger'] as $ledger) {
            if ($ledger->ac_type == 'vendors') {
                ($ledger->ledger_type=='cr')? $cr_vendor_ac_id = $ledger->account_id:$dr_vendor_ac_id = $ledger->account_id;
            }
            if ($ledger->ac_type == 'clients') {
                ($ledger->ledger_type=='cr')? $cr_client_ac_id = $ledger->account_id:$dr_client_ac_id = $ledger->account_id;
            }

            if ($ledger->ac_type == 'company-account') {
                ($ledger->ledger_type=='cr')? $cr_company_ac_id = $ledger->account_id:$dr_company_ac_id = $ledger->account_id;
            }

            if ($ledger->ac_type == 'bank') {
                ($ledger->ledger_type=='cr')? $cr_bank_ac_id = $ledger->account_id:$dr_bank_ac_id = $ledger->account_id;

            }
        }


         $data['edit_rec'] = array(
            'trans_id' => $trans_id,
            'cr_vendor_ac_id' => $cr_vendor_ac_id,
            'dr_vendor_ac_id' => $dr_vendor_ac_id,
            'cr_client_ac_id' => $cr_client_ac_id,
            'dr_client_ac_id' => $dr_client_ac_id,
            'cr_company_ac_id' => $cr_company_ac_id,
            'dr_company_ac_id' => $dr_company_ac_id,
            'cr_bank_ac_id' => $cr_bank_ac_id,
            'dr_bank_ac_id' => $dr_bank_ac_id,
            'amount' => $amount,
            'remarks' => $desc,
        );
        return view('accounts.payments.edit-jv')->with(compact('data'));
    }
    //updateJv
    public function updateJv(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->all();
            $trans_id=$request->hidden_trans_id;

            $crAc=Ledger::getCrAccountIdForJv($request);
            $drAc=Ledger::getDrAccountIdForJv($request);
            $crLedgerId=Ledger::where('transaction_id',$trans_id)->where('ledger_type','cr')->first();
            $drLedgerId=Ledger::where('transaction_id',$trans_id)->where('ledger_type','dr')->first();
            $trans=Transaction::updateTransaction($trans_id,$request);
            $ledgerForCreditors = Ledger::updateLedger($drLedgerId->id, $drAc['headIdAndLevel']['lHeadId'], $drAc['headIdAndLevel']['coa_level'], $drAc['drAccountId'], $drAc['acType'], 'dr', $request->payment_amount);
            //update ledger for credirors
            $ledgerForCreditors = Ledger::updateLedger($crLedgerId->id, $crAc['headIdAndLevel']['lHeadId'], $crAc['headIdAndLevel']['coa_level'], $crAc['crAccountId'], $crAc['acType'], 'cr', $request->payment_amount);
            return response()->json(['success' => 'JV updated successfully!']);
        }
    }


    //PrintReceipt

    public function printReceipt($id)
    {

        $trans = Transaction::find($id);
        if ($trans->inv_id > 0) {
            $pro = Product::where('id', $trans->item_id)->first();
        }
        $user = User::find($trans->auth_id);
        $ledger = Ledger::where('transaction_id', $trans->id)->where('ac_type', 'clients')->first();
        $client = Client::find($ledger->account_id);
        $emp = Employee::find($user->account_id);
        $company = Company::find($emp->company_id);

        $data['transaction'] = array(
            'payment_type' => 'CRV',
            'customer_id' => $client->id,
            'project_name' => 'MSC',//$pro->getprojectname['project_name'],
            'amount' => $trans->amount,
            'reecived_by' => $user->name,
            'client_name' => $client->name,
            'company_name' => $company->name,
        );

        return view('accounts.payments.print-receipts')->with(compact('data'));
    }

    //getClientsFiles

    public function getClientsFiles(Request $request)
    {

        $ac_id = $request->ac_id;
        $qry = Invoice::query();
        $qry->join('invoice_items', 'invoices.id', 'invoice_items.inv_no');
        $qry->join('products', 'products.id', 'invoice_items.item_id');
        $qry->where('invoices.ac_id', $ac_id);
        $qry->where('invoices.ac_type', 'clients');
        $qry->select('products.id', 'products.item');
        return $qry->get();
    }

    public function rv($trans_id)
    {
        $cheque_status = 0;
        $trans = Transaction::find($trans_id);
        $user = User::find($trans->auth_id);
        if ($trans) {
            if ($trans->bank_payment_mode == 2) {
                $cheque_status = BankCheque::getBankChequeStatus($trans_id);
            }
            $crDrName = Ledger::getCrDrAccountName($trans_id);
            $data = array(
                'prepared_by' => $user->name,
                'cheque_status' => $cheque_status,
                'trans_type' => $trans->trans_type,
                'trans_mode' => $trans->mode,
                'cr_name' => ($crDrName['crName']) ? $crDrName['crName'] : '',
                'dr_name' => ($crDrName['drName']) ? $crDrName['drName'] : '',
                'date' => $trans->date,
                'trans_id' => $trans_id,
                'amount' => $trans->amount,
                'remarks' => $trans->desc
            );
            return view('accounts.printer.cash_payment_voucher')->with(compact('data'));
        }
    }

    //editTransaction
    public function editVoucher($voucherType,$trans_id)
    {

        $data['voucherType']=$voucherType;
        $data['trans'] = Transaction::find($trans_id);
        $data['ledger'] = Ledger::getAllLedgers($trans_id);
        $data['clients'] = Client::getClients();
        $data['vendors'] = Vendor::getAllVendors();
        $data['accounts'] = Account::getAccounts();
        $data['banks'] = BankBranch::getBankBranches();

        $via = $data['trans']->via;
        $mode = $data['trans']->mode;
        $amount = $data['trans']->amount;
        $bank_payment_mode = $data['trans']->bank_payment_mode;
        $desc = $data['trans']->desc;

        $vendor_ac_id = 0;
        $client_ac_id = 0;
        $company_ac_id = 0;
        $bank_ac_id = 0;
        $chequeNo = 0;
        $chequeStatus = 0;
        $oldBankAcType = 0;


        foreach ($data['ledger'] as $ledger) {
            if ($ledger->ac_type == 'vendors') {
                $ac_type = $ledger->ac_type;
                $vendor_ac_id = $ledger->account_id;
            }
            if ($ledger->ac_type == 'clients') {
                $ac_type = $ledger->ac_type;
                $client_ac_id = $ledger->account_id;
            }

            if ($ledger->ac_type == 'company-account') {
                $company_ac_id = $ledger->account_id;
                $oldBankAcType = $ledger->ac_type;
            }

            if ($ledger->ac_type == 'bank') {
                $bank_ac_id = $ledger->account_id;
                $oldBankAcType = $ledger->ac_type;
            }
        }

        if ($data['trans']->bank_payment_mode == 2) {
             $cheque = BankCheque::getBankChequeInfo($trans_id);
            if ($cheque) {
                $chequeNo = $cheque->cheque_no;
                $chequeStatus = $cheque->cheque_status;
            }

        }
         $data['edit_rec'] = array(

            'trans_id' => $trans_id,
            'vendor_ac_id' => $vendor_ac_id,
            'client_ac_id' => $client_ac_id,
            'company_ac_id' => $company_ac_id,
            'bank_ac_id' => $bank_ac_id,
            'purpose' => $via,
            'trans_mode' => $mode,
            'amount' => $amount,
            'remarks' => $desc,
            'payment_mode' => $bank_payment_mode,
            'cheque_no' => $chequeNo,
            'cheque_status' => $chequeStatus,
            'ac_type' => $ac_type,
            'oldBankAcType' => $oldBankAcType,
        );
        return view('accounts.payments.edit-voucher')->with(compact('data'));
    }

    //updateVoucher
    public function updateVoucher(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'payment_amount' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        if($request->voucher_type==1) {
            $route='receipt';
        $companyBankLedgerType = 'dr';
        $cusVendLedgerType = 'cr';
        }
        if($request->voucher_type==2) {
            $route='payments';
            $companyBankLedgerType = 'cr';
            $cusVendLedgerType = 'dr';
            }
        $trans_id = $request->trans_id;
        $ac_type = $request->ac_type;
        $amount = $request->payment_amount;

        if ($ac_type == 'clients') {
            $account_id = $request->client_id;

        }
        if ($ac_type == 'vendors') {
            $account_id = $request->vendor_id;
        }
        //trans_mode
        if ($request->trans_mode == 'cash') {
            $transAcType = 'company-account';
            $companyAcBankId = $request->company_account_id;
            $data = Account::getAccountHeadId($companyAcBankId);
        }

        if ($request->trans_mode == 'bank') {
            $transAcType = 'bank';
            $companyAcBankId = $request->bank_id;
            $data = Account::getBankHeadId($companyAcBankId);

        }

        $updateTrans = Transaction::updateTransaction($trans_id, $request);
        if ($request->payment_mode == 2) {
                BankCheque::updateBankCheque($trans_id, $request);
        }


        //Transaction::updateTransaction($trans_id,$request);
        $ledForvendCustomer = Ledger::where('transaction_id', $trans_id)->where('ac_type', $request->old_ac_type)->first();
        $ledForBankAc = Ledger::where('transaction_id', $trans_id)->where('ac_type', $request->oldBankAcType)->first();
        $vendorCustomer = CoaMapping::getModuleHeadAndLevel($ac_type);


        //update ledger for customer vendor
        $ledgerForCusVendor = Ledger::updateLedger($ledForvendCustomer->id, $vendorCustomer['lHeadId'], $vendorCustomer['coa_level'], $account_id, $ac_type, $cusVendLedgerType, $amount);

        if ($ledForBankAc) {
            //update ledger for Company A/C Or Bank A/C
            if ($request->cheque_status == 2 or $request->cheque_status == 3 or $request->cheque_status == 4) {
                Ledger::deleteLedger($ledForBankAc->id);
            } else {
                $ledgerForCompanyAcBank = Ledger::updateLedger($ledForBankAc->id, $data['lHeadId'], $data['coa_level'], $companyAcBankId, $transAcType, $companyBankLedgerType, $amount);
            }
        }
        else {
            if ($request->cheque_status == 1) {
                //update ledger for Company A/C Or Bank A/C
                $data = Account::getBankHeadId($request->bank_id);
                saveLedger($trans_id, $data['lHeadId'], $request->bank_id, 'bank', $companyBankLedgerType, $amount, '0', $data['coa_level'],date('Y-m-d'));
            }
        }
        return redirect($route)->withSuccess(['success', 'Voucher updated successfully']);
        return response()->json(['success' => 'Voucher updated successfully'], 200);
    }
}



