<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ApprochedLeads extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];


    public function temp()
    {
        return $this->belongsTo(Temprature::class, 'temp_id', 'id')->select(['id', 'temp']);
    }

    public function agent()
    {
        return $this->belongsTo(Employee::class, 'agent_id', 'id')->select(['id', 'name']);
    }

    public function leads()
    {
        return $this->belongsTo(LeadsMarketing::class, 'lead_id', 'id');
    }

    public static function getOverDueLeads($agent_id)
    {
        $qry = ApprochedLeads::query();
        ($agent_id) ? $qry = $qry->where('agent_id', $agent_id) : '';
        $qry = $qry->whereDate('followup_date', '<', Carbon::today());
        $qry = $qry->where('status', 0);
        $qry = $qry->count();
        return $qry;
    }

    public static function getTempratureWiseLeads($temp_id, $purpose, $receiver, $agent_id)
    {

        $qry = ApprochedLeads::Query();
        $qry = $qry->select('lead_id')->distinct('lead_id');
        ($receiver!='admin')?$qry = $qry->where('agent_id',$agent_id):'';
        ($receiver=='admin')?$qry = $qry->where('created_at', '>=', Carbon::today()->subDays(3)):$qry = $qry->whereDate('created_at', date('Y-m-d'));
        $qry = $qry->get();


        $temp = 0;
        if ($purpose == 'counting') {
        foreach ($qry as $appLeads) {
            $res = ApprochedLeads::where('lead_id', $appLeads->lead_id)->latest('id')->first();
            if ($res && $res->temp_id == $temp_id) {
                $temp++;
            }
        }
        return $temp;
         }
        else{
            $data = collect([]);
            foreach ($qry as $appLeads) {
                 $res = ApprochedLeads::where('lead_id', $appLeads->lead_id)->latest('id')->first();
                if ($res && $res->temp_id == $temp_id) {

                    $qry= ApprochedLeads::with('leads');
                    $qry=$qry->where('id', $res->id );
                    $qry=$qry->first();
                    $array = $qry;
                    $data->push($array);
                }
            }
            return $data;
        }
    }

    public static function getEmpOverDueLeads($agent_id,$purpose)
    {
        $qry= ApprochedLeads::Query();
        $qry =$qry->join('assigned_leads', 'assigned_leads.lead_id','=','approched_leads.lead_id');
        $qry=$qry->whereDate('approched_leads.followup_date', '<', Carbon::today());
        $qry=$qry->where('assigned_leads.agent_id',$agent_id);
        $qry=$qry->where('approched_leads.status', 0);
        $qry=$qry->where(
        function($query) {
            return $query
                ->where('approched_leads.temp_id','!=',9)
                ->where('approched_leads.temp_id','!=',10);
        });
        $qry=$qry->where('approched_leads.lead_type', 0)->with('leads','leads.cityname');
        ($purpose=='counting')? $qry=$qry->count():$qry=$qry->paginate(20);
        return $qry;
    }

    public static function getTempComments($lead_id){

       return  $lead = ApprochedLeads::with('temp')
            ->where('lead_id', $lead_id)
            ->latest('id')
            ->first();
    }

    public static function chekTodayApproch($lead_id){

       return $res= ApprochedLeads::whereDate('created_at',date('Y-m-d'))->where('lead_id',$lead_id)->first();
    }



}

