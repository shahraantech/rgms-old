<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\ApprochedLeads;
use App\Models\AssignedLeads;
use App\Models\Attendance;
use App\Models\Company;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Emp_qualification;
use App\Models\Certification;
use App\Models\Expense;
use App\Models\Experience;
use App\Models\Grade;
use App\Models\LeadsMarketing;
use App\Models\Leave;
use App\Models\Target;
use App\Models\Tasks;
use App\Models\Temprature;
use App\Models\Ticket;
use Google\Service\ServiceControl\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Tanveer;
use Mail;
use Hash;
use Illuminate\Support\Str;
use App\Events\AccountVerifyEvent;
use App\Models\CompanyBranch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class EmployeeController extends Controller
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

    //dashboard

    public function dashboard()
    {

        $data['tickets'] = Ticket::where('emp_id', $this->userId)->whereMonth('created_at', Carbon::now())->count();
        $data['expense'] = Expense::where('emp_id', $this->userId)->whereMonth('created_at', Carbon::now())->sum('expense_amount');
        $data['taskThisMonth'] = Tasks::where('assigned_to', $this->userId)->whereMonth('created_at', Carbon::now()->month)->count();
        $data['targetThisMonth'] = Target::where('agent_id', $this->userId)->whereMonth('created_at', Carbon::now()->month)->count();

        $data['absent'] = Attendance::where('attendances.status', 0)->where('emp_id', $this->userId)->whereMonth('created_at', Carbon::now()->month)->count();
        $data['present'] = Attendance::where('attendances.status', 1)->where('emp_id', $this->userId)->whereMonth('created_at', Carbon::now()->month)->count();
        $data['leaves'] = Leave::where('emp_id', $this->userId)->whereMonth('created_at', Carbon::now()->month)->count();

        $data['tasks'] = Tasks::where('status', '!=', 'Complete')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();
        $data['overDueTasks'] = Tasks::where('status', '!=', 'Complete')->whereDate('end_date', '>', Carbon::now())->get();
        $data['totalLeads'] = AssignedLeads::getEmpTotalLeads($this->userId);
        $data['thisMonthLeads'] = AssignedLeads::getEmpThisMonthLeads($this->userId);
        $data['newLeads'] = AssignedLeads::getEmpNewLeads($this->userId, 'counting');
        $data['todayLeads'] = todayFollowupLeads('agent', 'count', $this->userId);


        $data['assigend'] = AssignedLeads::where('status', 0)->where('agent_id', $this->userId)->get();
        $data['overDate'] = ApprochedLeads::getEmpOverDueLeads($this->userId, 'counting');
        $data['tomorrowLeads'] = tommrowFollowupLeads($this->userId, 'counting');
        $data['notApproachedLeads'] = AssignedLeads::getEmpNotApproachesLeads($this->userId);




        $data['responceQueriesLastMonth'] = AssignedLeads::select('*')
            ->whereBetween(
                'created_at',
                [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()]
            )->count();


        $data['myTotalLeads'] = LeadsMarketing::where('user_id', \Illuminate\Support\Facades\Auth::id())->get();
        $data['myThisWeekLeads'] = LeadsMarketing::where('user_id', \Illuminate\Support\Facades\Auth::id())->whereBetween(
            'created_at',
            [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
        )->get();
        $data['myThisMonthLeads'] = LeadsMarketing::where('user_id', \Illuminate\Support\Facades\Auth::id())->whereMonth('created_at', Carbon::now()->month)->get();

        $data['temp'] = Temprature::all();
        return view('employee.employee-dashboard')->with(compact('data'));
    }



    public function index(Request $request)
    {
        $data['foundedRec'] = 0;
        $data['search'] = 0;
        $qry = Employee::join('designations', 'designations.id', '=', 'employees.desg_id');
        $qry->select('designations.desig_name', 'employees.*')->where('status', '!=', 0);

        if ($request->isMethod('post')) {

            $qry->when($request->emp_id, function ($query, $emp_id) {
                return $query->where('employees.id', $emp_id);
            });

            $qry->when($request->company_id, function ($query, $company_id) {
                return $query->where('employees.company_id', $company_id);
            });

            $qry->when($request->emp_name, function ($query, $emp_name) {
                return $query->where('employees.name', 'like', '%' . $emp_name . '%');
            });
            $qry->when($request->desig_id, function ($query, $desig_id) {
                return $query->where('employees.desg_id', $desig_id);
            });

            $qry->when($request->dept_id, function ($query, $dept_id) {
                return $query->where('employees.dept_id', $dept_id);
            });

            $qry->when($request->grade_id, function ($query, $grade_id) {
                return $query->where('employees.grade', $grade_id);
            });

            $data['foundedRec'] = $qry->count();
            $data['search'] = 1;
        }

        $qry->orderBy('employees.id', 'Desc');
        $data['employee'] = $qry->paginate(16);


        $data['dept'] = Department::getAllDept();
        $data['grade'] = Grade::getAllGrades();
        $data['designation'] = Designation::getDesignation();
        $data['company'] = Company::getAllCompanies();
        return view('employee.index')->with(compact('data'));
    }

    //newEmployee
    public function newEmployee()
    {
        try {
            $data['dept'] = Department::orderBy('id', 'desc')->get();
            $data['grades'] = Grade::all();
            $data['companies'] = Company::all();
            return view('employee.add-new-employee')->with(compact('data'));;
        } catch (\Exception $exception) {
            return view('errors.404');
        }
    }

    //saveNewEmployee
    public function saveNewEmployee(Request $request)
    {

        $this->validate($request, [
            //personal Information
            'designation' => 'required',
            'name' => 'required',
            'email' => 'required',
            'father_name' => 'required',
            'cnic' => 'required',
            'dob' => 'required',
            'phone' => 'required',
            'grade' => 'required',
            'salary' => 'required',
            'doj' => 'required',
            'marital_status' => 'required',
            'nationality' => 'required',
            'prob' => 'required',
            'location_id' => 'required',
        ]);


        $res = Employee::where('email', $request->email)->first();
        if ($res) {

            return Redirect::back()->withErrors(['errors', 'employee already exist']);
        } else {

            if ($request->hasFile('file')) {
                $uniqueid = uniqid();
                $original_name = $request->file('file')->getClientOriginalName();
                $size = $request->file('file')->getSize();
                $extension = $request->file('file')->getClientOriginalExtension();
                $name = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;
                $imagepath = url('/storage/uploads/expense-bills/' . $name);
                $path = $request->file('file')->storeAs('public/uploads/staff-images/', $name);
            } else {
                $name = 'user1-128x128.png';
            }
            //personal Information

            $emp = new Employee;
            $emp->desg_id = $request->designation;
            $emp->dept_id = $request->dept_name;
            $emp->emp_id = $request->employee_ID;
            $emp->name = $request->name;
            $emp->email = $request->email;
            $emp->father_name = $request->father_name;
            $emp->dob = $request->dob;
            $emp->cnic = $request->cnic;
            $emp->phone = $request->phone;
            $emp->grade = $request->grade;
            $emp->marital_status = $request->marital_status;
            $emp->nationality = $request->nationality;
            $emp->gross_salary = $request->salary;
            $emp->doj = $request->doj;
            $emp->prob_period = $request->prob;
            $emp->image = $name;
            $emp->status = 1;
            $emp->company_id = $request->company_id;
            $emp->location_id = $request->location_id;

            if ($emp->save()) {

                Applicant::where('email', $request->email)->update(['status' => 'hired']);
                return Redirect::back()->withSuccess(['success', 'Record save successfully']);
            }
        }
    }


    //employeeList
    public function employeeList(Request $request)
    {
        $data['designation'] = Designation::all();
        if ($request->isMethod('post')) {

            $data['employee'] = Employee::where(function ($query) use ($request) {
                return $request->emp_id ? $query->from('id')->where('id', $request->emp_id) : '';
            })
                ->where(function ($query) use ($request) {
                    return $request->emp_name ? $query->from('name')->where('name', 'like', '%' . $request->emp_name . '%') : '';
                })
                ->where(function ($query) use ($request) {
                    return $request->emp_name ? $query->from('name')->where('name', 'like', '%' . $request->emp_name . '%') : '';
                })

                ->get();
        } else {
            $data['employee'] = Employee::join('users', 'users.account_id', '=', 'employees.id')
                ->join('designations', 'designations.id', 'employees.desg_id')
                ->select('users.role', 'designations.desig_name', 'employees.*')
                ->orderBy('employees.id', 'Desc')
                ->get();
        }
        return view('employee.employee-list')->with(compact('data'));;
    }


    //editEmployee
    public function editEmployee($id)
    {
        $id = decrypt($id);
        $data['employeeData'] = Employee::where('id', $id)->get();

        $data['qualification'] = Emp_qualification::where('emp_id', $id)->get();
        $data['desig'] = Designation::get();
        $data['certification'] = Certification::where('emp_id', $id)->get();
        $data['experience'] = Experience::where('emp_id', $id)->get();
        $data['companies'] = Company::all();
        $data['company_branch'] = CompanyBranch::all();
        $data['department'] = Department::all();

        return view('employee.edit-employee-list')->with(compact('data'));
    }

    //updateEmployee
    public function updateEmployee(Request $request)
    {
        $request->all();
        $name = $request->name;
        $emp = Employee::find($request->hidden_emp_id);

        $emp->desg_id = $request->designation;
        $emp->company_id = $request->company_id;
        $emp->dept_id = $request->dept_id;
        $emp->emp_id = $request->employee_ID;
        $emp->name = $name;
        $emp->email = $request->email;
        $emp->father_name = $request->father_name;
        $emp->dob = $request->dob;
        $emp->cnic = $request->cnic;
        $emp->phone = $request->phone;
        $emp->grade = $request->grade;
        $emp->marital_status = $request->marital_status;
        $emp->nationality = $request->nationality;
        $emp->gross_salary = $request->salary;
        $emp->doj = $request->doj;
        $emp->location_id = $request->location_id;
        $emp->prob_period = $request->prob;
        if ($emp->save()) {

            if ($request->qualification) {
                //qualification Information
                $qua = Emp_qualification::where('emp_id', $request->hidden_emp_id)->first();
                $qua->qualification = ($request->qualification) ? $request->qualification : '';
                $qua->institute = $request->institute;
                $qua->from = $request->from;
                $qua->to = $request->to;
                $qua->cgpa = $request->cgpa;

                if ($request->hasFile('attachment_edu')) {
                    $path = 'storage/app/public/uploads/education/' . $qua->attachment;
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                    $file = $request->file('attachment_edu');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('storage/app/public/uploads/education/', $filename);
                    $qua->attachment = $filename;
                }
                $qua->save();
            }

            //Professional Certifications
            if ($request->course_title) {
                $cer = Certification::where('emp_id', $request->hidden_emp_id)->first();
                $cer->course_title = ($request->course_title) ? $request->course_title : '';
                $cer->orgnazations = ($request->exp_organization) ? $request->exp_organization : '';
                $cer->duration_period = ($request->period) ? $request->period : '';

                if ($request->hasFile('attachment_cer')) {
                    $path = 'storage/app/public/uploads/certification/' . $cer->attachment;
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                    $file = $request->file('attachment_cer');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('storage/app/public/uploads/certification/', $filename);
                    $cer->attachment = $filename;
                }

                $cer->save();
            }


            //Employment Experience
            if ($request->position) {
                $exp = Experience::where('emp_id', $request->hidden_emp_id)->first();

                $exp->position = $request->position;
                $exp->skills = $request->skill;
                $exp->organization = $request->relevent_exp_organization;
                $exp->start_date = $request->start_date;
                $exp->end_date = $request->end_date;
                $exp->annual_duration = $request->annual_duartion;
                $exp->exp = $request->relevent_exp;

                if ($request->hasFile('attachment_exp')) {
                    $path = 'storage/app/public/uploads/experience/' . $exp->attachment;
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                    $file = $request->file('attachment_exp');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('storage/app/public/uploads/experience/', $filename);
                    $exp->attachment = $filename;
                }

                $exp->save();
            }

            return Redirect::back()->withSuccess(['success', 'Record update successfully']);
        }
    }


    //deleteEmployee

    public function deleteEmployee(Request $request)
    {

        $emp = Employee::find($request->emp_id);

        if ($emp->delete()) {
            return response()->json(['success' => 'Record deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Record not deleted'], 200);
        }
    }



    public function employeeMail($email)
    {


        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $user = User::where('email', $email)->first();
        $user->remember_token = $token;
        $user->save();

        $details = [
            'title' => 'Alpha HRM',
            'body' => 'Reset Password',
            'email' => $email,
            'token' => $token,
            'name' => 'Salman Raza',
        ];

        Mail::to('salmanrazabwn@gmail.com')->send(new \App\Mail\SendMail($details));
    }



    public function jobOfferMail($email)
    {
        $res = Employee::join('designations', 'designations.id', '=', 'employees.desg_id')
            ->select('designations.desig_name', 'employees.*')
            ->where('employees.email', $email)
            ->first();



        $details = [
            'title' => 'Alpha HRM',
            'body' => 'Job Offer',
            'email' => $email,
            'name' => $res->name,
            'salary' => $res->gross_salary,
            'position' => $res->desig_name,
            'doj' => $res->doj,
            'prob_period' => $res->prob_period,
        ];

        Mail::to($email)->send(new \App\Mail\JobOffer($details));
    }

    //empResetPassword

    public function empResetPassword($token, $email)
    {
        if (DB::table('password_resets')->where([['email', $email], ['token', $token]])->first()) {
            return view('employee.employee-reset')->with(compact('token'));
        } else {
            return "no matched";
        }
    }


    //empPasswordUpdate

    public function empPasswordUpdate(Request $request)
    {

        $user = User::where([['email', $request->email], ['remember_token', $request->token]])->first();
        if ($user) {
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            if ($user->save()) {

                DB::table('password_resets')->where([['email', $request->email], ['token', $request->token]])->delete();
                return redirect('login');
            }
        } else {
            return "not exist";
        }
    }

    //getEmployeesBaseofCompanyId

    public function getEmployeesBaseofCompanyId(Request $request)
    {

        return  $user = Employee::where('company_id', $request->company_id)->where('status', 1)->get();

        //        return  $user = Employee::join('users','users.account_id','employees.id')
        //            ->select('employees.name','employees.id')
        //            ->where('employees.company_id', $request->company_id)->where('users.role_id',4)->get();

    }


    //getEmpInfo

    public function getEmpInfo(Request $request)
    {
        return $user = Employee::find($request->emp_id);
    }



    public function audioupload()
    {

        $audio =  Tanveer::get();
        return view('employee.audioupload', get_defined_vars());
    }



    public function addaudioupload(Request $request)
    {
        $image = base64_encode(file_get_contents($request->file('file')));
        $image2 = base64_encode($request->file('file'));
        Tanveer::create([
            'audio' => $image,
        ]);

        return redirect()->back();
    }


    public function updateEmployeeStatus(Request $request)
    {
        $update_status = Employee::where('id', $request->id)->first();
        $update_status->update(['status' => 0]);
        return response()->json([
            'status' => 200,
            'message' => 'Employee Delete Successfully',
        ]);
    }
}
