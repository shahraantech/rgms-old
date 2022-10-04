@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Property Type List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Property Type List</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_supplier"
                            title="Add Supplier"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered mt-5 table-hover table-striped">
                        <thead>
                            <tr class="bold-tr">
                                <th># </th>
                                <th>Property Type </th>
                                <th>Created At </th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tbody id="supplierTable">
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- /Page Content -->
        </div>

        <!-- Add Ticket Modal -->
        <div id="add_supplier" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add Property Type</h5>
                        <button type="button" class="close btn-dismiss" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form method="post" action="{{ url('category') }}" class="needs-validation" novalidate
                            id="supplierForm">
                            @csrf
                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Property Type</label>
                                        <input class="form-control" type="text" name="type"
                                            placeholder="Property Type" required>
                                    </div>
                                </div>


                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary btn-submit" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Ticket Modal -->


        <!-- Edit Ticket Modal -->
        <div id="edit_type_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Property Type</h5>
                        <button type="button" class="close btn-dismiss" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form method="POST" action="" class="needs-validation" novalidate id="edit_type_form">
                            <input type="hidden" name="type_id">
                            @csrf
                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Property Type</label>
                                        <input class="form-control" type="text" name="type"
                                            placeholder="Property Type" required>
                                    </div>
                                </div>


                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary btn-submit update_type" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Ticket Modal -->


        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <!-- CDN for Sweet Alert -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {
                getPropertyType();

                function getPropertyType() {

                    $.ajax({

                        url: '{{ url('/get-property-type') }}',
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
                                    '<td>' + data[i].type + '</td>' +
                                    '<td>' + data[i].created_at + '</td>' +
                                    '</td>' +
                                    '</td>' +
                                    '<td class="text-right"> ' +
                                    '<div class="dropdown">' +
                                    '<a href="#" class="action-icon" data-toggle="dropdown"aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                    '<div class="dropdown-menu dropdown-menu-right" style="">' +
                                    '<a class="dropdown-item btn_edit_property_type" href="javascript:void(0)" data="' +
                                    data[i].id + '"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item btn_delete_property_type" href="javascript:void(0)" data="' +
                                    data[i].id + '"><i class="fa fa-pencil"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>' +
                                    '</td>' +
                                    '</tr>';
                            }


                            $('#supplierTable').html(html);

                        },
                        error: function() {
                            toastr.error('something went wrong');
                        }

                    });
                }

                $('#supplierForm').unbind().on('submit', function(e) {
                    e.preventDefault();
                    var formData = $('#supplierForm').serialize();

                    $.ajax({

                        type: 'ajax',
                        method: 'post',
                        url: '{{ url('store-property-type') }}',
                        data: formData,
                        async: false,
                        dataType: 'json',
                        beforeSend: function() {

                            $(".btn-submit").prop("disabled", true);
                            $(".btn-submit").html("please wait...");

                        },
                        success: function(data) {
                            if (data.success) {
                                getPropertyType();
                                $('.close').click();
                                $('#supplierForm')[0].reset();
                                toastr.success(data.success);
                            }
                            if (data.errors) {
                                toastr.error(data.errors);
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

                //Edit Level 1
                $('#supplierTable').on('click', '.btn_edit_property_type', function(e) {
                    e.preventDefault();

                    var id = $(this).attr('data');

                    $('#edit_type_modal').modal('show');

                    $.ajax({

                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('edit-property-type') }}',
                        data: {
                            id: id
                        },
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            $('input[name=type_id]').val(data.type.id);
                            $('input[name=type]').val(data.type.type);
                        },

                        error: function() {

                            toastr.error('something went wrong');

                        }

                    });

                });

                //Update Level 1
                $('.update_type').on('click', function(e) {
                    e.preventDefault();

                    let EditFormData = new FormData($('#edit_type_form')[0]);

                    $.ajax({
                        type: "POST",
                        url: "{{ url('update-property-type') }}",
                        data: EditFormData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        beforeSend: function() {
                            $('.update_type').text('Updating...');
                            $(".update_type").prop("disabled", true);
                        },
                        success: function(response) {

                            if (response.status == 200) {
                                $('#edit_type_modal').modal('hide');
                                $('#edit_type_form').find('input').val("");
                                $('.update_type').text('Update');
                                $(".update_type").prop("disabled", false);
                                toastr.success(response.message);
                                getPropertyType();
                            }
                        },
                        error: function() {
                            toastr.error('something went wrong');
                            $('.update_type').text('Update');
                            $(".update_type").prop("disabled", false);
                        }
                    });

                });


                // Delete Level 1
                $('#supplierTable').on('click', '.btn_delete_property_type', function(e) {
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
                                url: "{{ url('delete-property-type') }}",
                                data: {
                                    id: id
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType: "json",
                                success: function(response) {

                                    toastr.success(response.message);
                                    getPropertyType();
                                }
                            });
                        }
                    })

                });

            });
        </script>
    @endsection
