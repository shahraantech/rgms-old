<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    use HasFactory;

    public static function getFreeLancers(){
        return $res=Freelancer::orderBy('id','DESC')->get();
    }
}
