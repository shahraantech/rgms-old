<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Lead;
use App\Models\Target;
use App\Models\Target_Achievement;
use App\Models\TeamTarget;
use Illuminate\Http\Request;
use Validator;

class TargetController extends Controller
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

    public function index(Request  $request)
    {


        if ($request->isMethod('post')) {


            $data = $request->all();
            $rules = array(
                'target_type' => 'required',
                'target_number' => 'required',
                'from_date' => 'required',
                'to_date' => 'required',
            );

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }


            $target = new Target();
            $target->manager_id = ($request->manager_id) ? $request->manager_id : '';
            $target->agent_id = ($request->agent_id) ? $request->agent_id : '';
            $target->target_type = $request->target_type;
            $target->target_in_numbers = $request->target_number;
            $target->from = $request->from_date;
            $target->to = $request->to_date;
            $target->status = 0;
            $target->save();


            if ($request->to_allocate == 2) {
                $team = new TeamTarget();

                $team->target_id = $target->id;
                $team->agent_id = $request->agent_id;
                $team->target_type = $request->target_type;
                $team->target_in_numbers = $request->target_number;
                $team->from = $request->from_date;
                $team->to = $request->to_date;

                $team->save();
            }
            return response()->json(['success' => 'Target created successfully'], 200);
        }

        $data['employee'] = Employee::where('status', 1)->select('id', 'name')->orderBy('id', 'DESC')->get();
        $data['manager'] = Lead::join('employees', 'employees.id', 'leads.leader_id')->select('leads.leader_id', 'employees.name')->get();
        $data['targets'] = Target::orderBy('id', 'desc')->get();
        return view('targets.index')->with(compact('data'));
    }


    //empTargets
    public function myTargets(Request $request)
    {

        $data['view'] = 'My';
        $data['targets'] = TeamTarget::where('agent_id', $this->userId)->orderBy('id', 'desc')->get();
        return view('targets.my-targets')->with(compact('data'));
    }

    //managerTargets

    public function managerTargets(Request $request)
    {

        $data['targets'] = Target::where('manager_id', $this->userId)->orderBy('id', 'desc')->get();
        $data['view'] = 'Manager';
        return view('targets.my-targets')->with(compact('data'));
    }

    //assignTarget

    public function assignTarget($target_id)
    {

        $data['targets'] = Target::where('manager_id', $this->userId)->orderBy('id', 'desc')->get();
        $data['member'] = getTeamMember($this->userId);
        $data['target'] = Target::find(($target_id));
        $data['assignTarget'] = TeamTarget::where('target_id', ($target_id))->sum('target_in_numbers');

        return view('targets.assign-targets')->with(compact('data'));
    }

    //saveAssignTarget

    public function saveAssignTarget(Request $request)
    {

        if ($request->isMethod('post')) {

            $data = $request->all();
            $target = Target::find($request->hidden_target_id);
            if ($data['member_id'] != '') {

                for ($c = 0; $c < count($data['member_id']); $c++) {
                    if ($data['member_id'][$c] != NULL) {
                        $team = new TeamTarget();
                        $team->target_id = $target->id;
                        $team->manager_id = $target->manager_id;
                        $team->agent_id = $data['member_id'][$c];
                        $team->target_type = $target->target_type;
                        $team->target_in_numbers = $data['numberOf'][$c];
                        $team->from = $target->from;
                        $team->to = $target->to;
                        $team->save();
                    }
                }
                return response()->json(['success' => 'Target assign  successfully'], 200);
            }
        }
    }

    //teamTarget

    public function teamTarget($target_id)
    {
        $data['view'] = 'Team';
        $data['teamTarget'] = TeamTarget::join('employees', 'employees.id', 'team_targets.agent_id')
            ->where('team_targets.target_id', $target_id)
            ->select('employees.name', 'team_targets.*')
            ->get();
        return view('targets.team-targets')->with(compact('data'));
    }

    public function updateTargets(Request $request)
    {
        $target = Target::find($request->target_id);
        $target->target_in_numbers = $request->target_number;
        $target->from = $request->from_date;
        $target->to = $request->to_date;
        $target->target_type = $request->target_type;

        $target->update();
        return response()->json([
            'status' => 200,
            'message' => 'Target updated successfully',
        ]);
    }

    public function updateTeamTarget(Request $request)
    {
        $target = TeamTarget::find($request->team_target_id);
        $target->target_in_numbers = $request->target_number;
        $target->from = $request->from_date;
        $target->to = $request->to_date;

        $target->update();
        return response()->json([
            'status' => 200,
            'message' => 'Team Target updated successfully',
        ]);
    }

    public function editTargets(Request $request)
    {
        $target = Target::find($request->id);
        return response()->json([
            'target' => $target,
        ]);
    }

    public function editTeamTarget(Request $request)
    {
        $team_target = TeamTarget::find($request->id);
        return response()->json([
            'team_target' => $team_target,
        ]);
    }

    public function deleteTargets(Request $request)
    {
        $target = Target::find($request->id);
        if ($target->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'target deleted successfully',
            ]);
        }
    }

    public function deleteTeamTarget(Request $request)
    {
        $target = TeamTarget::find($request->id);
        if ($target->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Team Target deleted successfully',
            ]);
        }
    }
}
