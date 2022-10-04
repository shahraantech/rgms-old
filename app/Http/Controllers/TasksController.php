<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Lead;
use App\Models\Productivity;
use App\Models\Project;
use App\Models\SubTask;
use App\Models\Tasks;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Google\Service\ServiceControl\Auth;
use Illuminate\Support\Facades\Redirect;

class TasksController extends Controller
{
    protected $userId;

    public function __construct()
    {

        $this->middleware(function (Request $request, $next) {
            if (!\Auth::check()) {
                return redirect('/login');
            }
            $this->userId = \Auth::user()->account_id; // you can access user id here

            return $next($request);
        });
    }
    //
    public function index()
    {

        $data['projects'] =  $data['projects'] = Project::paginate(6);

        $totalProject = Project::count();
        $doneProject = Project::where('status', 'Complete')->count();
        ($totalProject > 0) ? $data['progress'] = ($doneProject * 100) / $totalProject : $data['progress'] = 0;
        return view('tasks.task-board')->with(compact('data'));
    }

    //myTasks
    public function myTasks(Request $request)
    {

        if ($request->ajax()) {
            return  $data['myTasks'] = Tasks::join('employees', 'employees.id', '=', 'tasks.assigned_to')
                ->select('employees.name', 'tasks.*')
                ->where('tasks.assigned_to', $this->userId)
                ->get();
        }
        $data['tasks'] = Tasks::where('tasks.assigned_to', $this->userId)->get();
        return view('tasks.my-tasks')->with(compact('data'));
    }


    public function MyDailyTask(Request $request)
    {
        $data['empTasks']=Tasks::where('assigned_to', $this->userId)->orderBy('id','DESC')->get();
        return view('tasks.my-daily-tasks')->with(compact('data'));
    }

    public function myProjects()
    {
        $data['projects'] =  $data['projects'] = Project::join('employees', 'projects.manager_id', '=', 'employees.id')
            ->select('employees.id', 'employees.name', 'employees.image', 'projects.*')
            ->where('projects.manager_id', $this->userId)
            ->paginate(3);
        $data['team'] = Lead::join('employees', 'employees.id', 'leads.member_id')->where('leads.leader_id', $this->userId)
            ->select('employees.name', 'employees.id', 'employees.image')->get();
        $totalProject = Project::where('manager_id', $this->userId)->count();
        $doneProject = Project::where('manager_id', $this->userId)->where('status', 'Complete')->count();
        ($totalProject > 0) ? $data['progress'] = ($doneProject * 100) / $totalProject : $data['progress'] = 0;

        return view('tasks.my-projects')->with(compact('data'));
    }


    //projects
    public  function projects(Request $request)
    {

        $data['manager'] = Employee::join('leads', 'leads.leader_id', '=', 'employees.id')
            ->select('employees.id', 'employees.name')
            ->distinct()
            ->get();

        $data['projects'] = Project::join('employees', 'projects.manager_id', '=', 'employees.id')
            ->select('employees.id', 'employees.name', 'employees.image', 'projects.*')
            ->orderBy('projects.id', 'DESC')
            ->paginate(20);

        return view('tasks.projects')->with(compact('data'));
    }


    //eidt projects
    public function editProjects($id)
    {
        $pro = Project::find($id);
        $manager = Employee::join('leads', 'leads.leader_id', '=', 'employees.id')
            ->select('employees.id', 'employees.name')
            ->distinct()
            ->get();
        return view('tasks.edit-projects', compact('pro', 'manager'));
    }


    //saveProjects
    public function saveProjects(Request $request)
    {
        $data = $request->all();

        $rules = array(
            'project_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'price' => 'required',
            'priority' => 'required',
            'manager_id' => 'required',
            //'file'=>'mimes:jpeg,jpg,png,gif|required|max:10000'

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }

        $name = '';
        $path = '';
        if ($request->hasFile('file')) {
            $uniqueid = uniqid();
            $original_name = $request->file('file')->getClientOriginalName();
            $size = $request->file('file')->getSize();
            $extension = $request->file('file')->getClientOriginalExtension();
            $name = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;
            $imagepath = url('/storage/uploads/project-files/' . $name);
            $path = $request->file('file')->storeAs('public/uploads/project-files/', $name);
        }

        $pro = new Project();

        $pro->title = $request->project_name;
        $pro->start_date = $request->start_date;
        $pro->end_date = $request->end_date;
        $pro->price = $request->price;
        $pro->priorty = $request->priority;
        $pro->manager_id = $request->manager_id;
        $pro->desc = $request->des;
        $pro->path = $path;
        $pro->file = $name;
        $pro->status = 0;

        if ($pro->save()) {

            return Redirect::back()->withSuccess(['success', 'Project created successfully']);
        } else {
            return Redirect::back()->withSuccess(['errors', 'Projeect not saved ']);
        }
    }



    public function upadateProjects(Request $request)
    {
        $pro = Project::find($request->id);
        $pro->title = $request->project_name;
        $pro->start_date = $request->start_date;
        $pro->end_date = $request->end_date;
        $pro->price = $request->price;
        $pro->priorty = $request->priority;
        $pro->manager_id = $request->manager_id;
        $pro->desc = $request->des;
        if ($pro->update()) {
            return redirect('projects');
        } else {
            return Redirect::back()->withSuccess(['errors', 'Projeect not updated ']);
        }
    }


    public function deleteProjects(Request $request)
    {
        $pro = Project::find($request->id);
        if ($pro->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'project deleted successfully'
            ]);
        }
    }


    //getManagerData
    public  function getManagerData(Request $request)
    {
        echo json_encode(Employee::find($request->manager_id));
    }

    //projectDetails
    public  function projectDetails($id)
    {
        $project_id = decrypt($id);

        $data['project_id'] = $project_id;
        $data['project'] = Project::join('employees', 'projects.manager_id', '=', 'employees.id')
            ->select('employees.id', 'employees.name', 'employees.image', 'projects.*')
            ->where('projects.id', $project_id)
            ->first();

        $member = Lead::where('leads.leader_id', $this->userId)->where('status', 1)->first();
        $member_ids = (explode(",", $member->member_id));

        $data['member'] = collect([]);
        foreach ($member_ids as $k => $val) {
            $empData = Employee::find($val);
            if ($empData) {
                $array = array(
                    'id' => $empData->id,
                    'name' => $empData->name,

                );
                $data['member']->push($array);
            }
        }
        return view('tasks.project-details')->with(compact('data'));
    }

    public  function createDailyTask(Request $request)
    {
        $employees = Employee::getShahranEmp();
        $data['task'] =Tasks::getDailyTask($request);
        if($request->isMethod('post')){
             $data['task'] =Tasks::getDailyTask($request);
        }

        return view('tasks.create-new-task', get_defined_vars());
    }


    public  function saveCreateDailyTask(Request $request)
    {

        if($request->isMethod('post')) {

            $data = $request->all();
            $rules = array(
                'task' => 'required',
                'assign_to' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'desc' => 'required',
            );
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }


            if (Tasks::where('task', $request->task)->first()) {
                return response()->json(['errors' => 'This task already created']);
            }
            $task = new Tasks();
            $task->project_id = 0;
            $task->assigned_to = $request->assign_to;
            $task->assigned_by = auth()->user()->id;
            $task->task = $request->task;
            $task->start_date = $request->start_date;
            $task->end_date = $request->end_date;
            $task->desc = $request->desc;
            $task->status = 0;

            if ($task->save()) {
                $adjustSubTask= Tasks::tagifyValuesAdjustment($request->sub_task);
                foreach ($adjustSubTask as $key=>$val){

                    $subTask = new SubTask();
                    $subTask->task_id = $task->id;
                    $subTask->sub_task_title =$val;
                    $subTask->status = 0;
                    $subTask->save();
                }
            }


            return response()->json(['success' => 'Record save successfully'], 200);

        }
    }

    //markAsCompleteSubTask

    public  function markSubTask(Request $request)
    {

        $sub_task_id=$request->id;
        $status=$request->status;

        $subTask=SubTask::find($sub_task_id);
        $subTask->status=$status;
        $subTask->save();

        $taskStatus=1;
        $sub=SubTask::where('task_id',$subTask->task_id)->get();
        foreach($sub as $sub){
            if($sub->status==0){
                $taskStatus=0;
            }
        }
        $task=Tasks::find($subTask->task_id);
        ($taskStatus==1)? $status=1: $status=0;
        $task->save();
        return response()->json(['success' => 'Task mark as completed'], 200);

    }

    //empTask

    public  function empTask($emp_id)
    {
         $data['emp']=Employee::getEmpInfo($emp_id);
        $data['empTasks']=Tasks::where('assigned_to', decrypt($emp_id))->orderBy('id','DESC')->get();
        return view('tasks.emp-tasks')->with(compact('data'));
    }

    //saveTasks
    public function saveTasks(Request $request)
    {
        $data = $request->all();

        $rules = array(
            'task' => 'required',
            'assign_to' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'desc' => 'required',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }


        if ($request->ajax()) {

    if(Tasks::where('task',$request->task)->first())
    {
        return response()->json(['errors' => 'This task already exist'], 200);
    }
            $task = new Tasks();
            $task->project_id = $request->hidden_project_id;
            $task->assigned_to = $request->assign_to;
            $task->assigned_by = $this->userId;
            $task->task = $request->task;
            $task->start_date = $request->start_date;
            $task->end_date = $request->end_date;
            $task->desc = $request->desc;
            $task->status = 0;

            if ($task->save()) {

                return response()->json(['success' => 'Task created successfully'], 200);
            } else {
                return response()->json(['errors' => 'Task not created'], 200);
            }
        }
    }

    public function getNewTask(Request $request)
    {
        $task = Tasks::with('employee', 'user')->where('project_id', 0)->get();
        return $task;
    }

    public function editNewtask(Request $request)
    {
        $task = Tasks::find($request->id);
        $employees = Employee::where('company_id', 2)->get();
        return response()->json([
            'task' => $task,
            'employees' => $employees,
        ]);
    }




    public function updateNewtask(Request $request)
    {


        $task = Tasks::find($request->task_id);

        $task->project_id = 0;
        $task->assigned_to = $request->assign_to;
        $task->assigned_by = $this->userId;
        $task->task = $request->task;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->desc = $request->desc;
        $task->status = 0;

        if ($task->update()) {

            return response()->json(
                [
                    'status' => 200,
                    'message' => 'Task update successfully',
                ]
            );
        }
    }

    public function deleteNewtask(Request $request)
    {
        $pro = Tasks::find($request->id);
        if ($pro->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Task deleted successfully'
            ]);
        }
    }

    //getTaskList
    public  function getTaskList(Request $request)
    {
        $data = Tasks::join('employees', 'employees.id', 'tasks.assigned_to')
            ->select('employees.name', 'tasks.*')
            ->where('project_id', $request->project_id)->orderBy('id', 'desc')
            ->get();
        echo json_encode($data);
    }





    //updateProjectStatus
    public function updateProjectStatus(Request $request)
    {
        $pro = Project::find($request->project_id);
        $pro->status = 'Complete';
        if ($pro->save()) {
            return response()->json(['success' => 'Mark completed successfully']);
        }
        return response()->json(['error' => 'Mark as not completed ']);
    }


    //getMySingleTask
    public function getMySingleTask(Request $request)
    {

        if ($request->ajax()) {
            return  $data['myTasks'] = Tasks::join('projects', 'projects.id', 'tasks.project_id')
                ->join('employees', 'employees.id', '=', 'tasks.assigned_to')
                ->select('employees.name', 'employees.image',  'projects.title', 'tasks.*')
                ->where('tasks.id', $request->task_id)
                ->get();
        }
        return view('tasks.my-tasks');
    }


    public function getMyDailySingleTask(Request $request)
    {
        return Tasks::with('employee', 'user')->where('id', $request->id)->get();
    }

    public function storeMyDailySingleTask(Request $request,$id)
    {
        $pro = new Productivity();
        $pro->task_id = $id;
        $pro->project_id = 0;
        $pro->emp_id = auth()->user()->id;
        $pro->progress = 100;
        $pro->remarks = 'Completed';
        $pro->status = 1;
        $pro->save();

        return response()->json([
            'status' => 200,
            'message' => 'Productivity Adedd Successfully'
        ]);
    }

    //updateTaskStatus

    public function updateTaskStatus(Request $request)
    {
        $task = Tasks::find($request->task_id);
        $task->status = 'Complete';
        if ($task->save()) {
            return response()->json(['success' => 'Mark completed successfully']);
        }
        return response()->json(['error' => 'Mark as not completed ']);
    }


    //saveTaskProgress
    public function saveTaskProgress(Request $request)
    {
        $data = $request->all();

        $rules = array(
            'task_id' => 'required',
            'progress' => 'required',
            'remarks' => 'required',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }

        $pro = new Productivity();
        $project = Tasks::find($request->task_id);
        $pro->project_id = $project->project_id;
        $pro->task_id = $request->task_id;
        $pro->emp_id = $this->userId;
        $pro->progress = $request->progress;
        $pro->remarks = $request->remarks;
        $pro->status = 2;
        $pro->save();
        $progeress = Productivity::where('task_id', $pro->task_id)->sum('progress');

        $task = Tasks::find($pro->task_id);
        if ($progeress >= 100) {
            $task->status = 1;
        } else {
            $task->status = 2;
        }
        $task->save();

        return back()->with('success', 'Productivity Added Successfully');
    }


    public function editTasks(Request $request)
    {
        $task = Tasks::find($request->id);
        echo json_encode($task);
    }

    //udpate task
    public function updateTasks(Request $request)
    {
        $task = Tasks::find($request->task_id);
        $task->assigned_to = $request->assign_to;
        $task->task = $request->task;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->desc = $request->desc;
        if ($task->update()) {
            return response()->json([
                'status' => 200,
                'message' => 'task updated successfully',
            ]);
        }
    }

    public function deleteTasks(Request $request)
    {
        $task = Tasks::find($request->id);
        if ($task->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'task deleted successfully',
            ]);
        }
    }


    //taskDetailsForTaskBoard

    public  function taskDetailsForTaskBoard($id)
    {
        $project_id = decrypt($id);

        $data['project_id'] = $project_id;
        $data['project'] = Project::join('employees', 'projects.manager_id', '=', 'employees.id')
            ->select('employees.id', 'employees.name', 'employees.image', 'projects.*')
            ->where('projects.id', $project_id)
            ->first();

        $data['leader'] = Project::join('employees', 'employees.id', '=', 'projects.manager_id')
            ->select('employees.id', 'employees.name', 'employees.image')
            ->where('projects.id', $project_id)
            ->first();

        $data['team'] = Tasks::join('employees', 'employees.id', '=', 'tasks.assigned_to')
            ->select('employees.id', 'employees.name', 'employees.image')
            ->where('tasks.project_id', $project_id)
            ->groupBy('employees.name')
            ->get();


        $data['pendingTasks'] = Tasks::where('status', 0)->where('project_id', $project_id)->get();
        $data['completeTasks'] = Tasks::where('status', 1)->where('project_id', $project_id)->get();


        $data['tasks'] = Tasks::join('employees', 'employees.id', 'tasks.assigned_to')
            ->select('employees.name', 'tasks.*')
            ->where('tasks.project_id', $project_id)->get();

        return view('tasks.task-board-details')->with(compact('data'));
    }
}
