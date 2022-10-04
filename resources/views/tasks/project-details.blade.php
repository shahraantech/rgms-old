@extends('setup.master')
@section('content')



    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="chat-main-row">
            <div class="chat-main-wrapper">
                <div class="col-lg-7 message-view task-view task-left-sidebar">
                    <div class="chat-window">
                        <div class="fixed-header">
                            <div class="navbar">
                                <div class="float-left mr-auto">
                                    <div class="add-task-btn-wrapper">
                                        @if ($data['project']->status != 'Complete')
                                            <span class=" btn btn-white btn-sm" data-toggle="modal"
                                                data-target="#create_task">
                                                Add Task
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <a class="task-chat profile-rightbar float-right" id="task_chat" href="#task_window"><i
                                        class="fa fa fa-comment"></i></a>
                                <ul class="nav float-right custom-menu">
                                    <li class="nav-item dropdown dropdown-action">
                                        <a href="" class="dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false"><i class="fa fa-cog"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="javascript:void(0)">Pending Tasks</a>
                                            <a class="dropdown-item" href="javascript:void(0)">Completed Tasks</a>
                                            <a class="dropdown-item" href="javascript:void(0)">All Tasks</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>


                        <div class="chat-contents">
                            <div class="chat-content-wrap">
                                <div class="chat-wrap-inner">
                                    <div class="chat-box">
                                        <div class="task-wrapper">
                                            <div class="task-list-container">
                                                <div class="task-list-body">
                                                    <ul id="task-list" class="task-lis taskListSection">

                                                    </ul>



                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                    </div>
                </div>
                <div class="col-lg-5 message-view task-chat-view task-right-sidebar" id="task_window">
                    <div class="chat-window">
                        <div class="fixed-header">
                            <div class="navbar">
                                <div class="task-assign">

                                    @if ($data['project']->status != 'Complete')
                                        <a class="task-complete-btn btnMark" id="task_complete" href="javascript:void(0);"
                                            data="{{ $data['project_id'] }}">
                                            <i class="material-icons">check</i> Mark Complete
                                        </a>
                                    @endif
                                    @if ($data['project']->status == 'Complete')
                                        <a class="task-complete-btn " id="btnComplete" href="javascript:void(0);"
                                            style=" background-color: #4CAF50;color: white;">
                                            <i class="material-icons">check</i> Complete
                                        </a>
                                    @endif

                                </div>
                                <ul class="nav float-right custom-menu">
                                    <li class="dropdown dropdown-action">
                                        <a href="" class="dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="javascript:void(0)">Delete Task</a>
                                            <a class="dropdown-item" href="javascript:void(0)">Settings</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>


                        <div class="chat-contents task-chat-contents">
                            <div class="chat-content-wrap">
                                <div class="chat-wrap-inner">
                                    <div class="chat-box">
                                        <div class="chats">
                                            <h4>{{ $data['project']->title ? $data['project']->title : '' }}</h4>


                                            <div class="task-header">
                                                <div class="assignee-info">
                                                    <a href="#" data-toggle="modal" data-target="#assignee">
                                                        <div class="avatar">

                                                            <img alt="" class="avatar"
                                                                src="{{ asset('storage/app/public/uploads/staff-images/') . '/' . $data['project']->image }}">
                                                        </div>
                                                        <div class="assigned-info">
                                                            <div class="task-head-title">Assigned To</div>
                                                            <div class="task-assignee">
                                                                {{ $data['project']->name ? $data['project']->name : '' }}
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <span class="remove-icon">
                                                        <i class="fa fa-close"></i>
                                                    </span>
                                                </div>
                                                <div class="task-due-date">
                                                    <a href="#" data-toggle="modal" data-target="#assignee">
                                                        <div class="due-icon">
                                                            <span>
                                                                <i class="material-icons">date_range</i>
                                                            </span>
                                                        </div>
                                                        <div class="due-info">
                                                            <div class="task-head-title">Due Date</div>
                                                            <div class="due-date">
                                                                {{ $data['project']->end_date ? date('d M,Y', strtotime($data['project']->end_date)) : '' }}
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <span class="remove-icon">
                                                        <i class="fa fa-close"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <hr class="task-line">
                                            <div class="task-desc">
                                                <div class="task-desc-icon">
                                                    <i class="material-icons">subject</i>
                                                </div>
                                                <div class="task-textarea">

                                                    <p class="text-muted">
                                                        {!! $data['project']->desc !!}
                                                    </p>
                                                </div>
                                            </div>

                                            <hr class="task-line">


                                            <div class="chat-body">
                                                <div class="chat-bubble">
                                                    <div class="chat-content">
                                                        <span class="task-chat-user">{{ $data['project']->title }}</span>
                                                        <span class="file-attached">attached 1 files <i
                                                                class="fa fa-paperclip"></i></span>
                                                        <span
                                                            class="chat-time">{{ date('d M Y H:i:s a', strtotime($data['project']->created_at)) }}</span>

                                                        <ul class="attach-list">
                                                            <li><i class="fa fa-file"></i>
                                                                <a
                                                                    href="{{ asset('storage/app/public/uploads/project-files/') . '/' . $data['project']->file }}">View
                                                                    Document</a>
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
                    </div>


                </div>
            </div>
        </div>
    </div>


    <!-- Create Project Modal -->
    <div id="create_task" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" class="needs-validation" novalidate action="{{ url('save-tasks') }}"
                        id="taskForm">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="hidden_project_id" value="{{ $data['project_id'] }}" class>
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

                                        @isset($data['member'])
                                            @foreach ($data['member'] as $member)
                                                <option value="{{ $member['id'] }}">{{ $member['name'] }}</option>
                                            @endforeach
                                        @endisset
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
                            <button class="btn btn-primary submit-btn">Save</button>
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
                        <!-- @csrf -->
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

                                        @isset($data['member'])
                                            @foreach ($data['member'] as $member)
                                                <option value="{{ $member['id'] }}">{{ $member['name'] }}</option>
                                            @endforeach
                                        @endisset
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
    <!-- /Edit Project Modal -->


    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            toastr.options.timeOut = 3000;
            @if (Session::has('error'))
                toastr.error('{{ Session::get('error') }}');
            @elseif (Session::has('success'))
                toastr.success('{{ Session::get('success') }}');
            @endif

            taskList();

            function taskList() {
                var project_id = $('input[name=hidden_project_id]').val();

                $.ajax({

                    url: '{{ url('/get-task-list') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    data: {
                        project_id: project_id
                    },
                    success: function(data) {
                        console.log(data);

                        var html = '';
                        var i;
                        var c = 0;

                        for (i = 0; i < data.length; i++) {

                            c++;

                            html += '<li class="task">' +
                                '<div class="task-container">' +
                                ' <span class="task-action-btn task-check">' +
                                '<span class="action-circle large complete-btn" title="Mark Complete">' +
                                '<i class="material-icons">check</i>' +
                                '</span>' +
                                '</span>' +
                                '<span class="task-label" contenteditable="true">' + data[i].task +
                                '</span>' +
                                '<span class="task-action-btn task-btn-right">' +

                                '<span class=" large" title="Salman Raza">' + data[i].name + '</span>' +
                                '<span class="edit_task_btn action-circle large ml-1 " data="' + data[i]
                                .id + '" title="Edit Task"><i class="material-icons">edit</i></span>' +
                                '<span class="delete_task_btn action-circle large ml-1 " data="' + data[
                                    i].id +
                                '" title="Delete Task"><i class="material-icons">delete</i></span>' +

                                '</span>' +
                                '</div>' +
                                '</li>';

                        }

                        $('.taskListSection').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }

            $('#taskForm').unbind().on('submit', function(e) {
                e.preventDefault();

                var formData = $('#taskForm').serialize();


                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{ url('save-tasks') }}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        if (data.success) {
                            taskList();
                            $('#taskForm')[0].reset();
                            $('.close').click();
                            toastr.success(data.success);
                        }

                        if (data.error) {
                            toastr.success(data.error);
                        }


                    },

                    error: function() {
                        toastr.error('something went wrong');

                    }

                });


            });


            $('#task_complete').on('click', function() {

                var project_id = $(this).attr('data');


                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('update-project-status') }}',
                    data: {
                        project_id: project_id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (data.success) {
                            toastr.success(data.success);
                            // $("#btnComplete").css("visibility", "visible");
                            // $("#task_complete").css("display", "none");
                            window.location.reload();

                        }

                        if (data.error) {
                            toastr.success(data.error);


                        }

                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });
            });


            //edit data
            $('.taskListSection').on('click', '.edit_task_btn', function(e) {
                e.preventDefault();
                var id = $(this).attr('data');

                $('#edit_task_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('edit-tasks') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('input[name=task_id]').val(data.id);
                        $('input[name=task]').val(data.task);
                        $('select[name=assign_to]').val(data.assigned_to);
                        $('input[name=start_date]').val(data.start_date);
                        $('input[name=end_date]').val(data.end_date);
                        $('textarea[name=desc]').val(data.desc);
                    },

                    error: function() {
                        toastr.error('something went wrong');
                    }

                });

            });


            //Update Data with ajax call
            $('.update_task').on('click', function(e) {
                e.preventDefault();
                $('.update_task').text('Updating...');

                let EditFormData = new FormData($('#EditTaskForm')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('/update-tasks') }}",
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    data: EditFormData,
                    success: function(response) {

                        if (response.status == 200) {
                            $("#edit_task_modal").modal('hide');
                            $('#EditTaskForm').find('input').val("");
                            $('.update_task').text('Update');
                            toastr.success(response.message);
                            taskList();
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.update_task').text('Update');
                    }
                });

            });

            // script for delete data
            $('.taskListSection').on('click', '.delete_task_btn', function(e) {
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
                            url: "{{ url('/delete-tasks/') }}/" + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {
                                toastr.success(response.message);
                                taskList();
                            }
                        });
                    }
                })

            });


        });
    </script>

@endsection
