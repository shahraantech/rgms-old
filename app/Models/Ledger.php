<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;

    public static function getLedgerInfo(){
        $qry=Ledger::Query();
        $qry=$qry->join('transactions as t','t.id','ledgers.transaction_id');
        $qry=$qry->select('t.trans_type','t.amount','t.desc','ledgers.coa_head_id','ledgers.coa_level','ledgers.transaction_id');
        $qry=$qry->whereNotNull('ledgers.coa_head_id');
        $qry=$qry->get();
        return $qry;

    }
    public static function getLevelHeadName($level,$headId){


        if($level==1){
            $res=Level_1::where('id',$headId)->first();
            $headName=$res->level_head;
        }
        if($level==2){
            $res=Level_2::where('id',$headId)->first();
            $headName=$res->level_two_head;
        }
        if($level==3){
            $res=Level_3::where('id',$headId)->first();
            $headName=$res->level_three_head;
        }
        if($level==4){
            $res=Level_4::where('id',$headId)->first();
            $headName=$res->level_four_head;
        }
        if($level==5){
            $res=Level_5::where('id',$headId)->first();
            $headName=$res->level_five_head;
        }
        return $headName;
    }

//get ledger details
    public static function getLedgerDetails($coa_head_id,$level){
        $qry=Ledger::Query();
        $qry=$qry->where('coa_head_id',$coa_head_id);
        $qry=$qry->where('coa_level',$level);
        $qry=$qry->get();
        return $qry;

    }
//get ledger details
    public static function accountHistory($ac_id,$ac_type){
        $qry=Ledger::Query();
        $qry=$qry->where('account_id',$ac_id);
        $qry=$qry->where('ac_type',$ac_type);
        $qry=$qry->get();
        return $qry;

    }
    public static function getCrDrAccountName($trans_id){

        $data['crName']='';
        $data['drName']='';
    $led=Ledger::where('transaction_id',$trans_id)->get();
    foreach($led as $led){
        if($led->ledger_type=='cr'){
            $data['crName']=Account::getAcNameAcordingAcType($led->account_id,$led->ac_type);
        }
        if($led->ledger_type=='dr'){
            $data['drName']=Account::getAcNameAcordingAcType($led->account_id,$led->ac_type);
        }
    }
    return $data;
    }
    public static function getAllLedgers($trans_id){
        $data=Ledger::where('transaction_id',$trans_id)->get();
        return $data;
    }
    public static function updateLedger($ledger_id,$coaHeadId,$coaLevel,$account_id,$ac_type,$ledger_type,$amount){

            $ledger =  Ledger::find($ledger_id);
            $ledger->coa_head_id = $coaHeadId;
            $ledger->coa_level = $coaLevel;
            $ledger->account_id = $account_id;
            $ledger->ac_type = $ac_type;
            $ledger->ledger_type = $ledger_type;
            $ledger->amount = $amount;
            $ledger->save();

    }
    public static function deleteLedger($ledger_id){

        $ledger =  Ledger::find($ledger_id);
        $ledger->delete();

    }
    public static function getCrAccountIdForJv($request){

        if($request->cr_cash_ac_id){
            $data['crAccountId']=$request->cr_cash_ac_id;
            $data['acType']='company-account';
            $data['headIdAndLevel']=Account::getAccountHeadId($request->cr_cash_ac_id);
        }
        if($request->cr_bank_id){
            $data['crAccountId']=$request->cr_bank_id;
            $data['acType']='bank';
            $data['headIdAndLevel']=Bank::getBankHeadId($request->cr_bank_id);
        }
        if($request->cr_client_id){
            $data['crAccountId']=$request->cr_client_id;
            $data['acType']='clients';
            $data['headIdAndLevel']=CoaMapping::getModuleHeadAndLevel('clients',$request->cr_client_id);
        }
        if($request->cr_vendor_id){
            $data['crAccountId']=$request->cr_vendor_id;
            $data['acType']='vendors';
            $data['headIdAndLevel']=CoaMapping::getModuleHeadAndLevel('vendors',$request->cr_vendor_id);
        }
        if($request->cr_expense_id){
            $data['crAccountId']=$request->cr_expense_id;
            $data['acType']='account-head';
            $data['headIdAndLevel']=Level_4::getL4HeadAndLevel($request->cr_expense_id);
        }
        if($request->cr_assets_id){
            $data['crAccountId']=$request->cr_assets_id;
            $data['acType']='account-head';
            $data['headIdAndLevel']=Level_4::getL4HeadAndLevel($request->cr_assets_id);
        }
        if($request->cr_liability_id){
            $data['crAccountId']=$request->cr_liability_id;
            $data['acType']='account-head';
            $data['headIdAndLevel']=Level_4::getL4HeadAndLevel($request->cr_liability_id);
        }
        return $data;
    }
    public static function getDrAccountIdForJv($request){
        if($request->dr_cash_ac_id){
            $data['drAccountId']=$request->dr_cash_ac_id;
            $data['acType']='company-account';
            $data['headIdAndLevel']=Account::getAccountHeadId($request->dr_cash_ac_id);
        }
        if($request->dr_bank_id){
            $data['drAccountId']=$request->dr_bank_id;
            $data['acType']='bank';
            $data['headIdAndLevel']=Bank::getBankHeadId($request->dr_bank_id);
        }
        if($request->dr_client_id){
            $data['drAccountId']=$request->dr_client_id;
            $data['acType']='clients';
            $data['headIdAndLevel']=CoaMapping::getModuleHeadAndLevel('clients',$request->dr_client_id);
        }
        if($request->dr_vendor_id){
            $data['drAccountId']=$request->dr_vendor_id;
            $data['acType']='vendors';
            $data['headIdAndLevel']=CoaMapping::getModuleHeadAndLevel('vendors',$request->dr_vendor_id);
        }
        if($request->dr_expense_id){
            $data['drAccountId']=$request->dr_expense_id;
            $data['acType']='account-head';
            $data['headIdAndLevel']=Level_4::getL4HeadAndLevel($request->dr_expense_id);
        }
        if($request->dr_assets_id){
            $data['drAccountId']=$request->dr_assets_id;
            $data['acType']='account-head';
            $data['headIdAndLevel']=Level_4::getL4HeadAndLevel($request->dr_assets_id);
        }
        if($request->dr_liability_id){
            $data['drAccountId']=$request->dr_liability_id;
            $data['acType']='account-head';
            $data['headIdAndLevel']=Level_4::getL4HeadAndLevel($request->dr_liability_id);
        }
        return $data;
    }


    public static function getCrLedgerAccordingTrans($trans_id){
    return $res=Ledger::where('transaction_id',$trans_id)->where('ledger_type','cr')->first();
    }

    public static function getDrLedgerAccordingTrans($trans_id){
        return $res=Ledger::where('transaction_id',$trans_id)->where('ledger_type','dr')->first();
    }

    public static function countAccountsBalance($ac_type,$account_id){

            $balance=0;
            $acDrSum= Ledger::where('ac_type',$ac_type)->where('account_id',$account_id)->where('ledger_type','dr')->sum('amount');
            $acCrSum= Ledger::where('ac_type',$ac_type)->where('account_id',$account_id)->where('ledger_type','cr')->sum('amount');
            $balance=$acDrSum - $acCrSum;
            return $balance;

    }
}
