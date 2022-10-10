@extends('setup.master')

@section('content')
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Grades</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Grades</a></li>
                            <li class="breadcrumb-item active">Grades</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_department"><i
                                class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <table class="table table-striped mb-0 " id="datatable">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px;">#</th>
                                            <th>Grades </th>
                                            <th>Grades Category</th>
                                            <th>Created At</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="gradeTable">

                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                        <h5 class="modal-title">Add Grades</h5>
                        <button type="button" class="close btn-dismiss" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" id="gradeForm" class="needs-validation" novalidate>
                            @csrf

                            <div class="form-group">
                                <label>Grade <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="grade" placeholder="Grades Name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label> Grade Category <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="grade_cat"
                                    placeholder="Grade Category Name" required>
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
                        <h5 class="modal-title">Edit Grades</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnDissmissEdit">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="gradeEditForm" method="post" action="">
                            @csrf
                            <input type="hidden" name="hidden_grade_id">

                            <div class="form-group">
                                <label>Designation Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="grade">

                            </div>


                            <div class="form-group">
                                <label>Designation Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="grade_cat">

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
                            <h3>Delete Grade</h3>
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
            getGrades();

            function getGrades() {


                $.ajax({

                    url: '{{ url('/grades-list') }}',
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
                                '<td>' + data[i].grade + '</td>' +
                                '<td>' + data[i].grade_cat + '</td>' +


                                '<td>' + data[i].created_at + '</td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a class="dropdown-item btn-edit" href="#" data-toggle="modal" data-target="#edit_department" data="' +
                                data[i].id + '"><i class="la la-pencil" style="font-size:20px;"></i></a>' +
                                '<a class="dropdown-item btnDelete" href="#" data-toggle="modal" data-target="#delete_department" data="' +
                                data[i].id + '"><i class="la la-trash" style="font-size:20px;"></i></a>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +

                                '</tr>';
                        }


                        $('#gradeTable').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }


            $('#gradeForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData($('#gradeForm')[0]);

                $.ajax({
                    type: "POST",
                    url: '{{ url('grades') }}',
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

                        if (data.errors) {
                            toastr.error(data.errors);
                            $('.btn-save').text('Save');
                            $(".btn-save").prop("disabled", false);
                        }

                        if (data.success) {
                            getGrades();
                            $('#gradeForm')[0].reset();
                            $('.btn-dismiss').click();
                            toastr.success(data.success);
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


            })

            //btnEditDept

            $('#gradeTable').on('click', '.btn-edit', function() {
                var id = $(this).attr('data');

                $.ajax({

                    url: '{{ url('/edit-grade') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(data) {


                        $('input[name=grade]').val(data.grade);
                        $('input[name=grade_cat]').val(data.grade_cat);
                        $('input[name=hidden_grade_id]').val(data.id);

                    },
                    error: function() {
                        toastr.success('Save changes successfully');
                    }

                });

            })



            //btnUpdateDept
            $('.btn-update').on('click', function(e) {
                e.preventDefault();

                let EditFormData = new FormData($('#gradeEditForm')[0]);


                $.ajax({

                    url: '{{ url('/update-grade') }}',
                    type: "POST",
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
                            getGrades();
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

            $('#gradeTable').on('click', '.btnDelete', function() {
                var id = $(this).attr('data');

                $('.btnDeleteNow').on('click', function() {

                    $.ajax({

                        url: '{{ url('/delete-grade') }}',
                        type: 'get',
                        async: false,
                        dataType: 'json',
                        data: {
                            id: id
                        },
                        success: function(data) {

                            if (data.success) {
                                getGrades();
                                $('.btnSkip').click();
                                toastr.success('Record deleted successfully');
                            }

                        },
                        error: function() {
                            toastr.error('something went wrong');
                        }

                    });
                });

            });

            //Datatables
            $('#datatable').DataTable();
        });
    </script>
@endsection
