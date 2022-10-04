<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Department extends Model
{


    protected $casts = [
        'created_at' => 'datetime:d M Y h:i:s a',
    ];


    public function getCompanyName()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    public static function getAllDept(){
        return $res=Department::all();
    }



}
