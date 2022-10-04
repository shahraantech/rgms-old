<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level_5 extends Model
{
    use HasFactory;

    public function levelfour()
    {
        return $this->belongsTo(Level_4::class, 'level_four_id');
    }
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static function getL5HeadsWithParams($request){
        return $res=Level_5::where('level_four_id',$request->l4headId)->select('id','level_five_head')->get();
    }
}
