<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Training;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Trainer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class RatingsController extends Controller
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

    public function  index()
    {
        $data['routeName'] = Route::getFacadeRoot()->current()->uri();

        $data['trainer'] = Trainer::all();

        $data['training'] = Training::where('emp_id', $this->userId)->get();

        $data['rating'] = Rating::join('trainings', 'trainings.id', '=', 'ratings.training_id')
            ->join('trainers', 'trainers.id', '=', 'ratings.trainer_id')
            ->where('ratings.user_id', '=', $this->userId)
            ->select('trainings.training_type', 'trainings.from', 'trainings.to', 'trainers.f_name', 'trainers.l_name', 'ratings.*')
            ->paginate(5);
        return view('ratings.index')->with(compact('data'));
    }


    //writeFeedback

    public function  writeFeedback()
    {
        $data['routeName'] = Route::getFacadeRoot()->current()->uri();
        $data['trainer'] = Trainer::all();
        $data['training'] = Training::where('emp_id', $this->userId)->get();
        $data['rating'] = Rating::join('trainings', 'trainings.id', '=', 'ratings.training_id')
            ->join('trainers', 'trainers.id', '=', 'ratings.trainer_id')
            ->where('ratings.user_id', '=', $this->userId)
            ->select('trainings.training_type', 'trainings.from', 'trainings.to', 'trainers.f_name', 'trainers.l_name', 'ratings.*')
            ->paginate(5);
        return view('ratings.index')->with(compact('data'));
    }


    //getTrainerName
    public function  getTrainerName(Request $request)
    {
        $trainingId = $request->trainingId;
        $res = Training::join('trainers', 'trainers.id', '=', 'trainings.trainer')
            ->select('trainers.*')
            ->where('trainings.id', '=', $trainingId)
            ->get();
        echo json_encode($res);
    }


    //saveTrainerFeedBack


    public  function saveTrainerFeedBack(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'trainingId' => 'required',
            'trainer_id' => 'required',
            'rating' => 'required',
            'comment' => 'required',

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }
        //
        //        if($request->ajax()){

        $res = Rating::where([['user_id', $this->userId], ['training_id', $request->trainingId]])->first();

        if (!$res) {

            $rate = new Rating();
            $rate->user_id = $this->userId;
            $rate->type = 'trainer';
            $rate->rating = $request->rating;
            $rate->comment = $request->comment;
            $rate->training_id = $request->trainingId;
            $rate->trainer_id = $request->trainer_id;


            if ($rate->save()) {

                return response()->json(['success' => 'Record save successfully'], 200);
            }
        } else {

            return response()->json(['error' => 'Already reviewed'], 200);
        }
    }


    //traineeFeedback
    public function  traineeFeedback()
    {
        $data['trainer'] = Trainer::all();
        $data['training'] = Training::where('trainer', Auth::user()->trainer_id)->get();

        $data['rating'] = Rating::join('trainings', 'trainings.id', '=', 'ratings.training_id')
            ->join('employees', 'employees.id', '=', 'ratings.user_id')
            ->where('ratings.trainer_id', '=', Auth::user()->trainer_id)
            ->where('type', '=', 'trainy')
            ->select('trainings.training_type', 'trainings.from', 'trainings.to', 'employees.name', 'ratings.*')
            ->get();
        return view('ratings.traineeFeedBack')->with(compact('data'));
    }


    //getTrainyName

    public function  getTrainyName(Request $request)
    {
        $trainingId = $request->trainingId;
        $train = Training::find($trainingId);
        $res = Training::join('employees', 'trainings.emp_id', '=', 'employees.id')
            ->select('employees.name', 'employees.id')
            ->where('trainings.training_type', '=', $train->training_type)
            ->where('from', '=', $train->from)
            ->where('to', '=', $train->to)
            ->get();
        echo json_encode($res);
    }

    //saveTraineeFeedback
    public  function saveTraineeFeedback(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'trainingId' => 'required',
            'trainy_id' => 'required',
            'rating' => 'required',
            'comment' => 'required',

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }

        if ($request->ajax()) {

            $res = Rating::where([['user_id', $request->trainy_id], ['training_id', $request->trainingId]])->first();

            if (!$res) {

                $rate = new Rating();
                $rate->user_id = $request->trainy_id;
                $rate->type = 'trainy';
                $rate->rating = $request->rating;
                $rate->comment = $request->comment;
                $rate->training_id = $request->trainingId;
                $rate->trainer_id = Auth::user()->trainer_id;


                if ($rate->save()) {

                    return response()->json(['success' => 'Record save successfully'], 200);
                }
            } else {

                return response()->json(['error' => 'Already reviewed'], 200);
            }
        }
    }



    public function editTraineeFeedback(Request $request)
    {
        $rate = Rating::find($request->id);
        $trainer = Trainer::all();
        $training = Training::all();
        return view('ratings.editTraineeFeedBack', compact('rate','trainer','training'));
    }

    //update trainee feedback
    public function updateTraineeFeedback(Request $request)
    {
        $rate = Rating::find($request->id);
        $rate->user_id = $request->trainy_id;
        $rate->rating = $request->rating;
        $rate->comment = $request->comment;
        $rate->training_id = $request->trainingId;
        if($rate->save())
        {
            return redirect('trainee-feedback')->with('success', 'Record update successfully');
        }
    }

    public function deleteTraineeFeedback(Request $request)
    {
        $rate = Rating::find($request->id);
        if($rate->delete())
        {
            return response()->json([
                'status' => 200,
                'message' => 'Record deleted successfully',
            ]);
        }
    }


    //trainer-reviews
    public function  trainerReviews()
    {
        $data['rating'] = Rating::join('trainings', 'trainings.id', '=', 'ratings.training_id')
            ->join('trainers', 'trainers.id', '=', 'ratings.trainer_id')
            ->join('employees', 'employees.id', '=', 'ratings.user_id')
            ->where('ratings.type', '=', 'trainer')
            ->select('trainings.training_type', 'trainings.from', 'trainings.to', 'trainers.f_name', 'trainers.l_name', 'ratings.*', 'employees.name')
            ->paginate(5);
        return view('ratings.trainerReviews')->with(compact('data'));
    }

    //empReviews

    public function  empReviews()
    {
        $data['rating'] = Rating::join('trainings', 'trainings.id', '=', 'ratings.training_id')
            ->join('trainers', 'trainers.id', '=', 'ratings.trainer_id')
            ->join('employees', 'employees.id', '=', 'ratings.user_id')
            ->where('ratings.type', '=', 'trainy')
            ->select('trainings.training_type', 'trainings.from', 'trainings.to', 'trainers.f_name', 'trainers.l_name', 'ratings.*', 'employees.name')
            ->paginate(5);
        return view('ratings.empReviews')->with(compact('data'));
    }
}
