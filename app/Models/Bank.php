<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    //getBankHeadId

    public static function getBankHeadId($bank_id){
        $res=BankBranch::find($bank_id);
        $data['coa_level']=$res->level_no;
        $data['lHeadId']=$res->ac_head_id;
        return $data;
    }

}
