<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedMeetings extends Model
{
    use HasFactory;

    public function leads()
    {
        return $this->belongsTo(LeadsMarketing::class, 'lead_id', 'id');
    }

    public function getsourcename()
    {
        return $this->belongsTo(User::class, 'source_id', 'account_id');
    }
}
