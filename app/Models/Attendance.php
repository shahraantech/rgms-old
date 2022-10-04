<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    public function setStatusAttribute($value)
    {
        if($value=='present' OR $value==1){
            $value=1;
        }
            if($value=='absent' OR $value==0){
                $value=0;
        }
        if($value=='wo'){
            $value=2;
        }
        if($value=='leave'){
            $value=3;
        }
        $this->attributes['status'] =$value;
    }

    public function getStatusAttribute($value)
    {
        if($value==0){
            $getVal='Absent';
        }
        if($value==1){
            $getVal='Present';
        }
        if($value==2){
            $getVal='wo';
        }
        if($value==3){
            $getVal='leave';
        }

        return $getVal;
    }
    public function employee() {
        return $this->belongsTo('App\Models\Employee', 'emp_id');
    }
    public static function getEmpAttendanceWithParams($emp_id,$date,$month,$year){
      return $res= Attendance::where([['emp_id',$emp_id], ['attendance_date', $date], ['attendance_month', $month], ['attendance_year', $year]])->get();

    }
    public static  function markEmpAttendanceSingle($emp_id,$status,$att_date,$month,$year,$leave_id)
    {

        $res=self::chekEmpAttMarkOrNot($emp_id,$att_date,$month,$year);
        if (!$res) {
            $att = new Attendance();
            $att->emp_id = $emp_id;
            $att->status = $status;
            $att->date = date($year . '-' . $month . '-' . $att_date);
            $att->attendance_date = $att_date;
            $att->attendance_month = $month;
            $att->attendance_year = $year;
            $att->marked_by = 'admin';
            $att->guard = 'web';
            $att->leave_id =$leave_id;
            if ($att->save()) {
                return 1;
            }
        }
    }
    //updateEmpAttendanceSingle
    public static  function updateEmpAttendanceSingle($emp_id,$status,$attDate,$attMonth,$attYear,$leave_id=NULL)
    {

        $att = Attendance::where('emp_id', $emp_id)
            ->where('attendance_date', $attDate)
            ->where('attendance_month', $attMonth)
            ->where('attendance_year', $attYear)
            ->first();
        if ($att) {
            $att->leave_id =$leave_id;
            $att->status =$status;
            if ($att->save()) {
                return 1;
            }
        }
    }

    public static function chekEmpAttMarkOrNot($emp_id,$att_date,$month,$year){
       return $res = Attendance::where('emp_id', $emp_id)
            ->where('attendance_date', $att_date)
            ->where('attendance_month', $month)
            ->where('attendance_year', $year)
            ->first();
    }





}
