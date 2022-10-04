<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Employee extends Model
{
    use HasFactory;

      public function employee()
    {
        return $this->belongsTo(Employee::class, 'id','desg_id');
    }


    public function getOnAttribute($value)
    {
        return \Illuminate\Support\Facades\Date::createFromFormat('H:i:s', $value);
    }

    public function getOfAttribute($value)
    {
        return \Illuminate\Support\Facades\Date::createFromFormat('H:i:s', $value);
    }


    public function getDesignation()
    {
        return $this->belongsTo(Designation::class,  'desg_id','id');
    }

    public function depart()
    {
        return $this->belongsTo(Department::class,  'dept_id','id');
    }

    public static function getEmpBranchId()
    {
        $emp_id= Auth::user()->account_id;
         $res=Employee::find($emp_id);
         return $res->location_id;
    }


    public static function getEmpInfo($emp_id)
    {
       return $emp=Employee::with('getDesignation')->find(decrypt($emp_id));
    }

    public static function getShahranEmp()
    {
        $qry = Employee::query();
        $qry=$qry-> select('id','name');
        $qry=$qry-> where('company_id', 2);
        $qry=$qry->where('status', 1);
        $qry=$qry->get();
        return $qry;
    }


}
