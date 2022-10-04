<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankCheque extends Model
{
    use HasFactory;
    protected $guarded=[];

    public static function saveBankCheque($trans_id,$request){

        $image='';
        if ($request->hasFile('file')) {
            $image = base64_encode(file_get_contents($request->file('file')));
        }
        $bc=new BankCheque();
        $bc->transaction_id=$trans_id;
        $bc->cheque_no=$request->cheque_no;
        $bc->cheque_status=$request->cheque_status;
        $bc->attachement=$image;
        $bc->save();
    }

    public static function getBankChequeStatus($trans_id){

        $chequeStatus=1;
         $bankCheque=BankCheque::where('transaction_id',$trans_id)->first();
        if($bankCheque AND $bankCheque->cheque_status==1){
              $chequeStatus=0;
        }
        return $chequeStatus;

    }

    public static function getBankChequeInfo($trans_id){
        $bankCheque=BankCheque::where('transaction_id',$trans_id)->first();
        return $bankCheque;

    }

    public static function updateBankCheque($trans_id,$request)
    {
        $bank=BankCheque::where('transaction_id',$trans_id)->first();
        $bank->cheque_no=$request->cheque_no;
        $bank->cheque_status=$request->cheque_status;
        $bank->save();
    }
}
