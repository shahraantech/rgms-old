@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Attendance Check Out Report</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Attendance Check Out Report</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->


            <!-- Search Filter -->
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('checkout-report') }}" method="POST" id="searchFrom">
                        @csrf
                        <div class="row filter-row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="emp_id" class="form-control selectpicker" data-container="body"
                                        data-live-search="true">
                                        <option value="" selected disabled>Choose employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="date" class="form-control floating " name="date">
                                </div>
                            </div>
                            <div class="col-md-2">
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
                            <div class="col-md-2">
                                <div class="form-group form-focus select-focus">
                                    <select class="form-control floating select" name="year">
                                        <option value="">Choose Year</option>
                                        @for ($y = 2021; $y <= date('Y'); $y++)
                                            <option value="{{ $y }}">{{ $y }} </option>
                                        @endfor

                                    </select>

                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-primary searchBtn"> <i class="fa fa-search"></i></button>
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
                                            <th>Employee </th>
                                            <th>Date </th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Production</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($atts as $key => $att)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $att->employee->name }}</td>
                                                <td>{{ date('d M Y', strtotime($att->date)) }}</td>
                                                <td>
                                                    @if ($att->status == 'Present')
                                                        {{ date('h:i a', strtotime($att->created_at)) }}
                                                    @else
                                                        <span class="badge bg-danger">{{ $att->status }}</span>
                                                    @endif
                                                </td>
                                                @if ($att->chek_out == 1)
                                                    <td>{{ date('h:i a', strtotime($att->updated_at)) }}</td>
                                                @else
                                                    <td>-</td>
                                                @endif
                                                <td>
                                                    @php
                                                        $loginTime = new DateTime($att->created_at);
                                                        $outTime = new DateTime($att->updated_at);
                                                        $interval = $loginTime->diff($outTime);
                                                    @endphp
                                                    {{ $interval->format('%h') . ':' . $interval->format('%i') . ' Hrs' }}
                                                </td>
                                            </tr>
                                        @endforeach
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

    <!--Count down!-->
    <script>
        $(document).ready(function() {

            $('.searchBtn').on('click', function() {
                $(".searchBtn").prop("disabled", true);
                $(".searchBtn").html("Searching...");
                $('#searchFrom').submit();
            });

            //Datatables
            $('#datatable').DataTable();

        });
        // Set the date we're counting down to
    </script>
@endsection
