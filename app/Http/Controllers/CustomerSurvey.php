<?php

namespace App\Http\Controllers;

use App\Imports\CustomerSurvryImport;
use App\Models\CustomerServey;
use App\Models\ServeyRemarks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CustomerSurvey extends Controller
{
    public function index(){
        $data['survey']= CustomerServey::orderBy('id','DESC')->paginate(20);
        return view('call-center.survey.index')->with(compact('data'));
    }

    //importCustomerSurvey
    public function importCustomerSurvey(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'file' => 'required|mimes:xlsx, xls',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return Redirect::back()->withErrors(['errors', 'CSV File Required!']);
        }


        $res = Excel::import(new CustomerSurvryImport(), request()->file('file'));
        return Redirect::back()->withSuccess(['success', 'Leads import successfully']);
    }

    //viewCustomerSurvey

    public function viewCustomerSurvey($survey_id)
    {
        $data['survey']=CustomerServey::find(decrypt($survey_id));
        $data['remarks']=ServeyRemarks::where('servey_id',decrypt($survey_id))->first();

        return view('call-center.survey.view-customer-survey')->with(compact('data'));
    }



    public function customerServay()
    {
        $cs = CustomerServey::where('agent_id',Auth::user()->account_id)->where('status','0')->orWhere('status','2')->paginate(10);
        return view('call-center.survey.customer-survey', get_defined_vars());
    }

    public function servayRmarks($id)
    {
        $srmarks = CustomerServey::find(decrypt($id));
        return view('call-center.survey.create-survey-remarks', get_defined_vars());
    }

    public function storeServayRmarks(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'age' => 'required',
            'address' => 'required',
            'is_married' => 'required',
            'intrest' => 'required',
            'profession' => 'required',
            'is_dependent' => 'required',

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $sr = new ServeyRemarks();
        $sr->servey_id = $request->servey_id;
        $sr->age = $request->age;
        $sr->address = $request->address;
        $sr->is_married = $request->is_married;
        $sr->profession = $request->profession;
        $sr->intrest = $request->intrest;
        $sr->is_dependent = $request->is_dependent;
        $sr->remarks = $request->remarks;
        $sr->save();

        if($sr->save())
        {
           $survey= CustomerServey::find($request->servey_id);
            $survey->status=1;
            $survey->save();
            return redirect('customer-survey')->with('success', 'Survey remarks added successfully!');

        }
    }

    //notIntrested

    public function notIntrested($id)
    {
            $survey= CustomerServey::find(decrypt($id));
            $survey->status=3;
            $survey->save();
            return redirect('customer-survey')->with('success', 'Survey remarks added successfully!');

    }

//notConnected

    public function notConnected($id)
    {
        $survey= CustomerServey::find(decrypt($id));
        $survey->status=2;
        $survey->save();
        return redirect('customer-survey')->with('success', 'Survey remarks added successfully!');

    }

}
