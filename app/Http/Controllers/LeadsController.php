<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Employee_Allownce;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
    //
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $member_id = $request->team_id;

            $existTeam = Lead::whereIn('member_id', $member_id)->count();
            if ($existTeam < 1) {

                $leads = new Lead();
                $leads->leader_id = $request->manager_id;
                $leads->member_id = implode(',', $request->team_id);
                $leads->status = 1;
                $leads->save();
                return response()->json(['success' => 'Record save successfully'], 200);
            } else {
                return response()->json(['error' => 'Record already exist'], 200);
            }
        }
        $data['leads'] = Lead::join('employees', 'employees.id', 'leads.leader_id')
            ->select('employees.name', 'employees.image', 'employees.email', 'employees.phone as contact', 'leads.*')
            ->get();
        $data['employee'] = Employee::where('status', 1)->get();
        return view('tasks.leads.index')->with(compact('data'));
    }

    public function editLeeds(Request $request, $id)
    {
        $lead = Lead::find($request->id);
        $SelectedMonths = explode(',', $lead->member_id);
        $employee = Employee::where('status', 1)->get();
        return view('tasks.leads.edit-lead', compact('lead', 'SelectedMonths', 'employee'));
    }

    public function udpateLeeds(Request $request)
    {
        $leads = Lead::find($request->id);
        $leads->leader_id = $request->manager_id;
        $leads->member_id = implode(',', $request->team_id);
        $leads->status = 1;
        $leads->update();
        return redirect('team');
    }
}
