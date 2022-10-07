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
                            <h3 class="page-title">INTERVIEWS SCHEDULED</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Interviews Scheduled</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->


                <!-- Search Filter... -->
                <div class="card">
                    <div class="card-body">
                        <div class="container py-4">
                            <form action="{{ url('interviews') }}" method="POST" id="interviewSearch">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="job_id" class="select">
                                            <option value="" selected disabled>Choose Job Title</option>
                                            @isset($data['designation'])
                                                @foreach ($data['designation'] as $desig)
                                                    <option value="{{ $desig->id }}">{{ $desig->desig_name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="name" placeholder="Search Name">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary search_interview"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Search Filter... -->



                <div class="card">
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Job Title</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Apply Date</th>
                                                <th>Time</th>
                                                <th>Date</th>

                                                <th class="text-right">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody id="showApplicantsList">
                                            @php $c=0; @endphp
                                            @isset($data['interviews'])
                                                @foreach ($data['interviews'] as $interviews)
                                                    @php $c++ @endphp
                                                    <tr>

                                                        <td>{{ $c }}</td>
                                                        <td>{{ $interviews->desig_name }}</td>
                                                        <td>{{ $interviews->name }}</td>
                                                        <td>{{ $interviews->email }}</td>
                                                        <td>{{ $interviews->phone }}</td>
                                                        <td>{{ $interviews->created_at }}</td>
                                                        <td>{{ $interviews->interview_time }}</td>
                                                        <td>{{ $interviews->interview_date }}</td>

                                                        <td class="">
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle"
                                                                    data-toggle="dropdown" aria-expanded="false"><i
                                                                        class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item btnInterview" href="javascript:"
                                                                        data="{{ $interviews->interviewId }}"><i
                                                                            class="fa fa-clock-o m-r-5 text-success"></i> Re
                                                                        Schedulee</a>

                                                                </div>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @endisset

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
                    <button type="button" class="close modalDismiss" data-dismiss="modal" aria-label="Close"
                        id="btnDissmissEdit">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="interviewForm" method="post">
                        @csrf

                        <div class="form-group">
                            <label>Time <span class="text-danger">*</span></label>
                            <input class="form-control" type="hidden" name="hidden_interview_id">
                            <input class="form-control" type="time" name="interview_time">
                        </div>
                        <div class="form-group">
                            <label>Date <span class="text-danger">*</span></label>

                            <input class="form-control" type="date" name="interview_date">
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn btn_reshedule" id="btnSave" type="button">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function() {




            $('#showApplicantsList').on('click', '.btnInterview', function() {


                var id = $(this).attr('data');

                $('#scheduleInterview').modal('show');


                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('reshedule-interview') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('input[name=interview_time]').val(data.interview_time);
                        $('input[name=interview_date]').val(data.interview_date);
                        $('input[name=hidden_interview_id]').val(id);

                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });


            });


            $('#btnSave').on('click', function() {
                var formData = $('#interviewForm').serialize();

                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{ url('update-interview') }}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        if (data.errors) {
                            toastr.error(data.errors);
                        }
                        if (data.success) {
                            toastr.success('Record save updated successfully');
                            window.location.reload();
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });

            });

            $('.search_interview').on('click', function() {
                $(".search_interview").prop("disabled", true);
                $(".search_interview").html("Please wait...");
                $('#interviewSearch').submit();
            });


            //Datatables
            $('#datatable').DataTable();

        });
    </script>

@endsection
