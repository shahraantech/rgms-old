<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApprochedLeads;
use App\Models\AssignedLeads;
use App\Models\City;
use App\Models\Lead;
use App\Models\LeadSetting;
use App\Models\LeadsMarketing;
use App\Models\SocialPlatform;
use App\Models\Temprature;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class LeadsController extends Controller
{

    public function getleads(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'emp_id' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $emp_id = $request->emp_id;

        $new = AssignedLeads::getEmpNewLeads($emp_id, 'counting');
        $data['newLeads'] = $new;
        $thisMonth = AssignedLeads::getEmpThisMonthLeads($emp_id);
        $data['thisMonthLeads'] = $thisMonth->count();
        $total = AssignedLeads::getEmpTotalLeads($emp_id);
        $data['totalLeads'] = $total->count();
        $data['todayFollowUps'] = todayFollowupLeads('agent', 'count', $emp_id);
        $tomorow = tommrowFollowupLeads($emp_id, 'counting');
        $data['tomorrowFollowUps'] = $tomorow;
        $notapp = AssignedLeads::getEmpNotApproachesLeads($emp_id);
        $data['getNotApproachedLeads'] = $notapp->count();
        $overDate = ApprochedLeads::getEmpOverDueLeads($emp_id, 'counting');
        $data['overDueLeads'] = $overDate;
        $response = createAPIResponce($is_error = false, $code = 200, $message = 'data  found', $data);
        return response()->json($response);


    }
    //todayActivity
    public function todayActivity(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'emp_id' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $emp_id = $request->emp_id;
        $data['todayActivity'] = collect([]);
        $temp = Temprature::all();
        foreach ($temp as $temp) {
            $appLeads = ApprochedLeads::getTempratureWiseLeads($temp->id, 'counting', 'csr', $emp_id);
            $array = array(
                $temp->temp => $appLeads,

            );
            $data['todayActivity']->push($array);
        }
        return $data;
    }
    //todayCalls
    public function todayCalls(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'emp_id' => 'required',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $emp_id = $request->emp_id;

        $data['totalCalls'] = ApprochedLeads::where('agent_id', $emp_id)->whereDate('created_at', Carbon::today())->count();
        $data['connected'] = ApprochedLeads::where('agent_id', $emp_id)->where('is_connected', 1)->whereDate('created_at', Carbon::today())->count();
        $data['notConnected'] = ApprochedLeads::  where('agent_id', $emp_id)->where('is_connected', 0)->whereDate('created_at', Carbon::today())->count();
        return $data;


    }
    //empAllLeads
    public function empAllLeads(Request $request)
    {
        $data = $request->all();
        $emp_id = $request->emp_id;
        $qry = AssignedLeads::query();
        $qry = $qry->with('leads', 'leads.cityname');
        $qry = $qry->where('agent_id', $emp_id);
        $qry = $qry->orderBy('id', 'DESC');
        $qry = $qry->paginate(20);

        if ($qry->count() > 0) {
            return $qry;

        } else {
            $response = $this->createAPIResponce($is_error = true, $code = 400, $message = 'data not found', $qry);
            return response()->json($response, $status = 400);
        }
    }
    public function getleadsWithParams(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'emp_id' => 'required',
            'sender' => 'required',
            'lead_type' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $lead_type = $request->lead_type;
        $sender = 'agent';
        $emp_id = $request->emp_id;

        $data['assigned_leads'] = [];
        $data['leadType'] = '';
        if ($lead_type == 1) {
            $data['leadType'] = 'Today';
            $data['assigned_leads'] = todayFollowupLeads($sender, 'not count', $emp_id);
        }
        if ($lead_type == 2) {
            $data['leadType'] = 'Tomorrow Followups';
            $data['assigned_leads'] = tommrowFollowupLeads($emp_id, NULL);
        }
        if ($lead_type == 3) {
            $data['leadType'] = 'Not Approached';
            $data['assigned_leads'] = AssignedLeads::getNotApproachesLeads($emp_id, 'not counting', $sender);
        }
        if ($lead_type == 4) {
            $data['leadType'] = 'Over Due';
            $data['assigned_leads'] = ApprochedLeads::getEmpOverDueLeads($emp_id, NULL);
        }
        if ($lead_type == 5) {
            $data['assigned_leads'] = AssignedLeads::getEmpNewLeads($emp_id, NULL);
            $data['leadType'] = 'New';
        }

        //emp all leads
        if ($lead_type == 6) {
            $data['leadType'] = 'All';
            $qry = AssignedLeads::query();
            $qry = $qry->with('leads', 'leads.cityname');
            $qry = $qry->where('agent_id', $emp_id);
            $qry = $qry->orderBy('id', 'DESC');
            $data['assigned_leads'] = $qry->paginate(20);
        }
        return $data;
    }
    public function getleadsTemp(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'lead_id' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $lead_id = $request->lead_id;
        $lead = ApprochedLeads::getTempComments($lead_id);
        $data['temp'] = 'Open';
        $data['comments'] = '-';
        if ($lead) {
            $data['temp'] = $lead->temp;
            $data['comments'] = $lead->comments;
        }
        return $data;
    }
    //getTempWiseLeads
    public function getTempWiseLeads(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'temp_id' => 'required',
            'emp_id' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $temp_id = $request->temp_id;
        $emp_id = $request->emp_id;
        $data['assigned_leads'] = ApprochedLeads::getTempratureWiseLeads($temp_id, 'not count', 'csr', $emp_id);
        $response = $this->createAPIResponce($is_error = false, $code = 200, $message = 'data  found', $data['assigned_leads']);
        return response()->json($response, $status = 200);
    }
    public function saveLeadsRemarks(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'emp_id' => 'required',
            'lead_id' => 'required',
            'temp_id' => 'required',
            'comments' => 'required',
            'follow_date' => 'required|date|after:yesterday'
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $temp=Temprature::where('temp',$request->temp_id)->first();

        $lead_id =$request->lead_id;
        $emp_id = $request->emp_id;
        $temp_id = $temp->id;
        $is_connected =$request->is_connected;
        $comments =$request->comments;
        $follow_date = $request->follow_date;
        $time = $request->time;
        $lead_type =$request->lead_type;

        //update leads approach
        $appLeadFind=0;
        $appStat = ApprochedLeads::where('lead_id', $lead_id)->latest('id')->first();
        if ($appStat) {
            $appLeadFind=1;
            $appStat->status =1;
        }

        $chekTodayFollow = ApprochedLeads::where('lead_id', $lead_id)->where('followup_date', $follow_date)->first();
        if ($chekTodayFollow) {
            return response()->json(['errors' => 'This lead already be saved on same followup date'], 200);
        }


        $app = new ApprochedLeads();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension() . '.mp3';
            $filename = time() . '.' . $extension;
            $file->move('storage/app/public/uploads/leedRecording/', $filename);
            $app->audio = $filename;
        }

        $app->lead_id = $lead_id;
        $app->agent_id = $emp_id;
        $app->temp_id = $temp_id;
        $app->is_connected = ($is_connected) ? 1 : 1;
        $app->comments = $comments;
        $app->audio_call_rec = $request->call_rec;
        $app->followup_date = ($follow_date) ? $follow_date : '';
        $app->follow_time = ($time) ? $time : '';
        $app->lead_type = ($lead_type) ? 1 : 0;

        if ($app->save()) {
            if($appLeadFind==1) {
                $appStat->save();
            }
            //update assigned leads
            AssignedLeads::where('lead_id', $lead_id)->update(['status' => 1]);


            return response()->json([
                'status' => 200,
                'message' => 'Leeds remarks save successfully',
            ]);
        }
    }
    public function getAllTemp()
    {
        $res = Temprature::getAllTemp();
        $response = $this->createAPIResponce($is_error = false, $code = 200, $message = 'data  found', $res);
        return response()->json($response, $status = 200);
    }
    public function getAllCity()
    {
        $res = City::getAllCity();
        $response = $this->createAPIResponce($is_error = false, $code = 200, $message = 'data  found', $res);
        return response()->json($response, $status = 200);
    }
    public function getSocialPlatforms()
    {
        $res = SocialPlatform::getSocialPlatforms();
        $response = $this->createAPIResponce($is_error = false, $code = 200, $message = 'data  found', $res);
        return response()->json($response, $status = 200);
    }
    public function chekTodayLeadApproach(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'lead_id' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $lead_id = $request->lead_id;
        $chek = ApprochedLeads::chekTodayApproch($lead_id);
        if ($chek) {
            return 1;
        } else {
            return 0;
        }
    }
    public function getLeadsInfo(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'lead_id' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        return $leads = LeadsMarketing::getLeadsInfo($request->lead_id);

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
    //updateLeadsStatus
    public function updateLeadsStatus(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'id' => 'required',
            'temp_id' => 'required',
            'is_connected' => 'required',
            'remarks' => 'required',
            'followup_date' => 'required|date'
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $app = ApprochedLeads::find($request->id);
        if ($app) {
            $app->temp_id = $request->temp_id;
            $app->is_connected = $request->is_connected;
            $app->comments = $request->remarks;
            $app->followup_date = $request->followup_date;
            if ($app->save()) {
                return response()->json(['success' => 'Lead remarks updated successfully'], 200);
            } else {
                return response()->json(['success' => 'Lead remarks not updated '], 200);
            }
        } else {
            return response()->json(['error' => 'Record not found'], 200);
        }
    }
    //editLeadsRemarks
    public function editLeadsRemarks(Request $request)
    {

        $id = $request->id;
        $temp = Temprature::all();
        $appLeads = ApprochedLeads::select('id','lead_id','temp_id','is_connected','followup_date','comments')->where('id',$id)->first();
        if ($appLeads) {
            return $appLeads;
            return response()->json([
                'appLeads' => $appLeads,
                'temp' => $temp,
            ]);
        } else {
            return response()->json(['error' => 'Record not found'], 200);

        }
    }
    //getLeadDetail
    public function getLeadDetail(Request $request)
    {
         $lead_id=$request->lead_id;
        $app_lead= ApprochedLeads::with('agent', 'temp')
            ->where('lead_id', $lead_id
            )->where('lead_type', 0)
            ->orderByDesc('id')->get();
if($app_lead->count() ==0){
    return response()->json(['error' => 'Record not found'], 200);
}
        $data = collect([]);

        foreach ($app_lead as $appLead) {
            $array = array(
                'approach_by' => $appLead->agent['name'],
                'temp' => $appLead->temp['temp'],
                'lead_type' => ($appLead->lead_type==0)?'Inbound':'OutBound',
                'followup_date' => $appLead->followup_date,
                'comments' =>  $appLead->comments,
                'created_at' => $appLead->created_at,
            );

            $data->push($array);
        }
        return $data;
    }
    public function getApproachedLeads(Request $request)
    {
       return $res=ApprochedLeads::select('lead_id','agent_id','temp_id','comments','followup_date','audio_call_rec')->get();
    }
    public function deleteApprochedLeads(Request $request)
    {
        $lead_id=$request->lead_id;
        $asset = ApprochedLeads::where('lead_id',$lead_id)->delete();
        return response()->json(['success' => 'Record deleted'], 200);

    }


    public function storeInBoundLeads(Request $request)
    {

         $data = $request->all();
        $rules = array(
            'name' => 'required',
            'contact' => 'required',
            'source' => 'required',
            'temp' => 'required',
            'city' => 'required',
            'interest' => 'required',
            'comments' => 'required',
            'user_id' => 'required',
            'followup_date' => 'required',

        );
        $validator = \Illuminate\Support\Facades\Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

         $temp=Temprature::where('temp',$request->temp)->first();
         $socialPlatForm=SocialPlatform::where('platform',$request->source)->first();
         $city=City::where('city_name',$request->city)->first();

        if (!LeadsMarketing::where('contact', $request->contact)->first()) {
            $lead = new LeadsMarketing();
            $lead->name = $request->name;
            $lead->contact = $request->contact;
            $lead->city_id =$city->id;
            $lead->platform_id =$socialPlatForm->id;
            $lead->address = $request->address;
            $lead->lead_type ='inbound';
            $lead->interest = $request->interest;
            $lead->user_id = $request->user_id;

            if ($lead->save()) {
                if (!AssignedLeads::where('lead_id', $lead->id)->where('agent_id',$request->user_id)->first()) {

                        $assign = new AssignedLeads();
                        $assign->lead_id = $lead->id;
                        $assign->agent_id =$request->user_id;
                        $assign->type = 'lead';
                        $assign->status = 1;
                        $assign->save();

                        //save approache leads

                        $appr = new ApprochedLeads();
                        $appr->lead_id = $lead->id;
                        $appr->agent_id =$request->user_id;
                        $appr->temp_id =$temp->id;
                        $appr->comments = $request->comments;
                        $appr->followup_date = $request->followup_date;
                        $appr->audio_call_rec = $request->call_rec;
                        $appr->save();
                    }


                return response()->json(['success' => 'Lead save successfully'], 200);
            }
        } else {
            return response()->json(['errors' => 'This lead already exist'], 200);
        }
    }

}
