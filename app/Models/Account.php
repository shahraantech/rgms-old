<?php

namespace App\Models;
use App\Models\Ledger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Account extends Model
{
    use HasFactory;

    public function achead()
    {
        return $this->belongsTo(AccountHead::class, 'ac_head_id', 'id');
    }

    public static function getAccounts(){

       //return  Account::where('auth_id',Auth::id())->orderBy('id', 'DESC')->get();
       return  Account::orderBy('id', 'DESC')->get();
    }

    public static function getAccountHeadId($ac_id){

        $res=Account::find($ac_id);
        $data['coa_level']=$res->level_no;
        $data['lHeadId']=$res->ac_head_id;
        return $data;
    }


    public static function getBankHeadId($bank_id)
    {

        $res = BankBranch::find($bank_id);
        if ($res) {
            $data['coa_level'] = $res->level_no;
            $data['lHeadId'] = $res->head_id;
            return $data;
        }
    }


    public static function getAcNameAcordingAcType($ac_id,$ac_type,$level_no=NULL){
     if($ac_type=='clients'){
        $client= Client::find($ac_id);
        return $client->name;
     }
        if($ac_type=='vendors'){
            $vendor= Vendor::find($ac_id);
            return $vendor->name;
        }

        if($ac_type=='company-account'){
              $ac= Account::find($ac_id);
            return $res= Ledger::getLevelHeadName($ac->level_no,$ac->ac_head_id);

        }

        if($ac_type=='bank'){
            $ac= BankBranch::find($ac_id);
            return $res= Ledger::getLevelHeadName($ac->level_no,$ac->head_id);

        }
        if($ac_type=='account-head'){
            if($level_no==4){
                $res=Level_4::find($ac_id);
                $acName=$res->level_four_head;
                return $acName;
            }
        }
    }

}
