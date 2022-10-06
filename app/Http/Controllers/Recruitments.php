<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\Company;
use App\Models\Designation;
use App\Models\Emp_qualification;
use App\Models\Employee;
use App\Models\Experience;
use App\Models\Interviews;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Recruitment;
use App\Models\Applicant;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Toastr;

class Recruitments extends Controller
{
    //existing

    public function existing()
    {
        $data['existing'] = Applicant::join('designations', 'designations.id', '=', 'applicants.desig_id')
            ->join('departments', 'departments.id', '=', 'designations.dept_id')
            ->select('designations.desig_name', 'departments.departments', 'applicants.*')
            ->where('applicants.status', '!=', 'new')
            ->orderBy('applicants.id', 'Desc')
            ->get();
        $data['desig'] = Designation::getDesignation();
        return view('hr.recruitment.cv-bank')->with(compact('data'));
    }

    public function existingList()
    {
        $data = Applicant::join('designations', 'designations.id', '=', 'applicants.desig_id')
            ->join('departments', 'departments.id', '=', 'designations.dept_id')
            ->select('designations.desig_name', 'departments.departments', 'applicants.*')
            ->where('applicants.status', '!=', 'new')
            ->orderBy('applicants.id', 'Desc')
            ->get();
        echo json_encode($data);
    }



    //existing

    public  function  newHiring(Request $request)
    {
        if ($request->isMethod('post')) {

            return  $rec = Recruitment::join('designations', 'designations.id', '=', 'recruitments.desg_id')
                ->join('departments', 'departments.id', '=', 'designations.dept_id')
                ->when($request->job_title, function ($query, $job_title) {
                    return $query->where('recruitments.desg_id', $job_title);
                })
                ->when($request->job_type, function ($query, $job_type) {
                    return $query->where('recruitments.job_type', $job_type);
                })
                ->when($request->status, function ($query, $status) {
                    return $query->where('recruitments.status', $status);
                })
                ->select('designations.desig_name', 'departments.departments', 'recruitments.*')
                ->get();
        }

        $data['shareButtons'] = \Share::page(
            'https://rgms.shahraantech.com/job/list',
        )
        ->facebook()
        ->twitter()
        ->reddit()
        ->linkedin()
        ->whatsapp()
        ->telegram();

        $data['dept'] = Department::orderBy('id', 'desc')->get();
        $data['title'] = Designation::orderBy('id', 'desc')->get();
        return view('hr.recruitment.new-hiring')->with(compact('data'));
    }

    //newHiringForm
    public function newHiringForm()
    {
        $data['dept'] = Department::orderBy('id', 'desc')->get();
        $data['title'] = [''];
        $data['companies'] = Company::all();
        return view('hr.recruitment.new-form')->with(compact('data'));
    }

    //saveNewHiring
    public function saveNewHiring(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'designation' => 'required',
            'shift' => 'required',
            'salary' => 'required',
            'job_type' => 'required',
            'exp' => 'required',
            'vacancies' => 'required',
            'job_description' => 'required',

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {


            //return Redirect::back()->withError(['errors', $validator->errors()]);
            return response()->json(['field_errors' => $validator->errors()->toArray()]);
        }
        if (Recruitment::where([['desg_id', $request->designation], ['status', 'open']])->first()) {
            return response()->json(['errors' => 'Job already created'], 200);
        }

        $rec = new Recruitment;
        $rec->desg_id = $request->designation;

        $rec->shift = $request->shift;
        $rec->job_type = $request->job_type;
        $rec->experience = $request->exp;
        $rec->last_date = $request->last_date;
        $rec->location = $request->location;
        $rec->salary = $request->salary;
        $rec->vacancies = $request->vacancies;
        $rec->desc = $request->job_description;
        $rec->status = 'open';
        if ($rec->save()) {
            // return Redirect::back()->withSuccess(['success', 'Record save successfully']);
            return response()->json(['success' => 'Record save successfully'], 200);
        }
    }

    //getNewHiring
    public function getNewHiring()
    {

        $rec = Recruitment::join('designations', 'designations.id', '=', 'recruitments.desg_id')
            ->join('departments', 'departments.id', '=', 'designations.dept_id')
            ->select('designations.desig_name', 'departments.departments', 'recruitments.*')
            ->get();
        echo json_encode($rec);
    }



    //deleteRecruitment
    public function deleteRecruitment(Request $request)
    {

        $res = Recruitment::find($request->id);

        if ($res) {

            if ($res->delete()) {
                return response()->json(['success' => 'Record deleted successfully'], 200);
            } else {
                return response()->json(['error' => 'Record not deleted'], 200);
            }
        } else {
            return response()->json(['error' => 'Data not exist'], 200);
        }
    }

    //editRecruitment

    public function editRecruitment($id)
    {
        $data['hiring'] = Recruitment::where('id', $id)->first();
        if ($data['hiring']) {
            $data['desig'] = Designation::all();

            return view('hr.recruitment.edit-recruitment')->with(compact('data'));
        }
    }



    public function updateRecruitment(Request $request)
    {
        $data = $request->all();

        $rules = array(
            'designation' => 'required',

            'shift' => 'required',
            'salary' => 'required',
            'job_type' => 'required',
            'exp' => 'required',
            'vacancies' => 'required',

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }


        $rec = Recruitment::find($request->hidden_rec_id);
        $rec->desg_id = $request->designation;

        $rec->shift = $request->shift;
        $rec->job_type = $request->job_type;
        $rec->experience = $request->exp;
        $rec->last_date = $request->last_date;
        $rec->location = $request->location;
        $rec->salary = $request->salary;
        $rec->vacancies = $request->vacancies;
        $rec->status = $request->job_status;
        $rec->desc = $request->des;
        if ($rec->save()) {
            return Redirect::back()->withSuccess(['success', 'Record update successfully']);
        }
    }
}
