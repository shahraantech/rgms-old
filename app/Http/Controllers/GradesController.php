<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use Validator;

class GradesController extends Controller
{
    public function index()
    {
        return view('grades.index');
    }


    //gradesList
    public function gradesList()
    {
        echo json_encode(Grade::orderBy('id','desc')->get());
    }

    //saveGrade
    public function saveGrade(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'grade' => 'required',
            'grade_cat' => 'required',

        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $grade = new Grade();
        $grade->grade = $request->grade;
        $grade->grade_cat = $request->grade_cat;

        if ($grade->save()) {
            return response()->json(['success' => 'Grades save successfully'], 200);


        }
    }

    //deleteGrade

    public function deleteGrade(Request $request)
    {

        $grade = Grade::find($request->id);

        if ($grade) {

            if ($grade->delete()) {
                return response()->json(['success' => 'Record deleted successfully'], 200);
            } else {
                return response()->json(['error' => 'Record not deleted'], 200);
            }

        } else {
            return response()->json(['error' => 'Data not exist'], 200);
        }
    }


    public function editGrade(Request $request)
    {
        $id = $request->id;
        $grade = Grade::find($id);
        echo json_encode($grade);
    }


    public function updateGrade(Request $request)
    {


        $data = $request->all();
        $rules = array(
            'grade' => 'required',
            'grade_cat' => 'required',
        );


        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }


        $grade = Grade::find($request->hidden_grade_id);
        $grade->grade = $request->grade;
        $grade->grade_cat = $request->grade_cat;
        if ($grade->save()) {
            return response()->json(['success'=>'Save changes successfully'],200);
        }
    }
}
