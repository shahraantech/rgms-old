<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialPlatform extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:d M Y',
    ];

    public static function getSocialPlatforms(){
        return $res=SocialPlatform::all();
    }
}
