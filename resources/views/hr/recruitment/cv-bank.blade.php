@extends('setup.master')

@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">


        <div class="page-header my-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title bold-heading">CV Bank</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage Resumes</li>
                    </ul>
                </div>

                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_department"
                       title="Add New Leads"><i class="fa fa-plus" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>

        <!-- /Page Header -->


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
                                        <th>Job Title</th>
                                        <th>Department</th>
                                        <th>Status</th>
                                        <th>Resume</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="existingTable">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Page Content -->


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

    <div id="add_department" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">CV Bank</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{url('apply-job')}}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate id="applyJobForm1" >
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" name="sender" value="admin">
                            <label>Job Titile</label>
                                <select name="job_id" class="form-control selectpicker" data-container="body"
                                        data-live-search="true" required>
                                    <option value="">Choose One</option>
                                @isset($data['desig'])
                                @foreach($data['desig'] as $row)
                                <option value="{{$row->id}}">{{$row->desig_name}}</option>
                                    @endforeach
                                        @endisset
                            </select>

                            <div class="invalid-feedback">
                                Choose Job Title.
                            </div>
                        </div>
                            </div>
                            <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>

                            <input class="form-control" type="text"  name="name" required>
                            <div class="invalid-feedback">
                                Please enter  name.
                            </div>
                        </div>
                            </div>
                            <div class="col-md-6">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input class="form-control" type="email" required name="email">
                            <div id="emailId"></div>
                            <div class="invalid-feedback">
                                Please enter  email.
                            </div>
                        </div>
                            </div>
                            <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone</label>
                            <input class="form-control" type="number" required name="phone">  <div class="invalid-feedback">
                                Please enter  phone.
                            </div>
                        </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="">Choose Status</option>
                                        <option value="bank">Store As Bank</option>
                                        <option value="Rejected">Rejected</option>
                                        <option value="Short List">Short List</option>
                                        <option value="Hired">Hired</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                        <div class="form-group">
                            <label>Upload your CV</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input"  required name="file">
                                <label class="custom-file-label" for="cv_upload">Choose file</label>
                                <div class="invalid-feedback">
                                    Please choose  your cv in pdf format.
                                </div>
                            </div>
                        </div>
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
</div>
<!-- /Page Wrapper -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script>
    $(document).ready(function() {

        getApplicantsList();

        function getApplicantsList() {
            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{url("existingList")}}',
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
                            ' <td>' + data[i].desig_name + '</td>' +
                            '<td>' + data[i].departments + '</td>' +

                            ' <td class="text-center">' +
                            '<div class="dropdown action-label">' +
                            '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="fa fa-dot-circle-o text-success"></i>' + data[i].status + '</a>' +
                            '</div>' +
                            '</td>' +
                            ' <td><a href="{{url("/download-resume")}}/' + data[i].id + '" class="btn btn-sm btn-primary btnDownload" title="download"><i class="fa fa-download"></i></a></td>' +
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


                    $('#existingTable').html(html);

                },

                error: function() {
                    toastr.error('something went wrong');

                }

            });
        }
        $('#existingTable').on('click', '.btnInterview', function() {
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
        $('#existingTable').on('click', '.btn-status', function() {
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

        //Datatables
        $('#datatable').DataTable();

    });
</script>

<script type="text/javascript">

    @if(count($errors) > 0)
    @foreach($errors->all() as $error)

    toastr.error("{{ $error }}");
    @endforeach
    @endif


    @if(Session::has('success'))
    toastr.success("You have applied successfully");

    @endif


</script>
@endsection
