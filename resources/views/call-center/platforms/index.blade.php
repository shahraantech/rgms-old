@extends('setup.master')
@section('content')
    <div class="main-wrapper">
        <!-- /Sidebar -->
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <div class="page-header my-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title bold-heading">Platforms</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Platforms List</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_department"
                                title="Add New Leads Temperature"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">

                        <table class="table table-striped table-hover data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="leadsTable">
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
            <!-- /Page Content -->
        </div>


        <!-- Add Department Modal -->
        <div id="add_department" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Plateform</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="" id="LeadForm" class="needs-validation" novalidate>
                            {{-- @csrf --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label> Plateform <span class="text-danger">*</span></label>
                                        <input type="text" name="platform" class="form-control" placeholder="Plateform">
                                        <div class="invalid-feedback">
                                            Please choose mode.
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn add_platfom" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Department Modal -->

        <!-- Edit Plateform Modal -->
        <div id="edit_platfom_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Plateform</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" id="edit_platform_form" class="needs-validation" novalidate>
                            <input type="hidden" name="plat_id">
                            {{-- @csrf --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label> Plateform <span class="text-danger">*</span></label>
                                        <input type="text" name="platform" class="form-control" placeholder="Platform">
                                        <div class="invalid-feedback">
                                            Please choose mode.
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary update_plateform submit-btn" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Plateform Modal -->



    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            getLeadsSettings();

            //Add Plateform
            $('#LeadForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData($('#LeadForm')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('platforms-store') }}",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.add_platfom').text('Saving...');
                        $(".add_platfom").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            toastr.success(response.message);
                            $('.add_platfom').text('Save');
                            $(".add_platfom").prop("disabled", false);
                            $("#add_department").modal('hide');
                            $('#LeadForm').find('input').val("");
                            getLeadsSettings();
                        }

                        if (response.errors) {
                            toastr.error('Please Enter Values');
                            $('.add_platfom').text('Save');
                            $(".add_platfom").prop("disabled", false);
                        }
                    },
                    error: function() {
                        $('.add_platfom').text('Save');
                        $(".add_platfom").prop("disabled", false);
                        toastr.error('something went wrong');
                    },
                });

            });

            function getLeadsSettings() {

                $.ajax({

                    url: '{{ url('/platforms-list') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',

                    success: function(data) {
                        console.log(data);


                        var html = '';
                        var i;
                        var c = 0;

                        for (i = 0; i < data.length; i++) {

                            c++;

                            html += '<tr>' +

                                '<td>' + c + '</td>' +
                                '<td>' + data[i].id + '</td>' +
                                '<td>' + data[i].platform + '</td>' +
                                '<td>' + data[i].created_at + '</td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a href="#" class="dropdown-item btn_edit_plat" data="' + data[i]
                                .id + '"><i class="fa fa-pencil m-r-5n "></i> Edit</a>' +
                                '<a href="#" class="dropdown-item btn_delete_plat" data="' + data[i]
                                .id +
                                '" id="btn_delete_clients"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>' +
                                '</tr>';
                        }


                        $('#leadsTable').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }

            //Edit Platform
            $('#leadsTable').on('click', '.btn_edit_plat', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                $('#edit_platfom_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('platforms-edit') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('input[name=plat_id]').val(data.plateform.id);
                        $('input[name=platform]').val(data.plateform.platform);
                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });

            //Update Platform
            $('.update_plateform').on('click', function(e) {
                e.preventDefault();

                let EditFormData = new FormData($('#edit_platform_form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('platforms-update') }}",
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('.update_plateform').text('Updating...');
                        $(".update_plateform").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            $('#edit_platfom_modal').modal('hide');
                            $('#edit_platform_form').find('input').val("");
                            $('.update_plateform').text('Update');
                            $(".update_plateform").prop("disabled", false);
                            toastr.success(response.message);
                            getLeadsSettings();
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.update_plateform').text('Update');
                        $(".update_plateform").prop("disabled", false);
                    }
                });

            });

            // Delete Platform
            $('#leadsTable').on('click', '.btn_delete_plat', function(e) {
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
                            url: "{{ url('platforms-delete') }}",
                            data: {
                                id: id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {

                                toastr.success(response.message);
                                getLeadsSettings();
                            }
                        });
                    }
                })

            });


        });
    </script>
@endsection
