<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property_variation extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s ',
    ];

    public function type()
    {
        return $this->belongsTo(Property_type::class, 'type_id', 'id');
    }
}
