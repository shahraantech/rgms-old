<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    //sendername
    public function sendername()
    {
        return $this->belongsTo(Employee::class, 'sender_id', 'id')->select(['id', 'name','image']);
    }
}
