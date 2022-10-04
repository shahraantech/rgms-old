<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;


    public function post()
    {
        return $this->belongsTo(Project::class);
    }

    public function pending()
    {
        return $this->hasMany(Employee::class, 'assigned_to', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'assigned_to', 'id')->select(['id','name']);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_by', 'id')->select(['id','name']);
    }


    public function getStatusAttribute($value)
    {
        if ($value == 0) {
            $getVal = 'pending';
        }
        if ($value == 1) {
            $getVal = 'complete';
        }
        if ($value == 2) {
            $getVal = 'in process';
        }

        return $getVal;
    }

    public static  function getDailyTask($request)
    {


        $qry=Tasks::with('employee', 'user');
        $qry=$qry->where('project_id', 0);

        $qry->when($request->emp_id, function ($query, $emp_id) {
            return $query->where('assigned_to',$emp_id);
        });

        $qry->when($request->date, function ($query, $date) {
            return $query->whereDate('created_at',$date);
        });
        $qry->when($request->status, function ($query, $status) {
            return $query->where('status',$status);
        });
        if(!$request->search) {
            $qry = $qry->whereDate('created_at', Carbon::Today());
        }
        $qry=$qry->orderBy('id','DESC');
        $qry=$qry->paginate(20);
        return $qry;
    }

    public static  function tagifyValuesAdjustment($value)
    {
        $value = str_replace( array('[',']') , '' , $value );
        $value = str_replace( '\"', "\"" , $value );
        $value = explode(',', $value);
        $value_array = array();
        if ( is_array($value) && 0 !== count($value) ) {
            foreach ($value as $value_inner) {
                $value_array[] = json_decode( $value_inner );
            }
            $value_array = json_decode(json_encode($value_array), true);

            // Create an array only with the values of the child array
            $output = array();
            foreach($value_array as $value_array_inner) {
                foreach ($value_array_inner as $key=>$val) {
                    $output[] = $val;
                }
            }

        }

        return $output;
    }
    public static  function updateTaskStatus($task_id,$status){
        $task=Tasks::find($task_id);
        $task->status=$status;
        $task->save();
    }
}
