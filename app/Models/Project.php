<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

     public function task()
    {
        return $this->hasMany(Tasks::class);
    }

    public function getStatusAttribute($value)
    {
        $getVal='';
        if($value==0){
            $getVal='pending';
        }
        if($value==1){
            $getVal='complete';
        }
        if($value==2){
            $getVal='open';
        }

        return $getVal;
    }
}
