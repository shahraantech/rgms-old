@extends('setup.master')

@section('content')


    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Task Board</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Task Board</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row board-view-header">
                <div class="col-4">
                    <div class="pro-teams">
                        <div class="pro-team-members">
                            <h4>My Team</h4>
                            <div class="avatar-group">
                                @isset($data['team'])
                                    @foreach ($data['team'] as $team)
                                        <div class="avatar">
                                            <img class="avatar-img rounded-circle border border-white" alt="User Image"
                                                src="{{ asset('storage/app/public/uploads/staff-images/') . '/' . $team->image }}"
                                                title="{{ $team->name }}">
                                        </div>
                                    @endforeach
                                @endisset

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8 text-right">
                    <a href="{{ url('my-projects') }}" class="btn btn-white float-right" title="View Task Board"><i
                            class="fa fa-link"></i></a>
                </div>

                <div class="col-12">

                    <div class="pro-progress">
                        <div class="pro-progress-bar">
                            <h4>Progress</h4>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $data['progress'] }}%"></div>
                            </div>
                            <span>{{ round($data['progress'], 2) }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="kanban-board card mb-0">


                <div class="card-body">
                    <div class="row">

                        @isset($data)
                            @foreach ($data['projects'] as $project)
                                <div class="col-md-4">
                                    <div class="kanban-cont">
                                        <div class="kanban-list kanban-danger">

                                            <div class="kanban-header">
                                                <span class="status-title">My Projects</span>
                                                <div class="dropdown kanban-action">
                                                    <a href="" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#edit_task_board">Edit</a>
                                                        <a class="dropdown-item" href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kanban-wrap">


                                                <div class="card panel">
                                                    <div class="kanban-box">
                                                        <div class="task-board-header">
                                                            <span class="status-title"><a
                                                                    href="{{ url('project-details') . '/' . encrypt($project->id) }}">{{ $project->title }}</a></span>
                                                            <div class="dropdown kanban-task-action">
                                                                <a href="" data-toggle="dropdown">
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                                                        data-target="#edit_task_modal">Edit</a>
                                                                    <a class="dropdown-item" href="#">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="task-board-body">
                                                            <div class="kanban-info">

                                                                @php
                                                                    $totalTask = APP\Models\Project::join('tasks', 'tasks.project_id', '=', 'projects.id')
                                                                        ->where('tasks.project_id', $project->id)
                                                                        ->get();
                                                                    $doneTask = APP\Models\Project::join('tasks', 'tasks.project_id', '=', 'projects.id')
                                                                        ->where('tasks.project_id', $project->id)
                                                                        ->where('tasks.status', 'Complete')
                                                                        ->get();
                                                                    if ($totalTask->count() > 0) {
                                                                        $progress = ($doneTask->count() * 100) / $totalTask->count();
                                                                    } else {
                                                                        $progress = 0;
                                                                    }

                                                                @endphp
                                                                <div class="progress progress-xs">
                                                                    <div class="progress-bar bg-success" role="progressbar"
                                                                        style="width: {{ round($progress) }}%"
                                                                        aria-valuenow="20" aria-valuemin="0"
                                                                        aria-valuemax="100"></div>
                                                                </div>
                                                                <span>{{ round($progress) }}%</span>
                                                            </div>
                                                            <div class="kanban-footer">
                                                                <span class="task-info-cont">
                                                                    <span class="task-date"><i class="fa fa-clock-o"></i>
                                                                        {{ date('d M Y', strtotime($project->end_date)) }}</span>
                                                                    <span
                                                                        class="task-priority badge bg-inverse-warning">{{ $project->priorty }}</span>
                                                                </span>
                                                                <span class="task-users">
                                                                    <img src="{{ asset('storage/app/public/uploads/staff-images/') . '/' . $project->image }}"
                                                                        class="task-avatar" width="24" height="24"
                                                                        alt="">

                                                                    <span class="task-user-count">
                                                                        @php
                                                                            $member = APP\Models\Project::join('tasks', 'tasks.project_id', '=', 'projects.id')
                                                                                ->where('tasks.project_id', $project->id)
                                                                                ->distinct()
                                                                            ->count('tasks.assigned_to'); @endphp
                                                                        {{ $member }} +
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-new-task">
                                                <a href="{{ url('project-details') . '/' . encrypt($project->id) }}">View
                                                    Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endisset
                    </div>
                    <div class="float-right mt-3">
                        {{ $data['projects']->links('pagination::bootstrap-4') }}
                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- /Page Wrapper -->
@endsection
