@extends('setup.master')
@section('content')
    <style type="text/css">
        body {
            font-family: Arial;
            font-size: 10pt;
        }

        table {
            border: 1px solid #ccc;
            border-collapse: collapse;
        }

        table th {
            background-color: #F7F7F7;
            color: #333;
            font-weight: bold;
        }

        table th,
        table td {
            padding: 5px;
            border: 1px solid #ccc;
        }

    </style>
    <div class="main-wrapper">
        <!-- /Sidebar -->
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <div class="page-header my-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title bold-heading">Leads Temperature</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Temperature</li>
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
                                    <th>Temperature</th>
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


        <!-- Add Temprature Modal -->
        <div id="add_department" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Leads Temperature</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ url('temp') }}" id="TempForm" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label> Leads Temperature <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="temp"
                                            placeholder="Leads Temperature" required>
                                        <div class="invalid-feedback">
                                            Please enter temperature.
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary  " type="submit" id="btnSubmit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Temprature Modal -->


        <!-- Edit Temprature Modal -->
        <div id="edit_temp_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Leads Temperature</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="" id="EditTempForm" class="needs-validation" novalidate>
                            <input type="hidden" name="temp_id">
                            {{-- @csrf --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label> Leads Temperature <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="temp"
                                            placeholder="Leads Temperature" required>
                                        <div class="invalid-feedback">
                                            Please enter temperature.
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary edit_temp submit-btn" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Temprature Modal -->



    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function() {
            getTemp();

            $('#TempForm').unbind().on('submit', function(e) {
                e.preventDefault();
                var formData = $('#TempForm').serialize();
                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{ url('temp') }}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {

                        $("#btnSubmit").prop("disabled", true);
                        $("#btnSubmit").html("loading...");

                    },
                    success: function(data) {

                        if (data.success) {
                            getTemp();
                            $('.close').click();
                            $('#TempForm')[0].reset();
                            toastr.success(data.success);

                        }
                        if (data.errors) {
                            toastr.error(data.errors);
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


            function getTemp() {

                $.ajax({

                    url: '{{ url('/temp-list') }}',
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
                                '<td>' + data[i].temp + '</td>' +
                                '<td>' + data[i].created_at + '</td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a href="#" class="dropdown-item edit-temp" data="' + data[i].id +
                                '" data-toggle="modal" data-target="#add_lead_status">Edit</a>' +
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

            //Edit temp
            $('#leadsTable').on('click', '.edit-temp', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                $('#edit_temp_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('edit-temp') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('input[name=temp_id]').val(data.temp.id);
                        $('input[name=temp]').val(data.temp.temp);
                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });


            //Update temp
            $('.edit_temp').on('click', function(e) {
                    e.preventDefault();

                    let EditFormData = new FormData($('#EditTempForm')[0]);

                    $.ajax({
                        type: "POST",
                        url: "{{ url('update-temp') }}",
                        data: EditFormData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        beforeSend: function() {
                            $('.edit_temp').text('Updating...');
                            $(".edit_temp").prop("disabled", true);
                        },
                        success: function(response) {

                            if (response.status == 200) {
                                $('#edit_temp_modal').modal('hide');
                                $('#EditTempForm').find('input').val("");
                                $('.edit_temp').text('Update');
                                $(".edit_temp").prop("disabled", false);
                                toastr.success(response.message);
                                getTemp();
                            }
                        },
                        error: function() {
                            toastr.error('something went wrong');
                            $('.edit_temp').text('Update');
                            $(".edit_temp").prop("disabled", false);
                        }
                    });

                });

        });
    </script>

    @include('call-center.general.dont-copy');
@endsection
