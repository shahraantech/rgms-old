<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:d M Y h:i:s a',
    ];

    public static function getAllGrades(){
        return $res=Grade::all();
    }
}
