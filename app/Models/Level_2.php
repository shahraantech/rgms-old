<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level_2 extends Model
{
    use HasFactory;

    public function levelone()
    {
        return $this->belongsTo(Level_1::class, 'level_one_id');
    }
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static function getL2HeadsWithParams($request){
        return $res=Level_2::where('level_one_id',$request->l1headId)->select('id','level_two_head')->get();
    }
}
