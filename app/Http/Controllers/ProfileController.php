<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Emp_qualification;
use App\Models\Experience;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
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


    public function index()
    {

        try {

            $data['employee'] = Employee::join('designations', 'designations.id', '=', 'employees.desg_id')
                ->select('designations.desig_name', 'employees.*')
                ->where('employees.id', $this->userId)->first();
            $data['qualification'] = Emp_qualification::where('emp_id', $this->userId)->get();
            $data['experience'] = Experience::where('emp_id', $this->userId)->get();

            return view('profile.index')->with(compact('data'));
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }


    public function userProfile($user_id = null)
    {
        $user_id = decrypt($user_id);

        try {

            $data['employee'] = Employee::join('designations', 'designations.id', '=', 'employees.desg_id')
                ->select('designations.desig_name', 'employees.*')
                ->where('employees.id', $user_id)->first();

            $data['qualification'] = Emp_qualification::where('emp_id', $user_id)->get();
            $data['experience'] = Experience::where('emp_id', $user_id)->get();
            $data['certifications'] = Certification::where('emp_id', $user_id)->first();

            return view('profile.index')->with(compact('data'));
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $userPassword = $user->password;

        if (!Hash::check($request->current_password, $userPassword)) {
            // return back()->withErrors(['current_password' => 'password not match']);
            return response()->json(['current_password' => 'password not match'], 200);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['success' => 'Password updated successfully'], 200);
    }

    public function storeEducation(Request $request)
    {
        // dd($request->all());
        //qualification Information
        $qua = new Emp_qualification;
        $qua->emp_id = $request->emp_id;
        $qua->qualification = $request->qualification;
        $qua->institute = $request->institute;
        $qua->from = $request->from;
        $qua->to = $request->to;
        $qua->cgpa = $request->cgpa;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('storage/app/public/uploads/education/', $filename);
            $qua->attachment = $filename;
        }

        $qua->save();

        return redirect()->back()->withSuccess(['success', 'Record save successfully']);
    }

    public function storeExperience(Request $request)
    {
        //Employment Experience
        $exp = new Experience;
        $exp->emp_id = $request->emp_id;
        $exp->position = $request->position;
        $exp->skills = $request->skill;
        $exp->organization = $request->relevent_exp_organization;
        $exp->start_date = $request->start_date;
        $exp->end_date = $request->end_date;
        $exp->annual_duration = $request->annual_duartion;
        $exp->exp = $request->relevent_exp;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('storage/app/public/uploads/experience/', $filename);
            $exp->attachment = $filename;
        }

        if ($exp->save()) {
            return Redirect::back()->withSuccess(['success', 'Record save successfully']);
        }
    }

    public function storeCertification(Request $request)
    {
        //Professional Certifications
        $cer = new Certification;
        $cer->emp_id = $request->emp_id;
        $cer->course_title = $request->course_title;
        $cer->orgnazations = $request->exp_organization;
        $cer->duration_period = $request->period;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('storage/app/public/uploads/certification/', $filename);
            $cer->attachment = $filename;
        }

        $cer->save();
        if ($cer->save()) {
            return Redirect::back()->withSuccess(['success', 'Record save successfully']);
        }
    }

    public function storeBankInformation(Request $request)
    {
        return $request->all();
    }
}
