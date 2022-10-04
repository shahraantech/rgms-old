<?php

namespace App\Http\Controllers\CallCenter;

use App\Http\Controllers\Controller;
use App\Models\Temprature;
use Illuminate\Http\Request;
use Validator;

class TempratureController extends Controller
{
    //
    public function  index(Request $request)
    {

        if ($request->isMethod('post')) { 

            $data = $request->all();
            $rules = array(
                'temp' => 'required',
            );

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            if (Temprature::where('temp', $request->temp)->first()) {
                return response()->json(['errors' => 'Temperature with same name already exist'], 200);
            }
            $temp = new Temprature();
            $temp->temp = $request->temp;

            if ($temp->save()) {
                return response()->json(['success' => 'Record save successfully'], 200);
            }
        }
        return view('call-center.leads.leads-temp');
    }

    public function  tempList()
    {
        return $res = Temprature::all();
    }

    public function editTemp(Request $request)
    {
        $temp = Temprature::find($request->id);
        return response()->json([
            'temp' => $temp,
        ]);
    }

    public function updateTemp(Request $request)
    {
        $temp = Temprature::find($request->temp_id);
        $temp->temp = $request->temp;

        $temp->update();
        return response()->json([
            'status' => 200,
            'message' => 'Temp updated successfully'
        ]);
    }
}
