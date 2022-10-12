<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Resignation;
use Validator;


class ResignationController extends Controller
{

    //index
    public function index()
    {
        return view('resignation.index');
    }
    //saveResignation
    public function saveResignation(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'notice_date' => 'required',
            'resign_date' => 'required',
            'reason' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }

        $resig = new Resignation();
        $resig->emp_id = Auth::user()->account_id;
        $resig->notice_date = $request->notice_date;
        $resig->resign_date = $request->resign_date;
        $resig->reason = $request->reason;
        $resig->status = 'new';

        if ($resig->save()) {
            return response()->json(['success' => 'Record save successfully'], 200);
        }
    }


    //edit Resignation
    public function editResignation(Request $request)
    {
        $resig = Resignation::find($request->id);
        if ($resig) {
            return json_encode($resig);
        }
    }


    //update Resignation
    public function updateResig(Request $request)
    {
        $resig = Resignation::find($request->reg_id);
        $resig->notice_date = $request->notice_date;
        $resig->resign_date = $request->resign_date;
        $resig->reason = $request->reason;
        if ($resig->update()) {
            return response()->json([
                'status' => 200,
                'message' => 'resignation updated successfully'
            ]);
        }
    }

    public function deleteResig(Request $request)
    {
        $resig = Resignation::find($request->id);
        if ($resig->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'resig deleted successfully'
            ]);
        }
    }

    //resignationList
    public function resignationList()
    {
        $data = Resignation::join('employees', 'employees.id', '=', 'resignations.emp_id')
            ->join('designations', 'designations.id', '=', 'employees.desg_id')
            ->select('designations.desig_name', 'employees.*', 'resignations.*')
            ->orderBy('employees.id', 'Desc')
            ->where('emp_id', Auth::user()->account_id)
            ->get();

        echo json_encode($data);
    }

    //resignationsListForHr

    public function resignationsListForHr()
    {
        $data['department'] = Department::all();
        $data['employees'] = Employee::all();
        return view('resignation.resignations-list-for-hr', compact('data'));
    }

    //resignationListData
    public function resignationListData(Request $request)
    {

        $qry = Resignation::join('employees', 'employees.id', '=', 'resignations.emp_id')
            ->join('designations', 'designations.id', '=', 'employees.desg_id')
            ->select('designations.desig_name', 'employees.*', 'resignations.*')
            ->orderBy('employees.id', 'Desc');

        //search filter
        if($request->isMethod('post'))
        {
            $qry = $qry->when($request->emp_id, function($query, $emp_id) {
                return $query->where('resignations.emp_id', $emp_id);
            });

            $qry = $qry->when($request->desg_id, function($query, $desg_id) {
                return $query->where('employees.desg_id', $desg_id);
            });
        }

        $data = $qry->get();
        echo json_encode($data);
    }


    //updateResignation

    public function updateResignation(Request $request)
    {
        $resig = Resignation::find($request->id);
        $resig->status = $request->status;

        if ($resig->save()) {
            updateEmployeeStatus($resig->emp_id);
            return response()->json(['success' => 'Save changes successfully'], 200);
        }
    }
}
