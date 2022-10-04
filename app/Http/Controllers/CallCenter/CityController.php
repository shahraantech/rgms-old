<?php

namespace App\Http\Controllers\CallCenter;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Validator;

class CityController extends Controller
{
    public function index(Request $request)
    {

        if ($request->isMethod('post')) {

            $data = $request->all();
            $rules = array(
                'city_name' => 'required',
            );

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }
            $city = new City();
            $city->city_name = $request->city_name;

            if ($city->save()) {
                return response()->json(['success' => 'Record save successfully'], 200);
            }
        }
        return view('call-center.city.index');
    }

    public function cityList()
    {
        return City::all();
    }

    public function editCity(Request $request)
    {
        $city = City::find($request->id);
        return response()->json([
            'city' => $city,
        ]);
    }

    public function updateCity(Request $request)
    {
        $city = City::find($request->city_id);
        $city->city_name = $request->city_name;

        $city->update();
        return response()->json([
            'status' => 200,
            'message' => 'City updated successfully',
        ]);

    }

    public function deleteCity(Request $request)
    {
        $city = City::find($request->id);
        if ($city->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'City deleted successfully'
            ]);
        }
    }
}
