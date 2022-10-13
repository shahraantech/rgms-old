<?php

namespace App\Http\Controllers;

use App\Models\Allownce;
use App\Models\Attendance;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Employee_Allownce;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Payroll;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Null_;
use phpDocumentor\Reflection\Types\Nullable;

class PayrollController extends Controller
{

    public function index2()
    {


        $totalDaysOfThisMonth = getTotalDaysOfMonth();
        $totalSundaysOfThisMonth = getNumberOfDays($date = date('d-m-Y'), $NameOfDay = 'sunday');
        $present = Attendance::where('emp_id', $empId)->where('attendance_month', $month)->where('attendance_year', $year)->where('status', 1)->count();
    }

    public function index(Request $request)
    {

        $totalDaysOfThisMonth = getTotalDaysOfMonth();
        // dd($totalDaysOfThisMonth);
        // $weekly=$month.'-'.$data['year'];

        $totalSundaysOfThisMonth = getNumberOfDays($totalDaysOfThisMonth['todayOfThisMonth'], $date = $totalDaysOfThisMonth['todayOfThisMonth'], $NameOfDay = 'sunday');

        $qry = Employee::join('designations', 'designations.id', '=', 'employees.desg_id')->where('employees.status', 1);

        $month = NULL;
        $year = NULL;

        $collection = collect([]);
        if ($request->search == 1) {

            $empId = $request->emp_id;
            $month = $request->month;
            $year = $request->year;

            $qry->when($empId, function ($query, $empId) {
                return $query->where('employees.id', $empId);
            });

            // $res =$this->countEmpSalary($empId,$month,$year);

            return $qry->get();
        }
        ($month) ? $month = $month : $month = date('m', strtotime(date('d-m-Y')));
        ($year) ? $year = $year : $year = date('Y', strtotime(date('d-m-Y')));



        $qry = $qry->select('designations.desig_name', 'employees.*');
        $qry = $qry->OrderBy('employees.id', 'ASC');
        $data['employee'] = $qry->get();

        foreach ($data['employee'] as $emp) {

            $res = $this->countEmpSalary($emp->id, $month, $year); //sir salman code
            $date = date('Y-m-d');
            // dd($date);
            $attendace1 = Attendance::where('emp_id', $emp->id)->where('status', '1')->where('date', '>=', '01')->where('date', '<=', $date)->count();
            $attendace2 = Attendance::where('emp_id', $emp->id)->where('status', '2')->where('date', '>=', '01')->where('date', '<=', $date)->count();

            $attendace3 = Attendance::where('emp_id', $emp->id)->where('status', '3')->where('date', '>=', '01')->where('date', '<=', $date)->count();
            // $total_current_working_days=$attendac
            // dd($attendace1);
            echo  $attendace1 . ' ' .   $attendace2 . '',  $attendace3;
            $sal = $res['netSal'];

            $salStatus = $this->salaryStatus($emp->id);
            $array = array(
                'id' => $emp->id,
                'name' => $emp->name,
                'image' => $emp->image,
                'desig' => $emp->desig_name,
                'email' => $emp->email,
                'doj' => $emp->doj,
                'income' => $sal,
                'gross_salary' => $emp->gross_salary,
                'salaryStatus' => $salStatus,
            );
            $collection->push($array);
        }

        $data['month'] = $month;
        $data['year'] = $year;


        return view('payroll.index')->with(compact('collection', 'data'));
    }

    public function countEmpSalary($empId, $month = 06, $year = 2022)
    {

        $totalDaysOfThisMonth = getTotalDaysOfMonth($month, $year);
        $totalSundaysOfThisMonth = getNumberOfDays($day = 1, $date = date('d-m-Y'), $NameOfDay = 'sunday');

        $emp = Employee::find($empId);
        $comapny = Company::where('id', $emp->company_id)->first();
        if ($comapny) {
            $workingDays = $comapny->working_days;
        } else {
            $workingDays = 1;
        }

        $empBasicSalary = $emp->gross_salary;

        $present = Attendance::where('emp_id', $empId)->where('attendance_month', $month)->where('attendance_year', $year)->where('status', 1)->count();
        $absent = Attendance::where('emp_id', $empId)->where('attendance_month', $month)->where('attendance_year', $year)->where('status', 0)->count();
        $att = Attendance::where('emp_id', $empId)->where('attendance_month', $month)->where('attendance_year', $year)->orderBy('date', 'ASC')->first();
        $attLastDay = Attendance::where('emp_id', $empId)->where('attendance_month', $month)->where('attendance_year', $year)->orderBy('date', 'DESC')->first();


        $perDaySalary = round(($empBasicSalary) / $workingDays, 2);



        if ($att) {


            $getSundayTodayYet = getSundaysBetween2Dates($startDate = date($att->date), $endDate = date($attLastDay->date));

            if ($att->attendance_date <= 10) {


                $totalWorkingDays = $present + $getSundayTodayYet;

                if ($totalWorkingDays >= $totalDaysOfThisMonth['totalDaysOfThisMonth']) {

                    $totalWorkingDays = 30;
                }
            } else {
                //$SundaysAfterAtt = getNumberOfDays($day = $att->attendance_date, $date = date('d-m-Y'), $NameOfDay = 'sunday');
                $getSundayTodayYet = getSundaysBetween2Dates($startDate = date($att->date), $endDate = date($attLastDay->date));
                $totalWorkingDays = $present + $getSundayTodayYet;
            }



            //get emp allownce
            $totalAllow = $this->countEmpAllownce($empId);
            $calculateBasicSalary = $perDaySalary * $totalWorkingDays;

            // get expense
            $res = $this->countEmpExpense($empId, $month, $year);
            $expense = $res['sumOfExpense'];


            $data['perDaySalary'] = $perDaySalary;
            $data['netSal'] = ($calculateBasicSalary + $expense + $totalAllow);
        } else {
            $data['perDaySalary'] = $perDaySalary;
            $data['netSal'] = 0;
        }
        return $data;
    }
    public function countEmpSalaryOld($empId, $month = Null, $year = Null)
    {

        $emp = Employee::find($empId);
        $comapny = Company::first();
        $empBasicSalary = $emp->gross_salary;

        $present = Attendance::where('emp_id', $empId)->where('attendance_month', $month)->where('attendance_year', $year)->where('status', 1)->count();
        $absent = Attendance::where('emp_id', $empId)->where('attendance_month', $month)->where('attendance_year', $year)->where('status', 0)->count();
        $totalAllow = $this->countEmpAllownce($empId);



        $perDaySalary = round(($empBasicSalary) / $comapny->working_days, 2);

        // chek is emp in prob period?

        //        $doj = Carbon::createFromFormat('Y-m-d', $emp->doj);
        //        $today =Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $serviceInMonth = 2; // $doj->diffInMonths($today);

        if ($absent > $comapny->allow_holidays) {
            if ($serviceInMonth > $emp->prob_period &&  $present > 0) {
                $present = $present + $comapny->allow_holidays;
            } else {
                $present = $present;
            }
        } else {
            $present = $present + $absent;
        }


        $calculateGrossSalary = $perDaySalary * $present;

        $res = $this->countEmpExpense($empId, $month, $year);
        $expense = $res['sumOfExpense'];

        $data['perDaySalary'] = $perDaySalary;
        $data['netSal'] = ($calculateGrossSalary + $expense);
        return $data;
    }

    //countEmpExpsend
    public function  countEmpExpense($empId, $month, $year)
    {
        $data['expense'] = Expense::where('emp_id', $empId)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'approved')
            ->get();

        $data['sumOfExpense'] = Expense::where('emp_id', $empId)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'approved')
            ->sum('expense_amount');
        return $data;
    }

    // count allownce

    public function  countEmpAllownce($empId, $month = Null, $year = Null)
    {

        $emp = Employee::find($empId);
        $allownce = Employee_Allownce::where('emp_id', $empId)->get();
        $totalAllow = 0;
        foreach ($allownce as $allownce) {

            $allow_ids = (explode(",", $allownce->allowance_id));
            foreach ($allow_ids as $k => $val) {

                $getAllow = $allownce->amount; // $emp->gross_salary * ($allownce->amount / 100);
                $totalAllow = $totalAllow + $getAllow;
            }
        }
        return $totalAllow;
    }

    //salarySlip


    public function salarySlip($month, $year, $id)
    {
        $empId = decrypt($id);

        //get monthname
        $monthNum = sprintf("%02s", $month);
        $monthName = date("F", mktime(12, 59, 59, $monthNum));



        $exist = Payroll::where('emp_id', $empId)->where('month', $month)->where('year', $year)->first();
        if (!$exist) {
            $pay = new Payroll();
            $pay->emp_id = $empId;
            $pay->month = $month;
            $pay->year = $year;
            $pay->status = 0;
            $pay->save();
        }
        $data['slipNo'] = Payroll::where('emp_id', $empId)->where('month', $month)->where('year', $year)->first();

        $data['totalExp'] = $this->countEmpExpense($empId, $month, $year);


        $data['absent'] = Attendance::where('emp_id', $empId)->where('attendance_month', $month)->where('attendance_year', $year)->where('status', 0)->count();
        $data['present'] = Attendance::where('emp_id', $empId)->where('attendance_month', $month)->where('attendance_year', $year)->where('status', 1)->count();
        $res = $this->countEmpSalary($empId, $month, $year);
        $data['incomeSalary'] = $res['netSal'];
        $data['perDaySalary'] = $res['perDaySalary'];
        $data['month'] = $monthName;
        $data['year'] = $year;



        $res = $this->countEmpExpense($empId, $month, $year);
        $data['sumOfExpense'] = $res['sumOfExpense'];
        $data['expense'] = $res['expense'];



        $data['employee'] = Employee::join('designations', 'designations.id', '=', 'employees.desg_id')
            ->where('employees.id', $empId)
            ->select('designations.desig_name', 'employees.*')
            ->first();

        $data['allownce'] = Employee_Allownce::join('allownces', 'allownces.id', 'employee__allownces.allowance_id')
            ->select('allownces.allowance', 'employee__allownces.*')
            ->where('emp_id', $empId)->get();


        return view('payroll.salary-slip')->with(compact('data'));
    }

    //paySalary

    public function paySalary(Request $request)
    {

        $empId = $request->emp_id;
        $month = $request->month;
        $year = $request->year;


        $pay = Payroll::where('emp_id', $empId)->where('month', $month)->where('year', $year)->first();
        if (!$pay) {
            $pay = new Payroll();
            $pay->emp_id = $empId;
            $pay->month = $month;
            $pay->year = $year;
            $pay->status = 1;
            $pay->save();
            return response()->json(['success' => 'Record updated successfully'], 200);
        } else {
            $pay->status = 1;
            if ($pay->save()) {

                return response()->json(['success' => 'Record updated successfully'], 200);
            }
        }
    }
    public function salaryStatus($empId)
    {

        $empId = $empId;
        $month = date('m', strtotime(date('d-m-Y')));
        $year = date('Y', strtotime(date('d-m-Y')));

        if ($pay = Payroll::where('emp_id', $empId)->where('month', $month)->where('year', $year)->first()) {
            return $pay->status;
        } else {
            return 0;
        }
    }
    //payrollItems
    public function payrollItems(Request $request)
    {

        if ($request->ajax() && $request->getAllowanceList == 1) {

            return  $data = Allownce::orderBy('id', 'DESC')->get();
        }

        $data['empAllowance'] = Employee_Allownce::join('employees', 'employees.id', '=', 'employee__allownces.emp_id')->get();
        $data['employee'] = Employee::all();
        $data['allowance'] = Allownce::all();
        return view('payroll.payroll-items')->with(compact('data'));
    }
    //saveAllowance
    public function saveAllowance(Request $request)
    {
        $data = $request->all();
        if ($request->ajax() && $request->empAllowanceForm == 1) {

            $rules = array(
                'emp_id' => 'required',
                'allowance_id' => 'required',
                'allowance_percent' => 'required',

            );

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {

                return response()->json(['errors' => $validator->errors()]);
            }


            $all = new Employee_Allownce();

            $all->emp_id = $request->emp_id;
            $all->allowance_id = implode(',', $request->allowance_id);
            $all->type = 1;
            $all->amount = $request->allowance_percent;


            if ($all->save()) {

                return response()->json(['success' => 'Allowance saved successfully'], 200);
            } else {
                return response()->json(['error' => 'Allowance not saved'], 200);
            }
        }



        $rules = array(
            'allowance' => 'required',
            'desc' => 'required',

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }

        $all = new Allownce();

        $all->allowance = $request->allowance;
        $all->description = $request->desc;


        if ($all->save()) {

            return response()->json(['success' => 'Project save successfully'], 200);
        } else {
            return Redirect::back()->withSuccess(['errors', 'Projeect not saved ']);
        }
    }

    public function editAllowance(Request $request)
    {
        $data['allowance'] = Allownce::find($request->id);
        return response()->json($data['allowance']);
    }

    public function updateAllowance(Request $request)
    {
        $all = Allownce::find($request->allownce_id);
        $all->allowance = $request->allowance;
        $all->description = $request->desc;
        if ($all->save()) {
            return response()->json(['success' => 'allowance udpated successfully'], 200);
        }
    }

    public function deleteAllowance(Request $request)
    {
        $all = Allownce::find($request->id);
        if ($all->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'allowance deleted successfully',
            ]);
        }
    }

    public function salarySheet(Request $request)
    {
        $company_id = '';
        $data['month'] = '';
        $data['year'] = '';

        $data['month'] = $request->month;
        $data['year'] = $request->year;
        $month = $request->month;

        $data['company_name'] = '';
        if ($request->company_id) {
            $company_id =  $request->company_id;
        }

        $res = Company::find($company_id);
        if ($res) {
            $data['company_name'] = $res->name;
        }

        $data['companies'] = Company::all();
        $data['depts'] = Department::where('company_id', $company_id)->get();

        return view('payroll.salary-sheet')->with(compact('data', 'month'));
    }

    public function deptWiseSalaryReport(Request $request)
    {
        $qry = Department::query();
        if ($request->isMethod('post')) {

            $qry->when($request->company_id, function ($query, $company_id) {
                return $query->where('company_id', $company_id);
            });

            $qry->when($request->dept_id, function ($query, $dept_id) {
                return $query->where('id', $dept_id);
            });
            $data['depts'] = $qry->get();
        }

        $data['companies'] = Company::all();
        $data['departments'] = Department::all();

        return view('payroll.dept-wise-salary-report')->with(compact('data'));
    }
}
