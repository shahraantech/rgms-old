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
                            <h3 class="page-title bold-heading">Users</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Users</li>
                            </ul>
                        </div>

                        <div class="col-auto float-right ml-auto">
                            <a type="submit" class="btn btn-primary" data-toggle="modal" data-target="#create_user"
                                title="Create User"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody id="usersTable">
                                @php $c=0; @endphp
                                @isset($data['users'])
                                    @foreach ($data['users'] as $user)
                                        @php $c++; @endphp
                                        <tr>
                                            <td>{{ $c }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td><span class="badge bg-inverse-primary">{{ $user->rolename['role'] }}</span></td>
                                            <td>
                                                @if ($user->status == 1)
                                                    <span class="badge bg-inverse-success">Active</span>
                                                @else
                                                    <span class="badge bg-inverse-danger">InActive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button style="border-radius: 1rem" type="button"
                                                        class=" btn-primary dropdown-toggle" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">Action</button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item btn-change-role" href=""
                                                            emp-id="{{ $user->id }}" data-toggle="modal"
                                                            data-target="#change_role_modal" data=""> <i
                                                                class="fa fa-clock-o m-r-5 text-success"></i>Change Role</a>
                                                        <a class="dropdown-item btn-status" href="#"
                                                            data="{{ $user->id }}" status="1"><i
                                                                class="fa fa-clock-o m-r-5 text-success"></i>Active</a>

                                                        <a class="dropdown-item btn-status" href="#"
                                                            data="{{ $user->id }}" status="0"><i
                                                                class="fa fa-clock-o m-r-5 text-danger"></i>InActive</a>
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
            </div>

            <!-- Create User -->
            <div id="create_user" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Create User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalDismiss">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ url('create-user') }}" id="userForm" class="needs-validation"
                                novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Choose Company <span class="text-danger">*</span></label>
                                            <select name="comp_id" class="form-control selectpicker" required>
                                                <option value="">Choose Company</option>
                                                @isset($data)
                                                    @foreach ($data['company'] as $comp)
                                                        <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                            <div class="invalid-feedback">
                                                Please choose company name.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Choose Employee <span class="text-danger">*</span></label>
                                            <select name="emp_id" class="form-control " id="showEmployee" required>
                                                <option value="">Choose Agent</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please choose Employee .
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>User Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email" placeholder="User Name"
                                        required>
                                    <input type="hidden" name="name">
                                    <div class="invalid-feedback">
                                        Please enter user name.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <input class="form-control" type="password" name="password" placeholder="Password"
                                        required>
                                    <div class="invalid-feedback">
                                        Please enter password name.
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Role <span class="text-danger">*</span></label>
                                            <select name="role_id" id="" class="form-control role-class"
                                                required>
                                                <option value="">Choose Role</option>
                                                @isset($data)
                                                    @foreach ($data['roles'] as $role)
                                                        <option value="{{ $role->id }}">{{ $role->role }}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                            <div class="invalid-feedback">
                                                Please choose Role .
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 module_section" style="display: none">
                                        <div class="form-group">
                                            <label>Module <span class="text-danger">*</span></label>
                                            <select name="module" id="" class="form-control">
                                                <option value="">Choose Module</option>
                                                <option value="call-center">Call Center</option>
                                                <option value="accounts">Accounts</option>
                                                <option value="admin">Hr</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn user_btn" id="btnSubmit"
                                        type="submit">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <div id="change_role_modal" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Change Role</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                id="modalDismiss">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <form method="post" action="{{ url('update-user-role') }}" id="changeRoleFormData"
                                class="needs-validation" novalidate>
                                @csrf
                                <input type="hidden" name="change_user_id">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Role <span class="text-danger">*</span></label>
                                            <select name="change_role_id" id="" class="form-control role-class"
                                                required>
                                                <option value="">Choose Role</option>
                                                @isset($data)
                                                    @foreach ($data['roles'] as $role)
                                                        <option value="{{ $role->id }}">{{ $role->role }}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                            <div class="invalid-feedback">
                                                Please choose Role .
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 module_section" style="display: none">
                                        <div class="form-group">
                                            <label>Module <span class="text-danger">*</span></label>
                                            <select name="change_module" id="" class="form-control">
                                                <option value="">Choose Module</option>
                                                <option value="call-center">Call Center</option>
                                                <option value="accounts">Accounts</option>
                                                <option value="admin">Hr</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn" id="btnSubmit"
                                        type="submit">Change</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Add Department Modal -->
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
            $(document).ready(function() {

                //roleTable
                //btn-change-role
                $('#usersTable').on('click', '.btn-change-role', function() {
                    var user_id = $(this).attr('emp-id');
                    $('input[name=change_user_id]').val(user_id);
                });

                //change status
                $('#usersTable').on('click', '.btn-status', function() {
                    var user_id = $(this).attr('data');
                    var status = $(this).attr('status');
                    $.ajax({
                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('change-user-status') }}',
                        data: {
                            user_id: user_id,
                            status: status
                        },
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            if (data.success) {
                                toastr.success(data.success);
                                window.location.reload();
                            }


                        },

                        error: function() {
                            toastr.error('something went wrong');

                        }
                    });
                });

                $('#changeRoleFormData').on('submit', function(e) {
                    e.preventDefault();
                    var formData = $('#changeRoleFormData').serialize();
                    $.ajax({
                        type: 'ajax',
                        method: 'post',
                        url: '{{ url('update-user-role') }}',
                        data: formData,
                        async: false,
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            if (data.success) {
                                $('#changeRoleFormData')[0].reset();
                                toastr.success(data.success);
                                window.location.reload();
                            }
                        },
                        error: function() {
                            toastr.error('something went wrong');
                        }
                    });
                });

                //company_id dependent dropdown for all employees
                $('select[name=comp_id]').change(function() {

                    var company_id = $('select[name=comp_id]').val();
                    $.ajax({
                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('/getEmployeesBaseofCompanyId') }}',
                        data: {
                            company_id: company_id
                        },

                        async: false,

                        dataType: 'json',

                        success: function(data) {


                            var html = '<option value="">Choose Employee</option>';

                            var i;
                            if (data.length > 0) {

                                for (i = 0; i < data.length; i++) {

                                    html += '<option value="' + data[i].id + '">' + data[i].name +
                                        '</option>';
                                }

                            } else {
                                var html = '<option value="">Choose Employee</option>';
                                toastr.error('data not found');
                            }


                            $('#showEmployee').html(html);

                        },

                        error: function() {

                            toastr.error('db error');


                        }

                    });
                });

                $('select[name=emp_id]').change(function() {
                    var emp_id = $('select[name=emp_id]').val();
                    $.ajax({
                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('/getEmpInfo') }}',
                        data: {
                            emp_id: emp_id
                        },
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            $('input[name=email]').val(data.email);
                            $('input[name=name]').val(data.name);
                        },
                        error: function() {
                            toastr.error('db error');
                        }
                    });
                });





                $('#userForm').on('submit', function(e) {
                    e.preventDefault();

                    let formData = new FormData($('#userForm')[0]);

                    $.ajax({
                        type: "POST",
                        url: '{{ url('create-user') }}',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('.user_btn').text('Saving...');
                            $(".user_btn").prop("disabled", true);
                        },
                        success: function(data) {
                            if (data.success) {
                                $('#userForm')[0].reset();
                                toastr.success(data.success);
                                $('.user_btn').text('Save');
                                $(".user_btn").prop("disabled", false);
                                window.location.reload();
                            } else {
                                toastr.error(data.errors);
                                $('.user_btn').text('Save');
                                $(".user_btn").prop("disabled", false);
                            }
                        },
                        error: function() {
                            toastr.error('something went wrong');
                            $('.user_btn').text('Save');
                            $(".user_btn").prop("disabled", false);
                        }
                    });


                });






                $('select[name=change_role_id]').change(function() {
                    var role_id = $('select[name=change_role_id]').val();

                    if (role_id == 1) {
                        $(".module_section").css("display", "block");
                    } else {
                        $(".module_section").css("display", "none");
                    }




                });
                $('select[name=role_id]').change(function() {
                    var role_id = $('select[name=role_id]').val();

                    if (role_id == 1) {
                        $(".module_section").css("display", "block");
                    } else {
                        $(".module_section").css("display", "none");
                    }




                });
            });
        </script>
    @endsection
