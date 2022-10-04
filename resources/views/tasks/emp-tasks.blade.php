@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Employee Task Details</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employee Task Details</li>
                        </ul>
                    </div>

                </div>
            </div>

            <!-- /Page Header -->
            <div class="card mb-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                        <a href="#">
                                            <img alt=""
                                                 src="{{ asset('storage/app/public/uploads/staff-images/user1-128x128.png') }}"></a>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0">
                                                    {{ $data['emp'] ? $data['emp']->name: '' }}
                                                </h3>
                                                <h6 class="text-muted"></h6>
                                                <small class="text-muted"></small>
                                                <div class="staff-id">
                                                    {{$data['emp']->getDesignation->desig_name}}
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Contact:</div>
                                                    <div class="text"><a
                                                            href="">{{ $data['emp'] ?$data['emp']->phone  : '' }}</a>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="title">Email:</div>
                                                    <div class="text"><a
                                                            href="">{{ $data['emp'] ?$data['emp']->email : '' }}</a>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="title">Created At:</div>
                                                    <div class="text"><a
                                                            href="">{{ $data['emp'] ?$data['emp']->created_at : '' }}</a>
                                                    </div>
                                                </li>


                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content">

                <!-- Profile Info Tab -->
                <div id="emp_profile" class="pro-overview tab-pane fade show active">

                    <div class="row">
                        @isset($data['empTasks'])
                            @foreach ($data['empTasks'] as $task)
                                @php $progress=0; @endphp
                                <div class="col-md-6 d-flex">
                                    <div class="card profile-box flex-fill">
                                        <div class="card-body">
                                            <span class="card-title">
                                                <div class="pro-progress">
                                                    <div class="pro-progress-bar">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                 style="width:{{ round($progress) }}%"></div>
                                                        </div>
                                                        <span>{{round($progress)}}%</span>
                                                    </div>
                                                </div>

                                            </span>
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Title.</div>
                                                    <div class="text badge bg-inverse-info">{{$task->task}}


                                                    </div>
                                                </li>
                                                @php
                                                    $subTask =App\Models\SubTask::getSubTaskAcordingMainTask($task->id);

                                                @endphp
                                                @if($subTask->count() > 0)
                                                <li>
                                                    <div class="title">Sub Task: </div>
                                                    <div class="text">

                                                            @foreach($subTask as $subTask)
                                                        <div class="text badge bg-inverse-primary"> {{$subTask->sub_task_title}} <span class="bg-inverse-success">
                                                                @if($subTask->status==1)
                                                            <i class="fa fa-check text-success"></i>
                                                                    @else
                                                                    <i class="fa fa-close text-danger"></i>
                                                                @endif
                                                            </span></div>
                                                            @endforeach



                                                    </div>
                                                </li>
                                                @endif

                                                <li>
                                                    <div class="title">Dead Line.</div>

                                                        <div class="text badge bg-inverse-danger">{{$task->end_date}}</div>
                                                </li>

                                                <li>
                                                    <div class="title">Description</div>
                                                    <div class="text">
                                                        {{$task->desc}}
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="title">Created At</div>
                                                    <div class="text">
                                                        {{$task->created_at}}
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="title">Comments</div>
                                                    <div class="text">

                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endisset
                    </div>
                </div>
                <!-- /Profile Info Tab -->
            </div>
        </div>
    </div>
@endsection
