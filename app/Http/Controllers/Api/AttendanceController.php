<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{

    public function saveEmpAttendance(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'emp_id' => 'required',
            'att_date' => 'required',
            'att_month' => 'required',
            'att_year' => 'required',
            'status' => 'required',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $empId = $request->emp_id;
        $date = $request->att_date;
        $month = $request->att_month;
        $year = $request->att_year;


        $res = Attendance::where('emp_id', $empId)
            ->where('attendance_date', $date)
            ->where('attendance_month', $month)
            ->where('attendance_year', $year)
            ->first();

        if (!$res) {


            $att = new Attendance();
            $att->emp_id = $request->emp_id;
            $att->status = $request->status;
            $att->date = date($year . '-' . $month . '-' . $date);
            $att->attendance_date = $date;
            $att->attendance_month = $month;
            $att->attendance_year = $year;
            $att->marked_by = 'self';
            $att->guard = 'app';
            $att->save();

            $response = $this->createAPIResponce($is_error = false, $code = 200, $message = 'Attendance marked successfully', $com = NULL);
            return response()->json($response, $status = 200);
        } else {

            $response = $this->createAPIResponce($is_error = true, $code = 201, $message = 'Attendance already  marked', $com = NULL);
            return response()->json($response, $status = 201);
        }

    }

    public function getAttendance(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'emp_id' => 'required',
            'month' => 'required',
            'year' => 'required',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $qry = Attendance::Query();
        $qry = $qry->where('emp_id', $request->emp_id);

        $qry = $qry->whereMonth('created_at', date($request->month));
        $qry = $qry->whereYear('created_at', date($request->year));
        $qry = $qry->orderBy('created_at', 'DESC');
        $qry = $qry->get();
        if ($qry->count() > 0) {

            $response = $this->createAPIResponce($is_error = false, $code = 201, $message = 'data found', $qry);
            return response()->json($response, $status = 201);
        } else {
            $response = $this->createAPIResponce($is_error = true, $code = 204, $message = 'data not found', $qry);
            return response()->json($response, $status = 201);
        }
    }
    //chekTodayEmpAttendance
    public function chekTodayEmpAttendance(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'emp_id' => 'required',
            'att_date' => 'required',
            'month' => 'required',
            'year' => 'required',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $qry = Attendance::Query();
        $qry = $qry->where('emp_id', $request->emp_id);
        $qry = $qry->where('attendance_date', $request->att_date);
        $qry = $qry->whereMonth('created_at', date($request->month));
        $qry = $qry->whereYear('created_at', date($request->year));
        $qry = $qry->orderBy('created_at', 'DESC');
        $qry = $qry->get();
        if ($qry->count() > 0) {

            $response = $this->createAPIResponce($is_error = false, $code = 201, $message = 'data found', $qry);
            return response()->json($response, $status = 201);
        } else {
            $response = $this->createAPIResponce($is_error = true, $code = 204, $message = 'data not found', $qry);
            return response()->json($response, $status = 201);
        }
    }

    public function createAPIResponce($is_error, $code, $message, $content)
    {


        $result = [];
        if ($is_error) {

            $result['success'] = false;
            $result['code'] = $code;
            $result['message'] = $message;
        } else {

            $result['success'] = true;
            $result['code'] = $code;

            if ($content == null) {

                $result['message'] = $message;
            } else {
                $result['data'] = $content;
            }
        }

        return $result;
    }

    public function saveEmpCheckout(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'emp_id' => 'required',
            'att_date' => 'required',
            'month' => 'required',
            'year' => 'required',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $qry = Attendance::Query();
        $qry = $qry->where('emp_id', $request->emp_id);
        $qry = $qry->where('attendance_date', $request->att_date);
        $qry = $qry->whereMonth('created_at', date($request->month));
        $qry = $qry->whereYear('created_at', date($request->year));
        $qry = $qry->first();

        if ($qry) {
            $qry->chek_out = 1;

            if ($qry->save()) {

                $response = $this->createAPIResponce($is_error = false, $code = 201, $message = 'check out successfully', $qry);
                return response()->json($response, $status = 201);
            } else {
                $response = $this->createAPIResponce($is_error = true, $code = 204, $message = 'check out error', $qry);
                return response()->json($response, $status = 201);
            }
        }else{
            $response = $this->createAPIResponce($is_error = true, $code = 204, $message = 'Record not found', $qry);
            return response()->json($response, $status = 201);
        }
    }

    public function resetChekout(Request $request){

        $emp_id=$request->emp_id;
        $data=array(
            'chek_out'=>0,
        );

        $chek=DB::table('attendances')->where('emp_id',$emp_id)->update($data);
        if($chek){

        $response = $this->createAPIResponce($is_error = true, $code = 204, $message = 'checkout reset successfully', $chek);
        return response()->json($response, $status = 201);
    }
    }
}

