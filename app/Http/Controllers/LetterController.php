<?php

namespace App\Http\Controllers;

use App\Models\Asign_asset;
use App\Models\Company;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Policy;
use Illuminate\Http\Request;

class LetterController extends Controller
{
    //expLetter
    public function expLetter()
    {
        $data['company'] = Company::all();
        return view('policies.exp-letter')->with(compact('data'));
    }


    public function clearanceLetter()
    {
        $data['company'] = Company::all();
        return view('policies.clearance-letter')->with(compact('data'));
    }

    //createLetter

    public function createLetter($empId)
    {

        $data['employee'] = Employee::leftJoin('resignations', 'resignations.emp_id', 'employees.id')
            ->where('employees.id', $empId)
            ->select('resignations.resign_date', 'employees.*')->first();
        $data['letterTitle'] = 'Experience Letter';
        $data['companyName'] = Company::getCompanyName($data['employee']->company_id);
        return view('policies.letter-create')->with(compact('data'));
    }


    //createClearanceLetter

    public function createClearanceLetter($empId)
    {

        $employee = Employee::join('designations', 'designations.id', 'employees.desg_id')
            ->leftJoin('resignations', 'resignations.emp_id', 'employees.id')
            ->where('employees.id', $empId)
            ->select('designations.desig_name', 'resignations.resign_date', 'employees.*')
            ->first();

        $companyName = Company::getCompanyName($employee->company_id);
        $asign_assets = Asign_asset::where('emp_id', $empId)->get();
        return view('policies.clearance-letter-create', get_defined_vars());
    }

    //getDeptRespectToCompany
    public function getDepartByCompany(Request $request)
    {
        return Department::where('company_id', $request->company_id)->get();
    }
}
