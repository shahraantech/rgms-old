@extends('setup.master')
@section('content')


    <style type="text/css">
        body {
            font-family: Arial;
            font-size: 10pt;
        }
    </style>
    </style>
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Monthly Loss & Profit Report</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Monthly Loss & Profit</li>
                        </ul>
                    </div>


                </div>
            </div>

            <div class="card">

                <div class="card-body">
                    <form action="{{ url('monthly-profit-loss-report') }}" method="POST" id="monthFilter">
                        @csrf
                        <div class="row filter-row">
                            <div class="col-sm-6 col-md-3">

                                <select class="form-control floating select search_month" name="search_month">
                                    <option value="">Choose Month</option>
                                    <option value="01">Jan</option>
                                    <option value="02">Feb </option>
                                    <option value="03">Mar</option>
                                    <option value="04">Apr</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">Jul</option>
                                    <option value="08">Aug</option>
                                    <option value="09">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>

                                </select>


                            </div>
                            <div class="col-sm-6 col-md-3">

                                <select class="form-control floating select" name="year">
                                    <option value="">Choose Year</option>
                                    @for ($y = 2021; $y <= date('Y'); $y++)
                                        <option value="{{ $y }}">{{ $y }} </option>
                                    @endfor

                                </select>
                            </div>


                            <div class="col-sm-6 col-md-2">
                                <button type="submit" class="btn btn-primary monthSearch"> <i class="fa fa-search"></i> </button>
                            </div>


                        </div>
                    </form>
                    <table class="table table-bordered mt-5 table-hover table-striped" id="datatable">
                        <thead>
                            <tr class="bold-tr">
                                <th>#</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Pur Price</th>
                                <th>Sale Price</th>
                                <th>Profit </th>
                                <th>Created At </th>


                            </tr>
                        </thead>
                        <tbody id="profileReportTable">
                            @isset($data['profitReport'])
                                @foreach ($data['profitReport'] as $key => $report)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $report['p_name'] }}</td>
                                        <td>{{ $report['qty'] }}</td>
                                        <td>{{ $report['pur_price'] }}</td>
                                        <td>{{ number_format($report['sale_price'], 2) }}</td>
                                        <td>{{ number_format($report['profit'], 2) }}</td>
                                        <td>{{ $report['created_at'] }}</td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /Page Content -->
        </div>


        <script>
            $('.monthSearch').on('click', function() {
                $(".monthSearch").prop("disabled", true);
                $(".monthSearch").html("Please wait...");
                $('#monthFilter').submit();
            });
        </script>

    @endsection
