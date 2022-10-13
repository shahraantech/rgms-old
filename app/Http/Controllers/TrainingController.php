<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Trainer;
use Illuminate\Http\Request;
use App\Models\Training;
use Illuminate\Support\Facades\Event;
use App\Events\SendTrainingMailEvent;
use Illuminate\Support\Facades\Validator;

class TrainingController extends Controller
{

    protected $userId;

    public function __construct()
    {

        $this->middleware(function (Request $request, $next) {
            if (!\Auth::check()) {
                return redirect('/login');
            }
            $this->userId = \Auth::user()->account_id; // you can access user id here

            return $next($request);
        });
    }
    //empTargets
    public function index()
    {

        $data['employee'] = Employee::all();
        $data['trainer'] = Trainer::all();
        $data['training'] = Training::join('employees', 'employees.id', '=', 'trainings.emp_id')
            ->select('employees.name', 'employees.image', 'trainings.*')
            ->groupBy('trainings.training_type', 'trainings.from', 'trainings.to')
            ->get();

        return view('targets.trainings')->with(compact('data'));
    }


    //saveTrainings

    public  function saveTrainings(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'emp_id' => 'required',
            'trainer_name' => 'required',
            'training_type' => 'required',
            'from' => 'required',
            'to' => 'required',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()->all()]);
        }
        //
        if ($request->ajax()) {

            $train = new Training();
            $train->emp_id = $request->emp_id;
            $train->trainer = $request->trainer_name;
            $train->training_type = $request->training_type;
            $train->cost = $request->cost;
            $train->from = $request->from;
            $train->to = $request->to;
            $train->desc = $request->desc;
            $train->status = $request->status;
            if ($train->save()) {

                Event::dispatch(new SendTrainingMailEvent($request->emp_id));
                return response()->json(['success' => 'Record save successfully'], 200);
            }
        }
    }

    public function editTrainings(Request $request)
    {
        $data['training'] = Training::find($request->id);
        $data['tran'] = Trainer::all();
        $data['employee'] = Employee::all();
        return $data;
    }

    public function updateTrainings(Request $request)
    {
        $train = Training::find($request->training_id);
        $train->emp_id = $request->emp_id;
        $train->trainer = $request->trainer_name;
        $train->training_type = $request->training_type;
        $train->cost = $request->cost;
        $train->from = $request->from;
        $train->to = $request->to;
        $train->desc = $request->desc;
        $train->status = $request->status;
        if ($train->save()) {

            return response()->json(['success' => 'Record updated successfully']);
        }
    }


    public function deleteTrainings(Request $request)
    {
        $training = Training::find($request->id);
        if ($training->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'training deleted successfully',
            ]);
        }
    }



    public function empTrainings()
    {

        $data['training'] = Training::where('emp_id', '=', $this->userId)->get();

        return view('targets.emp-trainings')->with(compact('data'));
    }
}
