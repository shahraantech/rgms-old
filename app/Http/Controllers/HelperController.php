<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function ajaxEmpAutoSearch(Request $request){

        $res=ajaxEmpAutoSearch($request);
        return response()->json($res);
    }
}
