<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Create_specification extends Model
{

    use HasFactory;

    public function speci()
    {
        return $this->belongsTo(Asset::class, 'asset_id','id')->withDefault();
    }
}
