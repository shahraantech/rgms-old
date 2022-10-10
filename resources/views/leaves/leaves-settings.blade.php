@extends('setup.master')
@section('content')


    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Leaves Settings</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Leaves Settings</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <!-- Page Tab -->
            <div class="page-menu">
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs nav-tabs-solid">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab_additions">Leave Type</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn" data-toggle="tab" href="#tab_overtime"> Company Leaves</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="tab-content">

                <div class="tab-pane show active" id="tab_additions">

                    <div class="text-right mb-4 clearfix">
                        <button class="btn btn-primary add-btn" type="button" data-toggle="modal"
                            data-target="#add_leave_type" title="Create Allowance"><i class="fa fa-plus"></i> </button>
                    </div>

                    <div class="payroll-table card">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>SR#</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="leaveTypeTable">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /Payroll Additions Table -->
                </div>

                <div class="tab-pane" id="tab_overtime">
                    <div class="text-right mb-4 clearfix">

                        <div class="text-right mb-4 clearfix">
                            <button class="btn btn-primary add-btn" type="button" data-toggle="modal"
                                data-target="#add_company" title="Create Allowance"><i class="fa fa-plus"></i> </button>
                        </div>

                    </div>
                    <div class="payroll-table card">
                        <div class="table-responsive">

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>SR#</th>
                                        <th>Company</th>
                                        <th>Type</th>
                                        <th>Days</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="CompanyLeaveTable">

                                    @isset($data['company_leaves'])
                                        @foreach ($data['company_leaves'] as $key => $comp_leave)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $comp_leave->leaveType->laeve_type ?? '' }}</td>
                                                <td>{{ $comp_leave->company->name }}</td>
                                                <td>{{ $comp_leave->leave_days }}</td>
                                                <td>{{ $comp_leave->created_at }}</td>

                                                <td class="text-right">
                                                    <div class="dropdown dropdown-action"><a href="#"
                                                            class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                            aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right"><a
                                                                class="dropdown-item btn_edit_company_leave" href="#"
                                                                data-toggle="modal" data="{{ $comp_leave->id }}"><i
                                                                    class="fa fa-pencil m-r-5n "></i> Edit</a>
                                                            <a class="dropdown-item btn_delete_company_leave" href="#"
                                                                data="{{ $comp_leave->id }}">
                                                                <i class="fa fa-trash-o m-r-5 "></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /Payroll Overtime Table -->
                </div>



            </div>


            <!-- Tab Content -->
        </div>
        <!-- /Page Content -->


        <!-- Add Leave Type Modal -->
        <div id="add_leave_type" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Leaves Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" id="LeaveTypeForm" class="needs-validation">
                            @csrf
                            <div class="form-group">
                                <label>Leave Type <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="laeve_type" required
                                    placeholder="Add Leaves Type Title">
                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn btn_leave_type" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Leave Type Modal -->


        <!-- Edit Leave Type Modal -->
        <div id="edit_leave_type" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Leaves Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form method="post" action="" id="EditLeaveTypeForm" class="needs-validation">
                            <input type="hidden" name="leavetype_id">
                            @csrf
                            <div class="form-group">
                                <label for="">Company</label>
                                <select name="company_id" class="form-control" required>
                                    <option value="" selected disabled>Choose Company</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Leave Type <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="laeve_type" required
                                    placeholder="Add Leaves Type Title">
                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn update_leaveType" type="button">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Leave Type Modal -->


        <!-- Edit Company Leave Modal -->
        <div id="edit_company_leave" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Company Leaves</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form method="post" action="" id="EditCompanyLeaveForm" class="needs-validation">
                            <input type="hidden" name="company_leave_id">
                            @csrf
                            <div class="form-group">
                                <label for="">Leave Type</label>
                                <select name="leave_type_id" class="form-control" required>
                                    <option value="" selected disabled>Choose leavetype</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Days <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="leave_days" required>
                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn update_company_leave"
                                    type="button">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Company Leave Modal -->



        <!-- Add Comany Leave Modal -->
        <div class="modal fade" id="add_company" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">Add Company Leaves</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form action="{{ url('add-company-leaves') }}" method="post" id="AddCompanyLeave"
                                class="needs-validation" novalidat>
                                @csrf
                                <table class="table table-bordered mt-5 table-style">
                                    <div class="col-md-12">
                                        <label for="">Company</label>
                                        <select name="company_id" class="select" required>
                                            <option value="" selected disabled>Choose Company</option>
                                            @isset($data)
                                                @foreach ($data['company'] as $comp)
                                                    <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                    <thead>
                                        <tr>
                                            <th>Leave Type <span class="text-danger">*</span></th>
                                            <th>Days <span class="text-danger">*</span></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblPurchase">
                                        <tr>
                                            <td>
                                                <select name="laeve_type[]" class="form-control item-id" required>
                                                    <option value="">Choose Item</option>
                                                    @isset($data['leavetypes'])
                                                        @foreach ($data['leavetypes'] as $item)
                                                            <option value="{{ $item->id }}">{{ $item->laeve_type }}
                                                            </option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                            </td>
                                            <td><input type="number" class="form-control" name="leave_days[]" required>
                                            </td>
                                            <td><button type="button" class="btn-success" id="addNewRow"><i
                                                        class="fa fa-plus"></i></button> </td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary float-right leave_save">Save</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Comany Leave Modal -->




        <script type="text/javascript">
            $(function() {
                $('#addNewRow').on('click', function() {
                    var tr = $("#dvOrders").find("Table").find("TR:has(td)").clone();
                    console.log(tr);
                    $("#tblPurchase").append(tr);
                });
            });
        </script>

        <div id="dvOrders" style="display:none">

            <table class="table table-bordered mt-5 table-style secondtable ">
                <tr>
                    <td>
                        <select name="laeve_type[]" class="form-control item-id" required>
                            <option value="">Choose Item</option>
                            @isset($data['leavetypes'])
                                @foreach ($data['leavetypes'] as $item)
                                    <option value="{{ $item->id }}">{{ $item->laeve_type }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </td>
                    <td><input type="number" class="form-control item-unit" name="leave_days[]" required></td>
                    <td style="color:red;cursor: pointer" class="delete-row" title="Remove"><i class="fa fa-trash"></i>
                    </td>
                </tr>
            </table>


        </div>
        <script>
            $(document).ready(function() {

                toastr.options.timeOut = 4000;
                @if (Session::has('error'))
                    toastr.error('{{ Session::get('error') }}');
                @elseif (Session::has('success'))
                    toastr.success('{{ Session::get('success') }}');
                @endif

                // Denotes total number of rows
                var rowIdx = 0;
                // jQuery button click event to remove a row.
                $('#tblPurchase').on('click', '.delete-row', function() {

                    // Getting all the rows next to the row
                    // containing the clicked button
                    var child = $(this).closest('tr').nextAll();

                    // Iterating across all the rows
                    // obtained to change the index
                    child.each(function() {

                        // Getting <tr> id.
                        var id = $(this).attr('id');

                        // Getting the <p> inside the .row-index class.
                        var idx = $(this).children('.row-index').children('p');

                        // Gets the row number from <tr> id.
                        var dig = parseInt(id.substring(1));

                        // Modifying row index.
                        idx.html(`Row ${dig - 1}`);

                        // Modifying row id.
                        $(this).attr('id', `R${dig - 1}`);
                    });

                    // Removing the current row.
                    $(this).closest('tr').remove();

                    // Decreasing total number of rows by 1.
                    rowIdx--;
                });




                $('.livesearch').select2({

                    ajax: {
                        url: '{{ url('get-clients-name') }}',
                        dataType: 'json',
                        delay: 250,
                        processResults: function(data) {

                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.name,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                });
            });
        </script>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <!-- CDN for Sweet Alert -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {


                $('.select2').select2({
                    placeholder: "Please select here",
                    width: "100%"
                });

                getLeaveType();

                //Get Leave Tpe
                function getLeaveType() {

                    $.ajax({

                        url: '{{ url('/get-leaves-settings') }}',
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
                                    '<td>' + data[i].laeve_type + '</td>' +
                                    '<td>' + data[i].created_at + '</td>' +
                                    '<td class="text-right">' +
                                    '<div class="dropdown dropdown-action">' +
                                    '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item btn_edit_leaveType" href="#" data-toggle="modal"  data="' +
                                    data[i].id + '"><i class="la la-pencil" style="font-size: 20px;"></i></a>' +
                                    '<a class="dropdown-item btn_delete_leaveType" href="#" " data="' +
                                    data[i].id + '"><i class="la la-trash" style="font-size: 20px;"></i></a>' +
                                    '</div>' +
                                    '</div>' +
                                    '</td>' +

                                    '</tr>';
                            }


                            $('#leaveTypeTable').html(html);

                        },
                        error: function() {
                            toastr.error('something went wrong');
                        }

                    });
                }

                //Add LeaveType

                $('#LeaveTypeForm').on('submit', function(e) {
                    e.preventDefault();

                    let formData = new FormData($('#LeaveTypeForm')[0]);

                    $.ajax({
                        type: "POST",
                        url: '{{ url('leaves-settings') }}',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('.btn_leave_type').text('Saving...');
                            $(".btn_leave_type").prop("disabled", true);
                        },
                        success: function(data) {

                            if (data.success) {
                                $('#add_leave_type').modal('hide');
                                $('#LeaveTypeForm')[0].reset();
                                toastr.success(data.success);
                                getLeaveType();
                                $('.btn_leave_type').text('Save');
                                $(".btn_leave_type").prop("disabled", false);
                            }
                        },

                        error: function() {
                            toastr.error('something went wrong');
                            $('.btn_leave_type').text('Save');
                            $(".btn_leave_type").prop("disabled", false);
                        }

                    });


                });

                //Edit LeaveType
                $('#leaveTypeTable').on('click', '.btn_edit_leaveType', function(e) {
                    e.preventDefault();

                    var id = $(this).attr('data');

                    $('#edit_leave_type').modal('show');

                    $.ajax({

                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('edit-leaves-settings') }}',
                        data: {
                            id: id
                        },
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            // alert(data.leavetype.id);


                            $('input[name=leavetype_id]').val(data.leavetype.id);

                            $.each(data.company, function(key, comp) {

                                $('select[name="company_id"]')
                                    .append(
                                        `<option value="${comp.id}" ${comp.id == data.leavetype.company_id ? 'selected' : ''}>${comp.name}</option>`
                                    )
                            });

                            $('input[name=laeve_type]').val(data.leavetype.laeve_type);
                        },

                        error: function() {

                            toastr.error('something went wrong');

                        }

                    });

                });

                //Edit LeaveType
                $('#CompanyLeaveTable').on('click', '.btn_edit_company_leave', function(e) {
                    e.preventDefault();

                    var id = $(this).attr('data');

                    $('#edit_company_leave').modal('show');

                    $.ajax({

                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('edit-company-leaves') }}',
                        data: {
                            id: id
                        },
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            // alert(data.leavetype.id);


                            $('input[name=company_leave_id]').val(data.companyleave.id);

                            $.each(data.leavetype, function(key, leav) {

                                $('select[name="leave_type_id"]')
                                    .append(
                                        `<option value="${leav.id}" ${leav.id == data.companyleave.leave_type_id ? 'selected' : ''}>${leav.laeve_type}</option>`
                                    )
                            });

                            $('input[name=leave_days]').val(data.companyleave.leave_days);
                        },

                        error: function() {

                            toastr.error('something went wrong');

                        }

                    });

                });

                //update LeaveType
                $('.update_leaveType').on('click', function() {


                    var formData = $('#EditLeaveTypeForm').serialize();

                    $.ajax({

                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('update-leaves-settings') }}',
                        data: formData,
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            $('#edit_leave_type').modal('hide');
                            toastr.success(data.success);
                            getLeaveType();
                        },

                        error: function() {
                            toastr.error('something went wrong');

                        }

                    });

                });

                //update Company Leave
                $('.update_company_leave').on('click', function() {

                    var formData = $('#EditCompanyLeaveForm').serialize();

                    $.ajax({

                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('update-company-leaves') }}',
                        data: formData,
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            $('#edit_company_leave').modal('hide');
                            toastr.success(data.success);
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        },

                        error: function() {
                            toastr.error('something went wrong');

                        }

                    });

                });

                // Delete LeaveType
                $('#leaveTypeTable').on('click', '.btn_delete_leaveType', function(e) {
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
                                url: "{{ url('/delete-leaves-settings/') }}/" + id,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.status == 200) {
                                        getLeaveType();
                                        toastr.success(response.success);

                                    }
                                }
                            });
                        }
                    });

                });

                // script for delete data
                $('#CompanyLeaveTable').on('click', '.btn_delete_company_leave', function(e) {
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
                                url: "{{ url('/delete-company-leaves/') }}/" + id,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.status == 200) {
                                        toastr.success(response.success);
                                        setTimeout(function() {
                                            window.location.reload();
                                        }, 1000);
                                    }
                                }
                            });
                        }
                    });

                });



            });



            $('.leave_save').on('click', function() {
                $(".leave_save").prop("disabled", true);
                $(".leave_save").html("Saving...");
                $('#AddCompanyLeave').submit();
            });
        </script>




    @endsection
