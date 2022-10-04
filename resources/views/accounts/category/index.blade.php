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
                    <h3 class="page-title bold-heading">Category</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Category</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_category_modal" title="Give Feedback"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">




                    <table class="table table-striped table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category </th>
                                <th>Created At </th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tbody id="categoryTable">

                        </tbody>
                    </table>

            </div>
        </div>

        <!-- /Page Content -->


        <!-- Add Cateogory -->
        <div id="add_category_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" id="AddCategoryForm" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" placeholder="Category Name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Cateogory -->


        <!-- Edit Cateogory -->
        <div id="edit_category_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" id="EditCategoryForm" class="needs-validation" novalidate>
                            <input type="hidden" name="category_id">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" placeholder="Category Name" required>
                                    </div>
                                </div>

                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn category_update" type="button">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Cateogory -->


    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            getCategory();

            function getCategory() {

                $.ajax({

                    url: '{{url("/get-category")}}',
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
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a class="dropdown-item btn_edit_category" href="#" data-toggle="modal"  data="' + data[i].id + '"><i class="fa fa-pencil m-r-5n "></i> Edit</a>' +
                                '<a class="dropdown-item btn_delete_category" href="#" " data="' + data[i].id + '"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +

                                '</tr>';
                        }


                        $('#categoryTable').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }


            // save category
            $('#AddCategoryForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $('#AddCategoryForm').serialize();

                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{url("save-category")}}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function(data) {


                        if (data.success) {
                            $('#AddCategoryForm')[0].reset();
                            $('#add_category_modal').modal('hide');
                            toastr.success(data.success);
                            getCategory();
                        }


                    },

                    error: function() {
                        toastr.error('something went wrong');

                    }

                });


            });


            //Edit category
            $('#categoryTable').on('click', '.btn_edit_category', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                $('#edit_category_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{url("edit-category")}}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('input[name=category_id]').val(data.id);
                        $('input[name=name]').val(data.name);
                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });

            //update category
            $('.category_update').on('click', function() {


                var formData = $('#EditCategoryForm').serialize();

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{url("update-category")}}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('#edit_category_modal').modal('hide');
                        toastr.success('categoy upated successfully');
                        getCategory();
                    },

                    error: function() {
                        toastr.error('something went wrong');

                    }

                });

            });

            // script for delete data
            $('#categoryTable').on('click', '.btn_delete_category', function(e) {
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
                            url: "{{ url('/delete-category/') }}/" + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status == 200) {
                                    toastr.success('data deleted successuflly');
                                    getCategory();
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
