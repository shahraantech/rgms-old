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
        $data=BankBranch::where('auth_id',Auth::id())->orderBy('id','desc')->get();
        return $data;


    }


    public static function getBankBranches(){
        $data=BankBranch::orderBy('id','desc')->get();
        return $data;


    }
}
