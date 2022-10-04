<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;
    public function getStatusAttribute($value)
    {
        return strtoupper($value);
    }

    public function trainee()
    {
        return $this->belongsTo(Employee::class, 'emp_id','id');
    }
}
