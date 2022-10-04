<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asign_asset extends Model
{
    use HasFactory;

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id')->withDefault();
    }

    public function assets()
    {
        return $this->belongsTo(Asset::class, 'asset_id')->withDefault();
    }
}
