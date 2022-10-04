@extends('setup.master')

@section('content')

<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

{{--        <div class="page-header">--}}
{{--            <div class="row align-items-center">--}}

{{--                <div class="col-auto float-right ml-auto">--}}
{{--                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_department"><i class="fa fa-plus"></i> Add Designation</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}



        <div class="page-menu">
            <div class="row">
                <div class="col-sm-10 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- <h4 class="card-title">Solid justified</h4> -->
                            <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                                <li class="nav-item" style="display: flex">
                                    <a href="{{url('departments')}}" class="nav-link" onMouseOver="this.style.color='#8053CB'" onMouseOut="this.style.color='green'" href="{{url('att-dashboard')}}">Departments</a>
                                    <a href="{{url('designation')}}"  class="nav-link" onMouseOver="this.style.color='#8053CB'" onMouseOut="this.style.color='green'" href="{{url('att-dashboard')}}">Designation</a>
                                    <a class="nav-link"  style="display: inline-block;
                              text-align: right;
                              width: 100%;" href="#" class="btn add-btn" onMouseOver="this.style.color='#8053CB'" onMouseOut="this.style.color='green'" data-toggle="modal" data-target="#add_department">Add Designation</a>


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
                                        <th>Department </th>
                                        <th>Designation</th>
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
                    <h5 class="modal-title">Add Designation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalDismiss">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="" id="desigForm" class="needs-validation" novalidate>
                        @csrf

                        <div class="form-group">
                            <label>Dept <span class="text-danger">*</span></label>
                            <select class="select" name="dept_id" id="deptId" required>
                                <option value="">Choose Dept</option>
                                @isset($data)
                                @foreach($data['dept'] as $dept)
                                <option value="{{$dept->id}}">{{$dept->departments}}</option>
                                @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Department Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="desig_name" placeholder="Designation Name" required>
                            <div class="invalid-feedback">
                                Please enter Designation name.
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn " type="submit">Save</button>
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
                    <h5 class="modal-title">Edit Designation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnDissmissEdit">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="desigEditForm" method="post">
                        <input type="hidden" name="dept_id">
                        <div class="form-group">
                            <label>Designation Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="edit_desig_name">
                            <input class="form-control" type="hidden" name="hiiden_desig_id">
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary btn-update" type="button">Update</button>
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
                        <h3>Delete Designation</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:void(0);" class="btn btn-primary continue-btn deleteNow">Delete</a>
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



<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        getDesignation();

        function getDesignation() {
            $.ajax({
                url: '{{url("/designationList")}}',
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
                            '<td>' + data[i].departments + '</td>' +

                            '<td>' + data[i].desig_name + '</td>' +
                            '<td>' + data[i].created_at + '</td>' +

                            '<td class="text-right">' +
                            '<div class="dropdown dropdown-action">' +
                            '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a class="dropdown-item btn-edit" href="#" data-toggle="modal"  data="' + data[i].id + '"><i class="fa fa-pencil m-r-5n "></i> Edit</a>' +
                            '<a class="dropdown-item btn-delete" href="#" " data="' + data[i].id + '"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>' +
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

        // save designation
        $('#desigForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $('#desigForm').serialize();
            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{url("save-desig")}}',
                data: formData,
                async: false,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        getDesignation();
                        $('#desigForm')[0].reset();
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

        $('#deptTable').on('click', '.btn-delete', function() {


            var id = $(this).attr('data');
            $('#delete_department').modal('show');

            $('.deleteNow').on('click', function() {


                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{url("delete-designation")}}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {


                        if (data.success) {
                            getDesignation();
                            toastr.success(data.success);
                            $('#delete_department').modal('hide');
                        }




                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });


        });

        //edit data
        $('#deptTable').on('click', '.btn-edit', function() {


            var id = $(this).attr('data');
            $('#edit_department').modal('show');

            $.ajax({

                type: 'ajax',
                method: 'get',
                url: '{{url("edit-designation")}}',
                data: {
                    id: id
                },
                async: false,
                dataType: 'json',
                success: function(data) {

                    $('input[name=hiiden_desig_id]').val(data.id);
                    $('input[name=edit_desig_name]').val(data.desig_name);



                },

                error: function() {

                    toastr.error('something went wrong');

                }

            });




        });



        //update designation
        $('.btn-update').on('click', function() {


            var formData = $('#desigEditForm').serialize();

            $.ajax({

                type: 'ajax',
                method: 'get',
                url: '{{url("update-desig")}}',
                data: formData,
                async: false,
                dataType: 'json',
                success: function(data) {

                    getDesignation();
                    $('#edit_department').modal('hide');
                    toastr.success('Record updated successfully');



                },

                error: function() {
                    toastr.error('something went wrong');

                }

            });

        });

        //Datatables
        $('#datatable').DataTable();
    });
</script>

@endsection
