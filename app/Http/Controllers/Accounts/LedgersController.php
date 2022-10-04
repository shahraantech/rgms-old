<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Ledger;
use Illuminate\Http\Request;

class LedgersController extends Controller
{
    public function index(){

       $data['ledger']=Ledger::getLedgerInfo();
        return view('accounts.ledgers.index')->with(compact('data'));
    }

    //ledgerHistory
    public function accountHistory($ac_id,$ac_type){

         $data['acName']=Account::getAcNameAcordingAcType($ac_id,$ac_type);
         $data['ledgerDetail']=Ledger::accountHistory($ac_id,$ac_type);
        return view('accounts.ledgers.ledger-history')->with(compact('data'));
    }
}
