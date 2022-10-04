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
                <div class="col-auto float-right ml-auto">
                </div>
            </div>
            <!-- /Page Header -->



            <div class="page-menu">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">

                        <ul class="nav nav-tabs nav-tabs-solid">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="{{url('departments')}}">Departments</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active"  href="{{url('designation')}}">Designation</a>
                            </li>

                            <li class="nav-item">


                                <a class="nav-link"  style="" href="#" class="btn add-btn" data-toggle="modal" data-target="#add_department">Add Department</a>
                            </li>





                        </ul>



                            </div>
                        </div>
                    </div>
                </div>
            </div>



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
                        <button type="button" class="close btnSkip" data-dismiss="modal" aria-label="Close" id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{url('save-department')}}" id="deptForm" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <label>Companies <span class="text-danger">*</span></label>
                                <select class="select" name="company_id" required>
                                    <option value="">Choose Company</option>
                                    @isset($data)
                                        @foreach($data['companies'] as $company)
                                            <option value="{{$company->id}}">{{$company->name}}</option>
                                        @endforeach
                                    @endisset
                                </select>
                                <div class="invalid-feedback">
                                    Please choose company.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Department Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="dept_name" required>
                                <div class="invalid-feedback">
                                    Please enter department name.
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn btn-save-dept135" type="submit" id="saveform">Save</button>
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
                                <button class="btn btn-primary submit-btn" id="btnUpdate" type="button">Update</button>
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
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn btnDeleteNow">Delete</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn btnSkip">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Department Modal -->
    </div>
    <script type="text/javascript" src="{{asset('public/assets/js/custom-js/validations.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function() {
            getDept();

            function getDept() {

                $.ajax({

                    url: '{{url("/get-department")}}',
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
                                '<a class="dropdown-item btnEditDept" href="#" data-toggle="modal" data-target="#edit_department" data="' + data[i].id + '"><i class="fa fa-pencil m-r-5n "></i> Edit</a>' +
                                '<a class="dropdown-item btnDelete" href="#" data-toggle="modal" data-target="#delete_department" data="' + data[i].id + '"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>' +
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

            $('#deptForm').unbind().on('submit', function(e) {
                e.preventDefault();
                var formData = $('#deptForm').serialize();
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{url("save-department")}}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        // if(data.errors) {
                        //     toastr.error(data.errors['dept_name']);
                        // }

                        if (data.success) {
                            getDept();
                            $('#deptForm')[0].reset();
                            $('#modalDismiss').click();
                            toastr.success(data.success);
                        }
                        if (data.errors) {
                            toastr.error(data.errors);
                        }



                    },

                    error: function() {
                        toastr.error('something went wrong');

                    }

                });


            });

            $('#deptTable').on('click', '.btnDelete', function() {
                var id = $(this).attr('data');
                $('.btnDeleteNow').unbind().click(function() {
                    $.ajax({
                        url: '{{url("/delete-department")}}',
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

                    url: '{{url("/edit-department")}}',
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
                                .append(`<option value="${comp.id}" ${comp.id == data.dept.company_id ? 'selected' : ''}>${comp.name}</option>`)
                        });
                        $('input[name=edit_dept_name]').val(data.dept.departments);

                    },
                    error: function() {
                        toastr.success('Save changes successfully');
                    }

                });

                $('#btnUpdate').unbind().click(function() {

                    var formData = $('#editDeptForm').serialize();


                    $.ajax({

                        url: '{{url("/update-department")}}',
                        type: 'get',
                        async: false,
                        dataType: 'json',
                        data: formData,
                        success: function(data) {

                            if (data.errors) {
                                toastr.error(data.errors);
                            }

                            if (data.success) {
                                getDept();
                                $('#btnDissmissEdit').click();
                                //$('#editDeptForm')[0].reset();

                                toastr.success('Save changes successfully');
                            }

                        },
                        error: function() {
                            toastr.error('Something went wrong');
                        }

                    });

                });
            });

            //Datatables
            $('#datatable').DataTable();
        });
    </script>
@endsection
