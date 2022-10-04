<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Company;
use App\Models\CompanyLeave;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmpWeekOff;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\LeaveType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use DateTime;

class LeaveController extends Controller
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
    //index
    public function index()
    {
        $data['totalLeaves'] = CompanyLeave::getCompanyLeaves();
        $data['consumeLeaves'] = Leave::getEmpConsumeLeaves($this->userId);
        $data['RemainingLeaves'] = $data['totalLeaves'] - $data['consumeLeaves']->count();
        $data['leaveTypes'] = LeaveType::orderBy('id', 'desc')->get();
        return view('leaves.index')->with(compact('data'));
    }

    //saveLeaves

    public function saveLeaveRequest(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'leave_type_id' => 'required',
            'from' => 'required',
            'to' => 'required',
            'reason' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $leave = new Leave();
        $leave->emp_id = $this->userId;
        $leave->leave_type = $request->leave_type_id;
        $leave->from = $request->from;
        $leave->to = $request->to;
        $leave->reason = $request->reason;
        $leave->leave_status = 0;
        if ($leave->save()) {
            return response()->json(['success' => 'Record save']);
        }
    }


    //edit leave
    public function editLeaves(Request $request)
    {
        $leave = Leave::find($request->id);
        if ($leave) {
            return $leave;
        }
    }

    //upate leave
    public function updateLeaves(Request $request)
    {
        $leave = Leave::find($request->leave_id);
        $leave->leave_type = $request->leave_type;
        $leave->from = $request->from;
        $leave->to = $request->to;
        $leave->reason = $request->reason;
        if ($leave->update()) {
            return response()->json([
                'status' => 200,
                'message' => 'leaves updated successfully',
            ]);
        }
    }

    //delete leaves
    public function deleteLeaves(Request $request)
    {
        $leave = Leave::find($request->id);
        if ($leave->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'leave deleted successfully'
            ]);
        }
    }


    public function getLeavesList()
    {

        $qry = Leave::join('employees', 'employees.id', '=', 'leaves.emp_id')
            ->join('designations', 'designations.id', '=', 'employees.desg_id')
            ->join('leave_types', 'leave_types.id', '=', 'leaves.leave_type')
            ->select(
                'leaves.id',
                'leaves.from',
                'leaves.to',
                'leaves.reason',
                'leaves.leave_status',
                'leaves.created_at',
                'leave_types.laeve_type',
                'employees.name as emp_name',
                'employees.image as image',
                'designations.desig_name'
            )
            ->where('leaves.emp_id', $this->userId)
            ->orderBy('leaves.id', 'DESC')
            ->get();
        echo json_encode($qry);
    }

    public function getRemainingLeaves(Request $request)
    {
        $res = Leave::countEmpLeaves($this->userId, $request->leave_type_id);
        return $res;
    }

    //leavesRequest

    public function leavesRequest(Request $request)
    {
        if ($request->getdata == 1) {
            $qry = Leave::join('employees', 'employees.id', '=', 'leaves.emp_id')
                ->join('designations', 'designations.id', '=', 'employees.desg_id')
                ->join('leave_types', 'leave_types.id', '=', 'leaves.leave_type')
                ->select('leaves.id', 'leaves.from', 'leaves.to', 'leaves.reason', 'leaves.leave_status', 'leaves.created_at', 'leave_types.laeve_type', 'employees.name as emp_name', 'employees.image as image', 'designations.desig_name')
                ->orderBy('leaves.id', 'DESC');



            $qry->when($request->company_id, function ($query, $company_id) {
                return $query->where('employees.company_id', $company_id);
            });
            $qry->when($request->dept_id, function ($query, $dept_id) {
                return $query->where('employees.dept_id', $dept_id);
            });
            $qry->when($request->name, function ($query, $name) {
                return $query->where('employees.name', 'like', '%' . $name . '%');
            });
            $data = $qry->get();
            return response()->json($data);
        }
        $data['totalRequest'] = Leave::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
        $data['approvedRequest'] = Leave::where('leave_status', 'APPROVED')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
        $data['pendingRequest'] = Leave::where('leave_status', 'PENDING')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
        $data['declineRequest'] = Leave::where('leave_status', 'DECLINED')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
        $data['company'] = Company::all();
        $data['department'] = Department::all();

        return view('leaves.leaves-request')->with(compact('data'));
    }

    //updateLeaveRequest

    public function updateLeaveRequest(Request $request)
    {
        $id = $request->id;
        $status = $request->leave_status;
        $leave = Leave::find($id);
        $leave->leave_status = $status; // $request->leave_status;
        $leave->save();
        //1 mean if leave status for approve
        $reqLeave = $leave;
        $start_date = $reqLeave->from;
        $end_date = $reqLeave->to;
        if ($status == 1) {
            while (strtotime($start_date) < strtotime($end_date)) {
                $attDate = date('d', strtotime($start_date));
                $attMonth = date('m', strtotime($start_date));
                $attYear = date('Y', strtotime($start_date));
                $chekAttMarkOrNot = Attendance::chekEmpAttMarkOrNot($reqLeave->emp_id, $attDate, $attMonth, $attYear);
                if ($chekAttMarkOrNot) {
                    $att = Attendance::updateEmpAttendanceSingle($reqLeave->emp_id, 3, $attDate, $attMonth, $attYear,$leave->leave_type);
                } else {
                    $att = Attendance::markEmpAttendanceSingle($reqLeave->emp_id, 3, $attDate, $attMonth, $attYear,$leave->leave_type);
                }
                $start_date = date("Y-m-d", strtotime("+1 days", strtotime($start_date)));
            }
        } else {
            while (strtotime($start_date) < strtotime($end_date)) {
                $attDate = date('d', strtotime($start_date));
                $attMonth = date('m', strtotime($start_date));
                $attYear = date('Y', strtotime($start_date));
                $chekAttMarkOrNot = Attendance::chekEmpAttMarkOrNot($reqLeave->emp_id, $attDate, $attMonth, $attYear);
                if ($chekAttMarkOrNot) {
                    //return $att = Attendance::updateEmpAttendanceSingle(1,0,05,06,2022);
                    $att = Attendance::updateEmpAttendanceSingle($reqLeave->emp_id, 0, $attDate, $attMonth, $attYear);
                } else {
                    $att = Attendance::markEmpAttendanceSingle($reqLeave->emp_id, 0, $attDate, $attMonth, $attYear);
                }
                $start_date = date("Y-m-d", strtotime("+1 days", strtotime($start_date)));
            }
        }
        return response()->json(['success' => 'Leave updated successfully']);
    }
    //leavesSettings
    public function leavesSettings(Request $request)
    {
        if ($request->isMethod('post')) {
            $leavetype = new LeaveType();
            $leavetype->company_id = 0; // $request->company_id;
            $leavetype->laeve_type = $request->laeve_type;
            if ($leavetype->save()) {
                return response()->json([
                    'success' => 'leaveType addedd successfully'
                ], 200);
            }
        }

        $data['company'] = Company::all();
        $data['company_leaves'] = CompanyLeave::all();
        $data['leavetypes'] = LeaveType::all();
        return view('leaves.leaves-settings', compact('data'));
    }

    //offWeek

    public function offWeek(Request $request)
    {
        $company = Company::all();
        $emps = EmpWeekOff::all();
        return view('leaves.off-week', get_defined_vars());
    }

    public function editOffWeek(Request $request)
    {
        $emp_week = EmpWeekOff::find($request->id);
        $company = Company::all();
        $employee = Employee::all();
        return response()->json([
            'company' => $company,
            'employee' => $employee,
            'emp_week' => $emp_week,
        ]);
    }

    public function updateOffWeek(Request $request)
    {
        $emp_week = EmpWeekOff::find($request->week_id);
        $emp_week->company_id = $request->company_id1;
        $emp_week->emp_id = $request->emp_id;
        $emp_week->day_off = $request->day_off;

        $emp_week->update();
        return back()->with('success', 'Week of day update successfull');
    }

    public function deleteOffWeek(Request $request)
    {
        $emp_week = EmpWeekOff::find($request->id);
        if ($emp_week->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Week of day deleted successfully'
            ]);
        }
    }

    public function getEmpoyeeCompanyBase(Request $request)
    {
        return Employee::where('company_id', $request->company_id)->get();
    }

    public function offWeekStore(Request $request)
    {
        if (!EmpWeekOff::where('emp_id', $request->emp_id)->orWhere('day_off', $request->day_off)->first()) {
            $size = count($request->emp_id);
            for ($i = 0; $i < $size; $i++) {

                $emp = new EmpWeekOff();
                $emp->company_id = $request->company_id;
                $emp->emp_id = $request->emp_id[$i];
                $emp->day_off = $request->day_off[$i];
                $emp->save();
            }

            return back()->with('success', 'Week of day added successfull');
        } else {
            return back()->with('error', 'Record Already Exists');
        }
    }

    public function getLeavesSettings(Request $request)
    {
        if ($request->ajax()) {
            return LeaveType::with('company')->orderBy('id', 'desc')->get();
        }
    }

    //Edit leave settings
    public function editLeavesSettings(Request $request)
    {
        $leavetype = LeaveType::find($request->id);
        $company = Company::all();
        return response()->json([
            'leavetype' => $leavetype,
            'company' => $company,
        ]);
    }

    // Edit Company Leave
    public function editCompanyLeave(Request $request)
    {
        $companyleave = CompanyLeave::find($request->id);
        $leavetype = LeaveType::all();
        return response()->json([
            'companyleave' => $companyleave,
            'leavetype' => $leavetype,
        ]);
    }

    //update leave settings
    public function updateLeavesSettings(Request $request)
    {
        $leavetype = LeaveType::find($request->leavetype_id);
        $leavetype->company_id = $request->company_id;
        $leavetype->laeve_type = $request->laeve_type;
        if ($leavetype->save()) {
            return response()->json([
                'success' => 'leaveType updated successfully'
            ], 200);
        }
    }

    //update company leave
    public function udpateCompanyLeave(Request $request)
    {
        $companyleave = CompanyLeave::find($request->company_leave_id);
        $companyleave->leave_type_id = $request->leave_type_id;
        $companyleave->leave_days = $request->leave_days;
        if ($companyleave->save()) {
            return response()->json([
                'success' => 'company leave updated successfully'
            ], 200);
        }
    }

    //delete Leave Type
    public function deleteLeavesSettings(Request $request)
    {
        $leavetype = LeaveType::find($request->id);
        if ($leavetype->delete()) {
            return response()->json([
                'status' => 200,
                'success' => 'leaveType delete successfully'
            ], 200);
        }
    }

    //delete Company Leave
    public function deleteCompanyLeaves(Request $request)
    {
        $leavetype = CompanyLeave::find($request->id);
        if ($leavetype->delete()) {
            return response()->json([
                'status' => 200,
                'success' => 'company leave delete successfully'
            ], 200);
        }
    }

    //Add Company Leave
    public function AddCompanyLeave(Request $request)
    {
        if (!CompanyLeave::where('company_id', $request->company_id)->where('leave_type_id', $request->laeve_type)->first()) {
            if ($request->isMethod('post')) {
                $input = $request->all();

                if ($input['laeve_type'] != '') {
                    for ($c = 0; $c < count($input['laeve_type']); $c++) {
                        if ($input['laeve_type'][$c] != NULL) {
                            $compleave = new CompanyLeave();
                            $compleave->company_id = $request->company_id;
                            $compleave->leave_type_id = $input['laeve_type'][$c];
                            $compleave->leave_days = $input['leave_days'][$c];
                            $compleave->save();
                        }
                    }
                }
            }
            return back()->with(['success' => 'Company leave added successfully']);
        } else {
            return back()->with(['error' => 'Record Already Exists']);
        }
    }
}
