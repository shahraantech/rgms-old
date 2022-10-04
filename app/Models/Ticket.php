<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:d M Y h:i:s a',
    ];


    public function getStatusAttribute($value)
    {
        return strtoupper($value);

    }

    public function getPeriortyAttribute($value)
    {
        return strtoupper($value);

    }
}
