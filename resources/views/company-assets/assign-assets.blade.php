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
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Asign Assets</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Asign Assets</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="page-menu">

            </div>
            <div class="tab-content">
                <!--Main Account Type-->
                <div class="tab-pane show " id="main_type">
                    <!-- Add Addition Button -->
                    <div class="text-right mb-4 clearfix">
                        <button class="btn btn-primary add-btn" type="button" data-toggle="modal"
                            data-target="#main_type_modal" title="Add Main Type">
                            <i class="fa fa-plus"></i> </button>
                    </div>
                    <!-- /Add Addition Button -->
                    <!-- Payroll Additions Table -->
                    <div class="card">
                        <div class="card-body">
                            <div class="payroll-table">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>SR#</th>
                                                <th>Main A/C Name</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="mainAccountTable">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Payroll Additions Table -->
                </div>
                <!--Main Account Type End Here-->
                <!--Sub Account Type Start Here-->


                {{-- Level 1 --}}
                <div class="tab-pane active" id="level_1">
                    <div class="text-right mb-4 clearfix">
                        <button class="btn btn-primary add-btn" type="button" data-toggle="modal"
                            data-target="#level_1_modal" title="assign allowance"><i class="fa fa-plus"></i></button>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="payroll-table">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Employee</th>
                                                <th>Assign Assets</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="level_1_table"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Level 1 --}}
            </div>
        </div>
    </div>


    <!-- Level 1 Modal Start-->
    <div id="level_1_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Asign Assets</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="level_1_form" class="needs-validation" novalidate>
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Employee<span class="text-danger">*</span></label>
                                    <select name="emp_id" class="select" required>
                                        <option value="" selected disabled>Choose Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Assign Assets<span class="text-danger">*</span></label>
                                    <select name="asset_id" class="select" required>
                                        <option value="" selected disabled>Asign assets</option>
                                        @foreach ($assets as $asset)
                                            <option value="{{ $asset->id }}">{{ $asset->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn add_level_1" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Level 1 Modal End-->

    <!-- Edit Level 1 Modal Start-->
    <div id="Edit_level_1_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Asign Assets</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="Edit_level_1_form" class="needs-validation" novalidate>
                        <input type="hidden" name="asset_asign_id">
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Employee<span class="text-danger">*</span></label>
                                    <select name="emp_id" class="select">
                                        <option value="" selected disabled>Choose Empoyee</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Asign Asset<span class="text-danger">*</span></label>
                                    <select name="asset_id" class="select">
                                        <option value="" selected disabled>Choose assets</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn update_btn" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Level 1 Modal End-->







    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            getCompanyAssets();

            toastr.options.timeOut = 3000;
            @if (Session::has('error'))
                toastr.error('{{ Session::get('error') }}');
            @elseif(Session::has('success'))
                toastr.success('{{ Session::get('success') }}');
            @endif


            function getCompanyAssets() {

                $.ajax({

                    url: '{{ url('/get-asign-assets') }}',
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
                                '<td>' + data[i].employee.name + '</td>' +
                                '<td>' + data[i].assets.title + '</td>' +
                                '<td>' + data[i].created_at + '</td>' +
                                '</td>' +
                                '</td>' +
                                '<td class="text-right"> ' +
                                '<div class="dropdown">' +
                                '<a href="#" class="action-icon" data-toggle="dropdown"aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right" style="">' +
                                '<a class="dropdown-item btn_edit_asign_asset" href="javascript:void(0)" data="' +
                                data[i].id + '"><i class="fa fa-pencil"></i>Edit</a>' +
                                '<a class="dropdown-item btn_delete_asign_asset" href="javascript:void(0)" data="' +
                                data[i].id + '"><i class="fa fa-pencil"></i>Delete</a>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +
                                '</tr>';
                        }

                        $('#level_1_table').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }

            // Delete Level 1
            $('#level_1_table').on('click', '.btn_delete_asign_asset', function(e) {
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
                            url: "{{ url('delete-asign-assets') }}",
                            data: {
                                id: id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {

                                toastr.success(response.message);
                                getCompanyAssets();
                            }
                        });
                    }
                })

            });


            $('.add_level_1').on('click', function() {
                $(".add_level_1").prop("disabled", true);
                $(".add_level_1").html("Please wait...");
                $('#level_1_form').submit();
            });

            $('.update_level_1').on('click', function() {
                $(".update_level_1").prop("disabled", true);
                $(".update_level_1").html("Please wait...");
                $('#Edit_level_1_form').submit();
            });


            //Add Level 2
            $('#level_1_form').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData($('#level_1_form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('store-asign-assets') }}",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.add_level_1').text('Saving...');
                        $(".add_level_1").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            toastr.success(response.message);
                            $('.add_level_1').text('Save');
                            $(".add_level_1").prop("disabled", false);
                            $("#level_1_modal").modal('hide');
                            $('#level_1_form').find('input').val("");
                            getCompanyAssets()
                        }

                        if (response.errors) {
                            toastr.error('Please Enter Values');
                            $('.add_level_1').text('Save');
                            $(".add_level_1").prop("disabled", false);
                        }
                    },
                    error: function() {
                        $('.add_level_1').text('Save');
                        $(".add_level_1").prop("disabled", false);
                        toastr.error('something went wrong');
                    },
                });

            });


            //Edit Level 3
            $('#level_1_table').on('click', '.btn_edit_asign_asset', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                $('#Edit_level_1_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('edit-asign-assets') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {


                        $('input[name=asset_asign_id]').val(data.asset.id);

                        $.each(data.emp, function(key, emp) {

                            $('select[name="emp_id"]')
                                .append(
                                    `<option value="${emp.id}" ${emp.id == data.asset.emp_id ? 'selected' : ''}>${emp.name}</option>`
                                )
                        });

                        $.each(data.assets, function(key, assets) {

                            $('select[name="asset_id"]')
                                .append(
                                    `<option value="${assets.id}" ${assets.id == data.asset.asset_id ? 'selected' : ''}>${assets.title}</option>`
                                )
                        });

                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });


            //Update Level 3
            $('.update_btn').on('click', function(e) {
                e.preventDefault();

                let EditFormData = new FormData($('#Edit_level_1_form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('update-asign-assets') }}",
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('.update_btn').text('Updating...');
                        $(".update_btn").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            $('#Edit_level_1_modal').modal('hide');
                            $('#Edit_level_1_form').find('input').val("");
                            $('.update_btn').text('Update');
                            $(".update_btn").prop("disabled", false);
                            toastr.success(response.message);
                            getCompanyAssets();

                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.update_btn').text('Update');
                        $(".update_btn").prop("disabled", false);
                    }
                });

            });

        });
    </script>
@endsection
