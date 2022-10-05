<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountHead;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\BankBranch;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Ledger;
use App\Models\Level_1;
use App\Models\Transaction;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountsController extends Controller
{

    public function report()
    {
        return view('att_report');
    }

    //index
    public function index(Request $request)
    {

        if ($request->isMethod('post')) {

            $data = $request->all();
            $rules = array(
                'l1headId' => 'required',
                'open_bal' => 'required',
            );

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => 'Missing some fields']);
            }

            $data=Level_1::chekCoaLevel($request);
            if (Account::where('ac_head_id', $data['lHeadId'])->where('level_no',$data['coa_level'])->first()) {
                return response()->json(['errors' => 'This account already exist'], 200);
            }
            //branch mean loacatio id
               $location_id=Employee::getEmpBranchId();
                $account = new Account();
                $account->ac_head_id = $data['lHeadId'];
                $account->level_no = $data['coa_level'];
                $account->auth_id = Auth::id();
                $account->date = $request->date;
                $account->balance = $request->open_bal;
                $account->location_id =$location_id;

                if ($account->save()) {
                    //save transaction
                    $trans_id=saveTransaction(0,'open balance',NULL,NULL,$location_id,$request->open_bal,'A/C Open balance', $request->date,'dr');
                    // save ledger for credits for client
                    saveLedger($trans_id->id,$data['lHeadId'],$account->id,'company-account','dr',$request->open_bal,$account->balance,$data['coa_level']);
                    return response()->json(['success' => 'Account created successfully'], 200);
                }

        }
        $data['l1Head'] = Level_1::getLevel1();
        return view('accounts.accounts.index')->with(compact('data'));
    }


    //accountsList
    public function accountsList()
    {

        $data['accounts'] = Account::getAccounts();
        return view('accounts.accounts.accounts-list')->with(compact('data'));
    }

    //editAccounts

    public function editAccounts(Request $request)
    {

        $data['achead'] = AccountHead::all();
        $data['accounts'] = Account::find($request->id);
        return $data;

    }

    //updateAccounts

    public function updateAccounts(Request $request)
    {


         $data = $request->all();
        $rules = array(
            'account_head' => 'required',
            'ac_holder_name' => 'required',
            'contact' => 'required',
            'balance' => 'required',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
              return response()->json(['errors' => $validator->errors()]);
        }

        $account = Account::find($request->account_hidden_id);
        $account->ac_head_id = $request->account_head;
        $account->ac_holder_name = $request->ac_holder_name;
        $account->email = $request->email;
        $account->contact = $request->contact;
        $account->cnic = $request->cnic;
        $account->balance = $request->balance;

        if ($account->save()) {
            return response()->json(['success' => 'Account updated successfully'], 200);

    }else
{
return response()->json(['errors' => 'Account not updated successfully'], 200);
}
}


//deleteAccounts

    public function deleteAccount(Request $request)
    {
        $account = Account::find($request->id);
        if ($account->delete()) {
            $res=Ledger::where('ac_type','company-account')->where('account_id',$request->id)->delete();
            return response()->json(['success' => 'Account deleted successfully'], 200);
        }else
        {
            return response()->json(['errors' => 'Account not deleted'], 200);
        }
    }


    //deposit

    public  function deposit(Request $request){

        if($request->isMethod('post') AND $request->ajax()){

            $amount=$request->amount;
            $ac_id=$request->ac_id;

            $res=updateCompanyAccount($request->ac_id,'dr',$amount);
            $trans=saveTransaction($inv_id=0, $amount, $transType = 'dr',$ac_id,$ac_type='company',$res->balance,$trans_mode='deposit',$request->narration);
            updateAccountSummary($trans->id,$ac_id,$amount,$trans_type='dr',$res->balance,$ac_type='company');
            if($res){
                return response()->json(['success' => 'Deposit added successfully'], 201);
            }
        }


        $data['accounts']=Account::with('achead')->orderBy('id','DESC')->get();
        return view('accounts.accounts.deposit')->with(compact('data'));
    }
    //transfer
    public  function transfer(Request $request){
        if($request->isMethod('post')) {
          $request->all();
            $amount=$request->amount;
            $date=$request->date;
            $from_account=$request->from_account;
            $to_account=$request->to_account;
            $from_bank_id=$request->from_bank_id;
            $to_bank_id=$request->to_bank_id;

             $data = $request->all();
            $rules = array(
                'amount' => 'required',

            );

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            $location_id=Employee::getEmpBranchId();
            $fromlevel=0;
            $fromHeadId=0;
            $tolevel=0;
            $toHeadId=0;
            $fromAcType='';
            $toAcType='';
            //save transaction
            $trans=saveTransaction($inv_id=0,'transfer',$file_id=NULL,NULL,$location_id=$location_id,$amount,$request->narration,$date,$trans_type='transfer');
            if($request->transfer=='ata'){
            if($request->from_account == $request->to_account){
            return response()->json(['error' => 'You can not Transfer between same account'], 201);
         }
               $data = Account::getAccountHeadId($request->from_account);
                $fromlevel=$data['coa_level'];
                $fromHeadId=$data['lHeadId'];
                $fromAcType='company-account';
                $data = Account::getAccountHeadId($request->to_account);
                $tolevel=$data['coa_level'];
                $toHeadId=$data['lHeadId'];
                $toAcType='company-account';
                 $fromBalance=updateCompanyAccount($from_account,'cr',$amount);
                 $toBalance=updateCompanyAccount($to_account,'dr',$amount);
                $fromBalance=$fromBalance->balance;
                $toBalance= $toBalance->balance;


        }
            if($request->transfer=='btb'){
                if($from_bank_id ==$to_bank_id){
                    return response()->json(['error' => 'You can not Transfer between same account'], 201);
                }
                $data = Account::getBankHeadId($from_bank_id);
                $from_account=$from_bank_id;
                $fromlevel=$data['coa_level'];
                $fromHeadId=$data['lHeadId'];
                $fromAcType='bank';
                $data = Account::getBankHeadId($to_bank_id);
                $to_account=$to_bank_id;
                $tolevel=$data['coa_level'];
                $toHeadId=$data['lHeadId'];
                $toAcType='bank';
                $fromBalance=updateBranchBalance($from_bank_id,'cr',$amount);
                $toBalance=updateBranchBalance($to_bank_id,'dr',$amount);

            }
            if($request->transfer=='atb'){
                $data = Account::getAccountHeadId($from_account);
                $fromlevel=$data['coa_level'];
                $fromHeadId=$data['lHeadId'];
                $fromAcType='company-account';
                $data = Account::getBankHeadId($to_bank_id);
                $to_account=$to_bank_id;
                $tolevel=$data['coa_level'];
                $toHeadId=$data['lHeadId'];
                $toAcType='bank';

                 $fromBalance=updateCompanyAccount($from_account,'cr',$amount);
                 $toBalance=updateBranchBalance($to_bank_id,'dr',$amount);
                $fromBalance= $fromBalance->balance;

            }
            if($request->transfer=='bta'){
                $data = Account::getBankHeadId($from_bank_id);
                $from_account=$from_bank_id;
                $fromlevel=$data['coa_level'];
                $fromHeadId=$data['lHeadId'];
                $fromAcType='bank';
                $data = Account::getAccountHeadId($request->to_account);
                $tolevel=$data['coa_level'];
                $toHeadId=$data['lHeadId'];
                $toAcType='company-account';
                $fromBalance=updateBranchBalance($from_bank_id,'cr',$amount);
                $toBalance=updateCompanyAccount($to_account,'dr',$amount);

            }
            // save ledger for from account
            saveLedger($trans->id,$fromHeadId,$from_account,$fromAcType,$ledger_type='cr',$amount,$fromBalance,$fromlevel,$date);
            // save ledger for TO account
            saveLedger($trans->id,$toHeadId,$to_account,$toAcType,$ledger_type='dr',$amount,$toBalance,$tolevel,$date);
            return response()->json(['success' => 'Transfer successfully'], 201);

        }
        $data['banks']=BankBranch::all();
        $data['accounts']=Account::getAccounts();
        return view('accounts.accounts.transfer')->with(compact('data'));
    }
    //createVendCusAccount
    public function createVendCusAccount(Request $request){

        if($request->account_type=='clients'){
        $data = $request->all();
        $rules = array(
            'name' => 'required',
            'contact' => 'required'

        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        if (!Client::where('email', $request->email)->first()) {
            $client = new Client();
            $client->name = $request->input('name');
            $client->email = ($request->input('email')?$request->input('email'):'');
            $client->cnic = ($request->input('cnic'))?$request->input('cnic'):'';
            $client->contact = $request->input('contact');
            $client->city = $request->input('city');
            $client->open_bal = ($request->bal_type == 'cr') ? $request->input('open_bal') : '-' . $request->input('open_bal');;
            $client->address = ($request->input('address'))?$request->input('address'):'';
            $client->save();
            return response()->json(['success' =>'Account created successfully']);
        }
        else {
            return response()->json(['error' => 'This client already exist']);
        }
    }else{
            $data = $request->all();
            $rules = array(
                'contact' => 'required|min:11'

            );
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }
            if (!Vendor::where('email', $request->email)->first()) {
                $vendor = new Vendor();
                $vendor->name = $request->input('name');
                $vendor->email = ($request->input('email'))?$request->input('email'):'';
                $vendor->fp_name = $request->input('fp_name');
                $vendor->contact = $request->input('contact');
                $vendor->city = $request->input('city');
                $vendor->open_bal = ($request->bal_type == 'cr') ? $request->input('open_bal') : '-' . $request->input('open_bal');
                $vendor->address = ($request->input('address'))?$request->input('address'):'';
                $vendor->save();

                return response()->json(['success' =>'Account created successfully']);
            }
            else{
                return response()->json([ 'error' => 'This vendor already exist']);
            }
        }
    }
    public function getAccountBalance(Request $request){
        $balance=Ledger::countAccountsBalance($request->ac_type,$request->ac_id);
        return $balance;
    }

}
