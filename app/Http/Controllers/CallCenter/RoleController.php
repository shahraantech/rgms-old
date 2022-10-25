<?php

namespace App\Http\Controllers\CallCenter;

use App\Http\Controllers\Controller;
use App\Models\CallRecording;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Module;
use App\Models\Permission;
use App\Models\SubModule;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleHasPermission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{


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

    //index
    public function index(Request $request)
    {


        if ($request->isMethod('post')) {

            $data = $request->all();
            $rules = array(
                'role' => 'required',
            );

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }
            $role = new Role();
            $role->role = $request->role;

            if ($role->save()) {
                return response()->json(['success' => 'Record save successfully'], 200);
            }
        }

        return view('call-center.roles.index');
    }




    public function rolesList(Request $request)
    {
        if ($request->ajax() && $request->isMethod('get')) {
            return $role = Role::all();
        }
    }

    //rolePermissions
    public function rolePermissions(Request $request)
    {

        if ($request->isMethod('post')) {


            for ($i = 0; $i < count($request->role_id); $i++) {
                if (!RoleHasPermission::where('permission_id', $request->permission_id)->where('role_id', $request->role_id[$i])->first()) {
                    $perm = new RoleHasPermission();
                    $perm->permission_id = $request->permission_id;
                    $perm->role_id = $request->role_id[$i];
                    $perm->is_allow = 1;
                    $perm->save();
                }
            }
            return response()->json(['success' => 'Permission created successfully'], 200);
        }
        $data['role_has_permission'] = RoleHasPermission::with('permissionname', 'rolename')->get();
        $data['permission'] = SubModule::all();
        $data['roles'] = Role::all();
        return view('call-center.roles.permission')->with(compact('data'));
    }

    //testPermissions

    public function testPermissions(Request $request)
    {
        $role_id = $request->role_id;
        $output = '';

        $mod = Module::get();
        foreach ($mod as $mod) {
            $output .= '<tr>' .
                '<th colspan="6" style="background: #252d50; color: white">' . $mod->module . '</th>' .
                '</tr>' .
                '<tr>';
            $m = SubModule::where('module_id', $mod->id)->get();

            foreach ($m as $sm) {
                $output .= '<td>' .
                    $checked = '';
                $role = RoleHasPermission::where('sub_module_id', $sm->id)->where('role_id', $role_id)->first();
                if ($role) {
                    if ($role->is_allow == 1) {
                        $checked = 'checked';
                    }
                }

                $output .= '<input ' . $checked . ' class="is_allow checkbox" type="checkbox" data="' . $sm->id . '"  value="' . $sm->id . '" name="sub_module[]">
                                                ' . $sm->title . '</td>';
            }
            $output .= '</tr>';
        }


        echo json_encode($output);
    }

    //roleAssign

    public function roleAssign(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = array(
                'comp_id' => 'required',
                'emp_id' => 'required',
                'email' => 'required',
                'password' => 'required',
                'role_id' => 'required',
            );

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            // users create
            $chekUser = User::where('email', $request->email)->first();
            if (!$chekUser) {

                $role = 'employee';
                if ($request->role_id == 8) {
                    $role = 'super-admin';
                }
                if ($request->module) {
                    $role = $request->module;
                }

                $user = User::create([
                    'account_id' => $request->emp_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'role' => $role,
                    'role_id' => $request->role_id,
                    'status' => 1,
                    'password' => \Illuminate\Support\Facades\Hash::make($request->password),

                ]);
            } else {
                return response()->json(['errors' => 'User Already Exist']);
            }
            return response()->json(['success' => 'User created successfully'], 200);
        }
        $data['roles'] = Role::all();
        $data['company'] = Company::all();
        $data['users'] = User::with('rolename')->orderBy('id', 'DESC')->get();
        return view('call-center.roles.users')->with(compact('data'));
    }
    //updateUserRole
    public function updateUserRole(Request $request)
    {
        $request->all();
        $user = User::find($request->change_user_id);
        $role = 'employee';
        if ($request->change_role_id == 8) {
            $role = 'super-admin';
        }
        if ($request->change_module) {
            $role = $request->change_module;
        }


        $user->role = $role;
        $user->role_id = $request->change_role_id;
        if ($user->save()) {
            return response()->json(['success' => 'Role update successfully'], 200);
        }
    }
    //changeUserStatus
    public function changeUserStatus(Request $request)
    {
        $user = User::find($request->user_id);
        $user->status = $request->status;
        if ($user->save()) {
            Employee::where('id', $user->account_id)->update(['status' => $request->status]);
            return response()->json(['success' => 'User Status updated successfully'], 200);
        }
    }
    //updateRoleHasPermissions
    public function updateRoleHasPermissions(Request $request)
    {
        $perm = RoleHasPermission::where('sub_module_id', $request->sub_module_id)->where('role_id', $request->role_id)->first();
        if ($perm) {
            $perm->is_allow = $request->status;
            $perm->save();
        } else {
            $perm = new RoleHasPermission();
            $perm->sub_module_id = $request->sub_module_id;
            $perm->role_id = $request->role_id;
            $perm->is_allow = $request->status;
            $perm->save();
        }
        return response()->json(['success' => 'Permission updated successfully'], 200);
    }
    //callRecording
    public function callRecording(Request $request)
    {
        $data['callRecording'] = CallRecording::all();
        return view('call-center.calls.call-recording')->with(compact('data'));
    }
}
