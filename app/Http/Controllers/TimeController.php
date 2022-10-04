<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Time;
use Illuminate\Support\Facades\Validator;

class TimeController extends Controller
{
    public function index()
    {
        return view('time-management.index');
    }

    //saveTimes
    public function saveTimes(Request $request)
    {


        $data = $request->all();
        $rules = array(
            'login_time' => 'required',
            'break_time' => 'required',
            'short_leave_time' => 'required',
            'dept_time' => 'required',


        );


        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }

        if (Time::first()) {
            return response()->json(['errors' => 'You can not add time settings more then one!'], 200);
        } else {
            $time = new Time;
            $time->login_time = $request->login_time;
            $time->break_time = $request->break_time;
            $time->short_leave_time = $request->short_leave_time;
            $time->dept_time = $request->dept_time;
            if ($time->save()) {
                return response()->json(['success' => 'Record save successfully'], 200);
            }


            $time = new Time;
            $time->login_time = $request->login_time;
            $time->break_time = $request->break_time;
            $time->short_leave_time = $request->short_leave_time;
            $time->dept_time = $request->dept_time;
            if ($time->save()) {
                return response()->json(['success' => 'Record save successfully'], 200);
            }
        }
    }

    public function getTimes()
    {

        echo json_encode(Time::orderBy('id', 'Desc')->get());
    }

    //deleteTimes

    public function deleteTimes(Request $request)
    {

        $dept = Time::find($request->id);

        if ($dept) {

            if ($dept->delete()) {
                return response()->json(['success' => 'Record deleted successfully'], 200);
            } else {
                return response()->json(['error' => 'Record not deleted'], 200);
            }
        } else {
            return response()->json(['error' => 'Data not exist'], 200);
        }
    }


    public function editTimes(Request $request)
    {
        $id = $request->id;
        $time = Time::find($id);
        echo json_encode($time);
    }


    public function updateTimes(Request $request)
    {


        $data = $request->all();
        $rules = array(
            'login_time' => 'required',
            'break_time' => 'required',
            'short_leave_time' => 'required',
            'dept_time' => 'required',

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }


        $time = Time::find($request->hidden_time_id);
        $time->login_time = $request->login_time;
        $time->break_time = $request->break_time;
        $time->short_leave_time = $request->short_leave_time;
        $time->dept_time = $request->dept_time;
        if ($time->save()) {
            return response()->json(['success' => 'Save changes successfully'], 200);
        }
    }
}
