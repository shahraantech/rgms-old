@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Survey Details</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Survey Details</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="card mb-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                        <a href="#">
                                            <img alt=""
                                                 src="{{ asset('storage/app/public/uploads/staff-images/user1-128x128.png') }}"></a>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0">
                                                    {{ $data['survey'] ? $data['survey']->name : '' }}
                                                </h3>
                                                <h6 class="text-muted"></h6>
                                                <small class="text-muted"></small>
                                                <div class="staff-id">Survey ID
                                                    :{{ $data['survey'] ? $data['survey']->id : '' }}
                                                </div>
                                                <div class="small doj text-muted">Create At :
                                                    {{ $data['survey'] ? $data['survey']->created_at : '' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Phone:</div>
                                                    <div class="text"><a
                                                            href="">{{ $data['survey'] ? $data['survey']->contact : '' }}</a>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="title">Project:</div>
                                                    <div class="text"><a
                                                            href="">{{ $data['survey'] ? $data['survey']->project : '' }}</a>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="title">Marla:</div>
                                                    <div class="text"><a
                                                            href="">{{ $data['survey'] ? $data['survey']->size : '' }}</a>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="title">Date:</div>
                                                    <div class="text"><a
                                                            href="">{{ $data['survey'] ? $data['survey']->date : '' }}</a>
                                                    </div>
                                                </li>



                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <!-- Profile Info Tab -->
                <div id="emp_profile" class="pro-overview tab-pane fade show active">
                    <h4>Survey Information </h4>
                    <div class="row">

                                <div class="col-md-6 d-flex">
                                    <div class="card profile-box flex-fill">
                                        <div class="card-body">
                                            <h3 class="card-title"><small
                                                    class="text-secondary">{{ $data['remarks']->created_at }}</small></h3>
                                            <ul class="personal-info">

                                                <li>
                                                    <div class="title" style="    font-weight: bold;">Age</div>
                                                    <div class="text">{{  $data['remarks']->age }} Years</div>
                                                </li>
                                                <li>
                                                    <div class="title" style="    font-weight: bold;">Address</div>
                                                    <div class="text">{{  $data['remarks']->address }} </div>
                                                </li>
                                                <li>
                                                    <div class="title" style="    font-weight: bold;">Married</div>
                                                    <div class="text">{{  $data['remarks']->is_married }}</div>
                                                </li>
                                                <li>
                                                    <div class="title" style="    font-weight: bold;">Profession</div>
                                                    <div class="text">{{  $data['remarks']->profession}}</div>
                                                </li>
                                                <li>
                                                    <div class="title" style="    font-weight: bold;">Interest</div>
                                                    <div class="text">{{  $data['remarks']->intrest }}</div>
                                                </li>
                                                <li>
                                                    <div class="title" style="    font-weight: bold;">Dependent</div>
                                                    <div class="text">{{  $data['remarks']->is_dependent }}</div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                    </div>
                </div>
                <!-- /Profile Info Tab -->
            </div>
        </div>
    </div>
@endsection
