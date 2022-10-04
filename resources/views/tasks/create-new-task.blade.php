@extends('setup.master')
@section('content')



    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Daily Task</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Daily Task</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="" class="btn add-btn" title="Banks List" data-toggle="modal"
                            data-target="#create_task"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>

                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ url('create-daily-task') }}">
                            @csrf
                            <input type="hidden" name="search" value="1">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="emp_id" class="form-control selectpicker"
                                                data-container="body" data-live-search="true">
                                            <option value="" selected>Choose Employee</option>
                                            @isset($employees)
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                                @endforeach
                                            @endisset

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="city_id" class="form-control selectpicker"
                                                data-container="body" data-live-search="true">
                                            <option value="" selected>Choose Status</option>
                                            <option value="1">Complete</option>
                                            <option value="2">In Progress</option>
                                            <option value="3">Pending</option>

                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr class="font-weight-bold">
                                <th>#</th>
                                <th>Assign To</th>
                                <th>Task</th>
                                <th>Dead Line</th>
                                <th>Status</th>
                                <th>Progress</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody id="taskTable">
                            @php $c=0; @endphp
                            @isset($data['task'])
                                @foreach ($data['task'] as $task)
                                    @php $c++; @endphp
                                    @php
                                       $deadLineClass='success';
                                        if($task->end_date < date('Y-m-d')){
                                         $deadLineClass='danger';
                                            }


                                       $progress = App\Models\SubTask::getTaskProgress($task->id);
                                       $className='';
                                       if($task->status=='pending'){
                                           $className='danger';
                                       }
                                            if($task->status=='complete'){
                                           $className='success';
                                       }
                                                if($task->status=='in process'){
                                           $className='primary';
                                       }
                                    @endphp
                                    <tr>
                                        <td>{{ $c }}</td>
                                        <td><a href="{{url('emp-tasks').'/'.encrypt($task->assigned_to)}}">{{ $task->employee->name }}</a></td>
                                        <td>{{ $task->task }}</td>
                                        <td>
                                            <span class="badge bg-inverse-{{$deadLineClass}}">
                                            {{ $task->end_date }}
                                            </span>
                                        </td>

                                        <td>
                                            <span>
                                                    @if($task->status=='complete')
                                                <i class="fa fa-check text-success"></i>
                                                @else
                                            <i class="fa fa-close text-danger"></i>
                                                        @endif
                                                </span>
                                        </td>
                                        <td>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: {{ round($progress) }}%" aria-valuenow="20" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                            <span>{{ round($progress) }}%</span>
                                        </td>
                                        <td>{{ $task->created_at }}</td>
                                    </tr>
                                @endforeach
                            @endisset
                            <tr>
                                <td colspan="11">
                                    <div class="float-right">
                                        {{ $data['task']->links('pagination::bootstrap-4') }}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
    </div>


    <!-- Create Project Modal -->
    <div id="create_task" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url('saveCreateDailyTask')}}" method="POST" class="needs-validation" novalidate  id="TaskForm">
                        @csrf
                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Task</label>
                                    <input class="form-control" type="text" name="task" placeholder="Task Title"
                                        required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Assign To</label>
                                    <select class="form-control selectpicker" data-container="body" data-live-search="true"
                                        name="assign_to" required>
                                        <option value="">Choose Employee</option>

                                        @isset($employees)
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Sub Task</label>
                                <input class="form-control" type="text" name="sub_task" placeholder="Sub Task"
                                       required>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <div class="cal-iconss">
                                        <input class="form-control " type="date" name="start_date" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <div class="cal-iconss">
                                        <input class="form-control " type="date" name="end_date" required>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Description</label>
                            <textarea rows="4" class="form-control summernote" placeholder="Enter your message here" name="desc" required></textarea>
                        </div>


                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn save_task">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Create Project Modal -->
    <!-- Edit Project Modal -->
    <div id="edit_task_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="EditTaskForm" class="needs-validation" novalidate action="">
                        <input type="hidden" name="task_id">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Task</label>
                                    <input class="form-control" type="text" name="task" placeholder="Task Title"
                                        required>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Assign To</label>
                                    <select class="select" name="assign_to" required>
                                        <option value="">Choose Member</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <div class="cal-iconss">
                                        <input class="form-control " type="date" name="start_date" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <div class="cal-iconss">
                                        <input class="form-control " type="date" name="end_date" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea rows="4" class="form-control summernote" placeholder="Enter your message here" name="desc"
                                required></textarea>
                        </div>


                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn update_task">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="{{ asset('public/assets/tagify/dist/tagify.css')}}">
    <script src="{{ asset('public/assets/tagify/dist/jQuery.tagify.min.js')}}"></script>
    <script src="https://unpkg.com/@yaireo/dragsort"></script>

    <script data-name="basic">
        (function(){
            var input = document.querySelector('input[name=sub_task]');
            new Tagify(input)
        })()
    </script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#TaskForm').unbind().on('submit', function(e) {
                e.preventDefault();
                var formData = $('#TaskForm').serialize();
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ url('saveCreateDailyTask') }}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $(".btn-submit").prop("disabled", true);
                        $(".btn-submit").html("please wait...");

                    },
                    success: function(data) {

                        if (data.success) {
                            $('.close').click();
                            $('#TaskForm')[0].reset();
                            toastr.success(data.success);
                            window.location.reload();
                        }
                        if (data.error) {
                            toastr.error('Please Enter Values');
                        }
                    },
                    complete: function(data) {
                        $(".btn-submit").html("Save");
                        $(".btn-submit").prop("disabled", false);
                    },
                    error: function() {
                        toastr.error('something went wrong');
                    },
                });
            });
            //Edit Level 4
            $('#taskTable').on('click', '.btn_edit_task', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');
                // alert(id);

                $('#edit_task_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('editNewtask') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {


                        $('input[name=task_id]').val(data.task.id);
                        $('input[name=task]').val(data.task.task);
                        $('input[name=start_date]').val(data.task.start_date);
                        $('input[name=end_date]').val(data.task.end_date);
                        $('textarea[name=desc]').val(data.task.desc);

                        $.each(data.employees, function(key, employees) {

                            $('select[name="assign_to"]')
                                .append(
                                    `<option value="${employees.id}" ${employees.id == data.task.assigned_to ? 'selected' : ''}>${employees.name}</option>`
                                )
                        });

                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });

            //Update Events
            $('.update_task').on('click', function(e) {
                e.preventDefault();


                let EditFormData = new FormData($('#EditTaskForm')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('updateNewtask') }}",
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('.update_task').text('Updating...');
                        $(".update_task").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            $('#edit_task_modal').modal('hide');
                            $('#EditTaskForm').find('input').val("");
                            $('.update_task').text('Update');
                            $(".update_task").prop("disabled", false);
                            toastr.success(response.message);
                            getAllTask();
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.update_task').text('Update');
                        $(".update_task").prop("disabled", false);
                    }
                });

            });

            // script for delete data
            $('#taskTable').on('click', '.btn_delete_task', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to Delete this Data!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('deleteNewtask') }}",
                            data: {
                                id: id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {

                                toastr.success(response.message);
                                getAllTask();
                            }
                        });
                    }
                })

            });

        });
    </script>


@endsection
