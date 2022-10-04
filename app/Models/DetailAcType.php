<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailAcType extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:d M Y ',
    ];

    public function subacname()
    {
        return $this->belongsTo(SubAcType::class,  'sub_ac_type_id','id');
    }
}
