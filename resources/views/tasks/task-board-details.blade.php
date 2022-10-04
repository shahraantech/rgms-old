@extends('setup.master')

@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">{{ $data['project']->title ? $data['project']->title : '' }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Project</li>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- /Page Header -->

            <input type="hidden" name="hidden_project_id" value="{{ $data['project']->id }}">
            <div class="row">
                <div class="col-lg-8 col-xl-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="project-title">
                                <h5 class="card-title">{{ $data['project']->title ? $data['project']->title : '' }}</h5>

                                @php
                                    $open = App\Models\Tasks::where('project_id', $data['project']->id)
                                        ->where('status', 2)
                                        ->count();
                                    $pending = App\Models\Tasks::where('project_id', $data['project']->id)
                                        ->where('status', 0)
                                        ->count();
                                    $complete = App\Models\Tasks::where('project_id', $data['project']->id)
                                        ->where('status', 1)
                                        ->count();
                                @endphp
                                <small class="block text-ellipsis m-b-15"><span
                                        class="text-xs">{{ $data['project']->id }}</span> <span class="text-muted">open
                                        tasks, </span>
                                    <span class="text-xs">{{ $data['project']->id }}</span> <span class="text-muted">tasks
                                        completed</span></small>
                            </div>
                            <p>
                                {!! $data['project']->desc ? $data['project']->desc : '' !!}
                            </p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title m-b-20">Uploaded files</h5>
                            <ul class="files-list">
                                <li>
                                    <div class="files-cont">
                                        <div class="file-type">
                                            <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                                        </div>
                                        <div class="files-info">
                                            <span class="file-name text-ellipsis"><a
                                                    href="{{ asset('storage/app/public/uploads/project-files/') . '/' . $data['project']->file }}">AHA
                                                    Selfcare Mobile Application Test-Cases.xls</a></span>
                                            <span class="file-author"><a
                                                    href="{{ asset('storage/app/public/uploads/project-files/') . '/' . $data['project']->file }}"></a></span>
                                            <span
                                                class="file-date">{{ date('d M Y', strtotime($data['project']->created_at)) }}</span>
                                            <div class="file-size">Size: 14.8Mb</div>
                                        </div>
                                        <ul class="files-action">
                                            <li class="dropdown dropdown-action">
                                                <a href="" class="dropdown-toggle btn btn-link"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                    <i class="material-icons">more_horiz</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:void(0)">Download</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                                        data-target="#share_files">Share</a>
                                                    <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="project-task">
                        <ul class="nav nav-tabs nav-tabs-top nav-justified mb-0" id="project_task">
                            <li class="nav-item"><a class="nav-link active" href="#all_tasks" data-toggle="tab"
                                    aria-expanded="true">All Tasks</a></li>
                            <li class="nav-item btnPending" data="pending"><a class="nav-link task" href="#pending_tasks"
                                    data-toggle="tab" aria-expanded="false">Pending Tasks</a></li>
                            <li class="nav-item btnComplete"><a class="nav-link task" href="#completed_tasks"
                                    data-toggle="tab" aria-expanded="false" data="Complete">Completed Tasks</a></li>
                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane show active" id="all_tasks">

                                <div class="task-wrapper">
                                    <div class="task-list-container">
                                        <div class="task-list-body">
                                            <ul id="task-list">
                                                @isset($data['tasks'])
                                                    @foreach ($data['tasks'] as $task)
                                                        <li class="task">
                                                            <div class="task-container">
                                                                <span class="task-action-btn task-check">
                                                                    <span class="action-circle large complete-btn"
                                                                        title="Mark Complete">
                                                                        <i class="material-icons">check</i>
                                                                    </span>
                                                                </span>
                                                                <span class="task-label"
                                                                    contenteditable="true">{{ $task->task }}</span>
                                                                <span class="task-action-btn task-btn-right">
                                                                    <span class="" title="Assign">
                                                                        <small>{{ $task->name }}</small>

                                                                    </span>

                                                                </span>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @endisset
                                            </ul>
                                        </div>
                                        <div class="task-list-footer">
                                            <div class="new-task-wrapper">
                                                <textarea id="new-task" placeholder="Enter new task here. . ."></textarea>
                                                <span class="error-message hidden">You need to enter a task first</span>
                                                <span class="add-new-task-btn btn" id="add-task">Add Task</span>
                                                <span class="btn" id="close-task-panel">Close</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane" id="pending_tasks">

                                <div class="task-wrapper">
                                    <div class="task-list-container">
                                        <div class="task-list-body">
                                            <ul id="task-list">

                                                @isset($data['pendingTasks'])
                                                    @foreach ($data['pendingTasks'] as $pendingTask)
                                                        <li class="task">
                                                            <div class="task-container">
                                                                <span class="task-action-btn task-check">
                                                                    <span class="action-circle large complete-btn"
                                                                        title="Mark Complete">
                                                                        <i class="material-icons">check</i>
                                                                    </span>
                                                                </span>
                                                                <span class="task-label"
                                                                    contenteditable="true">{{ $pendingTask->task }}</span>
                                                                <span class="task-action-btn task-btn-right">
                                                                    <span class="" title="Assign">
                                                                        <small>{{ $pendingTask->name }}</small>

                                                                    </span>

                                                                </span>

                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @endisset
                                            </ul>
                                        </div>
                                        <div class="task-list-footer">
                                            <div class="new-task-wrapper">
                                                <textarea id="new-task" placeholder="Enter new task here. . ."></textarea>
                                                <span class="error-message hidden">You need to enter a task first</span>
                                                <span class="add-new-task-btn btn" id="add-task">Add Task</span>
                                                <span class="btn" id="close-task-panel">Close</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane" id="completed_tasks">


                                <div class="task-wrapper">
                                    <div class="task-list-container">
                                        <div class="task-list-body">
                                            <ul id="task-list">

                                                @if ($data['completeTasks']->count() > 0)
                                                    @foreach ($data['completeTasks'] as $completeTask)
                                                        <li class="task">
                                                            <div class="task-container">
                                                                <span class="task-action-btn task-check">
                                                                    <span class="action-circle large complete-btn"
                                                                        title="Mark Complete">
                                                                        <i class="material-icons">check</i>
                                                                    </span>
                                                                </span>
                                                                <span class="task-label"
                                                                    contenteditable="true">{{ $completeTask->task }}</span>
                                                                <span class="task-action-btn task-btn-right">
                                                                    <span class="" title="Assign">
                                                                        <small>{{ $task->name }}</small>

                                                                    </span>

                                                                </span>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @endisset
                                        </ul>
                                    </div>
                                    <div class="task-list-footer">
                                        <div class="new-task-wrapper">
                                            <textarea id="new-task" placeholder="Enter new task here. . ."></textarea>
                                            <span class="error-message hidden">You need to enter a task first</span>
                                            <span class="add-new-task-btn btn" id="add-task">Add Task</span>
                                            <span class="btn" id="close-task-panel">Close</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title m-b-15">Project details</h6>
                        <table class="table table-striped table-border">
                            <tbody>
                                <tr>
                                    <td>Cost:</td>
                                    <td class="text-right">
                                        {{ $data['project']->price ? $data['project']->price : '' }}</td>
                                </tr>

                                <tr>
                                    <td>Created:</td>
                                    <td class="text-right">
                                        {{ $data['project']->created_at ? date('d M Y', strtotime($data['project']->created_at)) : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Deadline:</td>
                                    <td class="text-right">
                                        {{ $data['project']->end_date ? date('d M Y', strtotime($data['project']->end_date)) : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Priority:</td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <a href="#" class="badge badge-danger dropdown-toggle"
                                                data-toggle="dropdown">{{ $data['project']->priorty ? $data['project']->priorty : '' }}
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#"><i
                                                        class="fa fa-dot-circle-o text-danger"></i> Highest
                                                    priority</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="fa fa-dot-circle-o text-info"></i> High priority</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="fa fa-dot-circle-o text-primary"></i> Normal
                                                    priority</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="fa fa-dot-circle-o text-success"></i> Low priority</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Status:</td>
                                    <td class="text-right">
                                        {{ $data['project']->status ? strtoupper($data['project']->status) : '' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        @php
                            $totalTask = APP\Models\Project::join('tasks', 'tasks.project_id', '=', 'projects.id')
                                ->where('tasks.project_id', $data['project']->id)
                                ->get();
                            $doneTask = APP\Models\Project::join('tasks', 'tasks.project_id', '=', 'projects.id')
                                ->where('tasks.project_id', $data['project']->id)
                                ->where('tasks.status', 1)
                                ->get();
                            if ($totalTask->count() > 0) {
                                $progress = ($doneTask->count() * 100) / $totalTask->count();
                            } else {
                                $progress = 0;
                            }

                        @endphp
                        <p class="m-b-5">Progress <span class="text-success float-right">{{ $progress }}%</span>
                        </p>
                        <div class="progress progress-xs mb-0">
                            <div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip"
                                title="40%" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="card project-user">
                    <div class="card-body">
                        <h6 class="card-title m-b-20">Team Leader

                        </h6>
                        <ul class="list-box">

                            <li>
                                <a href="#">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="">
                                                <img alt="" class="target-img"
                                                    src="{{ asset('storage/app/public/uploads/staff-images/') . '/' . $data['leader']->image }}"></span>
                                        </div>
                                        <div class="list-body">
                                            <span class="message-author">
                                                {{ $data['leader']->name ? $data['leader']->name : '' }}</span>
                                            <div class="clearfix"></div>
                                            <span class="message-content">Team Leader</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card project-user">
                    <div class="card-body">
                        <h6 class="card-title m-b-20">
                            Team Members
                        </h6>
                        <ul class="list-box">
                            @isset($data['team'])
                                @foreach ($data['team'] as $team)
                                    <li>
                                        <a href="#">
                                            <div class="list-item">
                                                <div class="list-left">
                                                    <span class="">
                                                        <img alt="" class="target-img"
                                                            src="{{ asset('storage/app/public/uploads/staff-images/') . '/' . $team->image }}">


                                                    </span>
                                                </div>
                                                <div class="list-body">
                                                    <span class="message-author">{{ $team->name }}</span>
                                                    <div class="clearfix"></div>
                                                    <span class="message-content">Web Developer</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endisset
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->


</div>
<!-- /Page Wrapper -->
@endsection
