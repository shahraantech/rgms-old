<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    use HasFactory;
    public static  function getSubTaskAcordingMainTask($task_id)
    {
         $res = SubTask::where('task_id',$task_id)->get();
             return $res;

    }

    public static  function getTaskProgress($task_id)
    {

         $totalTask = SubTask::where('task_id',$task_id)->count();
         $completeTask = SubTask::where('task_id',$task_id)->where('status',1)->count();
         if($totalTask > 0){
             $totalTask=$totalTask;
         }else{
             $totalTask=1;
         }
          $pertaskWeight=100 / $totalTask;
         $progress=$pertaskWeight * $completeTask;
         return $progress;
    }
}
