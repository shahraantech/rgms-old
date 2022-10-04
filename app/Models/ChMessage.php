<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChMessage extends Model
{
    //
    //sendername
    public function sendername()
    {
        return $this->belongsTo(Employee::class, 'from_id', 'id')->select(['id', 'name','image']);
    }
}
