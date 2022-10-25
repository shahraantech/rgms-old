<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BankBranch extends Model
{
    use HasFactory;

    public function bankname()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public static function getBankBranchBalance(){
        $qry=BankBranch::Query();
        (Auth::user()->role !='accounts')?$qry=$qry->where('auth_id',Auth::id()):'';
        $qry=$qry->orderBy('id','desc');
        $qry=$qry->get();
        return $qry;


    }


    public static function getBankBranches(){
        $data=BankBranch::orderBy('id','desc')->get();
        return $data;


    }
}
