<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){

        $data=$request->all();
        $data=$request->validate([
            'name'=>'required|max:191',
            'email'=>'required|max:191',
            'password'=>'required|max:191'

        ]);

        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'user_type' => 'member',
                'password' => Hash::make($data['password']),
            ]);

            $token = $user->createToken('AlphaToken')->plainTextToken;

            $response = ['user' => $user, 'token' => $token];

            return response($response, 201);
        }catch (AlreadyExist $exception) {

            return back()->withError($exception->getMessage())->withInput();
        }


    }

    public function logout(){

        auth()->user()->tokens()->delete();

        return response(['message'=>'you have logout successfully!']);
    }

    public function login(Request $request){
        $data=$request->validate([

            'email'=>'required|max:191',
            'password'=>'required|string'

        ]);

        $user=User::where([['email',$data['email']],['user_type','member']])->first();

        if(!$user || !Hash::check($data['password'], $user->password)){
            return response(['message' => 'Invalid credentials'], 401);

        }else{

            $token=$user->createToken('AlphaTokenLogin')->plainTextToken;
            $response=['user'=>$user, 'token'=>$token];

            return response($response,201);
        }
    }
}
