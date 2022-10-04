<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;
    public static function saveCommission($inv_id,$dealer_id,$sp_id,$commission_perc,$commission_amount,$customer_id){

        $com=new Commission();
        $com->inv_id=$inv_id;
        $com->dealer_id=$dealer_id;
        $com->sp_id=$sp_id;
        $com->commision_perc=$commission_perc;
        $com->commision_amount=$commission_amount;
        $com->customer_id=$customer_id;
        $com->status=0;
        $com->save();
    }


    public static function getCommission(){

        $com=Commission::orderBy('id','DESC')->get();
        return $com;
    }
    public function getStatusAttribute($value)
    {
        if($value==0){
            $getVal='UnPaid';
        }
        if($value==1){
            $getVal='Paid';
        }


        return $getVal;
    }
}
