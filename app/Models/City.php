<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:d M Y',
    ];

    public static function getAllCity(){
        return $res=City::all();
    }
}
