@extends('setup.master')

@section('content')




    <div class="main-wrapper">


        <!-- /Sidebar -->

        <!-- Page Wrapper -->
        <div class="page-wrapper">

            <!-- Page Content -->
            <div class="content container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Daily Attendance Report</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Daily Attendance Report</li>
                            </ul>
                        </div>
                    </div>

                </div>
                <!-- /Page Header -->



                <div class="card">
                    <div class="card-body">

                        <form action="{{ url('daily-att-report') }}" method="POST" id="searchAtt">

                            @csrf
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">

                                        <select name="company_id" class="form-control selectpicker" data-container="body"
                                            data-live-search="true" required>
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

                                        <input type="date" class="form-control " name="date_range" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-primary btn-search" type="button"> <i
                                            class="fa fa-search"></i></button>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>



                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0" id="datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Employee</th>
                                        <th>Date</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Status</th>
                                        <th>Marked By</th>
                                        <th>Guard</th>
                                    </tr>
                                </thead>
                                <tbody id="attReportTable">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- /Content End -->

            </div>
            <!-- /Page Content -->

        </div>
        <!-- /Page Wrapper -->



    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function() {


            // $('.btn-search').click(function(e) {
            //     e.preventDefault();

                // var formData = $('#searchAtt').serialize();

                $('.btn-search').click(function(e) {
                e.preventDefault();

                let formData = new FormData($('#searchAtt')[0]);

                $.ajax({

                    type: "POST",
                    url: '{{ url('daily-att-report') }}',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.btn-search').text('Searching...');
                        $(".btn-search").prop("disabled", true);
                    },
                    success: function(report) {


                        var html = '';
                        var i;
                        var c = 0;

                        for (i = 0; i < report.length; i++) {

                            (report[i]['status'] == 'Present') ? className = 'success':
                                className = 'danger';
                            c++;
                            html += '<tr>' +
                                '<td>' + c + '</td>' +
                                '<td>' +
                                '<h2 class="table-avatar">' +
                                '<a href="#"><img alt="" class="target-img" src="storage/app/public/uploads/staff-images/' +
                                report[i].image + '"></a>' +
                                '<a href="#">' + report[i]['name'] + '</a>' +
                                '</h2>' +
                                '</td>' +
                                '<td>' + report[i]['date'] + '</td>' +
                                '<td>' + report[i]['created_at'] + '</td>' +
                                '<td>' + report[i]['checkout'] + '</td>' +
                                '<td>' +
                                '<span class="badge bg-inverse-' + className + '">' + report[i][
                                    'status'
                                ] + '</span>' +
                                '</td>' +
                                '<td><span class="badge bg-inverse-info">' + report[i][
                                    'marked_by'
                                ] + '</span></td>' +
                                '<td><span class="badge bg-inverse-primary">' + report[i][
                                    'guard'
                                ] + '</span></td>' +
                                '</tr>';
                        }
                        $('#attReportTable').html(html);
                    },

                    complete: function(data) {
                        $(".btn-search").html('<i class="fa fa-search"></i>');
                        $(".btn-search").prop("disabled", false);
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.btn-search').text('Searching...');
                        $(".btn-search").prop("disabled", true);
                    },

                });
            })

        });
    </script>

@endsection
