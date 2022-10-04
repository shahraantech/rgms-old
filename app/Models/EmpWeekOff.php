<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpWeekOff extends Model
{
    use HasFactory;


    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id','id');
    }

    public function empoyee()
    {
        return $this->belongsTo(Employee::class, 'emp_id','id');
}
    public static function getEmpOffWeekWithParams($emp_id){
        $off=EmpWeekOff::where('emp_id',$emp_id)->first();
        return $off;

    }
}
