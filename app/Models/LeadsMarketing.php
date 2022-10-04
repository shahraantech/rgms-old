<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadsMarketing extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'email',
        'contact',
        'city_id',
        'platform_id',
        'address',
        'date',
        'lead_type',
        'user_id',
        'interest',

    ];
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];


    public function cityname()
    {
        return $this->belongsTo(City::class, 'city_id', 'id')->select(['id', 'city_name']);
    }

    public function platformname()
    {
        return $this->belongsTo(SocialPlatform::class, 'platform_id', 'id');
    }

//    protected $casts = [
//        'created_at' => 'datetime:d M Y',
//    ];

    public static function getTodayCreatedLeads($agent_id, $purpose)
    {

        $qry = LeadsMarketing::query();
        $qry = $qry->whereDate('created_at', date('Y-m-d'));
        ($agent_id) ? $qry->where('agent_id', $agent_id) : '';
        ($purpose == 'counting') ? $qry = $qry->count() : $qry = $qry->with('cityname', 'platformname')->paginate(200);
        return $qry;
    }

    //getOpenLeads

    public static function getOpenLeads($purpose)
    {
        $qry = LeadsMarketing::query();
        $qry = $qry->leftJoin('assigned_leads', 'leads_marketings.id', '=', 'assigned_leads.lead_id');
        $qry = $qry->whereNull('assigned_leads.lead_id');
        $qry = $qry->whereNull('leads_marketings.manager_id');
        $qry = $qry->select('leads_marketings.*');
        ($purpose == 'counting') ? $qry = $qry->count() : $qry = $qry->with('cityname', 'platformname')->paginate(10);
        return $qry;
    }

    public static function getLeadsInfo($lead_id)
    {
        return $res = LeadsMarketing::find($lead_id);
    }


    public static function getAllLeads($purpose=NULL,$startDate,$endDate)
    {

         $qry = LeadsMarketing::query();
         $qry=$qry->orderby('id', 'DESC');
        if($purpose==1){
            $qry=$qry->whereDate('created_at', '>=', $startDate);
            $qry = $qry->whereDate('created_at', '<=', $endDate);
            $qry = $qry-> count();
        }
       else {
           $qry = $qry->get();
       }
        return $qry;
    }

    //getLeadsSocialPlatformWise

    public static function getLeadsSocialPlatformWise($platformId, $isCounting,$start_date,$end_date)
    {
        $qry = LeadsMarketing::Query();
        ($platformId > 0)?$qry = $qry->where('platform_id', $platformId):'';
            $qry = $qry->whereDate('created_at', '>=', $start_date);
            $qry = $qry->whereDate('created_at', '<=', $end_date);
        //1 use for counting
        ($isCounting == 1) ? $qry = $qry->count() : $qry = $qry->get();
        return $qry;
    }

    public static function getLeadsStats($platformId,$temp_id,$qryForCall,$start_date,$end_date)
    {
        $qry = ApprochedLeads::Query();
        $qry = $qry->join('leads_marketings', 'leads_marketings.id', 'approched_leads.lead_id');
        ($platformId > 0)?$qry = $qry->where('leads_marketings.platform_id', $platformId):'';
            $qry = $qry->whereDate('leads_marketings.created_at', '>=', $start_date);
            $qry = $qry->whereDate('leads_marketings.created_at', '<=', $end_date);
        ($qryForCall == 1) ? $qry = $qry->where('approched_leads.is_connected', 1)->distinct('lead_id')->count():'';
        ($qryForCall != 1) ? $qry = self::countLeadsTempForStat($qry->groupBy('approched_leads.lead_id')->get(), $temp_id) : '';
        return $qry;
    }
    public static function countLeadsTempForStat($qry, $temp_id)
    {
         $temp = 0;
        foreach ($qry as $leads) {
            $res = ApprochedLeads::where('lead_id',$leads->id)->latest('id')->first();
            if ($res) {
                if ($res->temp_id == $temp_id) {
                    $temp++;
                }
            }
        }
            return $temp;
        }

        //getAllSales

    public static function getAllSales($request)
    {
        $qry=ApprochedLeads::query();
        $qry=$qry->with('agent','leads');

        $qry->when($request->agent_id, function ($query, $agent_id) {
            return $query->where('agent_id', $agent_id);
        });
        $qry->when($request->search_month, function ($query, $search_month) {
            return $query->whereMonth('created_at', $search_month);
        });
        $qry->when($request->search_year, function ($query, $search_year) {
            return $query->whereYear('created_at', $search_year);
        });
        $qry->when($request->from_date, function ($query, $agent_id) {
            return $query->where('agent_id', $agent_id);
        });

        $qry= $qry->where('temp_id',9);
        $qry=$qry->OrderBy('id','DESC')->get();
        return $qry;
    }


    public static function getDeadLeads($request)
    {
        $qry=ApprochedLeads::query();
        $qry=$qry->with('agent','leads');

        $qry->when($request->agent_id, function ($query, $agent_id) {
            return $query->where('agent_id', $agent_id);
        });
        $qry->when($request->search_month, function ($query, $search_month) {
            return $query->whereMonth('created_at', $search_month);
        });
        $qry->when($request->search_year, function ($query, $search_year) {
            return $query->whereYear('created_at', $search_year);
        });
        $qry->when($request->from_date, function ($query, $agent_id) {
            return $query->where('agent_id', $agent_id);
        });

        $qry= $qry->where('temp_id',10);
        $qry=$qry->OrderBy('id','DESC')->get();
        return $qry;
    }



    public static function countLeadFollowUps($lead_id)
    {
        $qry=ApprochedLeads::query();
        $qry= $qry->where('lead_id',$lead_id);
        $qry=$qry->count();
        return $qry;
    }
    }
