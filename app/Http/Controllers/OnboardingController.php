<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyBranch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Policy;
use Illuminate\Support\Facades\Redirect;

class OnboardingController extends Controller
{
    public function index()
    {
        $data['policy'] = Policy::with('company')->select('policies.*')->get();
        return view('policies.index')->with(compact('data'));
    }

    //createPolicies
    public function createPolicies()
    {
        $data['company'] = Company::all();
        return view('policies.create-policies', compact('data'));
    }

    //savePolicies


    public function savePolicies(Request $request)
    {

        $this->validate($request, [
            'policy' => 'required',
            'rules' => 'required',
            'confidentail_info' => 'required',

        ]);

        $policy = new Policy();
        $policy->company_id = $request->company_id;
        $policy->policies = $request->policy;
        $policy->rules = $request->rules;
        $policy->confidentional_info = $request->confidentail_info;

        if ($policy->save())
        {
            return Redirect::back()->withSuccess(['success', 'Record save successfully']);
        }
    }


    //deletePolicies
    public function deletePolicies($id)
    {

        $poliicy = Policy::find($id);
        if ($poliicy->delete()) {
            return Redirect::back()->withSuccess(['success', 'Record deleted successfully']);
        } else {
            return Redirect::back()->withErrors(['error', 'Record not deleted']);
        }
    }




    public function editPolicies($id)
    {
        $data['policy'] = Policy::where('id', $id)->first();
        $data['company'] = Company::all();
        return view('policies.policies-edit')->with(compact('data'));
    }


    //updatePolicies

    public function updatePolicies(Request $request)
    {

        $policy = Policy::find($request->hidden_policy_id);

        $policy->company_id = $request->company_id;
        $policy->policies = $request->policy;
        $policy->rules = $request->rules;
        $policy->confidentional_info = $request->confidentail_info;

        if ($policy->save()) {



            return Redirect::back()->withSuccess(['success', 'Record update successfully']);
        }
    }

    //offerLetter

    public function offerLetter()
    {
        $data['company'] = Company::all();
        return view('policies.offer-letter')->with(compact('data'));
    }

    //
    public function getEmployeeBaseDesignation(Request $request)
    {
        $desig_id = $request->desig_id;
        $res = getEmployeeAcordigToDesignation($desig_id);
        echo json_encode($res);
    }


    //offerLetterTest
    public function createOfferLetter($emp_id)
    {
        $data['employee'] = Employee::find($emp_id);
        $data['policy'] = Policy::first();
        $data['companyName']=Company::getCompanyName($data['employee']->company_id);
        return view('policies.offer-letter-create')->with(compact('data'));
    }

    //getDeptRespectToCompany
    public function getEmpByCompany(Request $request)
    {
        return Employee::where('company_id', $request->company_id)->get();
    }

    //getLocationOnTheBaseOfCompany

    public function getLocationOnTheBaseOfCompany(Request $request)
    {
        return CompanyBranch::where('company_id', $request->company_id)->get();
    }
}
