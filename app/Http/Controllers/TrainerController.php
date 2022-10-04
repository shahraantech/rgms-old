<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainer;
use App\Events\SaveTrainerInUserEvent;
use App\Models\Employee;
use App\Models\Rating;
use App\Models\Training;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\returnSelf;

class TrainerController extends Controller
{
    protected $userId;

    public function __construct()
    {

        $this->middleware(function (Request $request, $next) {
            if (!\Auth::check()) {
                return redirect('/login');
            }
            $this->userId = \Auth::user()->trainer_id; // you can access user id here

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return json_encode(Trainer::OrderBy('id', 'DESC')->get());
        }
        return view('trainers.index');
    }



    public function trainersList(Request $request)
    {
        if ($request->ajax()) {
            return json_encode(Trainer::OrderBy('id', 'DESC')->get());
        }
    }

    //saveTrainers

    public function saveTrainers(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'f_name' => 'required',
            'l_name' => 'required',
            'email' => 'required',
            'contact' => 'required',


        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }

        if ($request->ajax()) {
            if (!Trainer::where('email', $request->email)->first()) {

                $train = new Trainer();
                $train->f_name = $request->f_name;
                $train->l_name = $request->l_name;
                $train->email = $request->email;
                $train->contact = $request->contact;
                $train->status = $request->status;
                $trainerId = $train->save();
                if ($trainerId) {

                    Event::dispatch(new SaveTrainerInUserEvent($request));
                    return response()->json(['success' => 'Record save successfully'], 200);
                }
            } else {
                return response()->json(['error' => 'Trainer already exist'], 200);
            }
        }
    }


    public function editTrainers(Request $request)
    {
        $trainer = Trainer::find($request->id);
        return $trainer;
    }

    public function updateTrainers(Request $request)
    {
        $trainer = Trainer::find($request->trainer_id);
        $trainer->f_name = $request->f_name;
        $trainer->l_name = $request->l_name;
        $trainer->email = $request->email;
        $trainer->contact = $request->contact;
        $trainer->status = $request->status;
        if ($trainer->update()) {
            return response()->json([
                'status' => 200,
                'message' => 'trainer updated successfully',
            ]);
        }
    }

    public function deleteTrainers(Request $request)
    {
        $trainer = Trainer::find($request->id);
        if ($trainer->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'trainer deleted successfully'
            ]);
        }
    }

    //dashboard
    public function dashboard()
    {
        $data['trainer'] = Training::all()->count();
        $data['cost'] = Training::sum('cost');
        $data['comments'] = Rating::all()->count();
        $data['alltrainer'] = Trainer::all();
        $data['trainee'] = Training::join('employees', 'employees.id', '=', 'trainings.emp_id')
            ->select('trainings.*', 'employees.name')
            ->where('trainings.trainer', $this->userId)
            ->get();
        return view('trainers.dashboard', compact('data'));
    }

    public function traineeList(Request $request)
    {
        $data['trainee'] = Training::join('employees', 'employees.id', '=', 'trainings.emp_id')
            ->select('trainings.*', 'employees.name')
            ->where('trainings.trainer', $this->userId)
            ->paginate(5);
        return view('trainers.trainee', compact('data'));
    }

    public function totalTrainer()
    {
    }
}
