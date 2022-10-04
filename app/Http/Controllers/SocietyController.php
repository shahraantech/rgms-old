<?php

namespace App\Http\Controllers;

use App\Models\Society;
use Illuminate\Http\Request;
use Validator;

class SocietyController extends Controller
{
    public function index(Request $request){

        if($request->isMethod('post')){

            $data=$request->all();
            $rules = array(
                'name' => 'required',
            );

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }
            $society = new Society();
            $society->project_name = $request->name;

            if ($society->save()) {
                return response()->json(['success' => 'Record save successfully'], 200);
            }
        }

        return view('hr.society.index');
    }

    //societyList

    public function societyList(Request $request){

return $res=Society::all();
    }
}
