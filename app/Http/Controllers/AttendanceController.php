<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\Time;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Leave;
use Redirect;
use DateTime;
use Illuminate\Support\Carbon;
use Validator;

class AttendanceController extends Controller
{

    protected $userId;

    public function __construct()
    {

        $this->middleware(function (Request $request, $next) {
            if (!\Auth::check()) {
                return redirect('/login');
            }
            $this->userId = \Auth::user()->account_id; // you can access user id here

            return $next($request);
        });
    }

    //attDashboard

    public function attDashboard(Request $request)
    {

        if ($request->ajax()) {
            $data['absent'] = Attendance::join('employees', 'employees.id', '=', 'attendances.emp_id')
                ->join('designations', 'designations.id', '=', 'employees.desg_id')
                ->where('attendances.status', 0)->where('attendances.date', date('Y-m-d'))
                ->select('designations.desig_name', 'employees.name')
                ->get();

            // get attaendances
            $att = Attendance::join('employees', 'employees.id', 'attendances.emp_id')
                ->where('attendances.status', 1)->where('attendances.date', date('Y-m-d'))
                ->select('employees.name', 'attendances.created_at')->orderBy('attendances.id', 'DESC')->get();

            $data['totalStaff'] = Employee::where('status', 1)->count();
            $data['presentStaff'] = $att->count();
            $data['absentStaff'] = $data['absent']->count();
            $data['leaves'] = Leave::where('from', '<=', date('Y-m-d'))->where('to', '>=', date('Y-m-d'))->count();




            $data['chekIns'] = collect([]);
            foreach ($att as $k => $val) {

                $array = array(
                    'name' => $val->name,
                    'time' => $val->created_at->diffForHumans(),

                );
                $data['chekIns']->push($array);
            }
            return $data;
        }
        return view('attendance.att-dashboard');
    }

    public function index(Request $request)
    {
        $company_id = $request->company_id;
        $data['company'] = Company::all();
        $data['employee'] = Employee::join('designations', 'designations.id', '=', 'employees.desg_id')
            ->select('designations.desig_name', 'employees.*')
            ->where('employees.company_id', $company_id)
            ->where('employees.status', 1)
            ->orderBy('employees.id', 'Desc')
            ->get();
        return view('attendance.index')->with(compact('data'));
    }

    //markAttendance

    public function markAttendance(Request $request)
    {


        $input = $request->all();
        $got_error = '';

        if ($input['emp_id'] != '') {

            for ($c = 0; $c < count($input['emp_id']); $c++) {

                if ($input['emp_id'][$c] != NULL) {
                    if (!(Attendance::where([['emp_id', $input['emp_id'][$c]], ['date', date('Y-m-d')]])->first())) {

                        $att = new Attendance();
                        $att->emp_id = $input['emp_id'][$c];
                        $att->status = $input['status_' . $c + 1];
                        $att->date = date('Y-m-d');
                        $att->attendance_date = $attDay = date('d', strtotime(date('Y-m-d')));
                        $att->attendance_month = date('m', strtotime(date('Y-m-d')));
                        $att->attendance_year = date('Y', strtotime(date('Y-m-d')));
                        $att->marked_by = 'admin';
                        $att->guard = 'web';
                        $att->save();

                        if ($input['status_' . $c + 1] == 'absent') {

                            $leave = new Leave();
                            $leave->emp_id = $input['emp_id'][$c];
                            $leave->leave_type = 'not mention';
                            $leave->from = date('Y-m-d');
                            $leave->to = date('Y-m-d', strtotime('+1 days'));
                            $leave->reason = 'not mention';
                            $leave->leave_status = 'pending';
                            $leave->save();
                        }
                    } else {
                        $got_error = ['errors', 'Today already attendance marked!'];
                    }
                }
            }


            if ($got_error) {
                return Redirect::back()->withErrors($got_error);
            } else {

                return Redirect::back()->withSuccess(['success', 'Attendance marked successfully']);
            }
        }
    }


    //viewAttendance

    public function viewAttendance(Request $request)
    {
        $company_id = '';

        ($request->month) ? $data['month'] = $request->month : $data['month'] = '';
        ($request->year) ? $data['year'] = $request->year : $data['year'] = '';
        if ($request->company_id) {
            $company_id = $request->company_id;
        }
        $data['company'] = Company::all();
        $data['leave_type'] = LeaveType::select('id', 'laeve_type')->get();
        $data['employee'] = Employee::join('designations', 'designations.id', '=', 'employees.desg_id')
            ->select('designations.desig_name', 'employees.*')
            ->where('employees.company_id', $company_id)
            ->where('employees.status', 1)
            //            ->orderBy('employees.id', 'Desc')
            ->get();


        return view('attendance.view-attendance')->with(compact('data'));
    }

    //editAttendance

    public function editAttendance(Request $request)
    {
        $data = Attendance::find($request->id);
        echo json_encode($data);
    }


    //updateAttendance
    public function updateAttendance(Request $request)
    {
        $request->all();
        $att = Attendance::find($request->hiiden_att_id);
        $att->status = $request->update_status;
        if ($att->save()) {
            return 1;
        }
    }


    //markEmpAttendance

    public function markEmpAttendance(Request $request)
    {

        if (!($res = Attendance::where([['emp_id', $this->userId], ['date', date('Y-m-d')]])->first())) {
            if ($request->at_status == 1) {

                $att = new Attendance();
                $att->emp_id = $this->userId;
                $att->marked_by = 'self';
                $att->guard = 'web';
                $att->date = date('Y-m-d');
                $att->attendance_date = date('d', strtotime(date('Y-m-d')));
                $att->attendance_month = date('m', strtotime(date('Y-m-d')));
                $att->attendance_year = date('Y', strtotime(date('Y-m-d')));
                $att->save();
                return response()->json(['success' => 'Checked in successfully']);
            }
        } else {
            if ($request->at_status == 0) {
                $chekout = Attendance::find($request->id);
                $chekout->chek_out = 1;

                $chekout->save();
                return response()->json(['success' => 'Checked out successfully']);
            } else {
                return response()->json(['error' => 'Attendance already marked']);
            }
        }
    }

    //empAttendance

    public function empAttendance(Request $request)
    {
        $data['searchData'] = [];
        $data['workHours'] = '';
        $data['currentDiff'] = '';
        if ($request->search == 1) {

            $data['searchData'] = Attendance::where('emp_id', $this->userId)->get();
        }

        $data['times'] = Time::first();
        $data['att'] = Attendance::where([['emp_id', $this->userId], ['date', date('Y-m-d')]])->first();
        $data['is_check_out'] = Attendance::where([['emp_id', $this->userId], ['date', date('Y-m-d')]])->get();
        $data['all_att'] = Attendance::where('emp_id', $this->userId)->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))->orderBy('date', 'DESC')->get();


        //working status
        if (!empty($data['times']->dept_time) && !empty($data['times']->login_time)) {
            $data['workHours'] = intval((strtotime($data['times']->dept_time) - strtotime($data['times']->login_time)) / 3600);
            $loginTime = new DateTime($data['times']->login_time);
            $currentTime = new DateTime(date('h:i:s a'));
            $interval = $loginTime->diff($currentTime);
            $data['currentDiff'] = $interval->format('%h') . ':' . $interval->format('%i') . ':' . $interval->format('%s');
            $data['todayWorkProgress'] = ($interval->format('%h') * 100) / $data['workHours'];
            $data['weekWorkProgress'] = $this->weeklyHrsProgress($interval, $data['workHours']);
            $data['monthlyWorkProgress'] = $this->monthlyHrsProgress($data['workHours']);
        }
        if ($data['searchData']) {
            $data['all_att'] = $data['searchData'];
        }
        return view('attendance.emp-attendance')->with(compact('data'));
    }
    public function weeklyHrsProgress($interval, $workingHrs)
    {
        $NoOfDayRecently = date('w') - 1;
        $crruntHrs = $interval->format('%h');
        $data['weekWorkingHrs'] = $workingHrs * 6;
        $data['weeklyWorkedHrs'] = ($NoOfDayRecently * $workingHrs) + $crruntHrs;
        $data['weeklyProgress'] = round(($data['weeklyWorkedHrs'] * 100) /  $data['weekWorkingHrs']);
        return $data;
    }
    //monthlyHrsProgress
    public function monthlyHrsProgress($workingHrs)
    {
        $present = Attendance::where([['emp_id', $this->userId], ['date', date('Y-m-d')]])->where('status', 1)->count();
        $data['monthlyWorkingHrs'] = $workingHrs * 24;
        $data['monthlyCompletedHrs'] = $present * $workingHrs;
        $data['monthlyProgress'] = round(($data['monthlyCompletedHrs'] * 100) /  $data['monthlyWorkingHrs']);
        return $data;
    }
    //attendanceReports
    public function attendanceReports(Request $request)
    {

        $data['report'] = [];
        if ($request->search == 1) {
            $data['report'] = Attendance::join('employees', 'employees.id', 'attendances.emp_id')
                ->join('designations', 'designations.id', 'employees.desg_id')
                ->select('employees.name', 'employees.image', 'designations.desig_name', 'attendances.*')

                ->when($request->emp_id, function ($query, $emp_id) {
                    return $query->where('attendances.emp_id', $emp_id);
                })
                ->when($request->search_month, function ($query, $search_month) {
                    return $query->where('attendances.attendance_month', $search_month);
                })

                ->when($request->company_id, function ($query, $company_id) {
                    return $query->where('employees.company_id', $company_id);
                })

                ->when($request->year, function ($query, $year) {
                    return $query->where('attendances.attendance_year', $year);
                })
                ->orderBy('attendances.id', 'DESC')
                ->get();
        }
        $data['company'] = Company::all();
        return view('attendance.att-reports')->with(compact('data'));
    }
    //getChekOutTime
    public function getChekOutTime()
    {
        $res = Time::first();
        $data['time'] = $res->dept_time;
        $data['date'] = date('Y-m-d');
        echo json_encode($data);
    }
    //singleEmpAttMark
    public function singleEmpAttMark(Request $request)
    {

        $month = $request->hiiden_month;
        $year = $request->hiiden_year;

        $res = Attendance::where('emp_id', $request->hiiden_emp_id)
            ->where('attendance_date', $request->hiiden_att_date)
            ->where('attendance_month', $month)
            ->where('attendance_year', $year)
            ->first();

        if (!$res) {
            $leave_id = $request->leave_id;

            if ($request->mark_status == "leave") {
                $from = date($request->hiiden_year . '-' . $request->hiiden_month . '-' . $request->hiiden_att_date);
                $todate = $request->hiiden_att_date + 1;
                $to = date($request->hiiden_year . '-' . $request->hiiden_month . '-' . $todate);
                $res = Leave::saveEmpLeave($request->hiiden_emp_id, $leave_id, $from, $to, NULL, 1);
            }
            //$att = Attendance::markEmpAttendanceSingle($request->hiiden_emp_id, $request->mark_status, $request->hiiden_att_date, $month, $year, $request->hiiden_att_date,222);
            $att = Attendance::markEmpAttendanceSingle($request->hiiden_emp_id, $request->mark_status, $request->hiiden_att_date, $month, $year, $leave_id);
            if ($att == 1) {
                return response()->json(['success' => 'Attendance marked successfully']);
            }
        }
    }
    //attReport
    public function monthlyAttReport(Request $request)
    {


        if ($request->isMethod('post')) {


            $data = $request->all();
            $rules = array(
                'company_id' => 'required',
            );

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            $data['month'] = $request->search_month;
            $data['year'] = $request->search_year;
            $com = Company::find($request->company_id);
            $data['company'] = $com->name;
            $data['employee'] = Employee::where('company_id', $request->company_id)->select('id', 'name')->where('status', 1)->get();
            return view('attendance.monthly-att-result')->with(compact('data'));
        }

        $data['company'] = Company::all();
        return view('attendance.monthly-att-report')->with(compact('data'));
    }

    public function monthlyAttReportPrint(Request $request)
    {

        $data['month'] = $request->search_month;
        $data['year'] = $request->search_year;
        $com = Company::find($request->company_id);
        $data['employee'] = Employee::where('company_id', $request->company_id)->select('id', 'name')->where('status', 1)->get();
        return view('attendance.monthly-att-result_print')->with(compact('data'));
    }


    public function dailyAttReport(Request $request)
    {
        if ($request->ajax()) {
            ($request->company_id) ? $company_id = $request->company_id : $company_id = '';
            ($request->date_range) ? $search_date = $request->date_range : $search_date = Carbon::now();


            $data = collect([]);
            $emp = Employee::where('employees.company_id', $company_id)->where('status', 1)->get();


            foreach ($emp as $emp) {
                $checkin = $chek_out = $status = $date = $marked_by = $guard = '-';

                $att = Attendance::where('emp_id', $emp->id)->whereDate('created_at', $search_date)->first();
                $desg = Designation::find($emp->desg_id);
                if ($att) {

                    ($att->chek_out == 0) ? $chek_out = '-' : $chek_out = date_format($att->updated_at, "Y-m-d H:i:s");
                    ($att->date) ? $date = $att->date : $date = '-';
                    ($att->created_at) ? $checkin = date_format($att->created_at, "Y-m-d H:i:s") : $checkin = '-';
                    ($att->status == 'Present') ? $status = 'Present' : $status = 'Absent';
                    $marked_by = $att->marked_by;
                    $guard = $att->guard;
                }
                $array = array(
                    'name' => $emp->name,
                    'image' => $emp->image,
                    'desig_name' => $desg->desig_name,
                    'date' => $date,
                    'created_at' => $checkin,
                    'checkout' => $chek_out,
                    'status' => $status,
                    'marked_by' => strtoupper($marked_by),
                    'guard' => strtoupper($guard),
                );

                $data->push($array);
            }
            return $data;
        }

        $data['company'] = Company::all();
        return view('attendance.daily-att-report')->with(compact('data'));
    }

    public function tanveer()
    {
        $employee = Employee::get();
        $current_date = date('Y-m-d');
        foreach ($employee as $val) {
            $attt = Attendance::where('emp_id', $val->id)
                ->where('date', $current_date)->first();
            // echo $attt;
            if (isset($attt)) {
                // $today=new Attendance();

                echo 'Attendance Already';
            } else {
                $att = new Attendance();
                $att->emp_id = $val->id;
                $att->status = '0';
                $att->date = date('Y-m-d');
                $att->attendance_date = $attDay = date('d', strtotime(date('Y-m-d')));
                $att->attendance_month = date('m', strtotime(date('Y-m-d')));
                $att->attendance_year = date('Y', strtotime(date('Y-m-d')));
                $att->marked_by = 'admin';
                $att->guard = 'web';
                $att->save();
                echo 'Success';
            }
        }
    }

    public function checkoutReport(Request $request)
    {
        $qry = Attendance::orderBy('date', 'ASC');
        if ($request->isMethod('post')) {
            $qry->when($request->emp_id, function ($query, $emp_id) {
                return $query->where('emp_id', '=', $emp_id);
            });

            $qry->when($request->date, function ($query, $date) {
                return $query->whereDate('created_at', '=', $date);
            });

            $qry->when($request->month, function ($query, $month) {
                return $query->whereMonth('created_at', $month);
            });

            $qry->when($request->year, function ($query, $year) {
                return $query->whereYear('created_at', $year);
            });
        }
        $employees = Employee::all();
        $atts = $qry->get();
        return view('attendance.checkout', get_defined_vars());
    }
}
