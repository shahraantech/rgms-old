@extends('setup.master')

@section('content')

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    </head>
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Employee Expenses</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employee Expenses</li>
                        </ul>
                    </div>


                </div>
            </div>
            <!-- /Page Header -->

            <!-- Search Filter -->
            <div class="card">
                <div class="card-body">
                    <h5>Search Expenses</h5>
                    <form action="{{ url('expense') }}" method="post" id="searchForm">
                        @csrf
                        <input type="hidden" name="getdata" value="1">
                        <div class="row">
                            <div class="col-md-5">
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
                            <div class="col-md-5">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" placeholder="Search Name">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary expence_serach">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Search Filter -->

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" id="bb">

                                <table class="table table-striped table-responsive mb-0" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Employee</th>
                                            <th>Expense Type</th>
                                            <th>Cost</th>
                                            <th>Bill</th>
                                            <th>Expense Period</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody id="showExpense">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /Page Content -->


    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {

            expensesList();

            function expensesList() {

                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('expense') }}',
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        var html = '';
                        var i;
                        var c = 0;
                        var status_class = '';

                        for (i = 0; i < data.length; i++) {

                            c++;
                            (data[i].status == 'APPROVED') ? status_class = 'text-success':
                                status_class = 'text-danger';

                            html += '<tr>' +
                                '<td>' + c + '</td>' +
                                '<td>' +
                                '   <h2 class="table-avatar">' +
                                '  <a href="#"><img alt="" class="target-img" src="storage/app/public/uploads/staff-images/' +
                                data[i].image + '"></a>' +
                                ' <a href="#">' + data[i].name + '<span>' + data[i].desig_name +
                                '</span></a>' +
                                ' </h2>' +
                                ' </td>' +
                                '<td>' + data[i].expense_type + '</td>' +
                                ' <td>' + data[i].expense_amount + '</td>' +
                                ' <td><img src="{{ asset('storage/app/public/uploads/expense-bills') }}/' +
                                data[i].expense_bill +
                                '" style="height:45px; width:50px" class="img img-thumbnail"></td>' +
                                '<td>' + data[i].expense_period + '</td>' +
                                '<td>' + data[i].expense_desc + '</td>' +
                                '<td>' + data[i].created_at + '</td>' +

                                '<td class="text-center">' +
                                '<div class="action-label">' +
                                '<a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">' +
                                '<i class="fa fa-dot-circle-o ' + status_class + '"></i>' + data[i]
                                .status + '</a>' +
                                '</div> </td>' +

                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a class="dropdown-item btn-approve" href="#"  status="approved" data="' +
                                data[i].id + '"><i class="fa fa-pencil m-r-5n "></i> Approve</a>' +
                                '<a class="dropdown-item btn-approve" href="#" status="reject" " data="' +
                                data[i].id + '"><i class="fa fa-trash-o m-r-5 "></i> Reject</a>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +
                                '</tr>';
                        }

                        $('#showExpense').html(html);

                    },

                    error: function() {
                        toastr.error('something went wrong');

                    }

                });
            }


            //ajax call for serach record

            $('#searchForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData($('#searchForm')[0]);

                $.ajax({
                    type: "POST",
                    url: '{{ url('expense') }}',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.expence_serach').text('Searching...');
                        $(".expence_serach").prop("disabled", true);
                    },
                    success: function(data) {

                        var html = '';
                        var i;
                        var c = 0;
                        var status_class = '';

                        for (i = 0; i < data.length; i++) {

                            c++;
                            (data[i].status == 'APPROVED') ? status_class = 'text-success':
                                status_class = 'text-danger';

                            html += '<tr>' +
                                '<td>' + c + '</td>' +
                                '<td>' +
                                '   <h2 class="table-avatar">' +
                                '  <a href="#"><img alt="" class="target-img" src="storage/app/public/uploads/staff-images/' +
                                data[i].image + '"></a>' +
                                ' <a href="#">' + data[i].name + '<span>' + data[i].desig_name +
                                '</span></a>' +
                                ' </h2>' +
                                ' </td>' +
                                '<td>' + data[i].expense_type + '</td>' +
                                ' <td>' + data[i].expense_amount + '</td>' +
                                ' <td><img src="{{ asset('storage/app/public/uploads/expense-bills') }}/' +
                                data[i].expense_bill +
                                '" style="height:45px; width:50px" class="img img-thumbnail"></td>' +
                                '<td>' + data[i].expense_period + '</td>' +
                                '<td>' + data[i].expense_desc + '</td>' +
                                '<td>' + data[i].created_at + '</td>' +

                                '<td class="text-center">' +
                                '<div class="action-label">' +
                                '<a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">' +
                                '<i class="fa fa-dot-circle-o ' + status_class + '"></i>' +
                                data[i].status + '</a>' +
                                '</div> </td>' +

                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a class="dropdown-item btn-approve" href="#"  status="approved" data="' +
                                data[i].id +
                                '"><i class="fa fa-pencil m-r-5n "></i> Approve</a>' +
                                '<a class="dropdown-item btn-approve" href="#" status="reject" " data="' +
                                data[i].id +
                                '"><i class="fa fa-trash-o m-r-5 "></i> Reject</a>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +
                                '</tr>';
                        }

                        $('#showExpense').html(html);
                        $('.expence_serach').text('Search');
                        $(".expence_serach").prop("disabled", false);

                    },
                    error: function() {
                        toastr.error('something went wrong');

                    },
                });
            });


            $('#showExpense').on('click', '.btn-approve', function() {
                var id = $(this).attr('data');
                var status = $(this).attr('status');


                $.ajax({

                    url: '{{ url('/update-expense-status') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(data) {
                        if (data.success) {
                            expensesList();
                            toastr.success(data.success);
                        }

                    },
                    error: function() {
                        toastr.success('Save changes successfully');
                    }

                });

            });

            //Datatables
            $('#datatable').DataTable();

        });
    </script>

@endsection
