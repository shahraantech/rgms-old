<?php

namespace App\Http\Controllers\CallCenter;

use App\Http\Controllers\Controller;
use App\Models\ApprochedLeads;
use App\Models\AssignedLeads;
use App\Models\AssignedMeetings;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Lead;
use App\Models\LeadSetting;
use App\Models\QaFeedBack;
use App\Models\SocialPlatform;
use App\Models\SourceLeadsSettings;
use App\Models\Temprature;
use App\Models\User;
use Carbon\Carbon;
use Google\Service\AdMob\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\LeadsMarketing;
use Illuminate\Http\Request;
use App\Models\City;
use App\Imports\LeadsMarketingImport;
use App\Exports\LeadsMarketingExport;
use App\Models\Test;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use DateTimeZone;
use DateTime;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\returnArgument;

class CallCenterLeadsController extends Controller
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

    public function index(Request $request)
    {
        $qry = LeadsMarketing::query();
        $qry = $qry->with('cityname', 'platformname')->whereDate('created_at', Carbon::now())->orderByDesc('id');
        if ($request->isMethod('post')) {
            $request->all();
            $qry->when($request->name, function ($query, $name) {
                return $query->where('name', $name);
            });

            $qry->when($request->email, function ($query, $email) {
                return $query->where('email', $email);
            });

            $qry->when($request->contact, function ($query, $contact) {
                return $query->where('contact', $contact);
            });
        }

        $data['platforms'] = SocialPlatform::all();
        $data['city'] = City::all();
        $data['employee'] = Employee::where('status', 1)->get();
        $data['leedMarketing'] = $qry->get();
        return view('call-center.leads.index')->with(compact('data'));
    }

    public function storeLeeds(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'name' => 'required',
            'contact' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'source_id' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        if (!LeadsMarketing::where('contact', $request->contact)->first()) {
            $lead = new LeadsMarketing();
            $lead->name = $request->name;
            $lead->email = $request->email;
            $lead->contact = $request->contact;
            $lead->city_id = $request->city_id;
            $lead->platform_id = $request->source_id;
            $lead->address = $request->address;
            $lead->lead_type = $request->lead_type;
            $lead->interest = $request->interest;
            $lead->user_id = Auth::user()->id;

            if ($lead->save()) {

                if ($request->inbound != 1) {
                    $resLead = LeadSetting::first();
                    if ($resLead and $resLead->lead_mode == 1) {
                        autoAssignLeads($lead->id);
                    }
                }

                if (!AssignedLeads::where('lead_id', $lead->id)->where('agent_id', $this->userId)->first()) {
                    if ($request->inbound == 1) {
                        $assign = new AssignedLeads();
                        $assign->lead_id = $lead->id;
                        $assign->agent_id = $this->userId;
                        $assign->type = 'lead';
                        $assign->status = 1;
                        $assign->save();

                        //save approache leads

                        $appr = new ApprochedLeads();
                        $appr->lead_id = $lead->id;
                        $appr->agent_id = $this->userId;
                        $appr->temp_id = $request->temp_id;
                        $appr->comments = $request->comments;
                        $appr->followup_date = $request->follow_date;
                        $appr->follow_time = ($request->time) ? $request->time : '';
                        $appr->save();

                        if ($request->temp_id == 9) {
                            $meet = new AssignedMeetings();
                            $meet->lead_id =$lead->id;
                            $meet->source_id =$this->userId;
                            $meet->agent_id = $this->userId;
                            $meet->status = 1;
                            $meet->allocate_by =$this->userId;
                            $meet->save();
                        }

                    }
                }

                return response()->json(['success' => 'Lead save successfully'], 200);
            }
        } else {
            return response()->json(['errors' => 'This lead already exist'], 200);
        }
    }


    //leadsList

    public function leadsList(Request $request)
    {
        $qry = LeadsMarketing::query();
        $qry = $qry->with('cityname', 'platformname');
        if ($request->isMethod('post')) {
            $request->all();
            $qry->when($request->city_id, function ($query, $city_id) {
                return $query->where('city_id', $city_id);
            });
            $qry->when($request->lead_id, function ($query, $lead_id) {
                return $query->where('id', $lead_id);
            });
            $qry->when($request->date, function ($query, $date) {
                return $query->whereDate('created_at', $date);
            });
            $qry->when($request->lead_type, function ($query, $lead_type) {
                return $query->where('lead_type', $lead_type);
            });
            $qry->when($request->name, function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            });
            $qry->when($request->contact, function ($query, $contact) {
                return $query->where('contact', 'like', '%' . $contact . '%');
            });
        }

        $data['platforms'] = SocialPlatform::all();
        $data['city'] = City::all();
        $data['temp'] = Temprature::all();
        $data['company'] = Company::all();

        $data['employee'] = getCSR();
        $data['leadType'] = '';

        //        (Auth::user()->role_id!=8)?$qry=$qry->where('created_at', '>=', Carbon::today()->subDays(3)):'';

        $data['leadsMarketing'] = $qry->orderBy('id', 'DESC')->paginate(50);
        $data['manager'] = Lead::getManagers();

        return view('call-center.leads.leads-list')->with(compact('data'));
    }

    //openLeads

    public function openLeads(Request $request)
    {
        $data['platforms'] = SocialPlatform::all();
        $data['city'] = City::all();
        $data['temp'] = Temprature::all();
        $data['company'] = Company::all();
        $data['leadType'] = 'Open';
        $data['employee'] = getCSR();
        $data['leadsMarketing'] = LeadsMarketing::getOpenLeads('not-counting');
        $data['manager'] = Lead::getManagers();

        return view('call-center.leads.leads-list')->with(compact('data'));
    }
    //inbound outbound leads list
    public function inOutBoundleadsList($type)
    {

        $qry = LeadsMarketing::query();
        $qry = $qry->with('cityname', 'platformname');

        $data['platforms'] = SocialPlatform::all();
        $data['city'] = City::all();
        $data['temp'] = Temprature::all();
        $data['company'] = Company::all();
        $data['atl'] = getCSR();
        $data['employee'] = Employee::where('status', 1)->orderBy('id', 'DESC')->get();
        $data['manager'] = Lead::join('employees', 'employees.id', 'leads.leader_id')->select('leads.leader_id', 'employees.name')->get();

        if (decrypt($type) == 2) {
            $qry = $qry->where('lead_type', 'outbound');
        } else {
            $qry = $qry->where('lead_type', 'inbound');
        }
        $data['leadsMarketing'] = $qry->orderBy('id', 'DESC')->paginate(200);
        return view('call-center.leads.leads-list')->with(compact('data'));
    }

    //allocatedLeads
    public function allocatedLeads(Request $request)
    {

        $data['temp'] = Temprature::all();
        $data['manager'] = Lead::getManagers();
        $data['employee'] = getCSR();
        $data['atl'] = getCSR();
        $data['filter'] = 1;

        $qry = AssignedLeads::query();
        $data['tempId'] = 0;
        $qry = $qry->with('leads', 'leads.cityname', 'agent');

        if ($request->isMethod('get')) {

            if ($request->temp_id and $request->agent_id) {
                $data['tempId'] = $request->temp_id;

                $tempQry = ApprochedLeads::Query();
                $tempQry->when($request->agent_id, function ($query, $agent_id) {
                    return $query->where('agent_id', $agent_id);
                });
                $tempQry->when($request->temp_id, function ($query, $temp_id) {
                    return $query->where('temp_id', $temp_id);
                });
                $tempQry = $tempQry->groupBy('lead_id');
                $data['leadsMarketing'] = $tempQry->paginate(100);
                return view('call-center.leads.allocated-leads')->with(compact('data'));

                $qry->when($request->agent_id, function ($query, $agent_id) {
                    return $query->where('agent_id', $agent_id);
                });
            }
        }


        $qry->when($request->agent_id, function ($query, $agent_id) {
            return $query->where('agent_id', $agent_id);
        });
        //        (Auth::user()->role_id!=8)?$qry=$qry->where('created_at', '>=', Carbon::today()->subDays(3)):'';
        $qry = $qry->OrderBy('lead_id', 'DESC');
        $data['leadsMarketing'] = $qry->paginate(100);


        return view('call-center.leads.allocated-leads')->with(compact('data'));
    }
    //managerAllocatedLeads

    public function managerAllocatedLeads(Request $request)
    {
        $qry = LeadsMarketing::query();
        $qry = $qry->with('cityname', 'platformname');
        $qry = $qry->where('manager_id', '>', 0);
        //        (Auth::user()->role_id!=8)?$qry=$qry->where('created_at', '>=', Carbon::today()->subDays(3)):'';


        if ($request->isMethod('post')) {
            $request->all();
            $qry->when($request->city_id, function ($query, $city_id) {
                return $query->where('city_id', $city_id);
            });
            $qry->when($request->lead_id, function ($query, $lead_id) {
                return $query->where('id', $lead_id);
            });

            $qry->when($request->contact, function ($query, $contact) {
                return $query->where('contact', 'like', '%' . $contact . '%');
            });

            $qry->when($request->manager_id, function ($query, $manager_id) {
                return $query->where('manager_id', $manager_id);
            });
        }
        $data['temp'] = Temprature::all();
        $data['city'] = City::all();
        $data['platforms'] = SocialPlatform::all();

        $data['manager'] = Lead::getManagers();
        $data['employee'] = getCSR();

        $data['leadsMarketing'] = $qry->paginate(200);


        return view('call-center.leads.manager-allocated-leads')->with(compact('data'));
    }


    //Edit Leeds
    public function editLeeds(Request $request)
    {
        $data['leedsMarketing'] = LeadsMarketing::find($request->id);
        $data['city'] = City::all();
        $data['platforms'] = SocialPlatform::all();
        $data['company'] = Company::all();
        return view('call-center.leads.leads-edit', compact('data'));
    }
    // Update Leeds
    public function updateLeeds(Request $request)
    {
        $leedMarket = LeadsMarketing::find($request->Leed_id);
        $leedMarket->name = $request->name;
        $leedMarket->email = $request->email;
        $leedMarket->contact = $request->contact;
        $leedMarket->city_id = $request->city_id;
        $leedMarket->platform_id = $request->source_id;
        $leedMarket->address = $request->address;
        $leedMarket->lead_type = $request->lead_type;

        if ($leedMarket->save()) {
            return Redirect::back()->withSuccess(['success', 'Leads updated successfully']);
        }
    }
    // Update Leeds

    // Delete Leeds
    public function deleteLeeds(Request $request)
    {
        $leedMarket = LeadsMarketing::find($request->id);
        if ($leedMarket->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Leed deleted successfully'
            ]);
        }
    }



    public function importLeads(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'file' => 'required|mimes:xlsx, xls',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return Redirect::back()->withErrors(['errors', 'CSV File Required!']);
        }


        $res = Excel::import(new LeadsMarketingImport, request()->file('file'));
        return Redirect::back()->withSuccess(['success', 'Leads import successfully']);
    }

    //exportLeads
    public function exportLeads()
    {
        return Excel::download(new LeadsMarketingExport, 'leads.xlsx');
    }

    //deleteLeads

    public function deleteLeads(Request $request)
    {
        $ids = $request->ids;
        $del = LeadsMarketing::whereIn('id', explode(",", $ids))->delete();
        $del = ApprochedLeads::whereIn('lead_id', explode(",", $ids))->delete();
        $del = AssignedLeads::whereIn('lead_id', explode(",", $ids))->delete();
        return response()->json(['success' => 'Leads deleted successfully']);
    }

    //customeAssignLeads

    public function customeAssignLeads(Request $request)
    {


        $leads_ids = $request->ids;

        for ($i = 0; $i < count($leads_ids); $i++) {
            if ($request->manager_id == 0) {
                $receiver_id = $request->agent_id;
                if (!AssignedLeads::where('lead_id', $leads_ids[$i])->where('type', $request->type)->first()) {
                    $lead = new AssignedLeads();
                    $lead->lead_id = $leads_ids[$i];
                    $lead->agent_id = $request->agent_id;
                    $lead->type = $request->type;
                    $lead->allocate_by = Auth::user()->id;
                    $lead->save();
                } else {

                    $lead = AssignedLeads::where('lead_id', $leads_ids[$i])->where('type', $request->type)->first();
                    $lead->lead_id = $leads_ids[$i];
                    $lead->agent_id = $request->agent_id;
                    $lead->type = $request->type;
                    $lead->status = 0;
                    $lead->allocate_by = Auth::user()->id;
                    $lead->save();
                }
            } else {

                $lead = LeadsMarketing::find($leads_ids[$i]);
                $lead->manager_id = $request->manager_id;
                $lead->allocate_by = Auth::user()->id;
                $lead->save();
                $receiver_id = $request->manager_id;
            }
            saveNotification($this->userId, $receiver_id, $path = 'my-leads', $message = "New Leads  for you");
        }

        return response()->json(['success' => 'Leads assigned successfully']);
    }


    public function managerToCsrLeadsAssign(Request $request)
    {

        $leads_ids = $request->ids;
        for ($i = 0; $i < count($leads_ids); $i++) {
            if ($request->manager_id == 0) {
                $receiver_id = $request->agent_id;
                if (!AssignedLeads::where('lead_id', $leads_ids[$i])->where('type', $request->type)->first()) {

                    //update manager id
                    $manager = LeadsMarketing::find($leads_ids[$i]);
                    $manager->manager_id = 0;
                    $manager->save();

                    $lead = new AssignedLeads();
                    $lead->lead_id = $leads_ids[$i];
                    $lead->agent_id = $request->agent_id;
                    $lead->type = $request->type;
                    $lead->allocate_by = Auth::user()->id;
                    $lead->save();
                }
            } else {
                $receiver_id = $request->manager_id;
                $lead = LeadsMarketing::find($leads_ids[$i]);
                $lead->manager_id = $request->manager_id;
                $lead->save();

                saveNotification($this->userId, $receiver_id, $path = 'my-leads', $message = "New Leads  for you");
            }


            saveNotification($this->userId, $receiver_id, $path = 'my-leads', $message = "New Leads  for you");
        }
        return response()->json(['success' => 'Leads assigned successfully']);
    }

    //csrToManagerLeadsAssign
    public function csrToManagerLeadsAssign(Request $request)
    {

        $leads_ids = $request->ids;
        $manager_id = $request->manager_id;
        if ($manager_id != 0) {
            for ($i = 0; $i < count($leads_ids); $i++) {
                $receiver_id = $manager_id;
                if (AssignedLeads::where('lead_id', $leads_ids[$i])->where('type', $request->type)->first()) {

                    //update manager id
                    $manager = LeadsMarketing::find($leads_ids[$i]);
                    $manager->manager_id = $manager_id;
                    $manager->save();

                    $lead = AssignedLeads::where('lead_id', $leads_ids[$i]);
                    $lead->delete();
                }


                saveNotification($this->userId, $receiver_id, $path = 'my-leads', $message = "New Leads  for you");
            }
        } else {

            for ($i = 0; $i < count($leads_ids); $i++) {
                $receiver_id = $request->agent_id;
                $lead = AssignedLeads::where('lead_id', $leads_ids[$i])->first();
                $lead->agent_id = $request->agent_id;
                $lead->save();

                saveNotification($this->userId, $receiver_id, $path = 'my-leads', $message = "New Leads  for you");
            }
        }

        return response()->json(['success' => 'Leads assigned successfully']);
    }

    //save meetings
    public function saveMeetings(Request $request)
    {

        $leads_ids = $request->ids;
        $receiver_id = 0;
        for ($i = 0; $i < count($leads_ids); $i++) {


            if ($request->manager_id == 0) {
                if (!AssignedMeetings::where('lead_id', $leads_ids[$i])->first()) {


                    $meet = new AssignedMeetings();
                    $meet->lead_id = $leads_ids[$i];
                    $meet->source_id = $request->source_id;
                    $meet->agent_id = getLeadAgent($leads_ids[$i]);
                    $meet->status = 0;
                    $meet->allocate_by = Auth::user()->id;
                    $meet->save();
                } else {

                    $meet = AssignedMeetings::where('lead_id', $leads_ids[$i])->first();
                    $meet->source_id = $request->source_id;
                    $meet->allocate_by = Auth::user()->id;
                    $meet->save();
                }
            } else {
                if (!AssignedLeads::where('lead_id', $leads_ids[$i])->where('type', $request->type)->first()) {
                    $res = AssignedLeads::where('lead_id', $leads_ids[$i])->first();
                    $lead = new AssignedLeads();
                    $lead->lead_id = $leads_ids[$i];
                    $lead->agent_id = $res->agent_id;
                    $lead->manager_id = $request->manager_id;
                    $lead->type = $request->type;
                    $lead->allocate_by = Auth::user()->id;
                    $lead->save();
                } else {

                    $lead = AssignedLeads::where('lead_id', $leads_ids[$i])->where('type', $request->type)->first();
                    $lead->manager_id = $request->manager_id;
                    $lead->save();
                }
            }
        }

        return response()->json(['success' => 'Leads assigned successfully']);
    }

    //myLeads for employee

    public function myLeads(Request $request)
    {

        $qry = AssignedLeads::query();
        $qry = $qry->with('leads', 'leads.cityname');
        if ($request->isMethod('post')) {

            $qry->when($request->lead_id, function ($query, $lead_id) {
                return $query->where('lead_id', $lead_id);
            });

            $qry->when($request->city_id, function ($query, $city_id) {
                return $query->whereRelation('leads', 'city_id', $city_id);
            });


            $qry->when($request->name, function ($query, $name) {
                return $query->whereRelation('leads', 'name', 'like', '%' . $name . '%');
            });

            $qry->when($request->date, function ($query, $date) {
                return $query->whereDate('created_at', $date);
            });

            $qry->when($request->phone, function ($query, $phone) {
                return $query->whereRelation('leads', 'contact', 'like', '%' . $phone . '%');
            });
        }


        $data['platforms'] = SocialPlatform::all();
        $data['city'] = City::orderBy('city_name', 'ASC')->get();
        $data['temp'] = Temprature::all();
        $data['leadType'] = 'My';
        readNotification($receiver_id = $this->userId, $path = 'my-leads');
        $data['temp'] = Temprature::all();
        //        $qry=$qry->where('created_at', '>=', Carbon::today()->subDays(3));
        $qry = $qry->where('agent_id', $this->userId);
        $qry = $qry->orderBy('id', 'DESC');
        $data['assigned_leads'] = $qry->paginate(10);


        return view('call-center.leads.my-leads')->with(compact('data'));
    }

    //myApproachedLeads

    public function myApproachedLeads(Request $request)
    {

        $data['res'] = 0;
        $qry = ApprochedLeads::query();
        $qry = $qry->with('leads', 'leads.cityname');
        if ($request->isMethod('post')) {


            $qry->when($request->follow_date, function ($query, $follow_date) {
                return $query->where('followup_date', $follow_date);
            });

            $qry->when($request->city_id, function ($query, $city_id) {
                return $query->whereRelation('leads', 'city_id', $city_id);
            });

            $qry->when($request->temp_id, function ($query, $temp_id) {
                return $query->where('temp_id', $temp_id);
            });

            $qry->when($request->lead_id, function ($query, $lead_id) {
                return $query->where('lead_id', $lead_id);
            });

            $qry->when($request->phone, function ($query, $phone) {
                return $query->whereRelation('leads', 'contact', 'like', '%' . $phone . '%');
            });


            $data['res'] = 1;

            $qry = $qry->where('agent_id', $this->userId);
            $qry = $qry->orderBy('id', 'DESC');
            $qry = $qry->get();
        }

        $data['approachedLeads'] = $qry;
        $data['temp'] = Temprature::all();
        $data['leadType'] = 'My Approached';
        $data['city'] = City::all();


        return view('call-center.leads.my-approached-leads')->with(compact('data'));
    }

    //saveLeadsStatus

    public function saveLeadRemarks(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = array(
                'temp_id' => 'required',
                'comments' => 'required',
                'follow_date' => 'required|date|after:yesterday'
            );

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $appLeadFind = 0;
            $appStat = ApprochedLeads::where('lead_id', $request->hidden_lead_id)->latest('id')->first();
            if ($appStat) {
                $appLeadFind = 1;
                $appStat->status = 1;
            }

            $chekTodayFollow = ApprochedLeads::where('lead_id', $request->hidden_lead_id)->where('followup_date', $request->follow_date)->first();
            if ($chekTodayFollow) {
                return response()->json(['errors' => 'This lead already be saved on same followup date'], 200);
            }


            ($request->lead_type) ? $agent_id = getLeadAgent($request->hidden_lead_id) : $agent_id = $this->userId;
            ($request->lead_type) ? $salesman_id = $this->userId : $salesman_id = 0;

            $app = new ApprochedLeads();

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension() . '.mp3';
                $filename = time() . '.' . $extension;
                $file->move('storage/app/public/uploads/leedRecording/', $filename);
                $app->audio = $filename;
            }

            $app->lead_id = $request->hidden_lead_id;
            $app->agent_id = $agent_id;
            $app->salesman_id = $salesman_id;
            $app->temp_id = $request->temp_id;
            $app->is_connected = ($request->is_connected) ? 1 : 0;
            $app->comments = $request->comments;
            $app->followup_date = ($request->follow_date) ? $request->follow_date : date('Y-m-d');
            $app->follow_time = ($request->time) ? $request->time : '';
            $app->lead_type = ($request->lead_type) ? 1 : 0;
            $app->dead_reason = ($request->dead_reason) ? $request->dead_reason : 0;
            $app->guard ='web';

            if ($app->save()) {
                if ($appLeadFind == 1) {
                    $appStat->save();
                }
                //update assigned leads
                AssignedLeads::where('lead_id', $request->hidden_lead_id)->update(['status' => 1]);

                if ($request->city) {
                    $data = LeadsMarketing::find($request->hidden_lead_id);
                    $data->name = $request->lead_name;
                    $data->city_id = $request->city;
                    $data->platform_id = $request->source;
                    $data->save();
                }

                if ($request->temp_id == 5) {

                    $res = User::where('role', 'call-center')->get();
                    foreach ($res as $row) {
                        saveNotification($this->userId, $receiver_id = $row->account_id, $path = 'meetings', $message = 'Meetings  for you');
                    }
                }


                if ($request->temp_id == 9) {
                    if (AssignedMeetings::where('lead_id', $request->hidden_lead_id)->first()) {
                        AssignedMeetings::where('lead_id', $request->hidden_lead_id)->update(['status' => 1]);
                    }else{

                        $meet = new AssignedMeetings();
                        $meet->lead_id =$request->hidden_lead_id;
                        $meet->source_id = $agent_id;
                        $meet->agent_id = $agent_id;
                        $meet->status = 1;
                        $meet->allocate_by = Auth::user()->id;
                        $meet->save();
                    }
                }
                return response()->json([
                    'status' => 200,
                    'message' => 'Remarks save successfully',
                ]);
            }
        }
    }

    //updateLeadsStatus
    public function updateLeadsStatus(Request $request)
    {

        if ($request->isMethod('post')) {

            $data = $request->all();
            $rules = array(

                'edit_lead_id' => 'required',
                'tempDropdown' => 'required',
                'is_connected' => 'required',
                'edit_comments' => 'required',
                'edit_followup' => 'required|date'

            );

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            $app = ApprochedLeads::find($request->edit_lead_id);
            if ($app) {
                $app->temp_id = $request->tempDropdown;
                $app->is_connected = $request->is_connected;
                $app->comments = $request->edit_comments;
                $app->followup_date = $request->edit_followup;
                if ($app->save()) {
                    return response()->json(['success' => 'Lead status updated successfully'], 200);
                } else {
                    return response()->json(['success' => 'Lead status not updated '], 200);
                }
            }
        }
    }


    //leadDetail
    public function leadDetail($lead_id)
    {
        $data['approached_leads'] = ApprochedLeads::with('agent', 'temp')
            ->where('lead_id', decrypt($lead_id))->where('lead_type', 0)
            ->orderByDesc('id')->get();
        $data['agent'] = ApprochedLeads::with('agent')->where('lead_id', decrypt($lead_id))->first();
        $data['lead'] = LeadsMarketing::with('cityname')->find(decrypt($lead_id));

        return view('call-center.leads.approach-leads-detail')->with(compact('data'));
    }
    //qaFeedback

    public function qaFeedback(Request $request)
    {
       $request->all();
       $apl=AssignedLeads::find($request->hidden_call_id);
        $res=QaFeedBack::where('approach_id',$request->hidden_call_id)->first();
        if($res){
            return response()->json(['errors' => 'Feedback already be created'], 200);
        }
        $qb=new QaFeedBack();
        $qb->agent_id=$apl->agent_id;
        $qb->lead_id=$apl->lead_id;
        $qb->approach_id=$request->hidden_call_id;
        $qb->rating=$request->rating;
        $qb->remarks=$request->remarks;
        if($qb->save()){
            return response()->json(['success' => 'Rating save successfully'], 200);
        }
    }

    //meetdDetail

    public function meetdDetail($lead_id)
    {
        $data['approached_leads'] = ApprochedLeads::with('agent', 'temp')
            ->where('lead_id', decrypt($lead_id))
            // ->where('lead_type', 1)
            ->orderByDesc('id')->get();
        $data['agent'] = ApprochedLeads::with('agent')->where('lead_id', decrypt($lead_id))->first();
        $data['lead'] = LeadsMarketing::with('cityname')->find(decrypt($lead_id));

        return view('call-center.leads.meeting-detail')->with(compact('data'));
    }

    //leadSettings

    public function leadSettings(Request $request)
    {

        $data['status'] = LeadSetting::first();
        return view('call-center.leads.lead-settings')->with(compact('data'));
    }

    //getLeadsSettings
    public function updateLeadsSettings(Request $request)
    {

        $lead = LeadSetting::first();
        if ($lead) {
            $lead->lead_mode = $request->status;
            $lead->save();
        } else {
            $lead = new LeadSetting();
            $lead->lead_mode = $request->status;
            $lead->save();
        }
        return response()->json(['success' => 'Settings save successfully'], 200);
    }

    //leadsSourceSettings

    public function updateSourceLeadsSettings(Request $request)
    {

        $lead = SourceLeadsSettings::where('agent_id', $request->csr_id)->first();
        if ($lead) {
            ($request->status == 0) ? $lead->is_turn = 0 : $lead->is_turn = 1;
            $lead->auto_save = $request->status;
            $res = $lead->save();

            $nextSource = SourceLeadsSettings::where('auto_save', 1)->where('id', '>', $lead->id)->min('id');
            if ($nextSource) {
                $source = SourceLeadsSettings::find($nextSource);
                $source->is_turn = 1;
                $source->save();
            } else {

                $previous = SourceLeadsSettings::where('id', '<', $lead->id)->where('auto_save', 1)->orderby('id', 'desc')->select('id')->first();
                $source = SourceLeadsSettings::find($previous->id);
                $source->is_turn = 1;
                $source->save();
            }
        } else {
            $lead = new SourceLeadsSettings();
            $lead->agent_id = $request->csr_id;
            $lead->auto_save = $request->status;
            $lead->save();
        }

        return response()->json(['success' => 'Settings save successfully'], 200);
    }

    //get_responsed_leads

    public function get_responsed_leads(Request $request)
    {
        $arr = explode("-", $request->leads_date_range);
        $start_date = date('Y-m-d', strtotime($arr[0]));
        $end_date = date('Y-m-d', strtotime($arr[1]));
        $leads = responsedLeads($start_date, $end_date);

        $c = 0;
        $output = '';
        if ($leads) {
            foreach ($leads as $lead) {
                $assign = AssignedLeads::where('lead_id', $lead->id)->first();
                $csr_name = '<span class="badge bg-inverse-danger">Open</span>';
                if ($assign) {
                    $emp = User::where('account_id', $assign->agent_id)->select('name')->first();
                    $csr_name = $emp->name;
                }
                $approach = ApprochedLeads::where('lead_id', $lead->id)->first();
                $assign ? ($assign_at = $assign->created_at) : ($assign_at = '-');
                $approach ? ($approach_at = $approach->created_at) : ($approach_at = '-');
                $c++;
                if ($approach_at != '-') {
                    $interval = '';
                    $tz = new DateTimeZone('UTC');
                    $dt1 = new DateTime($lead->created_at, $tz);
                    $dt2 = new DateTime($approach_at, $tz);
                    $year = $dt1->diff($dt2)->format('%r%y');
                    $month = $dt1->diff($dt2)->format('%m');
                    $days = $dt1->diff($dt2)->format('%d');
                    $time = $dt1->diff($dt2)->format('%h hours, %i minutes, %s seconds');

                    $year > 0 ? ($interval = $interval . '' . $year . ' ' . 'Year') : '';
                    $month > 0 ? ($interval = $interval . ' ' . $month . ' ' . 'Month') : '';
                    $days > 0 ? ($interval = $interval . ' ' . $days . ' ' . 'Days') : '';
                    $interval = $interval . ' ' . $time;
                } else {
                    $interval = '-';
                }

                $output .= '<tr>
                    <td>' . $c . '</td>
                    <td>' . $lead->id . '</td>
                    <td><span class="badge bg-inverse-success">' . $csr_name . '</span></td>

                     <td>' . $lead->created_at . '</td>
                     <td>' . $assign_at . '</td>
                      <td>' . $approach_at . '</td>
                       <td>
                       <span class="badge bg-inverse-danger">' . $interval . '</span></td></tr>';
            }
            $res = json_encode($output);
            return $res;
        }
    }


    public function leadsSourceSettings(Request $request)
    {

        $data['csrs'] = User::join('employees', 'employees.id', 'users.account_id')
            ->where('users.role_id', '4')
            ->orWhere('role_id', 7)
            ->select('employees.name', 'employees.id')->where('users.status', 1)->get();
        return view('call-center.leads.leads-source-settings')->with(compact('data'));
    }
    //updateSourceLeadsSettings

    //leadsParams
    public function leadsParams($dayType, $sender)
    {

        //1=today
        //2=tomorrow
        //3=not approcahed
        //4=over due
        //5=New Leads
        $data['city'] = City::orderBy('city_name', 'ASC')->get();
        $data['temp'] = Temprature::all();
        $data['platforms'] = SocialPlatform::all();

        $data['assigned_leads'] = [];
        $data['leadType'] = '';

        if (decrypt($dayType) == 1) {
            $data['assigned_leads'] = todayFollowupLeads(decrypt($sender), 'not count', $this->userId);
            $data['leadType'] = 'Today Followups';
        }
        if (decrypt($dayType) == 2) {
            $data['assigned_leads'] = getTomorrowLeads(decrypt($sender));
            $data['assigned_leads']->count();
            $data['leadType'] = 'Tomorrow';
        }
        if (decrypt($dayType) == 3) {
            $data['assigned_leads'] = AssignedLeads::getNotApproachesLeads(Auth::user()->account_id, 'not counting', decrypt($sender));
            $data['leadType'] = 'Not Approached';
        }
        if (decrypt($dayType) == 4) {

            $data['assigned_leads'] = getOverDueLeads(decrypt($sender));
            $data['leadType'] = 'Over Due';
        }

        if (decrypt($dayType) == 5) {
            $data['assigned_leads'] = getNewLeads();
            $data['leadType'] = 'New';
        }

        if (decrypt($dayType) == 6) {
            $data['leadType'] = 'Today Created';
            $data['leadsMarketing'] = LeadsMarketing::getTodayCreatedLeads(NULL, 'not count');
            $data['manager'] = Lead::getManagers();
            $data['employee'] = getCSR();
            return view('call-center.leads.today-created-leads')->with(compact('data'));
        }
        //7
        if (decrypt($dayType) == 7) {
            $data['leadType'] = 'Open';
            $data['leadsMarketing'] = LeadsMarketing::getOpenLeads('not count');
            $data['manager'] = Lead::getManagers();
            $data['employee'] = getCSR();
            return view('call-center.leads.today-created-leads')->with(compact('data'));
        }

        return view('call-center.leads.my-leads')->with(compact('data'));
    }

    //leadsTempWise

    public function leadsTempWise($sender, $temp_id, $temp_name)
    {
        $data['leadType'] = $temp_name;
        $data['platforms'] = SocialPlatform::all();

        $data['city'] = City::orderBy('city_name', 'ASC')->get();
        $data['temp'] = Temprature::all();
        $data['assigned_leads'] = ApprochedLeads::getTempratureWiseLeads($temp_id, 'not count', $sender, Auth::user()->account_id);
        return view('call-center.leads.leads-temp-wise')->with(compact('data'));
    }

    //testGraph

    public function getLeadsAcordingSocilaPlatforms(Request $request)
    {

        return $res = SocialPlatform::select('social_platforms.platform', DB::raw("count(leads_marketings.id) as total"))
            ->leftJoin('leads_marketings', 'leads_marketings.platform_id', '=', 'social_platforms.id')
            ->where('leads_marketings.lead_type', $request->lead_type)
            ->groupBy('leads_marketings.platform_id')
            ->get();
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $userPassword = $user->password;

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|same:confirm_password|min:6',
            'confirm_password' => 'required',
        ]);

        if (!Hash::check($request->current_password, $userPassword)) {
            return back()->withErrors(['current_password' => 'password not match']);
        }

        $user->password = Hash::make($request->password);

        if ($user->save()) {
            return Redirect::back()->withSuccess(['success', 'Password updated successfully']);
        }
    }


    //getLeadsInfo

    public function getLeadsInfo(Request $request)
    {
        $city = City::all();
        $platform = SocialPlatform::all();
        $leads = LeadsMarketing::getLeadsInfo($request->lead_id);
        return response()->json([
            'leads' => $leads,
            'city' => $city,
            'platform' => $platform,
        ]);
    }

    //editLeadsInfo

    public function editLeadsInfo(Request $request)
    {

        $id = $request->id;
        $temp = Temprature::all();
        $appLeads = ApprochedLeads::find($id);
        return response()->json([
            'appLeads' => $appLeads,
            'temp' => $temp,
        ]);
    }

    //managerLeads
    public function managerLeads(Request $request)
    {
        $qry = LeadsMarketing::query();
        $qry = $qry->with('cityname', 'platformname');

        if ($request->isMethod('post')) {
            $request->all();
            $qry->when($request->city_id, function ($query, $city_id) {
                return $query->where('city_id', $city_id);
            });
            $qry->when($request->date, function ($query, $date) {
                return $query->whereDate('date', $date);
            });

            $qry->when($request->lead_type, function ($query, $lead_type) {
                return $query->where('lead_type', $lead_type);
            });

            $qry->when($request->name, function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            });
        }

        $data['city'] = City::all();
        $data['leadsMarketing'] = $qry->where('manager_id', $this->userId);
        $data['leadsMarketing'] = $qry->orderBy('id', 'DESC')->paginate(20);


        $member = Lead::where('leads.leader_id', $this->userId)->where('status', 1)->first();
        $member_ids = (explode(",", $member->member_id));

        $data['team_member'] = collect([]);
        foreach ($member_ids as $k => $val) {
            $empData = Employee::find($val);
            if ($empData) {
                $array = array(
                    'id' => $empData->id,
                    'name' => $empData->name,

                );
                $data['team_member']->push($array);
            }
        }

        return view('call-center.leads.manager-leads')->with(compact('data'));
    }

    public function getComment(Request $request)
    {
        $coment = ApprochedLeads::where('lead_id', $request->id)->latest('id')->first();
        return $coment;
    }

    //csrPerFormance
    public function csrNoOfLeads(Request $request)
    {
        $data['from_date'] = '';
        $data['to_date'] = '';
        $data['csrLeads'] = AssignedLeads::getCsrNoOfLeads(NULL, NULL, 'count', NULL);

        if ($request->isMethod('post')) {
            $data['from_date'] = $request->from_date;
            $data['to_date'] = $request->to_date;
            $data['csrLeads'] = AssignedLeads::getCsrNoOfLeads($request->agent_id, $data['from_date'], 'count', $data['to_date']);
        }
        $data['csr'] = User::where('role_id', 4)->where('status', 1)->get();
        return view('call-center.reports.csr-no-of-leads')->with(compact('data'));
    }

    //csrLeads

    public function csrLeads($agent_id, $from_date, $to_date)
    {
        $data['temp'] = Temprature::all();
        $data['manager'] = Lead::getManagers();
        $data['employee'] = getCSR();
        $data['atl'] = getCSR();
        $data['tempId'] = 0;
        $data['filter'] = 0;
        $data['leadsMarketing'] = AssignedLeads::getCsrNoOfLeads($agent_id, $from_date, 'not count', $to_date);
        return view('call-center.leads.allocated-leads')->with(compact('data'));
    }

    //manager-no-of-leads

    public function managerNoOfLeads(Request $request)
    {
        $qry = User::Query();
        $qry = $qry->select('users.name', 'users.account_id', DB::raw("count(leads_marketings.id) as totalLeads"));
        $qry = $qry->leftJoin('leads_marketings', 'leads_marketings.manager_id', '=', 'users.account_id');
        $qry = $qry->where('users.role_id', 7);


        if ($request->isMethod('post') and $request->search == 1) {

            $arr = explode("-", $request->date_range);
            $start_date = date('Y-m-d', strtotime($arr[0]));
            $end_date = date('Y-m-d', strtotime($arr[1]));


            $qry->when($request->manager_id, function ($query, $manager_id) {
                return $query->where('leads_marketings.manager_id', $manager_id);
            });

            $qry = $qry->whereDate('leads_marketings.updated_at', '>=', $start_date);
            $qry = $qry->whereDate('leads_marketings.updated_at', '<=', $end_date);
        }

        $data['manager'] = Lead::join('employees', 'employees.id', 'leads.leader_id')->select('employees.id', 'employees.name')->get();

        $qry = $qry->groupBy('users.account_id');
        $data['managerLeads'] = $qry->get();
        return view('call-center.reports.manager-no-of-leads')->with(compact('data'));
    }

    //leadsResponse
    public function leadsResponse(Request $request)
    {
        $data['lastWeekLeads'] = responsedLeads(NULL, NULL);
        return view('call-center.reports.leads-response')->with(compact('data'));
    }

    //updateAllLeadStatusWhichAreApprocache
    public function updateAllLeadStatusWhichAreApprocache()
    {
        $apLead = ApprochedLeads::all();
        foreach ($apLead as $apLead) {
            $assign = AssignedLeads::where('lead_id', $apLead->lead_id)->first();
            if ($assign) {
                $assign->status = 1;
                $assign->save();
            }
        }
    }

    public function createRecord()
    {
        return view('call-center.leads.create-record');
    }

    public function storeRecord(Request $request)
    {
        $data = new Test();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension() . '.mp3';
            $filename = time() . '.' . $extension;
            $file->move('public/uploads/', $filename);
            $data->file = $filename;
        }
        $data->save();
        return response()->json([
            'status' => 200,
            'message' => 'Recording added successfully',
        ]);
    }

    //leadsAnalysis
    public function leadsAnalysis(Request $request)
    {

         $start_date=date('Y-m-d');
         $end_date=date('Y-m-d');

        if($request->date_range){
            $dateArr = explode("-", $request->date_range);
            $start_date =date('Y-m-d', strtotime($dateArr[0]));
            $end_date =date('Y-m-d', strtotime($dateArr[1]));
        }

        $platformPercLeads = 0;
        $platFormsCallsPerc = 0;
        $platFormVisitsPerc = 0;
        $platFormSalePerc = 0;
        $platFormDeadPerc = 0;



        ($request->platform_id) ? $platform_id = $request->platform_id : $platform_id = 0;



          $totalLeads = LeadsMarketing::getAllLeads(1,$start_date,$end_date);
         $socialPlatform = SocialPlatform::find($platform_id);
         $platformTotalLeads = LeadsMarketing::getLeadsSocialPlatformWise($platform_id, 1, $start_date,$end_date);
         ($platformTotalLeads > 0) ? $platformPercLeads = round(($platformTotalLeads * 100) / $totalLeads, 2) : '';
         $platFormsCalls = LeadsMarketing::getLeadsStats($platform_id, 0, 1, $start_date,$end_date);
        ($platFormsCalls > 0) ? $platFormsCallsPerc = round(($platFormsCalls * 100) / $platformTotalLeads, 2) : '';
         $platFormVisits = LeadsMarketing::getLeadsStats($platform_id, 6, 0, $start_date,$end_date);
        ($platFormVisits > 0) ? $platFormVisitsPerc = round(($platFormVisits * 100) / $platformTotalLeads, 2) : '';
        $platFormSale = LeadsMarketing::getLeadsStats($platform_id, 9, 0, $start_date,$end_date);
        ($platFormSale > 0) ? $platFormSalePerc = round(($platFormSale * 100) / $platformTotalLeads, 2) : '';
        $platFormDead = LeadsMarketing::getLeadsStats($platform_id, 10, 0, $start_date,$end_date);
        ($platFormDead > 0) ? $platFormDeadPerc = round(($platFormDead * 100) / $platformTotalLeads, 2) : '';

        $array = array(
            'totalLeads' => $totalLeads,
            'platFormName' => ($socialPlatform) ? $socialPlatform->platform : 'All Leads',
            'platFormColor' => ($socialPlatform) ? $socialPlatform->color_code : '#98AE9B  ',
            'platformTotalLeads' => $platformTotalLeads,
            'platformPercLeads' => $platformPercLeads,
            'platFormsCalls' => $platFormsCalls,
            'platFormsCallsPerc' => $platFormsCallsPerc,
            'platFormsVists' => $platFormVisits,
            'platFormsVistsPerc' => $platFormVisitsPerc,
            'platFormsSale' => $platFormSale,
            'platFormsSalePerc' => $platFormSalePerc,
            'platFormsDead' => $platFormDead,
            'platFormDeadPerc' => $platFormDeadPerc,
        );
        // $data->push($array);


        return $array;
        return view('call-center.reports.leads-analysis');

    }
    //emp-leads-analysis

    public function empLeadsAnalysis(Request $request)
    {
        $data['analysis'] = collect([]);
         $csr=getCSR();
         $start_date=date('Y-m-d');
         $end_date=date('Y-m-d');
        foreach ($csr as $csr) {
            $array = array(
                'agent' => $csr->name,
                'totalLeads' => LeadsMarketing::getEmpTotalLeads($csr->id, $start_date, $end_date, 1),
                'calls' => LeadsMarketing::getEmpTotalLeads($csr->id, $start_date, $end_date, 2),
                'not_approach' => LeadsMarketing::getEmpTotalLeads($csr->id, $start_date, $end_date, 3),
                'visit' => ApprochedLeads::getLeadsStatAcordingTemp($csr->id,6,$start_date,$end_date),
                'sale' => ApprochedLeads::getLeadsStatAcordingTemp($csr->id,9,$start_date,$end_date),
                'dead' => ApprochedLeads::getLeadsStatAcordingTemp($csr->id,10,$start_date,$end_date),
            );
            $data['analysis']->push($array);
        }
         $data['analysis'];
        return view('call-center.reports.emp-leads-analysis')->with(compact('data'));

    }

    //salesReport
    public function salesReport(Request $request)
    {
        if($request->isMethod('post')){
             $request->all();
            $sale = LeadsMarketing::getAllSales($request);
            $c=0;
            $output = '';
            foreach ($sale as $sale) {
                $c++;
                $output .= '<tr>
                    <td>' . $c . '</td>
                    <td>' . date('d-M-Y', strtotime($sale->created_at)) . '</td>
                    <td><a href="lead-detail/'.encrypt($sale->lead_id).'">' . $sale->lead_id . '</a></td>

                     <td><span class="badge bg-inverse-success">'.$sale->leads['name']. '</span></td>
                     <td><span class="badge bg-inverse-primary">' . $sale->agent['name'] . '</span></td>
                      <td>' . LeadsMarketing::countLeadFollowUps($sale->lead_id) . '</td>
                     </tr>';

            }
            $res = json_encode($output);
            return $res;
        }
        $data['saleReport'] = collect([]);
        $data['csr']=getCSR();
        $sale = LeadsMarketing::getAllSales($request);
        foreach ($sale as $sale) {

            $array = array(
                'date' => $sale->created_at,
                'lead_id' => $sale->lead_id,
                'c_name' => $sale->leads['name'],
                'sale_person' => $sale->agent['name'],
                'follow_ups' => LeadsMarketing::countLeadFollowUps($sale->lead_id),
            );
            $data['saleReport']->push($array);
        }
        return view('call-center.reports.sale-report')->with(compact('data'));
    }

    public function getSalesReport(Request $request)
    {
        $sale = LeadsMarketing::getAllSales($request);
        $c=0;
        $output = '';
        foreach ($sale as $sale) {
            $c++;
            $output .= '<tr>
                    <td>' . $c . '</td>
                    <td>' . date('d-M-Y', strtotime($sale->created_at)) . '</td>
                    <td><a href="lead-detail/'.encrypt($sale->lead_id).'">' . $sale->lead_id . '</a></td>

                     <td><span class="badge bg-inverse-success">'.$sale->leads['name']. '</span></td>
                     <td><span class="badge bg-inverse-primary">' . $sale->agent['name'] . '</span></td>
                      <td>' . LeadsMarketing::countLeadFollowUps($sale->lead_id) . '</td>
                     </tr>';

        }
        $res = json_encode($output);
        return $res;
    }
    //deadLeadReport

    public function deadLeadReport(Request $request)
    {
        if($request->isMethod('post')){
            $sale = LeadsMarketing::getDeadLeads($request);
            $c=0;
            $output = '';
            foreach ($sale as $sale) {
                $c++;
                $output .= '<tr>
                    <td>' . $c . '</td>
                    <td>' . date('d-M-Y', strtotime($sale->created_at)) . '</td>
                    <td><a href="lead-detail/'.encrypt($sale->lead_id).'">' . $sale->lead_id . '</a></td>

                     <td><span class="badge bg-inverse-success">'.$sale->leads['name']. '</span></td>
                     <td><span class="badge bg-inverse-primary">' . $sale->agent['name'] . '</span></td>
                      <td>' . $sale->dead_reason. '</td>
                      <td>' . $sale->comments. '</td>
                     </tr>';

            }
            $res = json_encode($output);
            return $res;
        }
        $data['saleReport'] = collect([]);
        $data['csr']=getCSR();
        return view('call-center.reports.dead-lead-report')->with(compact('data'));
    }
    //getDeadLeadReport

    public function getDeadLeadReport(Request $request)
    {
         $sale = LeadsMarketing::getDeadLeads($request);
        $c=0;
        $output = '';
        $agentName='';
        $deadReason='';
        foreach ($sale as $sale) {
            if($sale->agent){
                $agentName= $sale->agent['name'];
            }
       if($sale->dead_reason==1) {
           $deadReason = 'Politics Reason';
                }
            if($sale->dead_reason==2) {
                $deadReason = 'Economic Reason';
                }
            if($sale->dead_reason==3) {
                $deadReason = 'Out of Budget';
                }
            if($sale->dead_reason==4) {
                $deadReason = 'Not Interested In Properties';
                }
            if($sale->dead_reason==5) {
                $deadReason = 'Already Invested Other';
                }
            $c++;
            $output .= '<tr>
                    <td>' . $c . '</td>
                    <td>' . date('d-M-Y', strtotime($sale->created_at)) . '</td>
                    <td><a href="lead-detail/'.encrypt($sale->lead_id).'">' . $sale->lead_id . '</a></td>
                     <td><span class="badge bg-inverse-success">'.$sale->leads['name']. '</span></td>
                     <td><span class="badge bg-inverse-primary">' .$agentName. '</span></td>
                      <td>' .$deadReason. '</td>
                      <td>' . $sale->comments. '</td>
                     </tr>';

        }
        $res = json_encode($output);
        return $res;
    }

    //callsQaReport
    public function callsQaReport(Request $request)
    {
         $data['qa']=QaFeedBack::with('agent','leads')->get();
        return view('call-center.reports.qa-report')->with(compact('data'));
    }
}
