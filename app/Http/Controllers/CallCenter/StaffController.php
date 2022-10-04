<?php

namespace App\Http\Controllers\CallCenter;

use App\Http\Controllers\Controller;
use App\Models\ApprochedLeads;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    //index
    public function index(){
        return view('call-center.staff.index');
    }

    public function getTestTemp(){
        $temp_id=1;
        $temp=0;
         $appLeads =ApprochedLeads::select('lead_id')->distinct('lead_id')->get();
         foreach($appLeads as $appLeads){
              $res=ApprochedLeads::where('lead_id',$appLeads->lead_id)->latest('id')->first();
             if($res && $res->temp_id==$temp_id){
                 $temp++;
             }
         }
        return $temp;

    }
}
