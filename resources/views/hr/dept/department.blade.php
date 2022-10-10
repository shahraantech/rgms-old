@extends('setup.master')
@section('content')

    <style>
        .mouse:hover {
            background-color: yellow;
        }
    </style>

    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">Departments</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Departments</li>
                                </ul>
                            </div>
                            <div class="col-auto float-right ml-auto">
                                <a href="{{ url('/departments') }}" class="btn add-btn" title="Add Designation"
                                    data-toggle="modal" data-target="#add_department"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->


            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <table class="table table-striped mb-0" id="datatable">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px;">#</th>
                                            <th>Company Name</th>
                                            <th>Department Name</th>
                                            <th>Created At</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="deptTable">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
        <!-- Add Department Modal -->
        <div id="add_department" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Department</h5>
                        <button type="button" class="close btnSkip" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ url('save-department') }}" id="deptForm" class="needs-validation"
                            novalidate>
                            @csrf
                            <div class="form-group">
                                <label>Companies <span class="text-danger">*</span></label>
                                <select class="select" name="company_id" required>
                                    <option value="">Choose Company</option>
                                    @isset($data)
                                        @foreach ($data['companies'] as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                                <div class="invalid-feedback">
                                    Please choose company.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Department Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="dept_name" placeholder="Department Name"
                                    required>
                                <div class="invalid-feedback">
                                    Please enter department name.
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn btn-save-dept135 btn_department" type="submit"
                                    id="saveform">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Department Modal -->
        <!-- Edit Department Modal -->
        <div id="edit_department" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Department</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnDissmissEdit">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editDeptForm" method="post">
                            <input type="hidden" name="dept_id">
                            <div class="form-group">
                                <label>Companies <span class="text-danger">*</span></label>
                                <select class="select" name="company_id" required>
                                    <option value="" selected disabled>Choose Company</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please choose company.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Department Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="edit_dept_name">
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn update_department" id="btnUpdate"
                                    type="button">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Department Modal -->
        <!-- Delete Department Modal -->
        <div class="modal custom-modal fade" id="delete_department" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Department</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);"
                                        class="btn btn-primary continue-btn btnDeleteNow">Delete</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal"
                                        class="btn btn-primary cancel-btn btnSkip">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Department Modal -->
    </div>
    <script type="text/javascript" src="{{ asset('public/assets/js/custom-js/validations.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function() {
            getDept();

            function getDept() {

                $.ajax({

                    url: '{{ url('/get-department') }}',
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
                                '<td>' + data[i].get_company_name.name + '</td>' +
                                '<td>' + data[i].departments + '</td>' +

                                '<td>' + data[i].created_at + '</td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a class="dropdown-item btnEditDept" href="#" data-toggle="modal" data-target="#edit_department" data="' +
                                data[i].id + '"><i class="la la-pencil" style="font-size:20px;"></i></a>' +
                                '<a class="dropdown-item btnDelete" href="#" data-toggle="modal" data-target="#delete_department" data="' +
                                data[i].id + '"><i class="la la-trash" style="font-size:20px;"></i></a>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +

                                '</tr>';
                        }


                        $('#deptTable').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }

            $('#deptForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData($('#deptForm')[0]);

                $.ajax({
                    type: "POST",
                    url: '{{ url('save-department') }}',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.btn_department').text('Saving...');
                        $(".btn_department").prop("disabled", true);
                    },
                    success: function(data) {

                        if (data.success) {
                            getDept();
                            $('#deptForm')[0].reset();
                            $('#modalDismiss').click();
                            toastr.success(data.success);
                            $('.btn_department').text('Save');
                            $(".btn_department").prop("disabled", false);
                        }
                        if (data.errors) {
                            toastr.error(data.errors);
                            $('.btn_department').text('Save');
                            $(".btn_department").prop("disabled", false);
                        }
                    },

                    error: function() {
                        toastr.error('something went wrong');
                        $('.btn_department').text('Save');
                        $(".btn_department").prop("disabled", false);
                    }
                });


            });

            $('#deptTable').on('click', '.btnDelete', function() {
                var id = $(this).attr('data');
                $('.btnDeleteNow').unbind().click(function() {
                    $.ajax({
                        url: '{{ url('/delete-department') }}',
                        type: 'get',
                        async: false,
                        dataType: 'json',
                        data: {
                            id: id
                        },
                        success: function(data) {

                            if (data.success) {
                                getDept();
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

            $('#deptTable').on('click', '.btnEditDept', function() {

                var dept_id = $(this).attr('data');

                $.ajax({

                    url: '{{ url('/edit-department') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    data: {
                        id: dept_id
                    },
                    success: function(data) {

                        $('input[name=dept_id]').val(data.dept.id);

                        //edit dropdown in ajax
                        $.each(data.company, function(key, comp) {

                            $('select[name="company_id"]')
                                .append(
                                    `<option value="${comp.id}" ${comp.id == data.dept.company_id ? 'selected' : ''}>${comp.name}</option>`
                                )
                        });
                        $('input[name=edit_dept_name]').val(data.dept.departments);

                    },
                    error: function() {
                        toastr.success('Save changes successfully');
                    }

                });

            });



            $('.update_department').on('click', function(e) {
                e.preventDefault();


                let EditFormData = new FormData($('#editDeptForm')[0]);

                $.ajax({

                    type: "POST",
                    url: '{{ url('/update-department') }}',
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('.update_department').text('Saving...');
                        $(".update_department").prop("disabled", true);
                    },
                    success: function(data) {

                        if (data.errors) {
                            toastr.error(data.errors);
                            $('.update_department').text('Save Changes');
                            $(".update_department").prop("disabled", false);
                        }

                        if (data.success) {
                            getDept();
                            $('#btnDissmissEdit').click();
                            $('#editDeptForm')[0].reset();
                            toastr.success('Save changes successfully');
                            $('.update_department').text('Save Changes');
                            $(".update_department").prop("disabled", false);
                        }

                    },
                    error: function() {
                        toastr.error('Something went wrong');
                        $('.update_department').text('Save Changes');
                        $(".update_department").prop("disabled", false);
                    }

                });

            });

            //Datatables
            $('#datatable').DataTable();
        });
    </script>
@endsection
