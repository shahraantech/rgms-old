@extends('setup.master')
@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
        integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


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
                                        <h6 class="text-muted">
                                            {{ empty($data['employee']->desig_name) ? '' : $data['employee']->desig_name }}
                                        </h6>
                                        <p class="">Employee ID:
                                            {{ empty($data['employee']->id) ? '' : $data['employee']->id }}</p>
                                        <p class="text-secondary mb-1">Date of Join:
                                            {{ empty($data['employee']->doj) ? '' : $data['employee']->doj }}</p>
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
                                        <a
                                            href="#">{{ empty($data['employee']->email) ? '' : $data['employee']->email }}</a>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Phone</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <a
                                            href="#">{{ empty($data['employee']->phone) ? '' : $data['employee']->phone }}</a>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Birthday</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <a
                                            href="#">{{ empty($data['employee']->dob) ? '' : $data['employee']->dob }}</a>
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

                                                <input type="password" name="current_password" class="form-control" required
                                                    placeholder="Current Password">

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

                                                <input type="password" name="confirm_password" class="form-control" required
                                                    placeholder="Confirm Password">

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
                                <a href="#" class="edit-icon" data-toggle="modal" data-target="#bank_info"><i
                                        class="fa fa-plus"></i>
                                </a>
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
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="project-info-box">
                                                                <p class="text-secondary"><b>Bank Name:</b>
                                                                    {{ empty($data['employee']->bank_id) ? '' : 'Meezan Bank' }}</p>
                                                                <p class="text-secondary"><b>Bank account No :</b>
                                                                    {{ empty($data['employee']->bank_ac_no) ? '' : $data['employee']->bank_ac_no }}
                                                                </p>
                                                            </div>
                                                        </div>
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
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Education Informations
                                @if (Auth::user()->role == 'admin')
                                    <a href="#" class="edit-icon" data-toggle="modal"
                                        data-target="#education_info"><i class="fa fa-plus"></i>
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
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="project-info-box">
                                                                <p class="text-secondary"><b>Institute:</b>
                                                                    {{ empty($edu->institute) ? '' : $edu->institute }}</p>
                                                                <p class="text-secondary"><b>Qualification:</b>
                                                                    {{ empty($edu->qualification) ? '' : $edu->qualification }}
                                                                </p>
                                                                <p class="text-secondary"><b>From:</b>
                                                                    {{ empty($edu->from) ? '' : date('Y', strtotime($edu->from)) }}
                                                                </p>
                                                                <p class="text-secondary"><b>To:</b>
                                                                    {{ empty($edu->to) ? '' : date('Y', strtotime($edu->to)) }}
                                                                </p>
                                                                <p class="text-secondary"><b>CGPA:</b>
                                                                    {{ empty($edu->cgpa) ? '' : $edu->cgpa }}</p>
                                                            </div>
                                                        </div>

                                                        @if ($edu->attachment != '')
                                                            <div class="col-md-6 text-center">
                                                                <div class="project-info-box">
                                                                    <p class="text-secondary"><b>Attachment</b></p>
                                                                    <a
                                                                        href="{{ asset('storage/app/public/uploads/education/' . $edu->attachment ?? '') }}">
                                                                        <img src="{{ asset('storage/app/public/uploads/education/' . $edu->attachment ?? '') }}"
                                                                            width="50%" class="img-fluid" alt=""
                                                                            style="border-radius: 5px;"><br>
                                                                    </a>
                                                                    <a href="{{ asset('storage/app/public/uploads/education/' . $edu->attachment ?? '') }}"
                                                                        class="btn btn-primary btn-sm mt-3" download><i
                                                                            class="fa fa-cloud-download"
                                                                            aria-hidden="true"></i></a>
                                                                </div>
                                                            </div>
                                                        @endif

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
                                @if (Auth::user()->role == 'admin')
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
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="project-info-box">
                                                                <p class="text-secondary"><b>Position:</b>
                                                                    {{ empty($exp->position) ? '' : $exp->position }}</p>

                                                                <?php
                                                                
                                                                $diff = abs(strtotime($exp->start_date) - strtotime($exp->end_date));
                                                                
                                                                $years = floor($diff / (365 * 60 * 60 * 24));
                                                                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                                                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                                                ?>

                                                                <p class="text-secondary"><b>Experience:</b>
                                                                    {{ $years . '-' . $months . '-' . $days }}
                                                                </p>
                                                                <p class="text-secondary"><b>Organization:</b>
                                                                    {{ empty($exp->organization) ? '' : $exp->organization }}
                                                                </p>

                                                            </div>
                                                        </div>

                                                        @if ($exp->attachment != '')
                                                            <div class="col-md-6 text-center">
                                                                <div class="project-info-box">
                                                                    <p class="text-secondary"><b>Attachment</b></p>
                                                                    <a
                                                                        href="{{ asset('storage/app/public/uploads/experience/' . $exp->attachment ?? '') }}">
                                                                        <img src="{{ asset('storage/app/public/uploads/experience/' . $exp->attachment ?? '') }}"
                                                                            width="50%" class="img-fluid" alt=""
                                                                            style="border-radius: 5px;"><br>
                                                                    </a>
                                                                    <a href="{{ asset('storage/app/public/uploads/experience/' . $exp->attachment ?? '') }}"
                                                                        class="btn btn-primary btn-sm mt-3" download><i
                                                                            class="fa fa-cloud-download"
                                                                            aria-hidden="true"></i></a>
                                                                </div>
                                                            </div>
                                                        @endif

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
                                @if (Auth::user()->role == 'admin')
                                    <a href="#" class="edit-icon" data-toggle="modal"
                                        data-target="#certification_info"><i class="fa fa-plus"></i></a>
                                @endif
                            </h3>
                            @isset($data['certifications'])
                                <div class="experience-content">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="project-info-box">
                                                <p class="text-secondary"><b>Course Title:</b>
                                                    {{ empty($data['certifications']->course_title) ? '' : $data['certifications']->course_title }}
                                                </p>
                                                <p class="text-secondary"><b>Duration Period:</b>
                                                    {{ empty($data['certifications']->duration_period) ? '' : $data['certifications']->duration_period }}
                                                </p>
                                            </div>
                                        </div>

                                        @if ($data['certifications']->attachment != '')
                                            <div class="col-md-6 text-center">
                                                <div class="project-info-box">
                                                    <p class="text-secondary"><b>Attachment</b></p>
                                                    <a
                                                        href="{{ asset('storage/app/public/uploads/certification/' . $data['certifications']->attachment ?? '') }}">
                                                        <img src="{{ asset('storage/app/public/uploads/certification/' . $data['certifications']->attachment ?? '') }}"
                                                            width="30%" class="img-fluid" alt=""
                                                            style="border-radius: 5px;"><br>
                                                    </a>
                                                    <a href="{{ asset('storage/app/public/uploads/certification/' . $data['certifications']->attachment ?? '') }}"
                                                        class="btn btn-primary btn-sm mt-3" download><i
                                                            class="fa fa-cloud-download" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>

            </div>



            <!-- /Profile Info Tab -->
        </div>
        <!-- /Page Content -->

    </div>


    <!-- Bank Informations Modal -->
    <div class="modal fade" id="bank_info" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bank Informations </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('update-bank-detail') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="emp_id" value="{{ $data['employee'] ? $data['employee']->id : '' }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Bank Name <span class="text-danger"></span></label>
                                <select class="form-control " name="bank_id" required>
                                    <option value="1">Choose Bank</option>
                                    <option value="2">HBL</option>
                                    <option value="3">Bank Al Habib</option>
                                    <option value="4">Meezan</option>
                                    <option value="4">MCB</option>
                                    <option value="4">Islami Bank</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Account# <span class="text-danger"></span></label>
                                <input class="form-control" type="number" name="bank_ac_no" placeholder="Bank Ac number" required>
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
    <!-- Bank Informations Modal -->

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
                <form action="{{ url('store-education') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="emp_id" value="{{ $data['employee'] ? $data['employee']->id : '' }}">
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
                                    <input type="date" class="form-control" name="from" placeholder="From"
                                        required>
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
                                    <input type="text" class="form-control" placeholder="Devision/CGPA"
                                        name="cgpa" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Attachment</label>
                                    <input type="file" class="form-control" placeholder="Attachment"
                                        name="attachment" required>
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
                <form action="{{ url('store-experience') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="emp_id" value="{{ $data['employee'] ? $data['employee']->id : '' }}">
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
                                    <input class="form-control" type="text" name="skill" placeholder="Skills"
                                        required>
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
                                    <input class="form-control" type="date" name="start_date"
                                        placeholder="Start Date" required>
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
                                    <input class="form-control" type="text" name="relevent_exp"
                                        placeholder="Experience" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Attachment</label>
                                    <input class="form-control" type="file" name="attachment"
                                        placeholder="Attachment" required>
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
                <form action="{{ url('store-certification') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="emp_id" value="{{ $data['employee'] ? $data['employee']->id : '' }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Course Title</label>
                                    <input type="text" class="form-control" placeholder="Course Title"
                                        name="course_title" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Organization</label>
                                    <input type="text" class="form-control" name="exp_organization"
                                        placeholder="organization" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Duration Period</label>
                                    <input type="text" class="form-control" name="period"
                                        placeholder="Duration Period" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Attachment</label>
                                    <input class="form-control" type="file" name="attachment"
                                        placeholder="Attachment" required>
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
