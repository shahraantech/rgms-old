@extends('setup.master')
@section('content')


    <div class="page-wrapper">


        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title">Profile</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Profile</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->


            @if ($data['employee'])
            <div class="row gutters-sm mt-3">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ asset('storage/app/public/uploads/staff-images/') . '/' . $data['employee']->image }}"
                                alt="" class="img-fluid rounded-circle" style="width: 55%;">
                                <div class="mt-3">
                                    <h3>{{ empty($data['employee']->name) ? '' : $data['employee']->name }}</h3>
                                    <h6 class="text-muted">{{ empty($data['employee']->desig_name) ? '' : $data['employee']->desig_name }}</h6>
                                    <p class="">Employee ID: {{ empty($data['employee']->id) ? '' : $data['employee']->id }}</p>
                                    <p class="text-secondary mb-1">Date of Join: {{ empty($data['employee']->doj) ? '' : $data['employee']->doj }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3" id="vendorTable">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>

                                <div class="col-sm-9 text-secondary">
                                    @if ($data['employee'])
                                        <div class="pro-edit float-right"><a class="edit-"
                                                href="{{ url('edit-employee') . '/' . encrypt($data['employee']->id) }}"><i
                                                    class="fa fa-edit"></i></a></div>
                                    @endif
                                    <a href="#">{{ empty($data['employee']->email) ? '' : $data['employee']->email }}</a>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Phone</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <a href="#">{{ empty($data['employee']->phone) ? '' : $data['employee']->phone }}</a>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Birthday</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <a href="#">{{ empty($data['employee']->dob) ? '' : $data['employee']->dob }}</a>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">CNIC</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ empty($data['employee']->cnic) ? '' : $data['employee']->cnic }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Nationality</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ empty($data['employee']->nationality) ? '' : $data['employee']->nationality }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Gross Salary</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ empty($data['employee']->gross_salary) ? '' : $data['employee']->gross_salary }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @endif

            <div class="tab-content">

                {{-- change password --}}
                <form method="post" action="{{ url('change-password') }}" id="Add_Password_Change_Form">
                    @csrf
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="main-card mb-3  card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <h4>Change Password</h4>
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group mt-3">

                                                <input type="password" name="current_password" class="form-control"
                                                    required placeholder="Current Password">

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mt-3">

                                                <input type="password" name="password" class="form-control" required
                                                    placeholder="New Password">

                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group mt-3">

                                                <input type="password" name="confirm_password" class="form-control"
                                                    required placeholder="Confirm Password">

                                            </div>
                                        </div>

                                        <div class="col-md-3">

                                            <div class="d-flex justify-content-first mt-4 ml-2">
                                                <button type="submit" class="btn btn-primary" id="formSubmit">change
                                                    password</button>



                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
                {{-- change password --}}
            </div>

            <div class="row">
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">

                            <h3 class="card-title">Bank information
                            </h3>
                            <ul class="personal-info">
                                <li>
                                    <div class="title">Bank name</div>

                                    <div class="text">
                                        {{ empty($data['employee']->bank_id) ? '' : 'Meezan Bank' }}</div>
                                </li>
                                <li>
                                    <div class="title">Bank account No.</div>
                                    <div class="text">
                                        {{ empty($data['employee']->bank_ac_no) ? '' : $data['employee']->bank_ac_no }}
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Education Informations
                                @if(Auth::user()->role=='admin')
                                <a href="#" class="edit-icon"
                                 data-toggle="modal" data-target="#education_info"><i class="fa fa-plus"></i>
                                </a>
                                @endif
                            </h3>
                            <div class="experience-box">
                                <ul class="experience-list">

                                    @isset($data['qualification'])
                                        @foreach ($data['qualification'] as $edu)
                                            <li>
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="#/"
                                                            class="name">{{ empty($edu->institute) ? '' : $edu->institute }}</a>
                                                        <div>
                                                            {{ empty($edu->qualification) ? '' : $edu->qualification }}
                                                        </div>
                                                        <span
                                                            class="time">{{ empty($edu->from) ? '' : date('Y', strtotime($edu->from)) }}
                                                            -
                                                            {{ empty($edu->to) ? '' : date('Y', strtotime($edu->to)) }}</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endisset

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Experience
                                @if(Auth::user()->role=='admin')
                                <a href="#" class="edit-icon" data-toggle="modal"
                                    data-target="#experience_info"><i class="fa fa-plus"></i></a>
                            @endif
                            </h3>
                            <div class="experience-box">
                                <ul class="experience-list">

                                    @isset($data['experience'])
                                        @foreach ($data['experience'] as $exp)
                                            <li>
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="#/"
                                                            class="name">{{ empty($exp->position) ? '' : $exp->position }}</a>
                                                        <?php

                                                        $diff = abs(strtotime($exp->start_date) - strtotime($exp->end_date));

                                                        $years = floor($diff / (365 * 60 * 60 * 24));
                                                        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                                        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                                        ?>
                                                        <span
                                                            class="time">{{ $years . '-' . $months . '-' . $days }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endisset
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Certifications
                                @if(Auth::user()->role=='admin')
                                <a href="#" class="edit-icon"
                                    data-toggle="modal" data-target="#certification_info"><i class="fa fa-plus"></i></a>
                                    @endif
                            </h3>
                            @isset($data['certifications'])
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Course Titile</div>

                                        <div class="text">
                                            {{ empty($data['certifications']->course_title) ? '' : $data['certifications']->course_title }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">Durations</div>
                                        <div class="text">
                                            {{ empty($data['certifications']->duration_period) ? '' : $data['certifications']->duration_period }}
                                        </div>
                                    </li>

                                </ul>
                            @endisset
                        </div>
                    </div>
                </div>

            </div>



            <!-- /Profile Info Tab -->
        </div>
        <!-- /Page Content -->

    </div>


    <!-- Education Informations Modal -->
    <div class="modal fade bd-example-modal-lg" id="education_info" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Education Informations </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('store-education') }}" method="POST">
                    <input type="hidden" name="emp_id" value="{{ ($data['employee'])?$data['employee']->id:'' }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Qualification</label>
                                    <input type="text" class="form-control" placeholder="Qualification"
                                        name="qualification" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Institute</label>
                                    <input type="text" class="form-control" name="institute" placeholder="Institute"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">From</label>
                                    <input type="date" class="form-control" name="from" placeholder="From" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">To</label>
                                    <input type="date" class="form-control" name="to" placeholder="To" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Devision/CGPA</label>
                                    <input type="text" class="form-control" placeholder="Devision/CGPA" name="cgpa"
                                        required>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Education Informations Modal -->

    <!-- Experience Modal -->
    <div class="modal fade bd-example-modal-lg" id="experience_info" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Experience Detail </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('store-experience') }}" method="POST">
                    {{ ($data['employee'])?$data['employee']->id:'' }}
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Position</label>
                                    <input class="form-control" type="text" name="position" placeholder="Position"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Skills</label>
                                    <input class="form-control" type="text" name="skill" placeholder="Skills" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Organization</label>
                                    <input class="form-control" type="text" name="relevent_exp_organization"
                                        placeholder="Organization" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Start Date</label>
                                    <input class="form-control" type="date" name="start_date" placeholder="Start Date"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">End Date</label>
                                    <input class="form-control" type="date" name="end_date" placeholder="End Date"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Annual Duration</label>
                                    <input class="form-control" type="number" name="annual_duartion"
                                        placeholder="Annual Duration In Years" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Relevant Experience</label>
                                    <input class="form-control" type="text" name="relevent_exp" placeholder="Experience"
                                        required>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Experience Modal -->


    <!-- Certifications  Modal -->
    <div class="modal fade bd-example-modal-lg" id="certification_info" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Certifications Detail </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('store-certification') }}" method="POST">
                    <input type="hidden" name="emp_id" value="{{ ($data['employee'])?$data['employee']->id:'' }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Course Title</label>
                                    <input type="text" class="form-control" placeholder="Course Title" name="course_title" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Organization</label>
                                    <input type="text" class="form-control" name="exp_organization" placeholder="organization" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Duration Period</label>
                                    <input type="text" class="form-control" name="period" placeholder="Duration Period" required>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Certifications  Modal -->




    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


    <script>
        @if (count($errors) > 0)

            @foreach ($errors->all() as $error)

                toastr.error("{{ $error }}");
            @endforeach
        @endif


        @if (Session::has('success'))
            toastr.success("Record save successfully!");
        @endif
    </script>

    <script>
        $(document).ready(function() {

            $('#Add_Password_Change_Form').on('submit', function(e) {
                e.preventDefault();

                var formData = $('#Add_Password_Change_Form').serialize();

                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{ url('change-password') }}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        if (data.success) {
                            $('#Add_Password_Change_Form')[0].reset();
                            toastr.success(data.success);
                        }

                        if (data.current_password) {
                            toastr.error(data.current_password);
                        }


                    },

                    error: function() {
                        toastr.error('something went wrong');

                    }

                });


            });

        });
    </script>


@endsection
