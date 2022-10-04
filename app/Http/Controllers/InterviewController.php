<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\Interviews;
use App\Models\Applicant;
use App\Models\Designation;
use Redirect;
use Validator;

class InterviewController extends Controller
{
    //saveInterview

    public function saveInterview(Request $request)
    {


        $data = $request->all();
        $applicant_id = $request->hidden_applicant_id;
        $rules = array(
            'interview_time' => 'required|max:8',
            'interview_date' => 'required',

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }

        if (Interviews::where('applicant_id', $request->hidden_applicant_id)->first()) {


            return response()->json(['errors' => 'Already applied'], 200);
        } else {



            $interview = new Interviews;

            $interview->applicant_id = $applicant_id;
            $interview->interview_time    = $request->interview_time;
            $interview->interview_date = $request->interview_date;
            $interview->status = 'scheduled';

            if ($interview->save()) {
                // code for applicant update
                $applicant = Applicant::find($applicant_id);
                $applicant->status = 'scheduled';
                $applicant->save();

                return response()->json(['success' => 'Save successfully'], 200);
            }
        }
    }


    //interviews
    public function interviews(Request $request)
    {

        $qry = $data['interviews'] = Interviews::join('applicants', 'applicants.id', '=', 'interviews.applicant_id')
            ->join('designations', 'designations.id', '=', 'applicants.desig_id')
            ->join('departments', 'departments.id', '=', 'designations.dept_id')
            ->select('designations.desig_name', 'departments.departments', 'applicants.*', 'interviews.id as interviewId', 'interviews.interview_time', 'interviews.interview_date', 'interviews.created_at as created')
            ->where('applicants.status', '=', 'scheduled')
            ->orderBy('interviews.id', 'Desc');

            //search filter
        if ($request->isMethod('post')) {

            $qry = $qry->when($request->job_id, function ($query, $job_id) {
                return $query->where('applicants.job_id', $job_id);
            });

            $qry = $qry->when($request->name, function($query, $name) {
                return $query->where('applicants.name', $name);
            });
        }

        $data['interviews'] = $qry->get();
        $data['designation'] = Designation::all();

        return view('jobs.interviews')->with(compact('data'));
    }

    //resheduleInterview

    public function resheduleInterview(Request $request)
    {
        echo json_encode(Interviews::find($request->id));
    }

    //updateInterview

    public function updateInterview(Request $request)
    {


        $data = $request->all();
        $rules = array(
            'interview_time' => 'required|max:8',
            'interview_date' => 'required',

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }

        $interview = Interviews::find($request->hidden_interview_id);

        $interview->interview_time    = $request->interview_time;
        $interview->interview_date = $request->interview_date;
        if ($interview->save()) {
            return response()->json(['success' => 'Record updated successfully']);
        }
    }
}
