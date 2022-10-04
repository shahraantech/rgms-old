
@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">My Tasks</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">My Tasks</li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="tab-content">

                <!-- Profile Info Tab -->
                <div id="emp_profile" class="pro-overview tab-pane fade show active">

                    <div class="row">
                        @isset($data['empTasks'])
                            @foreach ($data['empTasks'] as $task)
                                @php
                                    $progress=App\Models\SubTask::getTaskProgress($task->id);
                                $deadLineClass='success';
                                if($task->end_date < date('Y-m-d')){
                                    $deadLineClass='danger';
                                }


                                @endphp
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
                                                                <div class="text badge bg-inverse-primary"> {{$subTask->sub_task_title}}
                                                                   <checkbox class="bg-inverse-success" href="">
                                                                            <input type="checkbox"  @if($subTask->status==1) checked    @endif class="mt-1 ml-1 btn-complete" data="{{$subTask->id}}" style="background-color: #0b2e13">
                                                                   </checkbox> </div>
                                                            @endforeach
                                                        </div>
                                                    </li>
                                                @endif
                                                <li>
                                                    <div class="title">Dead Line.</div>
                                                    <div class="text badge bg-inverse-{{$deadLineClass}}">{{$task->end_date}}</div>
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


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {

            $('.btn-complete').click(function() {
                var id = $(this).attr('data');
                var status = 0;
                ($(this).prop("checked") == true) ? status = 1 : status = 0;
                $.ajax({
                    url: '{{url("mark-sub-task")}}',
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    data:{id:id,status:status},
                    success: function(data){
                      if(data.success){
                          toastr.success(data.success);
                      }
                    },
                    error:function()
                    {
                        toastr.error('something went wrong');
                    }
                });
            });
        });
    </script>
@endsection
