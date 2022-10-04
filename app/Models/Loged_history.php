<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Loged_history extends Model
{
    use HasFactory;

    protected $casts = [
        'check_in_time' => 'datetime:d M Y',
    ];

    public function history()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public  static  function createLogedInHistory($guard,$lat,$lang,$user_id,$address){
        $log_time = new Loged_history();
        $log_time->user_id = $user_id;
        $log_time->check_in_time = Carbon::now();
        $log_time->guard = $guard;
        $log_time->lat = $lat;
        $log_time->lang = $lang;
        $log_time->address = $address;
        $log_time->save();
    }
}
