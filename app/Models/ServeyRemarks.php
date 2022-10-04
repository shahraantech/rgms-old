<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServeyRemarks extends Model
{
    use HasFactory;


    public function getIsMarriedAttribute($value)
    {
        $getVal='';
        if($value==0){
            $getVal='No';
        }
        if($value==1){
            $getVal='Yes';
        }
        return $getVal;
    }

    public function getIsDependentAttribute($value)
    {
        $getVal='';
        if($value==0){
            $getVal='No';
        }
        if($value==1){
            $getVal='Yes';
        }
        return $getVal;
    }
}
