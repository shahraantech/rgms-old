<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification_value extends Model
{
    use HasFactory;

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id','id')->withDefault();
    }

    public function speci()
    {
        return $this->belongsTo(Specification::class, 'specification_id','id')->withDefault();
    }
}
