@extends('setup.master')

@section('content')

<div class="main-wrapper">
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Job Applicants</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Job Applicants</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <!-- Search Filter -->
            <div class="card">
                <div class="card-body">
                    <form action="{{url('job-applicants')}}" method="post" id="searchForm">
                        @csrf
                        <div class="row filter-row">

                            <div class="col-md-3">
                                <div class="form-group form-focus">
                                    <input type="text" class="form-control floating" name="name">
                                    <label class="focus-label"> Name</label>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group form-focus">
                                    <input type="text" class="form-control floating" name="phone">
                                    <label class="focus-label">Phone</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
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
                            <div class="table-responsive">
                                <table class="table table-striped" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Apply Date</th>
                                            <th class="text-center">Status</th>
                                            <th>Resume</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="showApplicantsList">

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
    <!-- /Page Wrapper -->

</div>


<div id="scheduleInterview" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Schedule Interview</h5>
                <button type="button" class="close modalDismiss" data-dismiss="modal" aria-label="Close" id="btnDissmissEdit">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="interviewForm" method="post">
                    @csrf
                    <input type="hidden" name="dept_id">
                    <div class="form-group">
                        <label>Time <span class="text-danger">*</span></label>
                        <input class="form-control" type="hidden" name="hidden_applicant_id">
                        <input class="form-control" type="time" name="interview_time">
                    </div>
                    <div class="form-group">
                        <label>Date <span class="text-danger">*</span></label>

                        <input class="form-control" type="date" name="interview_date">
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn" id="btnSave" type="button">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {

        getApplicantsList();

        function getApplicantsList() {

            $.ajax({

                type: 'ajax',
                method: 'get',
                url: '{{url("getApplicantsList")}}',
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
                            ' <td>' + data[i].email + '</td>' +
                            '<td>' + data[i].phone + '</td>' +
                            ' <td>' + moment(data[i].created_at).format('DD-MMM-YYYY') + '</td>' +
                            ' <td class="text-center">' +
                            '<div class="dropdown action-label">' +
                            '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="fa fa-dot-circle-o text-success"></i>' + data[i].status + '</a>' +
                            '</div>' +
                            '</td>' +
                            ' <td><a href="{{url('/download-resume')}}/' + data[i].id + '" class="btn btn-sm btn-primary btnDownload" title="Download"><i class="fa fa-download"></i> </a></td>' +
                            '<td class="text-right">' +
                            '<div class="dropdown dropdown-action">' +
                            '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a class="dropdown-item btnInterview" href="javascript:" data="' + data[i].id + '"><i class="fa fa-clock-o m-r-5 text-success" ></i> Schedule Interview</a>' +
                            '<a class="dropdown-item btn-status" href="javascript:" data="' + data[i].id + '" status="Rejected"><i class="fa fa-clock-o m-r-5 text-danger" ></i> Rejected</a>' +
                            '<a class="dropdown-item btn-status" href="javascript:" data="' + data[i].id + '"  status="Short List"><i class="fa fa-clock-o m-r-5 text-success"></i> Short List</a>' +
                            '<a class="dropdown-item btn-status" href="javascript:" data="' + data[i].id + '"  status="hired"><i class="fa fa-clock-o m-r-5 text-success"></i> Hired</a>' +
                            '</div>' +
                            ' </div>' +
                            '</td>' +
                            '</tr>';
                    }


                    $('#showApplicantsList').html(html);

                },

                error: function() {
                    toastr.error('something went wrong');

                }

            });
        }

        $('#showApplicantsList').on('click', '.btnInterview', function() {


            var applicant_id = $(this).attr('data');
            $('input[name=hidden_applicant_id]').val(applicant_id);
            $('#scheduleInterview').modal('show');


        });

        //ajax call for Delete Record..
        $('#btnSave').on('click', function() {
            var formData = $('#interviewForm').serialize();

            $.ajax({

                type: 'ajax',
                method: 'post',
                url: '{{url("save-interview")}}',
                data: formData,
                async: false,
                dataType: 'json',
                success: function(data) {

                    if (data.errors) {

                        toastr.error(data.errors);
                        toastr.error(data.errors['interview_time'], data.errors['interview_date']);
                    }

                    if (data.success) {
                        getApplicantsList();
                        $('#interviewForm')[0].reset();
                        $('.modalDismiss').click();
                        toastr.success('Record save successfully');
                    }


                },

                error: function() {

                    toastr.error('something went wrong');

                }

            });

        });

        $('#showApplicantsList').on('click', '.btn-status', function() {


            var id = $(this).attr('data');
            var status = $(this).attr('status');



            $.ajax({

                type: 'ajax',
                method: 'get',
                url: '{{url("update-applicant-status")}}',
                async: false,
                dataType: 'json',
                data: {
                    id: id,
                    status: status
                },
                success: function(data) {
                    getApplicantsList();
                    toastr.success(data.success);
                },

                error: function() {
                    toastr.error('something went wrong');

                }

            });
        });

        //ajax call for serach record
        $('#searchForm').unbind().on('submit', function(e) {
            e.preventDefault();
            var formData = $('#searchForm').serialize();
            $.ajax({

                type: 'ajax',
                method: 'post',
                url: '{{url("job-applicants")}}',
                data: formData,
                async: false,
                dataType: 'json',
                beforeSend: function() {
                    $(".btn-search").prop("disabled", true);
                    $(".btn-search").html("processing...");
                },
                success: function(data) {
                    var html = '';
                    var i;
                    var c = 0;
                    for (i = 0; i < data.length; i++) {
                        c++;
                        html += '<tr>' +
                            '<td>' + c + '</td>' +
                            '<td>' + data[i].name + '</td>' +
                            ' <td>' + data[i].email + '</td>' +
                            '<td>' + data[i].phone + '</td>' +
                            ' <td>' + moment(data[i].created_at).format('DD-MMM-YYYY') + '</td>' +
                            ' <td class="text-center">' +
                            '<div class="dropdown action-label">' +
                            '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="fa fa-dot-circle-o text-success"></i>' + data[i].status + '</a>' +

                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> New</a>' +
                            '<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success" ></i> Hired</a>' +
                            ' <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Rejected</a>' +
                            '<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Interviewed</a>' +
                            '</div>' +
                            '</div>' +
                            '</td>' +
                            ' <td><a href="{{url(' / download - resume ')}}/' + data[i].id + '" class="btn btn-sm btn-primary btnDownload"><i class="fa fa-download"></i> Download</a></td>' +
                            '<td class="text-right">' +
                            '<div class="dropdown dropdown-action">' +
                            '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a class="dropdown-item btnInterview" href="javascript:" data="' + data[i].id + '"><i class="fa fa-clock-o m-r-5 text-success" ></i> Schedule Interview</a>' +
                            '<a class="dropdown-item btn-status" href="javascript:" data="' + data[i].id + '" status="Rejected"><i class="fa fa-clock-o m-r-5 text-danger" ></i> Rejected</a>' +
                            '<a class="dropdown-item btn-status" href="javascript:" data="' + data[i].id + '"  status="Short List"><i class="fa fa-clock-o m-r-5 text-success"></i> Short List</a>' +
                            '<a class="dropdown-item btn-status" href="javascript:" data="' + data[i].id + '"  status="hired"><i class="fa fa-clock-o m-r-5 text-success"></i> Hired</a>' +
                            '</div>' +
                            ' </div>' +
                            '</td>' +
                            '</tr>';
                    }


                    $('#showApplicantsList').html(html);

                },
                error: function() {
                    toastr.error('something went wrong');
                },
                complete: function(data) {
                    $(".btn-search").prop("disabled", false);
                    $(".btn-search").html("search");
                },

            });


        });

        //Datatables
        $('#datatable').DataTable();

    });
</script>


@endsection
