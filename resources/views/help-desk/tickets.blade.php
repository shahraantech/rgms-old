@extends('setup.master')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Tickets</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tickets</li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="card-group m-b-30">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Declined Tickets</span>
                                </div>
                                @php
                                $declinedTickets=$data['declineTickets']? $data['declineTickets']:0;
                                if($data['totalTickets']==0){
                                $devidedBy=1;
                                }else{
                                $devidedBy= $data['totalTickets'];
                                }
                                $newProgress=round(($declinedTickets*100)/$devidedBy,2);
                                @endphp
                                <div>
                                    <span class="text-success">{{$newProgress}}%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">{{$declinedTickets}}</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$newProgress}}%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Solved Tickets</span>
                                </div>
                                <div>
                                    @php
                                    $completeTickets=$data['completeTickets']? $data['completeTickets']:0;
                                    $completeProgress=($completeTickets*100)/$devidedBy;
                                    @endphp
                                    <span class="text-success">{{round($completeProgress,2)}}%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">{{$completeTickets}}</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$completeProgress}}%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Pending Tickets</span>
                                </div>
                                <div>
                                    @php
                                    $pendingTickets=$data['pendingTickets']? $data['pendingTickets']:0;
                                    $pendingProgress=($pendingTickets*100)/$devidedBy;
                                    @endphp
                                    <span class="text-success">{{round($pendingProgress,2)}}%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">{{$pendingTickets}}</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$pendingProgress}}%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Total Tickets</span>
                                </div>
                                <div>
                                    <span class="text-success">{{round($completeProgress,2)}}%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">{{( $data['totalTickets']? $data['totalTickets']:0)}}</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$completeProgress}}%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Search Filter -->
        <div class="card">
            <div class="card-body">
                <form action="{{url('ticket')}}" method="post" id="searchForm">
                    @csrf
                    <div class="row filter-row">
                        <div class="col-md-3 col-sm-4">
                            <div class="form-group form-focus">
                                <select class="select p-3" name="company_id">
                                    <option value="">Choose Comapny</option>
                                    @isset($data['company'])
                                    @foreach($data['company'] as $comp)
                                    <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                    @endforeach
                                    @endisset
                                </select>

                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <div class="form-group form-focus">

                                <select class="livesearch form-control p-3" name="emp_id">
                                    <option value="">Choose Employee</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-2 col-sm-4">
                            <div class="form-group form-focus select-focus">
                                <select class="select floating" name="status">
                                    <option value=""> -- Status -- </option>
                                    <option value="complete"> Complete </option>
                                    <option value="new"> New </option>
                                    <option value="pending"> Pending </option>
                                    <option value="decline"> Decline </option>
                                    <option value="open"> Open </option>

                                </select>
                                <label class="focus-label"></label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-4">
                            <div class="form-group form-focus select-focus">
                                <select class="select floating" name="periorty">
                                    <option value=""> -- Priority -- </option>
                                    <option value="high"> High </option>
                                    <option value="low"> Low </option>
                                    <option value="medium"> Medium </option>
                                </select>
                                <label class="focus-label"></label>
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-4">
                            <button class="btn btn-success btn-block" type="submit"> Search </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Search Filter -->


        <div class="card">
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="table-responsive">

                            <table class="table table-striped table-responsive" id="datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ticket Id</th>
                                        <th>Employee</th>
                                        <th>Ticket Subject</th>
                                        <th>Desc</th>

                                        <th>Created Date</th>

                                        <th>Priority</th>
                                        <th class="text-center">Status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody id="ticketTable">

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


<script type="text/javascript">
    $('.livesearch').select2({

        ajax: {
            url: '{{url("ajax-autocomplete-search")}}',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                console.log(data);
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
</script>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        getTickets();

        function getTickets() {


            $.ajax({

                url: '{{url("/ticket-list")}}',
                type: 'get',
                async: false,
                dataType: 'json',
                success: function(data) {

                    var html = '';
                    var i;
                    var c = 0;
                    var status_class = '';

                    for (i = 0; i < data.length; i++) {
                        (data[i].status == 'COMPLETE') ? status_class = 'bg-success': status_class = 'bg-danger';
                        c++;
                        html += '<tr>' +
                            '<td>' + c + '</td>' +

                            '<td>#TKT-' + data[i].id + '</td>' +
                            ' <td>' +
                            ' <h2 class="table-avatar">' +
                            ' <a href="#"><img alt="" class="target-img" src="storage/app/public/uploads/staff-images/' + data[i].image + '"></a>' +
                            '   <a href="#">' + data[i].name + ' <span>' + data[i].desig_name + '</span></a>' +
                            ' </h2>' +
                            ' </td>' +
                            '<td>' + data[i].subject + '</td>' +

                            '<td>' + data[i].desc + '</td>' +
                            '<td>' + data[i].created_at + '</td>' +
                            '<td>' + data[i].periorty + '</td>' +
                            '<td><span class="badge ' + status_class + '" style="color:white"> ' + data[i].status + ' </span></td>' +
                            '<td class="text-right">' +
                            '<div class="dropdown dropdown-action">' +
                            '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a class="dropdown-item btn-status" href="javascript:" data="' + data[i].id + '" status="open"><i class="fa fa-clock-o m-r-5 text-success" ></i>Open</a>' +
                            '<a class="dropdown-item btn-status" href="javascript:" data="' + data[i].id + '" status="decline"><i class="fa fa-clock-o m-r-5 text-danger" ></i>Decline</a>' +
                            '<a class="dropdown-item btn-status" href="javascript:" data="' + data[i].id + '"  status="complete"><i class="fa fa-clock-o m-r-5 text-success"></i>Complete</a>' +
                            '<a class="dropdown-item btn-status" href="javascript:" data="' + data[i].id + '"  status="pending"><i class="fa fa-clock-o m-r-5 text-danger"></i>Pending</a>' +
                            '</div>' +
                            ' </div>' +
                            '</td>' +
                            '</tr>';
                    }


                    $('#ticketTable').html(html);

                },
                error: function() {
                    toastr.error('something went wrong');
                }

            });
        }

        //ajax call for save Record..
        $('.btn-save').on('click', function() {

            var formData = $('#ticketForm').serialize();

            $.ajax({

                type: 'ajax',
                method: 'post',
                url: '{{url("save-ticket")}}',
                data: formData,
                async: false,
                dataType: 'json',
                success: function(data) {


                    if (data.errors) {
                        toastr.error('missing some fields');
                    }

                    if (data.success) {
                        getTickets();
                        $('#ticketForm')[0].reset();
                        $('.btn-dismiss').click();
                        toastr.success('Success messages');
                    }

                },

                error: function() {
                    toastr.error('something went wrong');

                }

            });

        });

        //btnEditDept
        $('.btn-edit').on('click', function() {
            
            var id = $(this).attr('data');

            $.ajax({

                url: '{{url("/edit-grade")}}',
                type: 'get',
                async: false,
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(data) {

                    $('input[name=grade]').val(data.grade);
                    $('input[name=grade_cat]').val(data.grade_cat);
                    $('input[name=hidden_grade_id]').val(data.id);

                },
                error: function() {
                    toastr.success('Save changes successfully');
                }

            });

        })



        //btnUpdateDept
        $('.btn-update').on('click', function() {
            var formData = $('#gradeEditForm').serialize();


            $.ajax({

                url: '{{url("/update-grade")}}',
                type: 'post',
                async: false,
                dataType: 'json',
                data: formData,
                success: function(data) {

                    if (data.errors) {
                        toastr.error('missing some fileds');
                    }

                    if (data.success) {
                        getGrades();
                        $('#btnDissmissEdit').click();


                        toastr.success('Save changes successfully');
                    }

                },
                error: function() {
                    toastr.error('Something went wrong');
                }

            });

        })



        //btnEditDelete
        $('.btnDelete').on('click', function() {
            var id = $(this).attr('data');

            $('.btnDeleteNow').on('click', function() {

                $.ajax({

                    url: '{{url("/delete-grade")}}',
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(data) {

                        if (data.success) {
                            getGrades();
                            $('.btnSkip').click();
                            toastr.success('Record deleted successfully');
                        }

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            });

        })



        // update ticket status
        $('#ticketTable').on('click', '.btn-status', function() {
            var id = $(this).attr('data');
            var status = $(this).attr('status');


            $.ajax({

                url: '{{url("/update-ticket-status")}}',
                type: 'get',
                async: false,
                dataType: 'json',
                data: {
                    id: id,
                    status: status
                },
                success: function(data) {

                    if (data.success) {
                        getTickets();
                        toastr.success(data.success);
                        window.location.reload();
                    }

                },
                error: function() {
                    toastr.error('something went wrong');
                }

            });


        })



        //ajax call for serach record
        $('#searchForm').unbind().on('submit', function(e) {
            e.preventDefault();

            var formData = $('#searchForm').serialize();


            $.ajax({

                type: 'ajax',
                method: 'post',
                url: '{{url("ticket")}}',
                data: formData,
                async: false,
                dataType: 'json',
                beforeSend: function() {
                    $('.btn-submit').append("<img class='img-loader' style='height: 25px;width: 30px' src=public/assets/img/loader/loader.gif />").button();
                },

                success: function(data) {

                    var html = '';
                    var i;
                    var c = 0;
                    var status_class = '';

                    for (i = 0; i < data.length; i++) {
                        (data[i].status == 'COMPLETE') ? status_class = 'bg-success': status_class = 'bg-danger';
                        c++;
                        html += '<tr>' +
                            '<td>' + c + '</td>' +

                            '<td>#TKT-' + data[i].id + '</td>' +
                            '<tr>' +
                            '<td>' +
                            '<a href="#"><img alt="" class="target-img" src="storage/app/public/uploads/staff-images/' + data[i].image + '"></a>' +
                            '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td>' +
                            '<a class="ml-5" href="#">' + data[i].name + ' <span>' + data[i].desig_name + '</span></a>' +
                            '</td>'
                        '</tr>' +
                        '<td>' + data[i].subject + '</td>' +
                            '<td>' + data[i].desc + '</td>' +
                            '<td>' + data[i].created_at + '</td>' +
                            '<td>' + data[i].periorty + '</td>' +
                            '<td><span class="badge ' + status_class + '" style="color:white"> ' + data[i].status + ' </span></td>' +
                            '<td class="text-right">' +
                            '<div class="dropdown dropdown-action">' +
                            '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a class="dropdown-item btn-status" href="javascript:" data="' + data[i].id + '" status="open"><i class="fa fa-clock-o m-r-5 text-success" ></i>Open</a>' +
                            '<a class="dropdown-item btn-status" href="javascript:" data="' + data[i].id + '" status="decline"><i class="fa fa-clock-o m-r-5 text-danger" ></i>Decline</a>' +
                            '<a class="dropdown-item btn-status" href="javascript:" data="' + data[i].id + '"  status="complete"><i class="fa fa-clock-o m-r-5 text-success"></i>Complete</a>' +
                            '<a class="dropdown-item btn-status" href="javascript:" data="' + data[i].id + '"  status="pending"><i class="fa fa-clock-o m-r-5 text-danger"></i>Pending</a>' +
                            '</div>' +
                            ' </div>' +
                            '</td>' +
                            '</tr>';
                    }


                    $('#ticketTable').html(html);

                },
                error: function() {
                    toastr.error('something went wrong');

                },

                complete: function() {
                    $('.img-loader').remove();


                },

            });


        });

        //Datatables
        $('#datatable').DataTable();

    });
</script>

@endsection