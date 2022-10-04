<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoaMapping extends Model
{
    use HasFactory;
    public static function getCoaMapping(){
        return CoaMapping::orderBy('id','DESC')->get();
    }

    public static function getModuleHeadAndLevel($module){

        $res= CoaMapping::where('module',$module)->first();
        $data['coa_level']=$res->level_no;
        $data['lHeadId']=$res->head_id;
        return $data;
    }
}
