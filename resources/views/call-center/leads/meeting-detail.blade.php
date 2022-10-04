@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Meeting Details</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Meeting Details</li>
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
                                                    {{ $data['lead'] ? $data['lead']->name : '' }}
                                                </h3>
                                                <h6 class="text-muted"></h6>
                                                <small class="text-muted"></small>
                                                <div class="staff-id">Lead ID
                                                    :{{ $data['lead'] ? $data['lead']->id : '' }}
                                                </div>
                                                <div class="small doj text-muted">Date :
                                                    {{ $data['lead'] ? $data['lead']->created_at : '' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Phone:</div>
                                                    <div class="text"><a
                                                            href="">{{ $data['lead'] ? $data['lead']->contact : '' }}</a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Email:</div>
                                                    <div class="text"><a
                                                            href="">{{ $data['lead'] ? $data['lead']->email : '' }}</a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">City:</div>
                                                    <div class="text">
                                                        {{ $data['lead'] ? $data['lead']->cityname['city_name'] : '' }}
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Query:</div>
                                                    <div class="text">
                                                        {{ $data['lead'] ? $data['lead']->interest : '' }}
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
                    <h4>Meeting Information </h4>
                    <div class="row">
                        @isset($data['approached_leads'])
                            @foreach ($data['approached_leads'] as $leads)
                                <div class="col-md-4 d-flex">
                                    <div class="card profile-box flex-fill">
                                        <div class="card-body">
                                            <h3 class="card-title"><small
                                                    class="text-secondary">{{ $leads->created_at }}</small></h3>
                                            <ul class="personal-info">
                                                @php
                                                    $approchedBy='';
                                                    if($leads->lead_type==1){
                                                        $salesman=App\Models\Employee::find($leads->salesman_id);
                                                        $approchedBy=$salesman->name;
                                                        }else{
                                                        $agent=App\Models\Employee::find($leads->agent_id);
                                                        $approchedBy=$agent->name;
                                                        }

                                                @endphp
                                                <li>

                                                    <div class="title">Approached By.</div>
                                                    <div class="text badge bg-inverse-info">{{$approchedBy}}</div>
                                                </li>

                                                <li>
                                                    <div class="title">Temperature</div>
                                                    <div class="text">
                                                        <div class="text badge bg-inverse-warning">{{ $leads->temp['temp'] }}
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Lead Type.</div>
                                                    @php
                                                        if ($data['lead']->lead_type == 'Inbound') {
                                                        echo '
                                                        <div class="text badge bg-inverse-success">' . strtoupper($data['lead']->lead_type) . '</div>
                                                        ';
                                                        } else {
                                                        echo '
                                                        <div class="text badge bg-inverse-primary">' . strtoupper($data['lead']->lead_type) . '</div>
                                                        ';
                                                        }
                                                    @endphp
                                                </li>
                                                <li>
                                                    <div class="title">Followup Date/Time</div>
                                                    <div class="text">
                                                        {{ date('d-M-Y', strtotime($leads->followup_date)) }}
                                                        {{ $leads->follow_time }}
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Comments</div>
                                                    <div class="text">{{ $leads->comments }}</div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endisset
                    </div>
                </div>
                <!-- /Profile Info Tab -->
            </div>
        </div>
    </div>


    @include('call-center.general.dont-copy');
@endsection
