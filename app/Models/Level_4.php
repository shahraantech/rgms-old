<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level_4 extends Model
{
    use HasFactory;

    public function levelthree()
    {
        return $this->belongsTo(Level_3::class, 'level_three_id');
    }
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static function getL4HeadsWithParams($request){
        return $res=Level_4::where('level_three_id',$request->l3headId)->select('id','level_four_head')->get();
    }

    public static function getL4HeadAndLevel($id){
        $res=Level_4::find($id);
        $data['coa_level']=4;
        $data['lHeadId']=$res->id;
        return $data;
    }
}
