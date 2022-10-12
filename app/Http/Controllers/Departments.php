<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Validator;
use App\Models\Department;
use Carbon\Carbon;


class Departments extends Controller
{
    public function departments()
    {
        $data['companies'] = Company::all();
        return view('hr.dept.department')->with(compact('data'));
    }

    //save-department
    public function saveDepartment(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'company_id' => 'required',
            'dept_name' => 'required',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()->all()]);
        }

        if (Department::where('departments', $request->dept_name)->first()) {
            return response()->json(['errors' => 'This dept already exit'], 200);
        }

        $dept = new Department;
        $dept->company_id = $request->company_id;
        $dept->departments = $request->dept_name;
        if ($dept->save()) {
            return response()->json(['success' => 'Record save successfully'], 200);
        }
    }

    //getDepartment
    public function getDepartment()
    {
        $qry =  Department::query();
        $qry =  $qry->with(['getCompanyName' => function ($query) {
            $query->select('id', 'name');
        }]);
        $qry = $qry->orderBy('id', 'DESC')->get();
        echo json_encode($qry);
    }

    //editDepartment
    public function editDepartment(Request $request)
    {
        $dept = Department::find($request->id);
        $company = Company::all();
        return response()->json([
            'company' => $company,
            'dept' => $dept,
        ]);
    }

    public  function updateDepartment(Request $request)
    {

        $dept = Department::find($request->dept_id);
        $dept->departments = $request->edit_dept_name;
        $dept->company_id = $request->company_id;

        if ($dept->save()) {
            return response()->json(['success' => 'Save changes successfully'], 200);
        }
    }

    //deleteeDepartment
    public function deleteeDepartment(Request $request)
    {

        $dept = Department::find($request->id);

        if ($dept) {

            if ($dept->delete()) {
                return response()->json(['success' => 'Record deleted successfully'], 200);
            } else {
                return response()->json(['error' => 'Record not deleted'], 200);
            }
        } else {
            return response()->json(['error' => 'Data not exist'], 200);
        }
    }

    //getDeptRespectToCompany
    public function getDeptRespectToCompany(Request $request)
    {
        return Department::where('company_id', $request->company_id)->get();
    }
}
