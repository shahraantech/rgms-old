@extends('setup.master')
@section('content')
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Time Management</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Times Management</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_department"><i
                                class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div>
                        <table class="table table-striped" id="datatable">
                            <thead>
                                <tr>
                                    <th style="width: 30px;">#</th>
                                    <th>Login Time </th>
                                    <th>Break Time</th>
                                    <th>Short Leave </th>
                                    <th>Logout Time</th>
                                    <th>Date</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody id="timeTable">


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Add Department Modal -->
        <div id="add_department" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Time </h5>
                        <button type="button" class="close modalDismiss" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="timeForm" method="post" action="{{ url('save-times') }}" id="timeForm"
                            class="needs-validation" novalidate>
                            @csrf

                            <div class="form-group">
                                <label>Login Time <span class="text-danger">*</span></label>
                                <input class="form-control" type="time" name="login_time" placeholder="Login Time"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Break Time <span class="text-danger"> *</span></label>
                                <input class="form-control" type="time" name="break_time" placeholder="Break Tim"
                                    required>
                            </div>
                            <div class="form-group">
                                <label> Short Leave Time<span class="text-danger"> *</span></label>
                                <input class="form-control" type="time" name="short_leave_time"
                                    placeholder="Short Leave Time" required>
                            </div>
                            <div class="form-group">
                                <label> Departure Time<span class="text-danger"> *</span></label>
                                <input class="form-control" type="time" name="dept_time" placeholder="Departure Time"
                                    required>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn btn-save" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Department Modal -->

        <!-- Edit Department Modal -->
        <div id="edit_department" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Times</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnDissmissEdit">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="timeEditForm" method="post">
                            @csrf
                            <input type="hidden" name="hidden_time_id">
                            <div class="form-group">
                                <label>Login Time <span class="text-danger">*</span></label>
                                <input class="form-control" type="time" name="login_time">

                            </div>
                            <div class="form-group">
                                <label>Break Time <span class="text-danger">*</span></label>
                                <input class="form-control" type="time" name="break_time">

                            </div>
                            <div class="form-group">
                                <label>Short Leave Time <span class="text-danger">*</span></label>
                                <input class="form-control" type="time" name="short_leave_time">

                            </div>
                            <div class="form-group">
                                <label>Departure Time<span class="text-danger">*</span></label>
                                <input class="form-control" type="time" name="dept_time">

                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary btn-update" type="button">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Department Modal -->

        <!-- Delete Department Modal -->
        <div class="modal custom-modal fade" id="delete_department" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Time</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);"
                                        class="btn btn-primary continue-btn btnDeleteNow">Delete</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal"
                                        class="btn btn-primary cancel-btn btnSkip">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Department Modal -->

    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            getTimes();

            function getTimes() {


                $.ajax({

                    url: '{{ url('/get-times') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',

                    success: function(data) {

                        var html = '';
                        var i;
                        var c = 0;

                        for (i = 0; i < data.length; i++) {

                            c++;
                            html += '<tr>' +
                                '<td>' + c + '</td>' +
                                '<td>' + data[i].login_time + '</td>' +
                                '<td>' + data[i].break_time + '</td>' +
                                '<td>' + data[i].short_leave_time + '</td>' +
                                '<td>' + data[i].dept_time + '</td>' +

                                '<td>' + data[i].created_at + '</td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a class="dropdown-item btnEditDept" href="#" data-toggle="modal" data-target="#edit_department" data="' +
                                data[i].id + '"><i class="la la-pencil" style="font-size:20px;"></i></a>' +
                                '<a class="dropdown-item btnDelete" href="#" data-toggle="modal" data-target="#delete_department" data="' +
                                data[i].id + '"><i class="la la-trash" style="font-size:20px;"></i></a>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +

                                '</tr>';
                        }


                        $('#timeTable').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }


            //btnEditDept
            $('.btnEditDept').on('click', function() {

                var id = $(this).attr('data');


                $.ajax({

                    url: '{{ url('/edit-time') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(data) {

                        $('input[name=hidden_time_id]').val(data.id);
                        $('input[name=login_time]').val(data.login_time);
                        $('input[name=break_time]').val(data.break_time);
                        $('input[name=short_leave_time]').val(data.short_leave_time);
                        $('input[name=dept_time]').val(data.dept_time);


                    },
                    error: function() {
                        toastr.success('Save changes successfully');
                    }

                });

            })


            //btnUpdateDept

            $('.btn-update').on('click', function(e) {
                e.preventDefault();


                let EditFormData = new FormData($('#timeEditForm')[0]);

                $.ajax({

                    type: "POST",
                    url: '{{ url('/update-time') }}',
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('.btn-update').text('Saving...');
                        $(".btn-update").prop("disabled", true);
                    },
                    success: function(data) {

                        if (data.errors) {
                            toastr.error('missing some fileds');
                            $('.btn-update').text('Save Changes');
                            $(".btn-update").prop("disabled", false);
                        }

                        if (data.success) {
                            getTimes();
                            $('#timeForm')[0].reset();
                            $('#btnDissmissEdit').click();
                            toastr.success('Save changes successfully');
                            $('.btn-update').text('Save Changes');
                            $(".btn-update").prop("disabled", false);
                        }

                    },
                    error: function() {
                        toastr.error('Something went wrong');
                        $('.btn-update').text('Save Changes');
                        $(".btn-update").prop("disabled", false);
                    }

                });

            })


            //btnEditDelete
            $('.btnDelete').on('click', function() {
                var time_id = $(this).attr('data');

                $('.btnDeleteNow').on('click', function() {

                    $.ajax({

                        url: '{{ url('/delete-time') }}',
                        type: 'get',
                        async: false,
                        dataType: 'json',
                        data: {
                            id: time_id
                        },
                        success: function(data) {

                            if (data.success) {
                                getTimes();
                                $('.btnSkip').click();
                                toastr.success('Record deleted successfully');
                            }

                        },
                        error: function() {
                            toastr.error('something went wrong');
                        }

                    });
                });

            })

            $('#timeForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData($('#timeForm')[0]);

                $.ajax({

                    type: "POST",
                    method: 'post',
                    url: '{{ url('save-times') }}',
                    data: formData,
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.btn-save').text('Saving...');
                        $(".btn-save").prop("disabled", true);
                    },
                    success: function(data) {



                        if (data.success) {
                            getTimes();
                            $('#timeForm')[0].reset();
                            $('.modalDismiss').click();
                            toastr.success('Record save successfully');
                            $('.btn-save').text('Save');
                            $(".btn-save").prop("disabled", false);
                        }

                        if (data.errors) {
                            toastr.error(data.errors);
                            $('.btn-save').text('Save');
                            $(".btn-save").prop("disabled", false);
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.btn-save').text('Save');
                        $(".btn-save").prop("disabled", false);
                    }

                });


            });

            //Datatables
            $('#datatable').DataTable();

        });
    </script>
@endsection
