@extends('setup.master')
@section('content')

    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Leaves</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Leaves</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_leave"
                            title="Create Leave Request"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Leave Statistics -->
            <div class="row">
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Total Leaves</h6>
                        <h4>{{ $data['totalLeaves'] }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Consume Leaves</h6>
                        <h4>{{ $data['consumeLeaves']->count() }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Remaining Leaves</h6>
                        <h4>
                            <h4>{{ $data['RemainingLeaves'] }}</h4>
                        </h4>
                    </div>
                </div>

            </div>
            <!-- /Leave Statistics -->

            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="table-responsive">

                                <table class="table table-striped" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Leave Type</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Reason</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Created At</th>
                                            <th class="text-center">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody id="leaveTable">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /Page Content -->



        <!-- Add Leave Modal -->
        <div id="add_leave" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Leave</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" id="leaveForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Leave Type <span class="text-danger">*</span></label>
                                        <select class="select" name="leave_type_id" required>
                                            <option value="">Select Leave Type</option>
                                            @isset($data)
                                                @foreach ($data['leaveTypes'] as $leaveTypes)
                                                    <option value="{{ $leaveTypes->id }}">{{ $leaveTypes->laeve_type }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>From <span class="text-danger">*</span></label>
                                        <input class="form-control" type="date" name="from" required id="fromDate">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>To <span class="text-danger">*</span></label>
                                        <input class="form-control " type="date" name="to" required id="toDate">

                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Number of days <span class="text-danger">*</span></label>
                                        <input class="form-control" readonly type="text" name="numberOfDays" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Remaining Leaves <span class="text-danger">*</span></label>
                                        <input class="form-control" readonly type="text" name="remining" required>
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Leave Reason <span class="text-danger">*</span></label>
                                        <textarea rows="2" cols="3" class="form-control" name="reason" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn" type="submit">Send Request</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Leave Modal -->



        <!-- Edit Leave Modal -->
        <div id="edit_leave_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Leave</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="" class="needs-validation" novalidate id="EditLeaveForm">
                            <!-- @csrf -->

                            <input type="hidden" name="leave_id">

                            <div class="form-group">
                                <label>Leave Type <span class="text-danger">*</span></label>
                                <select class="select" name="leave_type" required>
                                    <option value="">Select Leave Type</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>From <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control" type="date" name="from" required id="fromDate">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>To <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control" type="date" name="to" required id="toDate">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Leave Reason <span class="text-danger">*</span></label>
                                <textarea rows="4" class="form-control" name="reason" required></textarea>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn udpate_leave" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Leave Modal -->



    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {


            $('#leaveForm').validate({

                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });



            $('#toDate').change(function() {
                var fromDate = new Date($('input[name=from]').val());
                var toDate = new Date($('input[name=to]').val());
                var Difference_In_Time = toDate.getTime() - fromDate.getTime();
                var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

                $('input[name=numberOfDays]').val(Difference_In_Days);

                getReminingLeaves(Difference_In_Days);
            });


            getLeaves();

            function getLeaves() {
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('getLeavesList') }}',
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        var html = '';
                        var i;
                        var c = 0;
                        var class_name = '';

                        for (i = 0; i < data.length; i++) {
                            (data[i].leave_status == 'APPROVED') ? class_name = 'text-success':
                                class_name = 'text-danger';
                            c++;

                            html += '<tr>' +
                                '<td>' +
                                '<h2 class="table-avatar">' +

                                ' <a href="{{ url('my-profile') }}"><img class="target-img" alt="" src="storage/app/public/uploads/staff-images/' +
                                data[i].image + '"></a>' +

                                ' <a>' + data[i].emp_name + ' <span>' + data[i].desig_name +
                                '</span></a>' +
                                ' </h2>' +
                                '</td>' +
                                '<td>' + data[i].laeve_type + '</td>' +
                                '<td>' + data[i].from + '</td>' +
                                '<td>' + data[i].to + '</td>' +
                                '<td>' + data[i].reason + '</td>' +
                                '<td class="text-center">' +
                                '<div class="dropdown action-label">' +
                                ' <span class="badge bg-inverse-success">' + data[i].leave_status +
                                '</span>' +
                                '</td>' +
                                '<td>' + data[i].created_at + '</td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a href="#" class="dropdown-item btn_edit_leave" data="' + data[i].id +
                                '" id="btn_edit_clients"><i class="fa fa-pencil m-r-5n "></i> Edit</a>' +
                                '<a href="" class="dropdown-item btn_delete_leave" data="' + data[i]
                                .id +
                                '" id="btn_delete_clients"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>' +

                                '</tr>';
                        }


                        $('#leaveTable').html(html);

                    },

                    error: function() {
                        toastr.error('something went wrong');

                    }

                });
            }

            function getReminingLeaves(numberOfDays) {
                var leave_type_id = $('select[name=leave_type_id]').val();
                $.ajax({
                    url: '{{ url('/getReminingLeaves') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    data: {
                        leave_type_id: leave_type_id
                    },
                    beforeSend: function() {
                        $(".btn-submit").prop("disabled", true);
                        $(".btn-submit").html("please wait...");
                    },
                    success: function(data) {
                        var remining = (data - parseInt(numberOfDays));
                        $('input[name=remining]').val(remining);
                        if (remining < 0) {
                            toastr.error('Your leave balance is low');
                            $(".submit-btn").prop("disabled", true);
                        } else {
                            $(".submit-btn").prop("disabled", false);
                        }
                    },
                    complete: function(data) {
                        $(".btn-submit").html("Send Request");
                        $(".btn-submit").prop("disabled", false);
                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }


            //save leave
            $('#leaveForm').on('submit', function(e) {
                e.preventDefault();

                var $form = $(this);
                // check if the input is valid
                if (!$form.validate().form()) return false;

                let formData = new FormData($('#leaveForm')[0]);

                $.ajax({
                    type: "POST",
                    url: '{{ url('leaves') }}',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.btn-submit').text('Saving...');
                        $(".btn-submit").prop("disabled", true);
                    },
                    success: function(data) {
                        if (data.success) {
                            getLeaves();
                            $('#leaveForm')[0].reset();
                            $('#modalDismiss').click();
                            toastr.success('Leave request submit successfully');
                            $('.btn-submit').text('Send Request');
                            $(".btn-submit").prop("disabled", false);
                        }
                        if (data.errors) {
                            toastr.error('missing some fields');
                            $('.btn-submit').text('Send Request');
                            $(".btn-submit").prop("disabled", false);
                        }
                    },
                    complete: function(data) {
                        $(".btn-submit").html("Send Request");
                        $(".btn-submit").prop("disabled", false);
                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }
                });
            });
            //Edit leaves
            $('#leaveTable').on('click', '.btn_edit_leave', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                $('#edit_leave_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('edit-leaves') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('input[name=leave_id]').val(data.id);


                        // $('select[name=leave_type]').val(data.leave_type);

                        $('select[name="leave_type"]')
                            .append(
                                `<option value="Casual Leave 12 Days" ${'Casual Leave 12 Days' == data.leave_type ? 'selected' : ''}>Casual Leave 12 Days</option>` +
                                `<option value="Medical Leave" ${'Medical Leave' == data.leave_type ? 'selected' : ''}>Medical Leave</option>` +
                                `<option value="Loss of Pay" ${'Loss of Pay' == data.leave_type ? 'selected' : ''}>Loss of Pay</option>`
                            );


                        $('input[name=from]').val(data.from);
                        $('input[name=to]').val(data.to);
                        $('textarea[name=reason]').val(data.reason);
                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });
            //Update leaves
            $('.udpate_leave').on('click', function(e) {
                e.preventDefault();
                $('.udpate_leave').text('Updating...');

                let EditFormData = new FormData($('#EditLeaveForm')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('/update-leaves') }}",
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(response) {

                        if (response.status == 200) {
                            getLeaves();
                            $("#edit_leave_modal").modal('hide');
                            $('#EditLeaveForm').find('input').val("");
                            $('.udpate_leave').text('Update');
                            toastr.success(response.message);
                            // window.location.reload();
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.udpate_leave').text('Update');
                    }
                });

            });
            // Delete Leaves
            $('#leaveTable').on('click', '.btn_delete_leave', function(e) {
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
                            url: "{{ url('/delete-leaves/') }}/" + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {
                                toastr.success(response.message);
                                getLeaves();
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
