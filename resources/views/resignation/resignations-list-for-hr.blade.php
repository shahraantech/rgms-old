@extends('setup.master')

@section('content')


    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Resignation</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Resignation</li>
                        </ul>
                    </div>


                </div>
            </div>
            <!-- /Page Header -->


            <!-- Search Filter... -->
            <div class="container py-4">
                <form action="" method="POST" id="searchForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <select name="emp_id" class="select">
                                <option value="" selected disabled>Choose Employee</option>
                                @isset($data['employees'])
                                    @foreach ($data['employees'] as $emp)
                                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="desg_id" class="select">
                                <option value="" selected disabled>Choose Departments</option>
                                @isset($data['department'])
                                    @foreach ($data['department'] as $depart)
                                        <option value="{{ $depart->id }}">{{ $depart->departments }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn_search_resig"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Search Filter... -->

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-responsive mb-0" id="datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Resigning Employee </th>
                                    <th>Department </th>
                                    <th>Reason </th>
                                    <th>Notice Date </th>
                                    <th>Resignation Date </th>
                                    <th>Status </th>
                                    <th>Created At </th>
                                    <th> Action</th>

                                </tr>
                            </thead>
                            <tbody id="resignationTable">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->


        <!-- Delete Resignation Modal -->
        <div class="modal custom-modal fade" id="delete_resignation" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Resignation</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal"
                                        class="btn btn-primary cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Resignation Modal -->

    </div>


    <script>
        $(document).ready(function() {
            getResignation();

            function getResignation() {


                $.ajax({

                    url: '{{ url('/resignationListData') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',

                    success: function(data) {

                        var html = '';
                        var i;
                        var c = 0;

                        for (i = 0; i < data.length; i++) {
                            var dat = data[i].created_at;

                            c++;
                            html += '<tr>' +
                                '<td>' + c + '</td>' +
                                '<td>' +
                                '<h2 class="table-avatar blue-link">' +

                                ' <a href="#"><img alt="" class="target-img" src="storage/app/public/uploads/staff-images/' +
                                data[i].image + '"></a>' +

                                '<a href="#">' + data[i].name + '</a>' +
                                '</h2>' +
                                '</td>' +
                                '<td>' + data[i].desig_name + '</td>' +

                                '<td>' + data[i].reason + '</td>' +
                                '<td>' + data[i].notice_date + '</td>' +
                                '<td>' + data[i].resign_date + '</td>' +
                                '<td>' + data[i].status + '</td>' +
                                '<td>' + data[i].created_at + '</td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a class="dropdown-item btn-status" href="#" data-toggle="modal" data-target="#edit_department" data="' +
                                data[i].id +
                                '" status="accept"><i class="fa fa-pencil m-r-5n "></i> Accept</a>' +
                                '<a class="dropdown-item btn-status" href="#" data-toggle="modal" data-target="#delete_department" data="' +
                                data[i].id +
                                '" status="reject"><i class="fa fa-trash-o m-r-5 "></i> Reject</a>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +


                                '</tr>';
                        }


                        $('#resignationTable').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }


            $('#resignationTable').on('click', '.btn-status', function() {
                var id = $(this).attr('data');
                var status = $(this).attr('status');

                $.ajax({

                    url: '{{ url('/update-resignation') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(data) {
                        getResignation();
                        toastr.success('Record updated successfully');

                    },
                    error: function() {
                        toastr.success('Save changes successfully');
                    }

                });

            });

            $('.btn-status').on('click', function() {
                var time_id = $(this).attr('data');

                $('.btnDeleteNow').on('click', function() {

                    $.ajax({

                        url: '{{ url('/delete-time') }}',
                        type: 'get',
                        async: false,
                        dataType: 'json',
                        data: {
                            id: time_id
                        },
                        success: function(data) {

                            if (data.success) {
                                getTimes();
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

            //ajax call for serach record

            $('#searchForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData($('#searchForm')[0]);


                $.ajax({
                    url: '{{ url('resignationListData') }}',
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.btn_search_resig').text('Searching...');
                        $(".btn_search_resig").prop("disabled", true);
                    },
                    success: function(data) {

                        var html = '';
                        var i;
                        var c = 0;

                        for (i = 0; i < data.length; i++) {
                            var dat = data[i].created_at;

                            c++;
                            html += '<tr>' +
                                '<td>' + c + '</td>' +
                                '<td>' +
                                '<h2 class="table-avatar blue-link">' +

                                ' <a href="#"><img alt="" class="target-img" src="storage/app/public/uploads/staff-images/' +
                                data[i].image + '"></a>' +

                                '<a href="#">' + data[i].name + '</a>' +
                                '</h2>' +
                                '</td>' +
                                '<td>' + data[i].desig_name + '</td>' +

                                '<td>' + data[i].reason + '</td>' +
                                '<td>' + data[i].notice_date + '</td>' +
                                '<td>' + data[i].resign_date + '</td>' +
                                '<td>' + data[i].status + '</td>' +
                                '<td>' + data[i].created_at + '</td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a class="dropdown-item btn-status" href="#" data-toggle="modal" data-target="#edit_department" data="' +
                                data[i].id +
                                '" status="accept"><i class="fa fa-pencil m-r-5n "></i> Accept</a>' +
                                '<a class="dropdown-item btn-status" href="#" data-toggle="modal" data-target="#delete_department" data="' +
                                data[i].id +
                                '" status="reject"><i class="fa fa-trash-o m-r-5 "></i> Reject</a>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +


                                '</tr>';
                        }


                        $('#resignationTable').html(html);
                        $('.btn_search_resig').html('<i class="fa fa-search"></i');
                        $(".btn_search_resig").prop("disabled", false);

                    },
                    error: function() {
                        toastr.error('something went wrong');

                    },
                });
            });

            //Datatables
            $('#datatable').DataTable();

        });
    </script>
@endsection
