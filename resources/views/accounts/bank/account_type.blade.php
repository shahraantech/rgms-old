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
                        <h3 class="page-title bold-heading">Chart Of Accounts</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Chart Of Accounts</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_accountType_modal"
                            title="Give Feedback"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">




                    <table class="table table-striped table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Account Type </th>
                                <th>Created At </th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tbody id="accountTypeTable">

                        </tbody>
                    </table>

                </div>
            </div>

            <!-- /Page Content -->


            <!-- Add AccoutnType -->
            <div id="add_accountType_modal125" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Chart Of Account</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="" id="AccountTypeForm" class="needs-validation" novalidate>
                                @csrf
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Account Category <span
                                                    class="text-danger">*</span></label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Balance Sheet Account</option>
                                                <option value="">Income Statement Account</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Main Account <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="ac_type"
                                                   placeholder="Account Type" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add AccoutnType -->



            <div id="add_accountType_modal125" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Chart Of Account</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="" id="AccountTypeForm" class="needs-validation" novalidate>
                                @csrf
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Account Category <span
                                                    class="text-danger">*</span></label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Balance Sheet Account</option>
                                                <option value="">Income Statement Account</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Main Account Type <span
                                                    class="text-danger">*</span></label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Current Assets</option>

                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Sub Account Type <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="ac_type"
                                                   placeholder="Account Type" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div id="add_accountType_modal125" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Chart Of Account</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="" id="AccountTypeForm" class="needs-validation" novalidate>
                                @csrf
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Account Category <span
                                                    class="text-danger">*</span></label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Balance Sheet Account</option>
                                                <option value="">Income Statement Account</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Main Account Type <span
                                                    class="text-danger">*</span></label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Current Assets</option>

                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Sub Account Type <span
                                                    class="text-danger">*</span></label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Accounts Receivables</option>

                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label"><span
                                                    class="text-danger">Detail Account Type</span></label>
                                            <input type="text" class="form-control" placeholder="Detail Account Type">
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div id="add_accountType_modal" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Chart Of Account</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="" id="AccountTypeForm" class="needs-validation" novalidate>
                                @csrf
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Account Category <span
                                                    class="text-danger">*</span></label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Balance Sheet Account</option>
                                                <option value="">Income Statement Account</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Main Account Type <span
                                                    class="text-danger">*</span></label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Current Assets</option>

                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Sub Account Type <span
                                                    class="text-danger">*</span></label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Accounts Receivables</option>

                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Detail Account Type</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Accounts Receivables</option>

                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Account Head</label>
                                            <input type="text" class="form-control" placeholder="Account Head">
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Edit AccoutnType -->
            <div id="edit_accounttype_modal" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Account Type</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="" id="EditAccountTypeForm" class="needs-validation" novalidate>
                                <input type="hidden" name="accounttype_id">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Account Type <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="ac_type"
                                                placeholder="Account Type" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn accounttype_update" type="button">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Edit AccoutnType -->


        </div>



        {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}
        <!-- CDN for Sweet Alert -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {

                getAccountType();

                function getAccountType() {

                    $.ajax({

                        url: '{{ url('/account-type') }}',
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
                                    '<td>' + data[i].ac_type + '</td>' +
                                    '<td>' + data[i].created_at + '</td>' +
                                    '<td class="text-right">' +
                                    '<div class="dropdown dropdown-action">' +
                                    '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item btn_edit_accounttype" href="#" data-toggle="modal"  data="' +
                                    data[i].id + '"><i class="fa fa-pencil m-r-5n "></i> Edit</a>' +
                                    '<a class="dropdown-item btn_delete_accounttype" href="#" " data="' +
                                    data[i].id + '"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>' +
                                    '</div>' +
                                    '</div>' +
                                    '</td>' +

                                    '</tr>';
                            }


                            $('#accountTypeTable').html(html);

                        },
                        error: function() {
                            toastr.error('something went wrong');
                        }

                    });
                }

                // save Account Type
                $('#AccountTypeForm').on('submit', function(e) {
                    e.preventDefault();

                    var formData = $('#AccountTypeForm').serialize();

                    $.ajax({

                        type: 'ajax',
                        method: 'post',
                        url: '{{ url('save-accounttype') }}',
                        data: formData,
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            if (data.success) {
                                $('#AccountTypeForm')[0].reset();
                                $('#add_accountType_modal').modal('hide');
                                toastr.success(data.success);
                                getAccountType();
                            }
                        },
                        error: function() {
                            toastr.error('something went wrong');

                        }
                    });
                });

                //Edit Account Type
                $('#accountTypeTable').on('click', '.btn_edit_accounttype', function(e) {
                    e.preventDefault();

                    var id = $(this).attr('data');

                    $('#edit_accounttype_modal').modal('show');

                    $.ajax({

                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('edit-accounttype') }}',
                        data: {
                            id: id
                        },
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            $('input[name=accounttype_id]').val(data.id);
                            $('input[name=ac_type]').val(data.ac_type);
                        },

                        error: function() {

                            toastr.error('something went wrong');

                        }

                    });

                });

                //update category
                $('.accounttype_update').on('click', function() {

                    var formData = $('#EditAccountTypeForm').serialize();

                    $.ajax({

                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('update-accounttype') }}',
                        data: formData,
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            $('#edit_accounttype_modal').modal('hide');
                            toastr.success(data.success);
                            getAccountType();
                        },

                        error: function() {
                            toastr.error('something went wrong');

                        }

                    });

                });

                // script for delete data
                $('#accountTypeTable').on('click', '.btn_delete_accounttype', function(e) {
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
                                url: "{{ url('/delete-accounttype/') }}/" + id,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType: "json",
                                success: function(response) {

                                    if(response.status == 200)
                                    {
                                        toastr.success(response.success);
                                        getAccountType();
                                    }

                                }
                            });
                        }
                    });

                });


                //Datatables
                $('#datatable').DataTable();

            });
        </script>


    @endsection
