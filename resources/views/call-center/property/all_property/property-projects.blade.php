@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Property Project</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Property Project</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" title="Add Supplier" data-toggle="modal"
                            data-target="#add_property_projects_modal"><i class="fa fa-plus"></i></a>
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
                                <th>Project </th>
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

        <!-- Add Property Poject Modal -->
        <div id="add_property_projects_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add Property Projects</h5>
                        <button type="button" class="close btn-dismiss" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form method="POST" action="" class="needs-validation"
                            novalidate id="supplierForm">
                            @csrf
                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Property Project</label>
                                        <input class="form-control" type="text" name="name"
                                            placeholder="Property Project" required>
                                    </div>
                                </div>


                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary btn-submit add_property_project" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Property Poject Modal -->

        <!-- Edit Property Poject Modal -->
        <div id="edit_property_projects_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Property Projects</h5>
                        <button type="button" class="close btn-dismiss" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form method="POST" action="" class="needs-validation" novalidate id="EditProjectForm">
                            <input type="hidden" name="prop_project_id">
                            @csrf
                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Property Project</label>
                                        <input class="form-control" type="text" name="name"
                                            placeholder="Property Project" required>
                                    </div>
                                </div>


                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary btn-submit update_property_project"
                                    type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Property Poject Modal -->


        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <!-- CDN for Sweet Alert -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {
                getPropertyType();

                function getPropertyType() {

                    $.ajax({

                        url: '{{ url('/get-property-projects') }}',
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
                                    '<td>' + data[i].name + '</td>' +
                                    '<td>' + data[i].created_at + '</td>' +
                                    '</td>' +
                                    '<td class="text-right"> ' +
                                    '<div class="dropdown">' +
                                    '<a href="#" class="action-icon" data-toggle="dropdown"aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                    '<div class="dropdown-menu dropdown-menu-right" style="">' +
                                    '<a class="dropdown-item btn_edit_property_project" href="javascript:void(0)" data="' +
                                    data[i].id + '"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item btn_delete_property_project" href="javascript:void(0)" data="' +
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

                //Add Level 1
            $('#supplierForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData($('#supplierForm')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('property-projects-store') }}",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.add_property_project').text('Saving...');
                        $(".add_property_project").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            toastr.success(response.message);
                            $('.add_property_project').text('Save');
                            $(".add_property_project").prop("disabled", false);
                            $("#add_property_projects_modal").modal('hide');
                            $('#supplierForm').find('input').val("");
                            getPropertyType();
                           
                        }

                        if (response.errors) {
                            toastr.error(response.errors);
                            $('.add_property_project').text('Save');
                            $(".add_property_project").prop("disabled", false);
                        }
                    },
                    error: function() {
                        $('.add_property_project').text('Save');
                        $(".add_property_project").prop("disabled", false);
                        toastr.error('something went wrong');
                    },
                });

            });

                //Edit Level 1
                $('#supplierTable').on('click', '.btn_edit_property_project', function(e) {
                    e.preventDefault();

                    var id = $(this).attr('data');

                    $('#edit_property_projects_modal').modal('show');

                    $.ajax({

                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('property-projects-edit') }}',
                        data: {
                            id: id
                        },
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            $('input[name=prop_project_id]').val(data.proj.id);
                            $('input[name=name]').val(data.proj.name);
                        },

                        error: function() {

                            toastr.error('something went wrong');

                        }

                    });

                });


                //Update Level 1
                $('.update_property_project').on('click', function(e) {
                    e.preventDefault();

                    let EditFormData = new FormData($('#EditProjectForm')[0]);

                    $.ajax({
                        type: "POST",
                        url: "{{ url('property-projects-update') }}",
                        data: EditFormData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        beforeSend: function() {
                            $('.update_property_project').text('Updating...');
                            $(".update_property_project").prop("disabled", true);
                        },
                        success: function(response) {

                            if (response.status == 200) {
                                $('#edit_property_projects_modal').modal('hide');
                                $('#EditProjectForm').find('input').val("");
                                $('.update_property_project').text('Update');
                                $(".update_property_project").prop("disabled", false);
                                toastr.success(response.message);
                                getPropertyType();
                            }
                        },
                        error: function() {
                            toastr.error('something went wrong');
                            $('.update_property_project').text('Update');
                            $(".update_property_project").prop("disabled", false);
                        }
                    });

                });

                // Delete Level 1
                $('#supplierTable').on('click', '.btn_delete_property_project', function(e) {
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
                                url: "{{ url('property-projects-delete') }}",
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
