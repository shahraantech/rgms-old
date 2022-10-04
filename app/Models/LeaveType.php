<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id','id');
    }
    public static function getLeaveName($leave_id)
    {
        $leave_name='Leave';
        $leave=self::find($leave_id);
        if($leave) {
            $leave_name = preg_replace('~\S\K\S*\s*~u', '', $leave->laeve_type);
        }
        return $leave_name;
    }

}
