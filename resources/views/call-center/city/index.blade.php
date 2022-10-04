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
                            <h3 class="page-title bold-heading">City</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">City List</li>
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


        <!-- Add City Modal -->
        <div id="add_department" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">City Name</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ url('city') }}" id="LeadForm" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label> City Name <span class="text-danger">*</span></label>
                                        <input type="text" name="city_name" class="form-control" placeholder="City Name">
                                        <div class="invalid-feedback">
                                            Please choose mode.
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn" type="submit" id="btnSubmit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add City Modal -->



        <!-- Edit City Modal -->
        <div id="edit_city_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit City Name</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="" id="edit_city_form" class="needs-validation" novalidate>
                            <input type="hidden" name="city_id">
                            {{-- @csrf --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label> City Name <span class="text-danger">*</span></label>
                                        <input type="text" name="city_name" class="form-control" placeholder="City Name">
                                        <div class="invalid-feedback">
                                            Please choose mode.
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn update-city" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit City Modal -->


    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {
                getLeadsSettings();

                $('#LeadForm').unbind().on('submit', function(e) {
                    e.preventDefault();
                    var formData = $('#LeadForm').serialize();
                    $.ajax({

                        type: 'ajax',
                        method: 'post',
                        url: '{{ url('city') }}',
                        data: formData,
                        async: false,
                        dataType: 'json',
                        beforeSend: function() {

                            $("#btnSubmit").prop("disabled", true);
                            $("#btnSubmit").html("loading...");

                        },
                        success: function(data) {

                            if (data.success) {
                                getLeadsSettings();
                                $('.close').click();
                                $('#LeadForm')[0].reset();
                                toastr.success(data.success);

                            }
                            if (data.errors) {
                                toastr.error('Please Enter City');
                            }
                        },

                        complete: function(data) {
                            $("#btnSubmit").html("Save");
                            $("#btnSubmit").prop("disabled", false);
                        },
                        error: function() {
                            toastr.error('something went wrong');

                        },

                    });


                });

                function getLeadsSettings() {

                    $.ajax({

                        url: '{{ url('/cityList') }}',
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
                                    '<td>' + data[i].id + '</td>' +
                                    '<td>' + data[i].city_name + '</td>' +
                                    '<td>' + data[i].created_at + '</td>' +
                                    '<td class="text-right">' +
                                    '<div class="dropdown dropdown-action">' +
                                    '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a href="#" class="dropdown-item city-edit" data="' + data[i].id +
                                    '">Edit</a>' +
                                    '<a href="#" class="dropdown-item city-delete" data="' + data[i].id +
                                    '">Delete</a>' +
                                    '</div>' +
                                    '</div>' +
                                    '</td>'

                                '</tr>';
                            }
                            $('#leadsTable').html(html);

                        },
                        error: function() {
                            toastr.error('something went wrong');
                        }

                    });
                }

                //Edit City
                $('#leadsTable').on('click', '.city-edit', function(e) {
                    e.preventDefault();

                    var id = $(this).attr('data');

                    $('#edit_city_modal').modal('show');

                    $.ajax({

                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('edit-city') }}',
                        data: {
                            id: id
                        },
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            $('input[name=city_id]').val(data.city.id);
                            $('input[name=city_name]').val(data.city.city_name);
                        },

                        error: function() {

                            toastr.error('something went wrong');

                        }

                    });

                });

                //Update City
                $('.update-city').on('click', function(e) {
                    e.preventDefault();

                    let EditFormData = new FormData($('#edit_city_form')[0]);

                    $.ajax({
                        type: "POST",
                        url: "{{ url('update-city') }}",
                        data: EditFormData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        beforeSend: function() {
                            $('.update-city').text('Updating...');
                            $(".update-city").prop("disabled", true);
                        },
                        success: function(response) {

                            if (response.status == 200) {
                                $('#edit_city_modal').modal('hide');
                                $('#edit_city_form').find('input').val("");
                                $('.update-city').text('Update');
                                $(".update-city").prop("disabled", false);
                                toastr.success(response.message);
                                getLeadsSettings();
                            }
                        },
                        error: function() {
                            toastr.error('something went wrong');
                            $('.update-city').text('Update');
                            $(".update-city").prop("disabled", false);
                        }
                    });

                });

                // Delete Level 1
                $('#leadsTable').on('click', '.city-delete', function(e) {
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
                                url: "{{ url('delete-city') }}",
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
