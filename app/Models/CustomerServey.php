<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerServey extends Model
{
    use HasFactory;

    public function getStatusAttribute($value)
    {
        if($value==0){
            $getVal='not approach';
        }
        if($value==1){
            $getVal='complete';
        }
        if($value==2){
            $getVal='not connected';
        }
        if($value==3){
            $getVal='not interested';
        }

        return $getVal;
    }
}
