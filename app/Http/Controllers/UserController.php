<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use Google\Service\Directory\Users;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    //index
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $qry = User::join('employees', 'employees.id', 'users.account_id')
                ->join('designations', 'designations.id', 'employees.desg_id')
                ->select('users.*', 'employees.name', 'employees.email', 'employees.image', 'employees.phone', 'designations.desig_name');

            $qry->when($request->company_id, function($query, $company_id) {
                return $query->where('employees.company_id', $company_id);
            });
            $qry->when($request->desg_id, function($query, $desg_id) {
                return $query->where('employees.desg_id', $desg_id);
            });
            $qry->when($request->name, function($query, $name) {
                return $query->where('employees.name', $name);
            });
            $data = $qry->get();
            return response()->json($data);
        }
        $data['company'] = Company::all();
        $data['department'] = Department::all();
        return view('users.index', compact('data'));
    }
    //udpate user role
    public  function changeRole(Request $request)
    {
        $user = User::find($request->id);
        $user->role = $request->value;
        if ($user->save()) {
            return response()->json(['success' => 'User role change successfully'], 200);
        }
    }
    public  function verifyAccount($id)
    {
        $user = User::find(decrypt($id));
        $user->email_verified_at = now();
        $user->status = 1;
        $user->save();
        return  Redirect('login');
    }
    //changeUserStatus
    public function changeUserStatus($user_id, $status)
    {
        $user = User::find($user_id);
        $user->status = $status;
        $user->email_verified_at = now();
        if ($user->save()) {
            return Redirect::back()->withSuccess(['success', 'Record updated successfully']);
        }
    }
    //getCurrentLocation
    public function getCurrentLocation()
    {
        return view('get-current-location');
    }
    public  function  getUsers(){
        return $res=User::with('rolename')->get();
    }
    //updateUserStatus
    public  function  updateUserStatus(Request $request){
        $user = User::find($request->user_id);
        $user->status =$request->status;
        if($user->save())
        {
            return response()->json(['success'=>'Status updated successfully'],200);
        }
    }
}
