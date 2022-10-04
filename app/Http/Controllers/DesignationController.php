<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Designation;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;

class DesignationController extends Controller
{


    public function getDesignations(Request $request)
    {
        return Designation::where('dept_id', $request->dept_id)->get();
    }

    //
    public function index(Request $request)
    {
        $data['dept'] = Department::all();
        return view('hr.designations.index')->with(compact('data'));
    }


    public function designationList()
    {

        $res = Designation::join('departments', 'departments.id', '=', 'designations.dept_id')
            ->select('departments.departments', 'designations.*')
            ->orderBy('designations.id', 'Desc')
            ->get();
        echo  json_encode($res);
    }


    //saveDesig
    public  function saveDesig(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'desig_name' => 'required',

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }

        if(Designation::where('desig_name',$request->desig_name)->first()){
            return response()->json(['errors' =>'This designation already exist']);
        }

        $desig = new Designation();
        $desig->dept_id = $request->dept_id;
        $desig->desig_name = $request->desig_name;
        if ($desig->save()) {
            return response()->json(['success' => 'Designation save successfully'], 200);
        }
    }

    //deleteDesignation
    public function deleteDesignation(Request $request)
    {

        $desig = Designation::find($request->id);

        if ($desig) {

            if ($desig->delete()) {
                return response()->json(['success' => 'Record deleted successfully'], 200);
            } else {
                return response()->json(['error' => 'Record not deleted'], 200);
            }
        } else {
            return response()->json(['error' => 'Record not exist'], 200);
        }
    }


    //editDesignation
    public function editDesignation(Request $request)
    {

        $desig = Designation::where('id', $request->id)->first();
        echo json_encode($desig);
    }


    //updateDesignation
    public  function updateDesignation(Request $request)
    {



        $data = $request->all();
        $rules = array(
            'edit_desig_name' => 'required',

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }


        $desig = Designation::find($request->hiiden_desig_id);
        $desig->desig_name = $request->edit_desig_name;

        if ($desig->save()) {
            return response()->json(['success' => 'Record updated successfully'], 200);
        }
    }
}
