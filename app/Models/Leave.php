<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    public function setLeaveStatusAttribute($value)
    {
        $this->attributes['leave_status'] = strtolower($value);

    }
    public function getLeaveStatusAttribute($value)
    {
        if($value==0){
            $value='PENDING';
        }
        if($value==1){
            $value='APPROVED';
        }
        if($value==2){
            $value='DECLINED';
        }
        return $value;
    }

    public  static function saveEmpLeave($emp_id,$leave_id,$from,$to,$reason,$status){
        $leave=new Leave();
        $leave->emp_id=$emp_id;
        $leave->leave_type=$leave_id;
        $leave->from=$from;
        $leave->to=$to;
        $leave->reason=($reason)?$reason:'Not Mention';
        $leave->leave_status=$status;
        if($leave->save()){
            return 1;
        }
    }

    public static function getLeavesData($emp_id){
        $res=Leave::where('emp_id', $emp_id)->get();
        return $res;
    }

    public static function countEmpLeaves($emp_id,$leave_id){

        $data['leavesAllow']=CompanyLeave::where('leave_type_id',$leave_id)->first();
        $data['leavesConsume']=Leave::where('emp_id',$emp_id)->where('leave_type',$leave_id)->where('leave_status',1)->count();
        $res=$data['leavesAllow']->leave_days - $data['leavesConsume'];
        return $res;
    }

    public static function getEmpConsumeLeaves($emp_id){
        return $res=Attendance::where('attendance_year',date('Y'))->where('emp_id',$emp_id)->where('status',3)->get();
    }
}
