<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    public static function getAllVendors(){
        $res=Vendor::orderBy('id','DESC')->get();
        return $res;
    }

    //getVendorGroup

    public static function getVendorGroup($vId){
        $res=Vendor::find($vId);
        return $res->v_group;
    }
}
