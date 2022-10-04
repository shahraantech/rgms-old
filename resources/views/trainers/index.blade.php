@extends('setup.master')
@section('content')

<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Trainers</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Trainers</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_trainer" title="Give Feedback"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->



        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">

                            <table class="table table-striped mb-0 " id="datatable">
                                <thead>
                                    <tr>
                                        <th style="width: 30px;">#</th>
                                        <th>Name </th>
                                        <th>Contact Number </th>
                                        <th>Email </th>
                                        <th>Status </th>
                                        <th>Action </th>
                                    </tr>
                                </thead>
                                <tbody id="trainerTable">


                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- /Page Content -->


    <div id="add_trainer" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Trainer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{url('trainers')}}" id="trainerForm" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="f_name" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Last Name</label>
                                    <input class="form-control" type="text" name="l_name" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Password </label>
                                    <input class="form-control" type="password" name="password" required>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Phone </label>
                                    <input class="form-control" type="number" name="contact" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Status</label>
                                    <select class="select" name="status">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="4" name="desc" required></textarea>
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


    <!-- Edit Trainer Modal -->
    <div id="edit_trainer_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Trainer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="EditTrainerForm" class="needs-validation" novalidate>
                        <input type="hidden" name="trainer_id">
                        <!-- @csrf -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="f_name" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Last Name</label>
                                    <input class="form-control" type="text" name="l_name" required>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email" required>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Phone </label>
                                    <input class="form-control" type="number" name="contact" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Status</label>
                                    <select class="select" name="status" id="stat">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn upate_trainer" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Trainer Modal -->

</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- CDN for Sweet Alert -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type='text/javascript'>
    $(document).ready(function() {

        getTrainersList();

        //add trainer
        $('#trainerForm').on('submit', function(e) {
            e.preventDefault();

            var formData = $('#trainerForm').serialize();


            $.ajax({

                type: 'ajax',
                method: 'post',
                url: '{{url("trainers")}}',
                data: formData,
                async: false,
                dataType: 'json',
                success: function(data) {

                    if (data.success) {
                        getTrainersList();
                        $('#trainerForm')[0].reset();
                        $('.close').click();
                        toastr.success('Record save successfully');

                    }
                    if (data.error) {
                        $('.close').click();
                        toastr.error(data.error);
                    }


                },

                error: function() {
                    toastr.error('something went wrong');

                }

            });


        });


        function getTrainersList() {


            $.ajax({

                url: '{{url("/trainersList")}}',
                type: 'get',
                async: false,
                dataType: 'json',

                success: function(data) {
                    var html = '';
                    var i;
                    var c = 0;
                    var status = '';

                    for (i = 0; i < data.length; i++) {
                        if (data[i].status == 1) {
                            status = 'Deactive';
                        } else {
                            status = 'Active';
                        }
                        c++;

                        html += '<tr>' +
                            '<td>' + c + '</td>' +
                            ' <td>' +
                            ' <h2 class="table-avatar">' +
                            '  <a href="#"><img alt="" class="target-img" src="{{asset("storage/app/public/uploads/staff-images/user1-128x128.png")}}"></a>' +
                            '   <a href="#">' + data[i].f_name + ' <span>' + data[i].l_name + '</span></a>' +
                            ' </h2>' +
                            ' </td>' +
                            ' <td>' + data[i].contact + '</td>' +
                            ' <td>' + data[i].email + '</td>' +

                            ' <td>' + status + ' </td>' +
                            '<td class="text-right">' +
                            '<div class="dropdown dropdown-action">' +
                            '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a href="#" class="dropdown-item btn_edit_trainer" data="' + data[i].id + '" id="btn_edit_clients"><i class="fa fa-pencil m-r-5n "></i> Edit</a>' +
                            '<a href="" class="dropdown-item btn_delete_trainer" data="' + data[i].id + '" id="btn_delete_clients"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>' +

                            '</tr>';
                    }


                    $('#trainerTable').html(html);

                },
                error: function() {
                    toastr.error('something went wrong');
                }

            });
        }

        //Edit trainer
        $('#trainerTable').on('click', '.btn_edit_trainer', function(e) {
            e.preventDefault();

            var id = $(this).attr('data');

            $('#edit_trainer_modal').modal('show');

            $.ajax({

                type: 'ajax',
                method: 'get',
                url: '{{url("edit-trainers")}}',
                data: {
                    id: id
                },
                async: false,
                dataType: 'json',
                success: function(data) {

                    $('input[name=trainer_id]').val(data.id);
                    $('input[name=f_name]').val(data.f_name);
                    $('input[name=l_name]').val(data.l_name);
                    $('input[name=email]').val(data.email);
                    $('input[name=contact]').val(data.contact);

                    $('select[name="status"]')
                        .append(`<option value="0" ${'0' == data.status ? 'selected' : ''}>Active</option>` ,
                            `<option value="1" ${'1' == data.status ? 'selected' : ''}>Dactive</option>`
                        );
                },

                error: function() {

                    toastr.error('something went wrong');

                }

            });

        });


        //Update trainer
        $('.upate_trainer').on('click', function(e) {
            e.preventDefault();
            $('.upate_trainer').text('Updating...');

            let EditFormData = new FormData($('#EditTrainerForm')[0]);

            $.ajax({
                type: "POST",
                url: "{{ url('/update-trainers') }}",
                data: EditFormData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {

                    if (response.status == 200) {
                        $("#edit_trainer_modal").modal('hide');
                        $('#EditTrainerForm').find('input').val("");
                        $('.upate_trainer').text('Update');
                        toastr.success(response.message);
                        getTrainersList();
                    }
                },
                error: function() {
                    toastr.error('something went wrong');
                    $('.upate_trainer').text('Update');
                }
            });

        });


        // script for delete data
        $('#trainerTable').on('click', '.btn_delete_trainer', function(e) {
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
                        url: "{{ url('/delete-trainers/') }}/" + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                        success: function(response) {

                            toastr.success(response.message);

                            getTrainersList();
                        }
                    });
                }
            })

        });


        //Datatables
        $('#datatable').DataTable();

    });
</script>

@endsection