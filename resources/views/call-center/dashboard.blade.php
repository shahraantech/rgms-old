@extends('setup.master')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="{{ asset('public/assets/chart-assets/canvas.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('public/assets/chart-assets/font-awesome.min.css')}}">

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="row mt-4" >
                <div class="col-3" style="padding-right: 0px;padding-left: 7px">
                    <div class="card bg-gradient-blue">
                        <div style="font-size: 1.2rem;" class="card-body text-center text-white ">
                            <span class="card-tital">Leads</span><br>
                            <span class="counter">{{ $data['totalLeads'] }}</span>
                            <hr>
                            <span class="mb-0 pt-3 text-white">This Month <span class="counter">{{$data['thisMonthLeads']}}</span></span>
                        </div>
                    </div>
                </div>
                <div class="col-3" style="padding-right: 0px;padding-left: 3px">
                    <div class="card bg-gradient-danger">
                        <div style="font-size: 1.2rem;" class="card-body text-center text-white ">
                            <span class="card-tital">Response Queries</span><br>
                            <span class="counter">{{ $data['responceQueries'] }}</span>
                            <hr>
                            <span class="mb-0 pt-3 text-white">This Month <span class="counter">{{ $data['thisMonthResponceQueirs'] }}</span></span>
                        </div>
                    </div>
                </div>
                <div class="col-3" style="padding-right: 0px;padding-left: 3px">
                    <div class="card bg-gradient-teal">
                        <div style="font-size: 1.2rem;" class="card-body text-center text-white ">
                            <span class="card-tital">Meetings</span><br>
                            <span class="counter">{{ $data['doneMeetings'] }}</span>
                            <hr>
                            <span class="mb-0 pt-3 text-white">This Month <span class="counter">{{ $data['doneMeetingsThisMonth'] }}</span></span>
                        </div>
                    </div>
                </div>
                <div class="col-3" style="padding-right: 10px;padding-left: 3px">
                    <div class="card bg-gradient-purple">
                        <div style="font-size: 1.2rem;" class="card-body text-center text-white ">
                            <span class="card-tital">Sales</span><br>
                            <span class="counter">{{ $data['sales'] }}</span>
                            <hr>
                            <span class="mb-0 pt-3 text-white">This Month <span class="counter">{{ $data['salesThisMonth'] }}</span></span>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                .custom-form{
                    width: 22%;
                    height: 10px;
                    padding: 12px 20px;
                    box-sizing: border-box;
                    border: 2px solid #ccc;
                    border-radius: 4px;
                    background-color: #f8f8f8;
                    resize: none;
                }
                .custom-form:focus{
                    border-color:lightskyblue;
                }
                .custom-select {
                    width: 22%;
                    padding: 1px 20px;
                    box-sizing: border-box;
                    border: 2px solid #ccc;
                    border-radius: 4px;
                    background-color: #f1f1f1;
                    height: 25px;

                }
                .custom-select:focus{
                    border-color:lightskyblue;
                }
            </style>
            <div class="row">

                <div class="col-md-12">
{{--                    <span class="text-center">Leads Analysis</span>--}}
                    <form action="">
                        <input type="text" class="date_range custom-form" name="date_range"/>
                        <select name="platform_id" id="" class="custom-select" style="margin-bottom: 10px">
                            <option value="">Social PlatForm</option>
                            @isset($data)
                                @foreach ($data['socialPlatforms'] as $platform)
                                    <option value="{{ $platform->id }}">{{ $platform->platform }}</option>
                                @endforeach
                            @endisset

                        </select>

                    </form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <canvas id="leadsAnalysisPieChart" style="width:100%;max-width:600px"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 text-center">
                            <div class="card">
                                <div class="card-body">
                                    <canvas id="leadsAnalysisBarChart" style="width:100%;max-width:600px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Statistics Widget -->
            <div class="row">
                <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">

                            <div class="row mb-3">
                                <div class="col-md-4"><h4 class="card-title mt-2">Leads</h4></div>
{{--                                <div class="col-md-8"><input type="text" class="form-control" name="daterange" /></div>--}}
                            </div>


                            <div class="statistics">
                                <div class="row">
                                    <div class="col-md-6 col-6 text-center">
                                        <div class="stats-box mb-4">
                                            <p>Today Leads</p>
                                            <h3 class="counter">{{ $data['todayCreatedLeads'] }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6 text-center">
                                        <div class="stats-box mb-4">
                                            <p>Total Leads</p>
                                            <h4 class="counter">{{ $data['totalLeads'] }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-purple" role="progressbar" style="width: 0%" aria-valuenow="30"
                                    aria-valuemin="0" aria-valuemax="100">30%</div>
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="18"
                                    aria-valuemin="0" aria-valuemax="100">22%</div>
                                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="12"
                                    aria-valuemin="0" aria-valuemax="100">24%</div>
                            </div>
                            <div>
                                <p><a href="{{ url('leads-params') . '/' . encrypt(6) . '/' . encrypt('admin') }}"><i
                                            class="fa fa-dot-circle-o text-warning mr-2"></i>Today Created Leads <span
                                            class="float-right counter">{{ $data['todayCreatedLeads'] }}</span></a></p>
                                <p>
                                    <a href="{{ url('leads-params') . '/' . encrypt(1) . '/' . encrypt('admin') }}"><i
                                            class="fa fa-dot-circle-o text-success mr-2"></i>Today Follow Up <span
                                            class="float-right counter">{{$data['todayFollowUpsLeads']}}</span></a>
                                </p>

                                <p><a href="{{ url('leads-params') . '/' . encrypt(2) . '/' . encrypt('admin') }}"><i
                                            class="fa fa-dot-circle-o text-purple  mr-2"></i>Tomorrow Follow Up <span
                                            class="float-right counter">{{ $data['tomorrowLeads']}}</span></a></p>

                                <p><a href="{{ url('leads-params') . '/' . encrypt(3) . '/' . encrypt('admin') }}"><i
                                            class="fa fa-dot-circle-o text-danger mr-2"></i>Not Approached Leads <span
                                            class="float-right counter">{{ $data['notApproachedLeads']}}</span></a>
                                </p>
                                <p><a href="{{ url('leads-params') . '/' . encrypt(4) . '/' . encrypt('admin') }}"><i
                                            class="fa fa-dot-circle-o text-info mr-2"></i>Over Due Leads <span
                                            class="float-right counter">{{ $data['overDueLeads'] }}</span></a></p>

{{--                                <p><a href="{{ url('leads-params') . '/' . encrypt(7) . '/' . encrypt('admin') }}"><i--}}
{{--                                            class="fa fa-dot-circle-o text-primary mr-2"></i>Open Leads <span--}}
{{--                                            class="float-right" id="open-lead-section"></span></a></p>--}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-12 col-xl-4 d-flex">

                    <div class="card flex-fill dash-statistics">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6"><span class="card-title mt-2">Temperatures </span></div>

                            </div>

                            <div>
                                <p>
                                    @php
                                        $temp = App\Models\Temprature::all();
                                    @endphp
                                    @foreach ($temp as $temp)
                                        @php
                                            $appLeads = App\Models\ApprochedLeads::getTempratureWiseLeads($temp->id,'counting','admin',NULL);
                                        @endphp
                                        <a
                                            href="{{ url('leads-temp-wise/admin') . '/' . ($temp->id . '/' . $temp->temp) }}">
                                            <i class="fa fa-dot-circle-o text-success mr-2"></i>{{ $temp->temp }}

                                            <span class="float-right counter">{{ $appLeads}}</span></a>
                                </p>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4"><h4 class="card-title mt-2">Calls</h4></div>
{{--                                <div class="col-md-8"><input type="text" class="form-control" name="daterange" /></div>--}}
                            </div>

                            <div class="statistics">
                                <div class="row">
                                    <div class="col-md-6 col-6 text-center">
                                        <div class="stats-box mb-4">
                                            <p>Total Calls</p>
                                            <h3 class="counter">{{ $data['totalCalls'] }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6 text-center">
                                        <div class="stats-box mb-4">
                                            <p>Calls<small>This Month</small></p>
                                            <h3 class="counter">{{ $data['thisMonthCalls'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p><i class="fa fa-dot-circle-o text-purple mr-2"></i>Connected <span
                                        class="float-right counter" >{{ $data['connected'] }}</span></p>
                                <p><i class="fa fa-dot-circle-o text-warning mr-2"></i>Connected <small>This month</small>
                                    <span class="float-right counter">{{ $data['thisMonthConnected'] }}</span>
                                </p>
                                <p><i class="fa fa-dot-circle-o text-success mr-2"></i>Not Connected <span
                                        class="float-right counter">{{ $data['notConnected'] }}</span></p>
                                <p><i class="fa fa-dot-circle-o text-danger mr-2"></i>Not Connected <small>This
                                        month</small> <span
                                        class="float-right counter">{{ $data['thisMonthnotConnected'] }}</span></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Sale Targets-->
            <div class="row">

                <div class="col-md-6 col-lg-6 col-xl-6 d-flex">
                    <div class="card flex-fill dash-statistics">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6"><h5 class="card-title mt-2">Sale Targets <small>(Team)</small></h5></div>

                            </div>
                            <div class="stats-list">
                                @isset($data['saleManager'])
                                    @foreach ($data['saleManager'] as $manager)
                                        @php
                                            $totalAcheive = 0;
                                            $target = $manager->target_in_numbers;
                                            $totalAcheive = getManagerTeamAcheivements($manager->id, 'sale');

                                            $pers = ($totalAcheive * 100) / $target;
                                            $bg = 'warning';
                                            $pers < 50 ? ($bg = 'danger') : '';
                                            $pers > 50 && $pers < 70 ? ($bg = 'info') : '';
                                            $pers > 70 && $pers < 80 ? ($bg = 'primary') : '';
                                            $pers > 80 ? ($bg = 'success') : '';
                                        @endphp

                                        <div class="stats-info">
                                            <p>{{ $manager->name }} ({{ round($pers, 0) }}%)
                                                <strong>{{ $totalAcheive }}
                                                    <small>/{{ $target }} </small></strong>
                                            </p>
                                            <div class="progress">
                                                <div class="progress-bar bg-{{ $bg }}" role="progressbar"
                                                    style="width:{{ $pers }}%" aria-valuenow="22" aria-valuemin="0"
                                                    aria-valuemax="100" title="10%"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6 d-flex">
                    <div class="card flex-fill dash-statistics">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6"><h5 class="card-title mt-2">Sale Targets <small>(individual)</small></h5></div>
{{--                                <div class="col-md-6"><input type="text" class="form-control" name="daterange" /></div>--}}
                            </div>
                            <div class="stats-list">

                                @isset($data['getIndividualSaleTeam'])
                                    @foreach ($data['getIndividualSaleTeam'] as $teamTarget)
                                        @php

                                            $totalAcheive=0;
                                                $target=$teamTarget->target_in_numbers;

                                                       $memberAcheive=getSalesManTargetAcheive($teamTarget->id,'sale');
                                                       $totalAcheive=$totalAcheive+$memberAcheive;

                                                    $pers=($totalAcheive *100)/$target;
                                                    $bg='warning';
                                                    ($pers<50)?$bg='danger':'';
                                                    ($pers>50 && $pers<70)?$bg='info':'';
                                                    ($pers>70 && $pers<80)?$bg='primary':'';
                                                    ($pers>80)?$bg='success':'';


                                        @endphp
                                        <div class="stats-info">
                                            <p>{{ $teamTarget->name }} ({{ $pers }})%
                                                <strong>{{ $totalAcheive }}<small>/{{ $target }}</small></strong>
                                            </p>
                                            <div class="progress">
                                                <div class="progress-bar bg-info" role="progressbar"
                                                    style="width: {{ $pers }}%" aria-valuenow="22" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Meetings Targets -->
            <div class="row">

                <div class="col-md-6 col-lg-6 col-xl-6 d-flex">
                    <div class="card flex-fill dash-statistics">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6"><h5 class="card-title mt-2">Meeting Targets <small>(Team)</small></h5></div>
{{--                                <div class="col-md-6"><input type="text" class="form-control" name="daterange" /></div>--}}
                            </div>

                            <div class="stats-list">
                                @isset($data['meetingManager'])
                                    @foreach ($data['meetingManager'] as $manager)
                                        @php
                                            $totalAcheive = 0;
                                            $target = $manager->target_in_numbers;
                                            $totalAcheive = getManagerTeamAcheivements($manager->id, 'meeting');
                                            $pers = ($totalAcheive * 100) / $target;
                                            $bg = 'warning';
                                            $pers < 50 ? ($bg = 'danger') : '';
                                            $pers > 50 && $pers < 70 ? ($bg = 'info') : '';
                                            $pers > 70 && $pers < 80 ? ($bg = 'primary') : '';
                                            $pers > 80 ? ($bg = 'success') : '';
                                        @endphp

                                        <div class="stats-info">
                                            <p>{{ $manager->name }} ({{ round($pers, 1) }}%)
                                                <strong>{{ $totalAcheive }}
                                                    <small>/{{ $target }} </small></strong>
                                            </p>
                                            <div class="progress">
                                                <div class="progress-bar bg-{{ $bg }}" role="progressbar"
                                                    style="width:{{ $pers }}%" aria-valuenow="22" aria-valuemin="0"
                                                    aria-valuemax="100" title="10%"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6 d-flex">
                    <div class="card flex-fill dash-statistics">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6"><h5 class="card-title mt-2">Meeting Targets <small>(individual)</small></h5></div>
{{--                                <div class="col-md-6"><input type="text" class="form-control" name="daterange" /></div>--}}
                            </div>

                            <div class="stats-list">

                                @isset($data['getIndividualMeetingTeam'])
                                    @foreach ($data['getIndividualMeetingTeam'] as $meetingTeam)
                                        @php

                                            $totalAcheive=0;
                                                $target=$meetingTeam->target_in_numbers;
                                                   $totalAcheive= getSalesManTargetAcheive($meetingTeam->id,'meeting');

                                                    $pers=($totalAcheive *100)/$target;
                                                    $bg='warning';
                                                    ($pers<50)?$bg='danger':'';
                                                    ($pers>50 && $pers<70)?$bg='info':'';
                                                    ($pers>70 && $pers<80)?$bg='primary':'';
                                                    ($pers>80)?$bg='success':'';


                                        @endphp
                                        <div class="stats-info">
                                            <p>{{ $meetingTeam->name }} ({{ round($pers, 1) }})%
                                                <strong>{{ $totalAcheive }}<small>/{{ $target }}</small></strong>
                                            </p>
                                            <div class="progress">
                                                <div class="progress-bar bg-info" role="progressbar"
                                                    style="width: {{ $pers }}%" aria-valuenow="22" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Leads Responce-->
            <!-- Graps -->

            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ url('inOutBoundleadsList') . '/' . encrypt(1) }}">
                                        <h3 class="card-title">Inbound</h3>
                                    </a>
                                    <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ url('inOutBoundleadsList') . '/' . encrypt(2) }}">
                                        <h3 class="card-title">Outbound</h3>
                                    </a>
                                    <canvas id="outBoundChart" style="width:100%;max-width:600px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        <!-- /Page Content -->
    </div>

    </div>

    <script src="{{ asset('public/assets/chart-assets/chart.js') }}"></script>
    <script>
        $(document).ready(function() {
            getInBoundValues();
            getOutBoundValues();
            LeadsAnalysisPieChart(0,0);
            LeadsAnalysisBarChart(0,0);
            function getInBoundValues() {

                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    data: {lead_type: 'inbound' },
                    url: '{{ url('getLeadsAcordingSocilaPlatforms') }}',
                    success: function(data) {
                        var platforms = [];
                        var noOfVal = [];
                        for (i = 0; i < data.length; i++) {
                            platforms.push(data[i].platform);
                            noOfVal.push(data[i].total);
                        }
                        var xValues = platforms;
                        var yValues = noOfVal
                        var barColors = ["#3b5998", "#E1306C", "#25D366", "#800000"];
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
                                legend: {
                                    display: false
                                },
                                title: {
                                    display: true,
                                    text: "The A Team Leads"
                                }
                            }
                        });
                    },
                });
            }
            function getOutBoundValues() {

                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    data: {
                        lead_type: 'outbound'
                    },
                    url: '{{ url('getLeadsAcordingSocilaPlatforms') }}',
                    success: function(data) {

                        var platforms = [];
                        var noOfVal = [];
                        for (i = 0; i < data.length; i++) {
                            platforms.push(data[i].platform);
                            noOfVal.push(data[i].total);
                        }

                        var xValues = platforms;
                        var yValues = noOfVal
                        var barColors = ["#3b5998", "#E1306C", "#25D366", "#800000"];

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
                                legend: {
                                    display: false
                                },
                                title: {
                                    display: true,
                                    text: "The A Team Call Center Leads"
                                }
                            }
                        });
                    },
                });
            }
            function LeadsAnalysisPieChart(platform_id,date_range) {

                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    data: {platform_id:platform_id,date_range:date_range},
                    url: '{{ url('leads-analysis') }}',
                    success: function(data) {
                        var barColors = ["#C7A183","#F6D0E8","#83D475","#df1b1b"];
                        new Chart("leadsAnalysisPieChart", {
                            type: "pie",
                            data: {
                                labels: ['Calls','Visit','Sale','Dead'],
                                datasets: [{
                                    backgroundColor: barColors,
                                    data: [data.platFormsCallsPerc,data.platFormsVistsPerc,data.platFormsSalePerc,data.platFormDeadPerc],
                                }],
                            },
                            options: {
                                legend: {
                                    display: true,
                                },
                            }
                        });
                    },


                });

            }
            function LeadsAnalysisBarChart(platform_id,date_range) {
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    data: {platform_id:platform_id,date_range:date_range},
                    url: '{{ url('leads-analysis') }}',
                    success: function(data) {
                        var barColors = [data.platFormColor,"#C7A183","#F6D0E8","#83D475","#df1b1b"];
                        new Chart("leadsAnalysisBarChart", {
                            type: "bar",
                            data: {
                                labels: [data.platFormName,'Calls','Visit','Sale','Dead'],
                                indexLabel: "{name}",
                                datasets: [{
                                    backgroundColor: barColors,
                                    data: [data.platformTotalLeads,data.platFormsCalls,data.platFormsVists,data.platFormsSale,data.platFormsDead],
                                }],

                            },
                            options: {
                                legend: { display: false},
                            }
                        });
                    },


                });

            }
            $('select[name=platform_id]').change(function() {
                var platform_id=$('select[name=platform_id]').val();
                var date_range=$('input[name=date_range]').val();

                LeadsAnalysisPieChart(platform_id,date_range);
                LeadsAnalysisBarChart(platform_id,date_range);
            });

            $('input[name=date_range]').change(function() {
                var date_range=$('input[name=date_range]').val();

                LeadsAnalysisPieChart(0,date_range);
                LeadsAnalysisBarChart(0,date_range);
            });
            $(document).ready(function () {
                $('.counter').each(function () {
                    $(this).prop('counter', 0).animate({
                        counter: $(this).text()
                    }, {
                        duration: 3000,
                        easing: 'swing',
                        step: function (now) {
                            $(this).text(Math.ceil(now));
                        }
                    });
                });
            });

        });
    </script>

@endsection
