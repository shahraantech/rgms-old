@extends('setup.master')
@section('content')

    <div class="page-wrapper" id="body">
        <style type="text/css">
            body {
                font-family: Arial;
            }

            table {
                border: 1px solid #ccc;
                border-collapse: collapse;
            }

            table th {
                background-color: #F7F7F7;
                color: #333;
                font-weight: bold;
            }

            table th,
            table td {
                padding: 5px;
                border: 1px solid #ccc;
            }

            #table-scroll {
                overflow: auto;
            }

            .salary {
                background-color: #000;
                padding: 10px 10px;
            }
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Salary Report</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Salary  Report</li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="card">

                <div class="card-body">
                    <form action="{{ url('dept-wise-salary-report') }}" method="post" id="SearchForm">
                        @csrf
                        <div class="row filter-row">
                            <div class="col-sm-6 col-md-3">

                                <div class="form-group">

                                    <select name="company_id" class="form-control selectpicker" data-container="body"
                                            data-live-search="true" title="Choose Company">

                                        @isset($data)
                                            @foreach ($data['companies'] as $company)
                                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>


                            </div>
                            <div class="col-sm-6 col-md-3">

                                <div class="form-group">
                                    <select name="dept_id" class="form-control selectpicker" data-container="body"
                                            data-live-search="true">
                                        @isset($data['departments'])
                                            <option value="" selected disabled>Choose one</option>
                                            @foreach ($data['departments'] as $dep)
                                                <option value="{{ $dep->id }}">{{ $dep->departments }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>


                            <div class="col-sm-6 col-md-2">
                                <button type="submit" class="btn btn-primary btn-search"> <i class="fa fa-search"></i> </button>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="card">
                <div class="card-body">
                    <div id="table-scroll">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Salary</th>
                                </tr>

                                @php
                                    $grandTotal = 0;

                                @endphp

                                @isset($data['depts'])
                                    @foreach ($data['depts'] as $dept)
                                        @php

                                            $emp = getEmployeesAcordingDept($dept->id);
                                            $c = 0;
                                              $subTotal = 0;
                                        @endphp


                                        <tr>
                                            <td colspan="16" class="font-weight-bold text-center font-18">{{ $dept->departments }}
                                            </td>
                                        </tr>
                                        @foreach ($emp as $emp)
                                            @php

                                                 $c++;
                                                 $subTotal=$subTotal+ $emp->gross_salary;

                                            @endphp
                                            <tr>
                                                <td>{{ $c }}</td>
                                                <td>{{ $emp->name }}</td>
                                                <td>{{ $emp->getDesignation['desig_name'] }}</td>
                                                <td>{{ $emp->gross_salary }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>
                                                <div class="float-right"> <strong>Sub Total:</strong></div>
                                            </td>
                                            <td colspan="3">
                                                <div class="float-right"> <strong>PKR: {{ $subTotal }}</strong></div>
                                            </td>
                                        </tr>
                                        @php
                                            $grandTotal = $grandTotal + $subTotal;
                                            @endphp
                                    @endforeach
                                @endisset

                                <tr>

                                    <td>
                                        <div class="float-right"> <strong>Grand Total:</strong></div>
                                    </td>
                                    <td colspan="14">
                                        <div class="float-right"> <strong>PKR: {{ $grandTotal }}</strong></div>
                                    </td>
                                </tr>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>


</div>


    <script>

        $('.btn-search').on('click', function() {
            $(".btn-search").prop("disabled", true);
            $(".btn-search").html("Please wait...");
            $('#SearchForm').submit();
        });
    </script>
    @endsection
