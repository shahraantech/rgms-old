<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s ',
    ];

    public function specification()
    {
        return $this->belongsTo(Specification::class, 'asset_id','id')->withDefault();
    }
}
