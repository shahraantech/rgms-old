@extends('setup.master')
@section('content')




    <div class="main-wrapper">


        <!-- /Sidebar -->

        <!-- Page Wrapper -->
        <div class="page-wrapper">

            <!-- Page Content -->
            <div class="content container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Monthly Attendance Report</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Monthly Attendance Report</li>
                            </ul>
                        </div>
                    </div>

                </div>
                <!-- /Page Header -->



                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('monthly-att-report') }}" method="post" id="searchAtt">

                            @csrf
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">

                                        <select name="company_id" class="form-control selectpicker" data-container="body"
                                            data-live-search="true" required>
                                            <option value="" selected disabled>Choose Company</option>
                                            @isset($data['company'])
                                                @foreach ($data['company'] as $comp)
                                                    <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="search_month" class="form-control selectpicker" data-container="body"
                                            data-live-search="true">
                                            <option value="" selected disabled>Choose Month</option>
                                            <option value="01">Jan</option>
                                            <option value="02">Feb </option>
                                            <option value="03">Mar</option>
                                            <option value="04">Apr</option>
                                            <option value="05">May</option>
                                            <option value="06">Jun</option>
                                            <option value="07">Jul</option>
                                            <option value="08">Aug</option>
                                            <option value="09">Sep</option>
                                            <option value="10">Oct</option>
                                            <option value="11">Nov</option>
                                            <option value="12">Dec</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">

                                        <select class="select" name="search_year">
                                            <option value="">Choose Year</option>
                                            @for ($y = 2021; $y <= date('Y'); $y++)
                                                <option value="{{ $y }}">{{ $y }} </option>
                                            @endfor

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-primary btn-search" type="submit"> <i
                                            class="fa fa-search"></i></button>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>




            </div>
            <!-- /Page Content -->

        </div>
        <!-- /Page Wrapper -->

    </div>
    <script>
        $('.btn-search').on('click', function() {
            $(".btn-search").prop("disabled", true);
            $(".btn-search").html("Please wait...");
            $('#searchAtt').submit();
        });
    </script>
@endsection
