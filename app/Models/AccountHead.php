<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountHead extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:d M Y ',
    ];

    public function mainacname()
    {
        return $this->belongsTo(MainAcType::class,  'main_ac_id','id');
    }

    public function subacname()
    {
        return $this->belongsTo(SubAcType::class,  'sub_ac_id','id');
    }

    public function detailacname()
    {
        return $this->belongsTo(DetailAcType::class,  'detail_ac_id','id');
    }
}
