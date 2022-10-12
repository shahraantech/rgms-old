@extends('setup.master')

@section('content')
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Resignation</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Resignation</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_resignation"><i
                                class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-responsive" id="datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Resigning Employee </th>
                                    <th>Department </th>
                                    <th>Reason </th>
                                    <th>Notice Date </th>
                                    <th>Resignation Date </th>
                                    <th>Status </th>
                                    <th>Created At </th>
                                    <th>Action </th>

                                </tr>
                            </thead>
                            <tbody id="resignationTable">

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <!-- /Page Content -->



        <!-- Add Resignation Modal -->
        <div id="add_resignation" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Resignation</h5>
                        <button type="button" class="close btn-dismiss" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="resigForm" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <label>Notice Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input type="date" class="form-control " name="notice_date" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Resignation Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input type="date" class="form-control " name="resign_date" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Reason <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="4" name="reason" required></textarea>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary btn-save btn_save_resig" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Resignation Modal -->




        <!-- Edit Resignation Modal -->
        <div id="edit_resignation_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Resignation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="" id="EditRegisterationForm">
                            <input type="hidden" name="reg_id">

                            <div class="form-group">
                                <label>Notice Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input type="text" name="notice_date" class="form-control datetimepicker">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Resignation Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input type="text" name="resign_date" class="form-control datetimepicker">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Reason <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="4" name="reason"></textarea>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn update_resig">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Resignation Modal -->


    </div>





    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            $('#resigForm').validate({

                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            getResignation();

            function getResignation() {


                $.ajax({

                    url: '{{ url('/resignationList') }}',
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
                                '<td>' +
                                '<h2 class="table-avatar blue-link">' +

                                '<a href="my-profile" ><img class="target-img" alt="" src="storage/app/public/uploads/staff-images/' +
                                data[i].image + '"></a>' +

                                '<a href="#">' + data[i].name + '</a>' +
                                '</h2>' +
                                '</td>' +
                                '<td>' + data[i].desig_name + '</td>' +

                                '<td>' + data[i].reason + '</td>' +
                                '<td>' + data[i].notice_date + '</td>' +
                                '<td>' + data[i].resign_date + '</td>' +
                                '<td>' + data[i].status + '</td>' +
                                '<td>' + data[i].created_at + '</td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a class="dropdown-item btn_edit_reg" href="#" data-toggle="modal"  data="' +
                                data[i].id + '"><i class="fa fa-pencil m-r-5n "></i> Edit</a>' +
                                '<a class="dropdown-item btn_delete_reg" href="#" " data="' + data[i]
                                .id + '"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +
                                '</tr>';
                        }


                        $('#resignationTable').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }

            //ajax call for save Record.


            $('#resigForm').on('submit', function(e) {
                e.preventDefault();

                var $form = $(this);
                // check if the input is valid
                if (!$form.validate().form()) return false;

                let formData = new FormData($('#resigForm')[0]);


                $.ajax({
                    type: "POST",
                    url: '{{ url('resignation') }}',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.btn_save_resig').text('Saving...');
                        $(".btn_save_resig").prop("disabled", true);
                    },
                    success: function(data) {
                        if (data.errors) {
                            toastr.error('missing some fields');
                            $('.btn_save_resig').text('Save');
                            $(".btn_save_resig").prop("disabled", false);
                        }
                        if (data.success) {
                            getResignation();
                            $('#resigForm')[0].reset();
                            $('.btn-dismiss').click();
                            toastr.success('Success messages');
                            $('.btn_save_resig').text('Save');
                            $(".btn_save_resig").prop("disabled", false);
                        }
                    },

                    error: function() {
                        toastr.error('something went wrong');
                        $('.btn_save_resig').text('Save');
                        $(".btn_save_resig").prop("disabled", false);
                    }

                });


            });


            //resigntraion edit
            $('#resignationTable').on('click', '.btn_edit_reg', function() {


                var id = $(this).attr('data');

                $('#edit_resignation_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('edit-resignation') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('input[name=reg_id]').val(data.id);
                        $('input[name=notice_date]').val(data.notice_date);
                        $('input[name=resign_date]').val(data.resign_date);
                        $('textarea[name=reason]').val(data.reason);
                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }
                });
            });


            //Update registration
            $('.update_resig').on('click', function(e) {
                e.preventDefault();
                $('.update_resig').text('Updating...');

                let EditFormData = new FormData($('#EditRegisterationForm')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('/update-resig') }}",
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(response) {

                        if (response.status == 200) {
                            $("#edit_resignation_modal").modal('hide');
                            $('#EditRegisterationForm').find('input').val("");
                            $('.update_resig').text('Update');
                            toastr.success(response.message);
                            getResignation();
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.update_resig').text('Update');
                    }
                });

            });


            // script for delete data
            $('#resignationTable').on('click', '.btn_delete_reg', function(e) {
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
                            url: "{{ url('/delete-resig/') }}/" + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {
                                toastr.success(response.data);
                                getResignation();
                            }
                        });
                    }
                })

            });




            //btnEditDept
            $('.btn-edit').on('click', function() {
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
            $('.btn-update').on('click', function() {
                var formData = $('#gradeEditForm').serialize();


                $.ajax({

                    url: '{{ url('/update-grade') }}',
                    type: 'post',
                    async: false,
                    dataType: 'json',
                    data: formData,
                    success: function(data) {

                        if (data.errors) {
                            toastr.error('missing some fileds');
                        }

                        if (data.success) {
                            getGrades();
                            $('#btnDissmissEdit').click();


                            toastr.success('Save changes successfully');
                        }

                    },
                    error: function() {
                        toastr.error('Something went wrong');
                    }

                });

            })



            //btnEditDelete
            $('.btnDelete').on('click', function() {
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
