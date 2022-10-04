<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Redirect;

class Applicant extends Model
{
    use HasFactory;



    public function getStatusAttribute($value)
    {
        return strtoupper($value);
    }

    public static function saveApplicant($request,$token){
        if($token!=1){
            $token['token']=session()->get('token');
        }else{
            $token['token']=$token;
        }
        if($request->hasFile('file')){
            $uniqueid=uniqid();
            $original_name=$request->file('file')->getClientOriginalName();
            $size=$request->file('file')->getSize();
            $extension=$request->file('file')->getClientOriginalExtension();
            $name=Carbon::now()->format('Ymd').'_'.$uniqueid.'.'.$extension;
            $imagepath=url('/storage/uploads/resume/'.$name);
            $path=$request->file('file')->storeAs('public/uploads/resume/',$name);

            //get token for already job applied

            $app=new Applicant;
            $app->job_id=$request->job_id;
            $app->desig_id=$request->job_id;
            $app->name=$request->name;
            $app->email=$request->email;
            $app->phone=$request->phone;
            $app->status=($request->status)?$request->status:'new';
            $app->resume=$path;
            $app->token= $token['token'];//($res['token'])?$res['token']:'';
            return $app->save();


        }
        else{
            return Redirect::back()->withErrors(['error', 'Missing Files']);
        }
    }
}
