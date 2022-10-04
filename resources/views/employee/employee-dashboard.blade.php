@extends('setup.master')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
@include('setup.welcome-msg')
            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card-group m-b-30">
                        @if(Auth::user()->role_id==3)
                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">Leads</span>
                                    </div>
                                    <div>
                                        <span class="text-success">Total: {{$data['myTotalLeads']->count()}}</span>

                                    </div>
                                </div>
                                <h5 class="mb-3"> <small>This Week:{{$data['myThisWeekLeads']->count()}}</small></h5>
                                <div class="progress mb-2" style="height: 5px;">

                                </div>
                                <h5 class="mb-3"> <small>This Month:{{$data['myThisMonthLeads']->count()}}</small></h5>

                            </div>
                        </div>
                        @endif
                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">Tickets</span>
                                    </div>

                                </div>
                                <h3 class="mb-3">{{ ($data['tickets'])?$data['tickets']:0}}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">Expense</span>
                                    </div>

                                </div>
                                <h3 class="mb-3">{{$data['expense']}}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">Tasks</span>
                                    </div>

                                </div>
                                <h3 class="mb-3">{{$data['taskThisMonth']}}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">Targets</span>
                                    </div>

                                </div>
                                <h3 class="mb-3">{{$data['targetThisMonth']}}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- CSR -->
@if(Auth::user()->role_id==4 OR Auth::user()->role_id==7)
            <div class="row">

                <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <h4 class="card-title">Leads</h4>
                            <div class="statistics">
                                <div class="row">
                                    <div class="col-md-4 col-4 text-center">
                                        <a href="{{url('leads-params').'/'.encrypt(5).'/'.encrypt('agent')}}">
                                        <div class="stats-box mb-4">

                                            <p>New</p>
                                            <h3>{{ $data['newLeads']}}</h3>
                                        </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-4 text-center">

                                            <div class="stats-box mb-4">
                                            <p>This Month</p>
                                            <h3>{{ $data['thisMonthLeads']->count()}}</h3>
                                        </div>

                                    </div>
                                    <div class="col-md-4 col-4 text-center">

                                        <div class="stats-box mb-4">
                                            <p>Total</p>
                                            <h3>{{ $data['totalLeads']->count()}}</h3>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-purple" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">22%</div>
                                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100">24%</div>
                            </div>
                            <div>
                                <p><a href="{{url('leads-params').'/'.encrypt(1).'/'.encrypt('agent')}}"><i class="fa fa-dot-circle-o text-success mr-2"></i>Today Follow Up<span class="float-right">{{ $data['todayLeads']}}</span></a></p>
                                <p><a href="{{url('leads-params').'/'.encrypt(2).'/'.encrypt('agent')}}"><i class="fa fa-dot-circle-o text-purple  mr-2"></i>Tomorrow Follow Up <span class="float-right">{{ $data['tomorrowLeads']}}</span></a></p>
                                <p><a href="{{url('leads-params').'/'.encrypt(3).'/'.encrypt('agent')}}"><i class="fa fa-dot-circle-o text-danger mr-2"></i>Not Approached Leads <span class="float-right">{{ $data['notApproachedLeads']->count()}}</span></a></p>
                                <p><a href="{{url('leads-params').'/'.encrypt(4).'/'.encrypt('agent')}}"><i class="fa fa-dot-circle-o text-primary mr-2"></i>Over Due Leads <span class="float-right">{{ $data['overDate']}}</span></a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <h4 class="card-title">Today Activity</h4>

                            <div>
                                <p>
                                   @php
                               $temp= App\Models\Temprature::all();
                                @endphp
                                    @foreach($temp as  $temp)
                                        @php
                                            $appLeads= App\Models\ApprochedLeads::getTempratureWiseLeads($temp->id,'counting','csr',\Illuminate\Support\Facades\Auth::user()->account_id);

                                        @endphp
                                    <a href="{{url('leads-temp-wise/agent').'/'.($temp->id.'/'.$temp->temp)}}">
                                        <i class="fa fa-dot-circle-o text-success mr-2"></i>{{$temp->temp}}

                                        <span class="float-right">{{$appLeads}}</span></a></p>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <h4 class="card-title">Today Calls</h4>
                            <div class="statistics">
                                <div class="row">
                                    <div class="col-md-12 col-6 text-center">
                                        <div class="stats-box mb-4">
                                            @php
                                                $appLeads= App\Models\ApprochedLeads::
                                            where('agent_id',\Illuminate\Support\Facades\Auth::user()->account_id)->whereDate('created_at', \Illuminate\Support\Carbon::now())->get();
                                                      $conn= App\Models\ApprochedLeads::
                                            where('agent_id',\Illuminate\Support\Facades\Auth::user()->account_id)->where('is_connected',1)->whereDate('created_at', \Illuminate\Support\Carbon::now())->get();

                                                      $notConn= App\Models\ApprochedLeads::
                                            where('agent_id',\Illuminate\Support\Facades\Auth::user()->account_id)->where('is_connected',0)->whereDate('created_at', \Illuminate\Support\Carbon::now())->get();


                                            @endphp
                                            <p>Total Calls</p>
                                            <h3>{{$appLeads->count()}}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress mb-4">
                            </div>
                            <div>
                                <p><i class="fa fa-dot-circle-o text-success mr-2"></i>Connected  <span class="float-right">{{$conn->count()}}</span></p>
                                <p><i class="fa fa-dot-circle-o text-danger mr-2"></i>Not Connected  <span class="float-right">{{$notConn->count()}}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <h4 class="card-title">Attendance</h4>
                            <div class="statistics">
                                <div class="row">
                                    <div class="col-md-6 col-6 text-center">
                                        <div class="stats-box mb-4">
                                            <p>Presents</p>
                                            <h3>{{ $data['present']}}</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6 text-center">
                                        <div class="stats-box mb-4">
                                            <p>Absents</p>
                                            <h3>{{ $data['absent']}}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-purple" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">22%</div>
                                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100">24%</div>
                            </div>
                            <div>
                                <p><i class="fa fa-dot-circle-o text-success mr-2"></i>Presents <span class="float-right">{{ $data['present']}}</span></p>
                                <p><i class="fa fa-dot-circle-o text-purple  mr-2"></i>Absents <span class="float-right">{{ $data['absent']}}</span></p>
                                <p><i class="fa fa-dot-circle-o text-danger mr-2"></i>Leaves <span class="float-right">{{ $data['leaves']}}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <h4 class="card-title">Tasks</h4>
                            <div class="statistics">
                                <div class="row">
                                    <div class="col-md-6 col-6 text-center">
                                        <div class="stats-box mb-4">
                                            <p>Total Tasks</p>
                                            <h3>{{$data['tasks']->count()}}</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6 text-center">
                                        <div class="stats-box mb-4">
                                            <p>Overdue Tasks</p>
                                            <h3>{{$data['overDueTasks']->count()}}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $complete=0;
                                $pending=0;
                                $open=0;
                                if($data['tasks']->count()>0){
                                $totalTasks=$data['tasks']->count();
                                }else{
                                $totalTasks=1;
                                }
                                $completePercent=0;
                                $pendingPercent=0;
                                $openPercent=0;
                                foreach($data['tasks'] as $row){
                                if($row->status=='complete'){
                                $complete++;
                                }
                                if($row->status=='pending'){
                                $pending++;
                                }
                                if($row->status=='open'){
                                $open++;
                                }
                                }
                                $completePercent=($complete*100)/$totalTasks;
                                $pendingPercent=($pending*100)/$totalTasks;
                                $openPercent=($open*100)/$totalTasks;
                            @endphp
                            <div class="progress mb-4">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$completePercent}}%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">{{$completePercent}}%</div>
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{$pendingPercent}}%" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">{{$pendingPercent}}%</div>
                                <div class="progress-bar bg-purple" role="progressbar" style="width: {{$openPercent}}%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100">{{$openPercent}}%</div>
                            </div>
                            <div>
                                <p><i class="fa fa-dot-circle-o text-success mr-2"></i>Completed Tasks <span class="float-right">{{$complete}}</span></p>
                                <p><i class="fa fa-dot-circle-o text-purple  mr-2"></i>Open Tasks <span class="float-right">{{$open}}</span></p>
                                <p><i class="fa fa-dot-circle-o text-danger mr-2"></i>Pending Tasks <span class="float-right">{{$pending}}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <h4 class="card-title">Targets</h4>
                            <div class="statistics">
                                <div class="row">
                                    <div class="col-md-6 col-6 text-center">
                                        <div class="stats-box mb-4">
                                            <p>Total Targets</p>
                                            <h3>0</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6 text-center">
                                        <div class="stats-box mb-4">
                                            <p>Completed Targets</p>
                                            <h3>0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-purple" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">22%</div>
                                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100">24%</div>
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">21%</div>
                                <div class="progress-bar bg-info" role="progressbar" style="width: 0%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">10%</div>
                            </div>
                            <div>
                                <p><i class="fa fa-dot-circle-o text-purple mr-2"></i>Completed Targets <span class="float-right">0</span></p>
                                <p><i class="fa fa-dot-circle-o text-warning mr-2"></i>Inprogress Targets <span class="float-right">0</span></p>
                                <p><i class="fa fa-dot-circle-o text-success mr-2"></i>On Hold Targets <span class="float-right">0</span></p>
                                <p><i class="fa fa-dot-circle-o text-danger mr-2"></i>Pending Targets <span class="float-right">0</span></p>
                                <p class="mb-0"><i class="fa fa-dot-circle-o text-info mr-2"></i>Review Targets <span class="float-right">0</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- CSR -->
            @if(Auth::user()->role_id==4 OR Auth::user()->role_id==7)
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Inbound</h3>
                                    <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Outbound</h3>
                                    <canvas id="outBoundChart" style="width:100%;max-width:600px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <!-- /Page Content -->
    </div>
    <script>
        var xValues = ["Facebook", "Instagram", "WhatsApp","Other"];
        var yValues = [120, 49, 44, 24, 15];
        var barColors = ["#3b5998", "#E1306C","#25D366","#800000"];

        new Chart("myChart", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                legend: {display: false},
                title: {
                    display: true,
                    text: "World Wine Production 2018"
                }
            }
        });
    </script>
    <script>
        var xValues = ["Facebook", "Instagram", "WhatsApp","Other"];
        var yValues = [120, 49, 44, 24, 15];
        var barColors = ["#3b5998", "#E1306C","#25D366","#800000"];

        new Chart("outBoundChart", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                legend: {display: false},
                title: {
                    display: true,
                    text: "World Wine Production 2018"
                }
            }
        });
    </script>
@endsection
