<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resignation extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:d M Y h:i:s a',
    ];

    public function getStatusAttribute($value)
    {
        return strtoupper($value);

    }


    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('d m Y');
    }
}

