<?php

namespace App\Http\Controllers\CallCenter;

use App\Http\Controllers\Controller;
use App\Models\ApprochedLeads;
use App\Models\AssignedLeads;
use App\Models\AssignedMeetings;
use App\Models\City;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Lead;
use App\Models\LeadsMarketing;
use App\Models\SocialPlatform;
use App\Models\Temprature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealController extends Controller
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
    public function index(){

          $data['deals']=ApprochedLeads::with('leads','leads.cityname','temp')
             ->where('temp_id',5)->orderByDesc('id')->get();

        readNotification($receiver_id = $this->userId, $path = 'meetings');
        $data['company']=Company::all();
        $data['city']=City::all();
        $data['platforms']=SocialPlatform::all();
        $data['manager']=Lead::join('employees','employees.id','leads.leader_id')->select('leads.leader_id','employees.name')->get();
        $data['employee'] = Employee::where('status', 1)->select('id','name')->orderBy('id', 'DESC')->get();

        return view('call-center.sales.index')->with(compact('data'));
    }

    //myDeals
    public function myMeetings(){

            $data['temp']=Temprature::all();
            $data['myDeal']=AssignedMeetings::with('leads','leads.cityname')
                ->where('source_id',$this->userId)
                ->where('status',0)
                ->orderBy('id','DESC')->get();
        return view('call-center.sales.my-meetings')->with(compact('data'));
    }

    //mySales

    public function mySales(){

        $data['temp']=Temprature::all();
        $data['myDeal']=AssignedMeetings::with('leads','leads.cityname')
            ->where('source_id',$this->userId)
            ->where('status',1)
            ->orderBy('id','DESC')->get();
        return view('call-center.sales.my-sales')->with(compact('data'));
    }

    //managerMeetings

    public function managerMeetings(){

        $data['managerMeetings']=AssignedLeads::with('leads','leads.cityname')
            ->where('manager_id',$this->userId)
            ->where('type','meeting')
            ->orderBy('id','DESC')->get();

        $data['company']=Company::all();
        $data['city']=City::all();
        $data['platforms']=SocialPlatform::all();
        $data['manager']=Lead::join('employees','employees.id','leads.leader_id')->select('leads.leader_id','employees.name')->get();
        $data['employee'] = Employee::where('status', 1)->select('id','name')->orderBy('id', 'DESC')->get();

        return view('call-center.sales.manager-meetings')->with(compact('data'));
    }

    //pushedMeetings

    public function pushedMeetings(){

        $data['temp']=Temprature::all();
        $data['leadType'] = 'Pushed';
        $data['meetings']=ApprochedLeads::with('leads','leads.cityname','temp')
            ->where('temp_id',5)->orderByDesc('id')->get();
        return view('call-center.sales.pushed-meetings')->with(compact('data'));
    }
}
