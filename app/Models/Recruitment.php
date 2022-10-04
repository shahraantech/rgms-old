<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    use HasFactory;


    public function getStatusAttribute($value)
    {
        return strtoupper($value);
    }

    public function getShiftAttribute($value)
    {
        return strtoupper($value);
    }

}
