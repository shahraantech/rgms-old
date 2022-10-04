<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAcType extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:d M Y ',
    ];

    public function achead()
    {
        return $this->belongsTo(AccountHead::class,  'ac_head_id','id');
    }
}
