<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level_3 extends Model
{
    use HasFactory;

    public function leveltwo()
    {
        return $this->belongsTo(Level_2::class, 'level_two_id', 'id');
    }
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];


    public static function getL3HeadsWithParams($request){
        return $res=Level_3::where('level_two_id',$request->l2headId)->select('id','level_three_head')->get();
    }
}
