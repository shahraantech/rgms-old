@extends('setup.master')
@section('content')
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header my-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Builders</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Buildings List</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{url('/buildings')}}" class="btn add-btn" title="Add Buildings"><i class="fa fa-plus" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">


                <table class="table-striped table-hover" id="datatable">
                    <thead>
                        <tr>
                            <th># </th>
                            <th>Title </th>
                            <th>Plot# </th>
                            <th>Block </th>
                            <th>Size </th>
                            <th>Society </th>
                            <th>Created At </th>
                            <th>Action </th>
                        </tr>
                    </thead>
                    <tbody id="buildingTable">

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Edit Builder -->
    <div id="edit_building_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Builders</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="" id="EditBuildForm" class="needs-validation" novalidate>
                        <input type="hidden" name="build_id">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="title" placeholder="Builder Title" required>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Plot# <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="plot_no" placeholder="Builder Plot" required>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Block <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="block" placeholder="Builder Block" required>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Size <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="size" placeholder="Builder Size" required>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Society Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="society_name" placeholder="Society Name" required>
                                </div>
                            </div>

                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn builder_update" type="button">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- CDN for Sweet Alert -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {

        getBuilders();

        function getBuilders() {

            $.ajax({

                url: '{{url("/buildings-list")}}',
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
                            '<td><a href="building-cost-detail/'+data[i].id+'">' + data[i].title + '</td>' +
                            '<td>' + data[i].plot_no + '</td>' +
                            '<td>' + data[i].block + '</td>' +
                            '<td>' + data[i].size + '</td>' +
                            '<td>' + data[i].society_name + '</td>' +
                            '<td>' + data[i].created_at + '</td>' +
                            '<td class="text-right">' +
                            '<div class="dropdown dropdown-action">' +
                            '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a class="dropdown-item btn_edit_builder" href="#" data-toggle="modal"  data="' + data[i].id + '"><i class="fa fa-pencil m-r-5n "></i> Edit</a>' +
                            '<a class="dropdown-item btn_delete_builder" href="#" " data="' + data[i].id + '"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>' +
                            '</div>' +
                            '</div>' +
                            '</td>' +

                            '</tr>';
                    }


                    $('#buildingTable').html(html);

                },
                error: function() {
                    toastr.error('something went wrong');
                }

            });
        }

        //Edit builder
        $('#buildingTable').on('click', '.btn_edit_builder', function(e) {
            e.preventDefault();

            var id = $(this).attr('data');

            $('#edit_building_modal').modal('show');

            $.ajax({

                type: 'ajax',
                method: 'get',
                url: '{{url("edit-buildings")}}',
                data: {
                    id: id
                },
                async: false,
                dataType: 'json',
                success: function(data) {

                    $('input[name=build_id]').val(data.id);
                    $('input[name=title]').val(data.title);
                    $('input[name=plot_no]').val(data.plot_no);
                    $('input[name=block]').val(data.block);
                    $('input[name=size]').val(data.size);
                    $('input[name=society_name]').val(data.society_name);
                },

                error: function() {

                    toastr.error('something went wrong');

                }

            });

        });

        //update builder
        $('.builder_update').on('click', function() {

            var formData = $('#EditBuildForm').serialize();

            $.ajax({

                type: 'ajax',
                method: 'get',
                url: '{{url("update-buildings")}}',
                data: formData,
                async: false,
                dataType: 'json',
                success: function(data) {

                    $('#edit_building_modal').modal('hide');
                    toastr.success(data.message);
                    getBuilders();
                },

                error: function() {
                    toastr.error('something went wrong');

                }

            });

        });

        // script for delete data
        $('#buildingTable').on('click', '.btn_delete_builder', function(e) {
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
                        url: "{{ url('/delete-buildings/') }}/" + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status == 200) {
                                toastr.success(response.message);
                                getBuilders();
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
