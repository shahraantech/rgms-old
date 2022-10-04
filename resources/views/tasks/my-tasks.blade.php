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
                                        <span class=" btn btn-white btn-sm" data-toggle="modal" data-target="#create_task">
                                            Add Productivity
                                        </span>
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
                                <div class="task-assign" id="status">





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
                                    <div class="chat-box" id="chatBoxSection">

                                        <img id="loader" class="center" src=public/assets/img/loader/loader.gif
                                            style="padding-left: 50px;display: none" />


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
                    <form class="needs-validation" novalidate action="{{ url('save-task-progress') }}" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Task</label>
                                    <select class="select" name="task_id" required>
                                        <option value="">Choose Task</option>
                                        @isset($data['tasks'])
                                            @foreach ($data['tasks'] as $task)
                                                <option value="{{ $task->id }}">{{ $task->task }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Progress (%)</label>

                                    <input class="form-control " type="number" name="progress" required
                                        placeholder="Enter progress in %" maxlength="100">
                                    <div id="progressError"></div>

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Comments</label>
                                    <textarea name="remarks" class="form-control" cols="30" rows="4" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn" id="btnSubmit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Create Project Modal -->



    </div>
    <!-- /Page Wrapper -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {



            taskList();

            function taskList() {

                $.ajax({

                    url: '{{ url('/my-tasks') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        var html = '';
                        var i;
                        var c = 0;

                        for (i = 0; i < data.length; i++) {

                            c++;
                            html +=
                                '<li class="task task-hover" data="' + data[i].id + '">' +
                                '<div class="task-container" >' +
                                ' <span class="task-action-btn task-check">' +
                                '<span class="action-circle large complete-btn" title="Mark Complete">' +
                                '<i class="material-icons" >check</i>' +
                                '</span>' +
                                '</span>' +
                                '<span class="task-label" ="true">' + data[i].task + '</span>' +
                                '<span class="task-action-btn task-btn-right">' +
                                '<span class="action-circle large" title="Assign">' +
                                '<i class="material-icons">person_add</i>' +
                                '</span>' +
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

            $(".task-hover").mouseover(function(){
                var task_id = $(this).attr("data");


                $.ajax({

                    url: '{{url("/getMySingleTask")}}',
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    data:{task_id:task_id},
                    beforeSend: function() {
                        $('#loader').show();
                    },

                    success: function(data)
                    {

                        var html = '';
                        var i;
                        var c=0;
                        var status='';
                        for(i=0; i<data.length; i++){
                            c++;
var taskStatus='';
                            (data[i].status==1)? status="text-success": status="text-danger";
                            if(data[i].status==1){
                                taskStatus='COMPLETE';
                            }
                            if(data[i].status==2){
                                taskStatus='OPEN';
                            }
                            if(data[i].status==0){
                                taskStatus='PENDING';
                            }


                            html +=' <div class="chats">'+
                                '<h4>'+data[i].task+'</h4>'+
                                '<div class="task-header">'+
                                ' <div class="assignee-info">'+
                                ' <a href="#" data-toggle="modal" data-target="#assignee">'+

                                ' <div class="">'+

                                '  <img alt="" class="target-img" src="{{asset("storage/app/public/uploads/staff-images/")}}/'+data[i].image+'">'+
                                ' </div>'+
                                ' <div class="assigned-info">'+
                                '   <div class="task-head-title">Assigned To</div>'+
                                '<div class="task-assignee">'+data[i].name+'</div>'+
                                '</div>'+
                                ' </a>'+
                                ' <span class="remove-icon">'+
                                '<i class="fa fa-close"></i>'+
                                '</span>'+
                                '</div>'+
                                '<div class="task-due-date">'+
                                ' <a href="#" data-toggle="modal" data-target="#assignee">'+
                                '<div class="due-icon">'+
                                '<span>'+
                                '<i class="material-icons">date_range</i>'+
                                '</span>'+
                                ' </div>'+
                                '<div class="due-info">'+
                                '<div class="task-head-title">Due Date</div>'+
                                '<div class="due-date">'+data[i].end_date+'</div>'+
                                '</div>'+
                                '</a>'+
                                ' <span class="remove-icon">'+
                                '<i class="fa fa-close"></i>'+
                                '</span>'+
                                '</div>'+
                                ' </div>'+
                                ' <hr class="task-line">'+
                                '<div class="task-desc">'+
                                ' <div class="task-desc-icon">'+
                                '<i class="material-icons">subject</i>'+
                                '</div>'+
                                ' <div class="task-textarea">'+

                                '<p class="text-muted">'+data[i].desc+' </p>'+

                                '</div>'+
                                ' </div>';

                            // '<a class="task-complete-btn btnMark text-success" id="task_complete" href="javascript:void(0);" taskId="'+data[i].id+'" >'+
                            //     '<i class="material-icons">check</i> Mark Complete    </a>' +
                            var status= '<a class="task-complete-btn btnMark '+status+'" id="task_complete" href="javascript:void(0);" style="margin-left:30px" data="'+data[i].id+'">'+
                                '<i class="material-icons"></i> '+taskStatus+' </a>';

                        }

                        $('#status').html(status);
                        $('#chatBoxSection').html(html);

                    },
                    error:function()
                    {
                        toastr.error('something went wrong');
                    },

                    complete: function() {
                        $('#loader').hide();

                    },

                });

            });

            //task status change
            $('#status').click('.task-complete-btn', function(event) {
                var task_id = event.target.attributes.taskId.value;
                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('update-task-status') }}',
                    data: {
                        task_id: task_id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        if (data.success) {
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
            })

            //progress
            $('input[name=progress]').change(function() {
                var progress = $('input[name=progress]').val();
                if (progress > 100) {
                    var p = '<span style="color:red">Value must be less hen or eqqual to 100</span>';
                    $('#progressError').html(p);
                    $('#btnSubmit').prop('disabled', true);
                }


                if (progress <= 100) {

                    $('#progressError').html('');
                    $('#btnSubmit').prop('disabled', false);
                }

                if (progress == 100) {
                    $('#progressStatus').html('<option id="sta" value="Complete">Complete</option>')

                } else {

                    var html = '';
                    html += '<option value="">Choose Status</option>' +
                        '<option value="Inprogress">Inprogress</option>' +
                        '<option value="Complete">Complete</option>';
                    $('#progressStatus').html(html);
                }
            })

            $('select[name=status]').change(function() {

                var status = $("#progressStatus option:selected").val()
                if (status == 'Complete') {
                    $('input[name=progress]').val(100);
                    $('input[name=progress]').prop('readonly', true);
                } else {
                    $('input[name=progress]').val();
                    $('input[name=progress]').prop('readonly', false);
                }
            })


        })
    </script>


    <script>
        @if(count($errors) > 0)

        @foreach($errors-> all() as $error)

        toastr.error("{{ $error }}");
        @endforeach
        @endif


        @if(Session::has('success'))
        toastr.success("Productivity added successfully!");

        @endif
    </script>

@endsection
