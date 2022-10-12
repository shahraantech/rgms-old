@extends('setup.master')
@section('content')

    <div class="page-wrapper">

        <style>
            .leave-img {
                width: 126%;
                border-radius: 40px;
            }
        </style>

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

                </div>
            </div>
            <!-- /Page Header -->

            <!-- Leave Statistics -->
            <div class="row">
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6> Leaves Request</h6>
                        <h4>{{ $data['totalRequest'] }} <span>This Month</span></h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Approved Request</h6>
                        <h4>{{ $data['approvedRequest'] }} <span>This Month</span></h4>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Pending Requests</h6>
                        <h4>{{ $data['pendingRequest'] }} <span>This Month</span></h4>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Decline Request</h6>
                        <h4>{{ $data['declineRequest'] }} <span>Today</span></h4>
                    </div>
                </div>
            </div>
            <!-- /Leave Statistics -->



            <!-- Search Filter -->
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('leaves-request') }}" method="post" id="searchForm">
                        @csrf
                        <input type="hidden" name="getdata" value="1">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="company_id" class="select">
                                        <option value="" selected disabled>Choose Company</option>
                                        @isset($data['company'])
                                            @foreach ($data['company'] as $comp)
                                                <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="dept_id" class="select">
                                        <option value="" selected disabled>Choose Department</option>
                                        @isset($data['department'])
                                            @foreach ($data['department'] as $dept)
                                                <option value="{{ $dept->id }}">{{ $dept->departments }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Search Employee Name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-search"><i
                                            class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Search Filter -->


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
                                            <th>Created At</th>
                                            <th class="text-center">Status</th>
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
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {

            getLeaves();

            function getLeaves() {
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('leaves-request') }}',
                    async: false,
                    dataType: 'json',
                    data: {
                        getdata: 1
                    },
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
                                ' <a href="#"><img alt="" class="target-img" src="storage/app/public/uploads/staff-images/' +
                                data[i].image + '"></a>' +
                                ' <a>' + data[i].emp_name + ' <span>' + data[i].desig_name +
                                '</span></a>' +
                                ' </h2>' +
                                '</td>' +
                                '<td>' + data[i].laeve_type + '</td>' +
                                '<td>' + data[i].from + '</td>' +
                                '<td>' + data[i].to + '</td>' +

                                '<td>' + data[i].reason + '</td>' +
                                '<td>' + data[i].created_at + '</td>' +
                                '<td class="text-center">' +
                                '<div class="dropdown action-label">' +
                                ' <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">' +
                                ' <i class="fa fa-dot-circle-o ' + class_name + '"></i> ' + data[i]
                                .leave_status + ' </a>' +

                                '       <div class="dropdown-menu dropdown-menu-right">' +

                                '           <a class="dropdown-item btn-status" id=' + data[i].id +
                                '  leave_status="0"><i class="fa fa-dot-circle-o text-info"></i> Pending</a>' +
                                '           <a class="dropdown-item btn-status" id=' + data[i].id +
                                '  leave_status="1" data-toggle="modal" data-target="#approve_leave"><i class="fa fa-dot-circle-o text-success"></i> Approved</a>' +
                                '           <a class="dropdown-item btn-status" id=' + data[i].id +
                                '  leave_status="2"><i class="fa fa-dot-circle-o text-danger"></i> Declined</a>' +
                                '       </div>' +
                                '   </div>' +
                                '</td>' +

                                '</tr>';
                        }
                        $('#leaveTable').html(html);
                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }
                });
            }

            //ajax call for serach record
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                // var formData = $('#searchForm').serialize();
                let formData = new FormData($('#searchForm')[0]);

                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ url('leaves-request') }}',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(".btn-search").prop("disabled", true);
                        $(".btn-search").html("please wait...");

                    },
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
                                ' <a href="#"><img alt="" class="target-img" src="storage/app/public/uploads/staff-images/' +
                                data[i].image + '"></a>' +
                                ' <a>' + data[i].emp_name + ' <span>' + data[i].desig_name +
                                '</span></a>' +
                                ' </h2>' +
                                '</td>' +
                                '<td>' + data[i].laeve_type + '</td>' +
                                '<td>' + data[i].from + '</td>' +
                                '<td>' + data[i].to + '</td>' +
                                '<td>2 days</td>' +
                                '<td>' + data[i].reason + '</td>' +
                                '<td class="text-center">' +
                                '<div class="dropdown action-label">' +
                                ' <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">' +
                                ' <i class="fa fa-dot-circle-o ' + class_name + '"></i> ' +
                                data[i].leave_status + ' </a>' +

                                '       <div class="dropdown-menu dropdown-menu-right">' +

                                '           <a class="dropdown-item btn-status" id=' + data[i]
                                .id +
                                '  leave_status="0"><i class="fa fa-dot-circle-o text-info"></i> Pending</a>' +
                                '           <a class="dropdown-item btn-status" id=' + data[i]
                                .id +
                                '  leave_status="1" data-toggle="modal" data-target="#approve_leave"><i class="fa fa-dot-circle-o text-success"></i> Approved</a>' +
                                '           <a class="dropdown-item btn-status" id=' + data[i]
                                .id +
                                '  leave_status="2"><i class="fa fa-dot-circle-o text-danger"></i> Declined</a>' +
                                '       </div>' +
                                '   </div>' +
                                '</td>' +

                                '</tr>';
                        }
                        $('#leaveTable').html(html);
                    },
                    complete: function(data) {
                        $(".btn-search").html('<i class="fa fa-search"></i>');
                        $(".btn-search").prop("disabled", false);
                    },
                    error: function() {
                        toastr.error('something went wrong');
                    },
                });
            });

            $('#leaveTable').on('click', '.btn-status', function() {
                var leave_status = $(this).attr('leave_status');
                var id = $(this).attr('id');
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('update-leave-request') }}',
                    data: {
                        id: id,
                        leave_status: leave_status
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (data.success) {
                            getLeaves();
                            toastr.success(data.success);

                        }


                    },

                    error: function() {

                        // toastr.error('something went wrong');

                    }

                });



            });
            //Datatables
            $('#datatable').DataTable();

        });
    </script>

@endsection
