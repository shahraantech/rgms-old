<?php

namespace App\Http\Controllers\Api;
use App\Models\Loged_history;
use App\Models\Tanveer;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyBranch;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    //login

    function login(Request $request)
    {

        $email=$request->email;
        $password=$request->password;
        $user= User::where('email', $email)->first();
        // print_r($data);
        if (!$user || !Hash::check($password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $user->createToken('crm-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        $response=$this->createAPIResponce($is_error=false,$code=200,$message='success',$response);

        Loged_history::createLogedInHistory('app',$request->lat,$request->lang,$user->id,'NULL');
        return response()->json($response,$status=200);

    }


    public function  getCompanyLocationOld(){
        $com= Company::select('id','name','lat','lang','address')->first();
        if($com){
            $response=$this->createAPIResponce($is_error=false,$code=200,$message='data found',$com);
            return response()->json($response,$status=200);
        }
        else{

            $response=$this->createAPIResponce($is_error=true,$code=400,$message='data not found',$com);
            return response()->json($response,$status=400);
        }
    }
    public function  getCompanyLocation(Request $request){


        $emp_id=$request->emp_id;
        $emp=Employee::find($emp_id);
        if($emp){
            $com= CompanyBranch::select('id','branch_name','lat','lang','address')->where('id',$emp->location_id)->first();
        if($com){
            $response=$this->createAPIResponce($is_error=false,$code=200,$message='data found',$com);
            return response()->json($response,$status=200);
        }
        else{

            $response=$this->createAPIResponce($is_error=true,$code=400,$message='data not found',$com);
            return response()->json($response,$status=400);
        }
    }else{
            $response=$this->createAPIResponce($is_error=true,$code=400,$message='This emp dose not exist',$emp=NULL);
            return response()->json($response,$status=400);
        }
    }
    public  function createAPIResponce($is_error,$code,$message,$content){


        $result=[];
        if($is_error){

            $result['success']=false;
            $result['code']=$code;
            $result['message']=$message;
        }
        else{

            $result['success']=true;
            $result['code']=$code;

            if($content==null){

                $result['message']=$message;
            }
            else{
                $result['data']=$content;
            }
        }

        return $result;
    }


}
