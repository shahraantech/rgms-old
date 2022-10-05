<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QaFeedBack extends Model
{
    use HasFactory;

    public function agent()
    {
        return $this->belongsTo(Employee::class, 'agent_id', 'id')->select(['id', 'name']);
    }

    public function leads()
    {
        return $this->belongsTo(LeadsMarketing::class, 'lead_id', 'id');
    }
}
