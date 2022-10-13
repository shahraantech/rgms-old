<?php

namespace App\Http\Controllers;
use App\Models\Applicant;
use App\Models\ApprochedLeads;
use App\Models\AssignedLeads;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\LeadsMarketing;
use App\Models\Leave;
use App\Models\Project;
use App\Models\SocialPlatform;
use App\Models\Target;
use App\Models\Tasks;
use App\Models\TeamTarget;
use App\Models\Temprature;
use App\Models\Ticket;
use App\Models\Trainer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Models\Recruitment;
use Psr\Log\NullLogger;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $userRole;
    public function __construct()
    {
        $this->middleware(['auth','verified']);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role=='employee') {
            return Redirect::to('employee-dashboard');
        }

        if (Auth::user()->role=='trainer') {
            return Redirect::to('trainer-dashboard');
        }

        if (Auth::user()->role=='hr') {
            return view('dashboard');
        }

        if (Auth::user()->role=='call-center' OR Auth::user()->role=='super-admin' ) {

            $data['socialPlatforms']=SocialPlatform::all();
            $data['totalLeads']=LeadsMarketing::all()->count();
             $data['thisMonthLeads']=LeadsMarketing::whereMonth('created_at', Carbon::now()->month)->count();
               $data['responceQueries']=ApprochedLeads::distinct()->count('lead_id');
             $data['thisMonthResponceQueirs']=ApprochedLeads::whereMonth('created_at', Carbon::now()->month)->distinct()->count('lead_id');

            $data['doneMeetings']=ApprochedLeads::where('temp_id',6)->count();
            $data['doneMeetingsThisMonth']=ApprochedLeads::where('temp_id',6)->whereMonth('created_at', Carbon::now()->month)->count();
            $data['sales']=ApprochedLeads::where('temp_id',9)->count();
            $data['salesThisMonth']=ApprochedLeads::where('temp_id',9)->whereMonth('created_at', Carbon::now()->month)->count();


            $data['temp']=Temprature::all();

            $data['totalCalls']= ApprochedLeads::count();
            $data['thisMonthCalls']= ApprochedLeads::whereMonth('created_at',Carbon::now()->month)->count();
            $data['connected']= ApprochedLeads::where('is_connected',1)->count();
            $data['thisMonthConnected']= ApprochedLeads::where('is_connected',1)->whereMonth('created_at',Carbon::now()->month)->count();
            $data['notConnected']= ApprochedLeads::where('is_connected',0)->count();
            $data['thisMonthnotConnected']= ApprochedLeads::where('is_connected',0)->whereMonth('created_at',Carbon::now()->month)->count();


             $data['notApproachedLeads']=AssignedLeads::getNotApproachesLeads(NULL,'counting','admin');

             $data['todayFollowUpsLeads']=todayFollowupLeads('admin','count',NULL);
             $data['tomorrowLeads']=tommrowFollowupLeads(NULL,'counting');
             $data['todayCreatedLeads']=LeadsMarketing::getTodayCreatedLeads(NULL,'counting');
             $data['overDueLeads']=ApprochedLeads::getOverDueLeads(NULL);



            $data['temp']=Temprature::all();
             $data['saleManager']=getTargetmanager(NULL,'sale');
             $data['getIndividualSaleTeam']=getIndividualSaleTeam('sale');
             $data['getIndividualMeetingTeam']=getIndividualSaleTeam('meeting');

            $data['meetingManager']=getTargetmanager(NULL,'meeting');

            return view('call-center.dashboard')->with(compact('data'));
        }


        if (Auth::user()->role=='accounts') {
             return Redirect::to('accounts-dashboard');
        }



        if (Auth::user()->role=='admin') {
            $data['employees']=Employee::where('status',1)->get();

            $data['tickets']=Ticket::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();
            $data['cvBank']=Applicant::where('status','!=','new')->count();
            $data['jobs']=Recruitment::where('last_date','>=',date('Y-m-d'))->where('last_date','<=',date('Y-m-d'))->count();
            $data['leaves']=Leave::whereDate('created_at', Carbon::today())->get();
            $data['pendingLeaves']=Leave::where('leave_status','pending')->whereDate('created_at', Carbon::today())->get();
            $data['approvedLeaves']=Leave::where('leave_status','approved')->whereDate('created_at', Carbon::today())->get();
            $data['tickets']=Ticket::whereDate('created_at', Carbon::today());
            $data['pendingTickets']=Ticket::whereDate('created_at', Carbon::today())->get();
             $data['close']=Ticket::where('status','complete')->whereDate('created_at', Carbon::today())->get();

                 $data['absents']=Attendance::join('employees','employees.id','attendances.emp_id')
                    ->where('attendances.status',0)
                    ->whereDate('attendances.created_at', Carbon::today())
                        ->select('employees.name','employees.image','attendances.*')
                    ->get();
            return view('dashboard')->with(compact('data'));
        }
        return view('errors.410');


    }



}
