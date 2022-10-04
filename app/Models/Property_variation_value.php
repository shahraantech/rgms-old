<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property_variation_value extends Model
{
    use HasFactory;

    public function provaration()
    {
        return $this->belongsTo(Property_variation::class, 'variation_id','id');
    }
}
