<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    public function proptype()
    {
        return $this->belongsTo(Property_type::class, 'property_type_id')->withDefault();
    }

    public function propertyproject()
    {
        return $this->belongsTo(Property_project::class, 'project_id')->withDefault();
    }
}
