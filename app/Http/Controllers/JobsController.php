<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use App\Models\Recruitment;
use App\Models\Applicant;
use App\Models\Viewer;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Redirect;
use Mail;
use App\Jobs\SendEmailToAllEmployee;


class JobsController extends Controller
{
    //jobList

    public function jobList(){
        $data['jobs']=Recruitment::join('designations', 'designations.id', '=', 'recruitments.desg_id')
            ->join('departments', 'departments.id', '=', 'designations.dept_id')
            ->select('designations.desig_name','departments.departments','recruitments.*')
            ->where('recruitments.status','=','open')
           ->orderBy('recruitments.id','Desc')
            ->get();

        return view('jobs.jobs-list')->with(compact('data'));
    }

    //jobView
    public function jobView($id){

        $id=decrypt($id);
        $token= session()->get('token');
        if(!$token) {
            $string = Str::random(64);
            $token = array(
                "token" =>$string,
                "job_id" =>$id,
            );
            session()->put('token', $token);
        }
        $res=session()->get('token');


        if(!$chek=Viewer::where([['job_id',$id],['token',$res['token']]])->first()){
            $v=new Viewer();
            $v->job_id=$id;
            $v->token=$res['token'];
            $v->save();
        }

        $data['isApplied']=Applicant::where([['job_id',$id],['token',$res['token']]])->count();
        $data['totalApplicant']=Applicant::where('job_id',$id)->count();
        $data['jobViews']=Viewer::where('job_id',$id)->count();
        $data['id']=$id;
        $data['jobs']=Recruitment::join('designations', 'designations.id', '=', 'recruitments.desg_id')
            ->join('departments', 'departments.id', '=', 'designations.dept_id')
            ->select('designations.desig_name','departments.departments','recruitments.*')
            ->where('recruitments.id','=',$id)
            ->orderBy('recruitments.id','Desc')
            ->get();

        return view('jobs.job-view')->with(compact('data'));
    }

    //applyJob
    public function applyJob(Request $request){


         $job_id=$request->job_id;
        $this->validate($request,[
            'name'=>'required|max:30',
            'email'=>'required',
            'phone'=>'required',
            'file'=>'required|mimes:pdf|max:10000'

        ]);

       if(Applicant::where([['email',$request->email],['job_id',$job_id]])->first()){


           return Redirect::back()->withErrors(['error', 'You have already applied']);
       }else{

           if($request->hasFile('file')){
               $uniqueid=uniqid();
               $original_name=$request->file('file')->getClientOriginalName();
               $size=$request->file('file')->getSize();
               $extension=$request->file('file')->getClientOriginalExtension();
               $name=Carbon::now()->format('Ymd').'_'.$uniqueid.'.'.$extension;
               $imagepath=url('/storage/uploads/resume/'.$name);
               $path=$request->file('file')->storeAs('public/uploads/resume/',$name);

                //get token for already job applied
               $res=session()->get('token');
               if($request->sender=='admin'){
                   $res['token']=1;
               }
               $app=new Applicant;

               $app->job_id=$job_id;
               $app->desig_id=$job_id;
               $app->name=$request->name;
               $app->email=$request->email;
               $app->phone=$request->phone;
               $app->status=($request->status)?$request->status:'new';
               $app->resume=$path;
               $app->token=$res['token'];
               $app->save();

               return Redirect::back()->withSuccess(['success', 'You have applied successfully']);
           }else{
               return Redirect::back()->withErrors(['error', 'Missing Files']);
           }

       }

    }

    //applicants
    public function applicants(Request $request){

        if($request->isMethod('post')) {
            $qry = Applicant::when($request->name, function ($query, $name) {
                    return $query->where('name','like','%'.$name.'%');
                })
                ->when($request->phone, function ($query, $phone) {
                    return $query->where('phone', $phone);
                });
            $data = $qry->get();
            return response()->json($data);
        }
        return view('jobs.applicants');
    }



    public function getApplicantsList(){
       echo json_encode(Applicant::orderBy('id','desc')->where('status','new')->get());

    }

    // downloadResume

    public function downloadResume ($id)
    {
        $find=Applicant::find($id);
        $pathToFile=storage_path()."/app/". $find->resume;
        return response()->download($pathToFile);
    }


    //checkJobApplied

    public function checkJobApplied(Request $request){

        if(Applicant::where([['email',$request->email],['emp_id',$request->id]])->first()){
            return 1;
        }else{
            return 0;
        }
    }

    //updateApplicantStatus


    public  function updateApplicantStatus(Request $request){

        $status = Applicant::find($request->id);
        $status->status =$request->status;

        if($status->save())
        {
            if($request->status=='Rejected'){
                $this->sendRejectMail($request->id);
            }
            if($request->status=='hired'){
                SendEmailToAllEmployee::dispatch($empId=$request->id);
            }
            return response()->json(['success'=>'Status updated'],200);
        }

    }

    public function sendRejectMail($id)
    {
        $res=Applicant::join('designations', 'designations.id', '=', 'applicants.desig_id')
            ->select('designations.desig_name','applicants.*')
            ->where('applicants.id',$id)
            ->first();



        $details = [
            'title' => 'Alpha HRM',
            'body' => 'Reject Resume',
            'email' =>$res->email,
            'name' =>$res->name,
            'position' =>$res->desig_name,
        ];

       Mail::to($res->email)->send(new \App\Mail\RejectCanidate($details));



    }



    public function imageupload(Request $request)
    {
        if ($request->isMethod('post')) {
            $image = base64_encode(file_get_contents($request->file('file')));
            Test::create([
                'image' => $image,
            ]);
            return redirect()->back();
        }
        $image=Test::all();
        return  view('test')->with(compact(('image')));
    }





}
