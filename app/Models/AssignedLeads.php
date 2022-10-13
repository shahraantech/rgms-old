<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AssignedLeads extends Model
{
    use HasFactory;


    public function leads()
    {
        return $this->belongsTo(LeadsMarketing::class, 'lead_id', 'id')->select(['id', 'name', 'contact', 'city_id', 'lead_type', 'interest']);
    }


    public function agent()
    {
        return $this->belongsTo(Employee::class, 'agent_id', 'id')->select(['id', 'name']);
    }

    public static function getNotApproachesLeads($agent_id, $purpose, $sender)
    {
        $qry = AssignedLeads::query();
        ($sender != 'admin') ? $qry = $qry->where('agent_id', $agent_id) : '';
        $qry = $qry->where('status', 0);
        $qry = $qry->where('type', 'lead');
        ($purpose == 'counting') ? $qry = $qry->count() : $qry = $qry->with('leads', 'leads.cityname')->paginate(20);
        return $qry;
    }

    public static function getCsrNoOfLeads($agent_id, $date, $purpose, $toDate)
    {

        $qry = User::Query();
        ($agent_id) ? $qry = $qry->where('account_id', $agent_id) : $qry = $qry->where('role_id', 4)->orwhere('role_id', 7);;
        $qry = $qry->get();
        $csrLeads = collect([]);
        $totalLeads = 0;
        foreach ($qry as $csr) {
            $lead = AssignedLeads::where('agent_id', $csr->account_id);
            ($date) ? $lead = $lead->whereDate('created_at', '>=', $date) : '';
            ($toDate) ? $lead = $lead->whereDate('created_at', '<=', $toDate) : '';
            if ($purpose == 'count') {
                $totalLeads = $lead->count();
                $array = array(
                    'emp_id' => $csr->account_id,
                    'name' => $csr->name,
                    'totalLeads' => $totalLeads,
                );
                $csrLeads->push($array);
            } else {
                $lead = $lead->with('leads', 'leads.cityname');
                $csrLeads = $lead->paginate(20);
            }
        }
        return $csrLeads;
    }

    public static function getEmpNewLeads($agent_id, $purpose)
    {
        $qry =  AssignedLeads::Query();
        $qry = $qry->with('leads', 'leads.cityname');
        $qry = $qry->where('agent_id', $agent_id);
        $qry = $qry->whereDate('created_at', Carbon::now());
        $qry = $qry->where('status', 0)->where('type', 'lead');
        ($purpose == 'counting') ? $qry = $qry->count() : $qry = $qry->paginate(20);
        return $qry;
    }


    public static function getEmpThisMonthLeads($agent_id)
    {

        return $res = AssignedLeads::with('leads')->where('agent_id', $agent_id)->whereMonth('created_at', Carbon::now()->month)->get();
    }

    public static function getEmpTotalLeads($agent_id)
    {

        return $res = AssignedLeads::where('agent_id', $agent_id)->get();
    }

    public static function getEmpNotApproachesLeads($agent_id)
    {
        return $res = AssignedLeads::where('agent_id', $agent_id)
            ->where('status', 0)
            ->where('type', 'lead')
            ->get();
    }
}
