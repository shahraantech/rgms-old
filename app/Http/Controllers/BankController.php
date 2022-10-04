<?php

namespace App\Http\Controllers;

use App\Models\AccountSummary;
use App\Models\AccountType;
use App\Models\BankBranch;
use App\Models\BankName;
use App\Models\BankSummry;
use App\Models\CoaMapping;
use App\Models\Employee;
use App\Models\Level_1;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Bank;
use Google\Service\CloudSourceRepositories\Repo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BankController extends Controller
{
    //

    public function index(Request $request)
    {

        if ($request->isMethod('post') ) {

             $data = $request->all();
            $rules = array(
                'l1headId' => 'required',
                'balance' => 'required',
            );

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {

                return response()->json(['errors' => $validator->errors()]);
            }
            $data=Level_1::chekCoaLevel($request);

            if(BankBranch::where('head_id',$data['lHeadId'])->first()){
                return response()->json(['errors' => 'This bank already exist'], 200);
            }
            $location_id=Employee::getEmpBranchId();
            $bank = new BankBranch();
            $bank->head_id = $data['lHeadId'];
            $bank->level_no =$data['coa_level'];
            $bank->balance = $request->balance;
            $bank->auth_id = Auth::id();
            $bank->location_id = $location_id;
            $bank->date =$request->date;
            if ($bank->save()) {
                //save transaction
                $trans_id=saveTransaction(0,'bank open balance',NULL,NULL,$location_id,$request->balance,'Open balance', $request->date,'cr');
                // save ledger for credits for client
                saveLedger($trans_id->id,$data['lHeadId'],$bank->id,'bank','dr',$request->balance,$bank->balance,$data['coa_level']);
                return response()->json(['success' => 'Bank trail balannce created successfully'], 200);
            }
        }

        $data['l1Head'] = Level_1::getLevel1();
        return view('accounts.bank.index')->with(compact('data'));
    }

    public function getBank()
    {
        $bank = Bank::all();
        return $bank;
    }

    public function editBank(Request $request)
    {
        $bank = Bank::find($request->id);
        return $bank;
    }

    public function udpateBank(Request $request)
    {
        $bank = Bank::find($request->bank_id);
        $bank->bank_name = $request->input('bank_name');
        $bank->balance = $request->input('balance');
        if ($bank->save()) {
            return response()->json(['success' => 'bank updated successfully'], 200);
        }
    }

    public function deleteBank(Request $request)
    {
        $bank = Bank::find($request->id);
        if ($bank->delete()) {
            return response()->json(['success' => 'bank deleted successfully'], 200);
        }
    }


    //bankTransaction

    public function bankTransaction(Request $request)
    {

        if ($request->isMethod('post') && $request->ajax()) {
            $amount = $request->amount;
            $trans_type = $request->trans_type;
            $branch_id = $request->branch_id;

            $balance = updateBranchBalance($branch_id, $trans_type, $amount);
            $trans = saveTransaction($inv_id = 0, $amount, $trans_type, $ac_id = 0, $ac_type = 'bank', $balance, $trans_mode = 'bank',
                $request->narration);
            $bank_summary = updateAccountSummary($trans->id, $branch_id, $amount, $trans_type, $balance,$ac_type='bank');

            return response()->json(['success' => 'Bank transaction successfully!'], 200);
        }
        $data['bank_name'] = Bank::all();
        return view('accounts.bank.bank-transaction')->with(compact('data'));
    }

    //manageBank

    public function manageBank(Request $request)
    {
         $data['branches']=BankBranch::getBankBranchBalance();
        return view('accounts.bank.bank-list')->with(compact('data'));
    }


    //getBankBranches

    public function getBankBranches(Request $request)
    {
        return $res = BankBranch::where('bank_id', $request->bank_id)->get();
    }

    //bankSummary

    public function bankSummary(Request $request)
    {
        $data['summary'] = AccountSummary::with('branchname', 'branchname.bankname')
            ->where('bank_branch_id','!=',0)
            ->where('auth_id',Auth::id())
            ->orderBy('id', 'DESC')->get();
        return view('accounts.bank.bank-summary')->with(compact('data'));
    }

    public function coa(Request $request)
    {
        if ($request->ajax()) {
            $type = AccountType::all();
            return $type;
        }
        return view('accounts.bank.account_type');
    }

    public function saveAccountType(Request $request)
    {
        $type = new AccountType();
        $type->ac_type = $request->ac_type;
        if ($type->save()) {
            return response()->json(['success' => 'account type added successfully'], 200);
        }
    }

    public function editAccountType(Request $request)
    {
        $type = AccountType::find($request->id);
        return $type;
    }

    public function updateAccountType(Request $request)
    {
        $type = AccountType::find($request->accounttype_id);
        $type->ac_type = $request->ac_type;
        if ($type->save()) {
            return response()->json(['success' => 'account type updated successfully'], 200);
        }
    }

    public function deleteAccountType(Request $request)
    {
        $type = AccountType::find($request->id);
        if($type->delete())
        {
            return response()->json([
                'status' => 200,
                'success' => 'account type deleted successfully',
            ]);
        }
    }
}
