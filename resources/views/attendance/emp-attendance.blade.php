@extends('setup.master')
@section('content')

    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Attendance</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Attendance</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-4">
                    <div class="card punch-status">
                        <div class="card-body">
                            <h5 class="card-title">Timesheet <small
                                    class="text-muted">{{ date('d M Y', strtotime(date('d-M-Y'))) }}</small></h5>
                            <div class="punch-det">
                                <h6>Check In at</h6>
                                @if (!empty($data['att']->created_at))
                                    <p>{{ $data['att']->created_at ? date('d M Y h:i:s a', strtotime($data['att']->created_at)) : '' }}
                                    </p>
                                @endif
                            </div>
                            <div class="punch-info">
                                <div class="punch-hours">
                                    <span id="time">{{ $data['currentDiff'] }} hrs</span>
                                </div>
                            </div>
                            <div class="punch-btn-section">
                                @if (empty($data['is_check_out']->count() > 0))
                                    <button type="button" class="btn btn-primary punch-btn btn-attendance"
                                        data="1">Check In </button>
                                @else
                                    <button type="button" class="btn btn-danger punch-btn btn-attendance" data="0"
                                        atId="{{ $data['att']->id }}">Logout</button>
                                @endif
                            </div>
                            <div class="statistics">
                                <div class="row">
                                    <div class="col-md-6 col-6 text-center">
                                        <div class="stats-box">
                                            <p>Break</p>
                                            <h6>{{ empty($data['times']->break_time) ? '' : $data['times']->break_time }}
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6 text-center">
                                        <div class="stats-box">
                                            <p>Short Leave Time</p>
                                            <h6>{{ empty($data['times']->short_leave_time) ? '' : $data['times']->short_leave_time }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="card att-statistics">
                        <div class="card-body">
                            <h5 class="card-title">Working Status</h5>
                            <div class="stats-list">
                                <div class="stats-info">
                                    <p>Today <strong>{{ $data['currentDiff'] }} <small>/ {{ $data['workHours'] }}
                                                hrs</small></strong></p>
                                    <div class="progress">
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>This Week <strong>
                                            @isset($data['weekWorkProgress']['weeklyWorkedHrs'])
                                                {{ $data['weekWorkProgress']['weeklyWorkedHrs'] }} <small>/
                                                    {{ $data['weekWorkProgress']['weekWorkingHrs'] }} hrs</small>
                                            @else
                                                0 <small>/ 0 hrs</small>
                                            @endisset

                                        </strong></p>
                                    <div class="progress">
                                        @isset($data['weekWorkProgress']['weeklyProgress'])
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ $data['weekWorkProgress']['weeklyProgress'] }}%"
                                                aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                        @else
                                            <div class="progress-bar bg-success" role="progressbar" style="width:0%"
                                                aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                        @endisset
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>This Month <strong>
                                            @isset($data['monthlyWorkProgress']['monthlyCompletedHrs'])
                                                {{ $data['monthlyWorkProgress']['monthlyCompletedHrs'] }} <small>/
                                                    {{ $data['monthlyWorkProgress']['monthlyWorkingHrs'] }} hrs</small>
                                            @else
                                                0 <small>/ 0 hrs</small>
                                            @endisset
                                        </strong></p>
                                    <div class="progress">
                                        @isset($data['monthlyWorkProgress']['monthlyProgress'])
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ $data['monthlyWorkProgress']['monthlyProgress'] }}%"
                                                aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                        @else
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 0%"
                                                aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                        @endisset
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Remaining <strong>
                                            @isset($data['monthlyWorkProgress']['monthlyCompletedHrs'])
                                                {{ $data['monthlyWorkProgress']['monthlyCompletedHrs'] }} <small>/
                                                    {{ $data['monthlyWorkProgress']['monthlyWorkingHrs'] }} hrs</small>
                                            @else
                                                0 <small>/ 0 hrs</small>
                                            @endisset
                                        </strong></p>
                                    <div class="progress">
                                        @isset($data['monthlyWorkProgress']['monthlyProgress'])
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                style="width: {{ $data['monthlyWorkProgress']['monthlyProgress'] }}%"
                                                aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                        @else
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 0%"
                                                aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                        @endisset
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card recent-activity">
                        <div class="card-body">
                            <h5 class="card-title">Today Activity</h5>
                            <ul class="res-activity-list">
                                <li>
                                    <p class="mb-0">Check In at</p>
                                    <p class="res-activity-time">
                                        <i class="fa fa-clock-o"></i>
                                        @if (!empty($data['att']->created_at))
                                            {{ date('h:i:s', strtotime($data['att']->created_at)) }}
                                        @endif
                                    </p>
                                </li>
                                <li>
                                    <p class="mb-0">Check Out at</p>
                                    <p class="res-activity-time">
                                        <i class="fa fa-clock-o"></i>
                                        @if (!empty($data['att']->created_at))
                                            {{ $data['att']->chek_out == 1 ? date('h:i:s', strtotime($data['att']->updated_at)) : '' }}
                                        @endif
                                    </p>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Search Filter -->
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('emp-attendance') }}" method="post" id="att_form">
                        @csrf
                        <div class="row filter-row">

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="date" class="form-control floating " name="date">
                                    <input type="hidden" name="search" value="1">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group form-focus select-focus">
                                    <select class="select floating" name="month">
                                        <option value="">Choose Month</option>
                                        <option value="1">Jan</option>
                                        <option value="2">Feb</option>
                                        <option value="3">Mar</option>
                                        <option value="4">Apr</option>
                                        <option value="5">May</option>
                                        <option value="6">Jun</option>
                                        <option value="7">Jul</option>
                                        <option value="8">Aug</option>
                                        <option value="9">Sep</option>
                                        <option value="10">Oct</option>
                                        <option value="11">Nov</option>
                                        <option value="12">Dec</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group form-focus select-focus">
                                    <select class="select floating" name="year">
                                        <option value="">Choose Year</option>
                                        <option value="2030">2030</option>
                                        <option value="2029">2029</option>
                                        <option value="2028">2028</option>
                                        <option value="2027">2027</option>
                                        <option value="2026">2026</option>
                                        <option value="2025">2025</option>
                                        <option value="2024">2024</option>
                                        <option value="2023">2023</option>
                                        <option value="2022">2022</option>
                                        <option value="2021">2021</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-primary btn_att_search"> <i class="fa fa-search"></i></button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <!-- /Search Filter -->

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date </th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Production</th>
                                            <th>Break</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @isset($data)
                                            @php $c=0; @endphp
                                            @foreach ($data['all_att'] as $row)
                                                @php $c++; @endphp

                                                <tr>
                                                    <td>{{ $c }}</td>
                                                    <td>{{ date('d M Y', strtotime($row->date)) }}</td>
                                                    <td>
                                                        @if ($row->status == 'Present')
                                                            {{ date('h:i a', strtotime($row->created_at)) }}
                                                        @else
                                                            <span class="badge bg-danger">{{ $row->status }}</span>
                                                        @endif
                                                    </td>
                                                    @if ($row->chek_out == 1)
                                                        <td>{{ date('h:i a', strtotime($row->updated_at)) }}</td>
                                                    @else
                                                        <td>-</td>
                                                    @endif
                                                    <td>
                                                        @php
                                                            $loginTime = new DateTime($row->created_at);
                                                            $outTime = new DateTime($row->updated_at);
                                                            $interval = $loginTime->diff($outTime);
                                                        @endphp
                                                        {{ $interval->format('%h') . ':' . $interval->format('%i') . 'hrs' }}
                                                    </td>

                                                    <td>1 hrs</td>

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




    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {

            $('.btn-attendance').on('click', function() {
                var status = $(this).attr('data');
                var id = $(this).attr('atId');
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ url('mark-emp-attendance') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        at_status: status,
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (data.success) {
                            toastr.success(data.success);
                            window.location.reload();
                        }
                        if (data.error) {
                            toastr.error(data.error);
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });

            });

        });
    </script>
    <!--Count down!-->
    <script>
        $(document).ready(function() {

            countDownFunction();

            function countDownFunction() {

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('getChekOutTime') }}',
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        var chekOut = data.time;
                        var dateNow = data.date;
                        var today = dateNow + ' ' + chekOut;
                        var myTime = new Date(today);
                        // var myTime=new Date("2021-12-24,18:00:00");
                        var countDownDate = new Date(myTime).getTime();
                        // Update the count down every 1 second
                        var x = setInterval(function() {
                            // Get today's date and time
                            var now = new Date().getTime();

                            // Find the distance between now and the count down date
                            var distance = countDownDate - now;

                            // Time calculations for days, hours, minutes and seconds
                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 *
                                60 * 60));
                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 *
                                60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            // Output the result in an element with id="demo"
                            document.getElementById("time").innerHTML = hours + ":" +
                                minutes + ":" + seconds;

                            // If the count down is over, write some text
                            if (distance < 0) {
                                clearInterval(x);
                                document.getElementById("time").innerHTML = "EXPIRED";
                            }
                        }, 1000);
                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }


            $('.btn_att_search').on('click', function() {
                $(".btn_att_search").prop("disabled", true);
                $(".btn_att_search").html("Please wait...");
                $('#att_form').submit();
            });


            //Datatables
            $('#datatable').DataTable();

        });
        // Set the date we're counting down to
    </script>


@endsection
