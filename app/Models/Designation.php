<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:d M Y h:i:s a',
    ];


    public function designation()
    {
        return $this->hasMany(Designation::class, 'id');
    }
    public static function  getDesignation()
    {
        return $res = Designation::all();
    }
}
