@extends('setup.master')
@section('content')
    <style type="text/css">
        body {
            font-family: Arial;
            font-size: 10pt;
        }

    </style>
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Weekly Exp Report</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Weekly Exp Report</li>
                        </ul>
                    </div>


                </div>
            </div>


            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Sr.NO</th>
                    <th scope="col">Head</th>
                    @php
                        $month = date('m');
                        $year = date('Y');
                        $a_date = $year . '-' . $month;
                                $lastDayOfThisMonth = date('t', strtotime(date('Y-m-d')));
                               $i=0;
                                 while($i<=$lastDayOfThisMonth){
                    @endphp

                    <th scope="col">{{$i=$i+1}}-{{$i}}</th>
                    @php
                        $i=$i+6;     } @endphp

                    <th scope="col">Total</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <th scope="row">Staff salaries</th>
                    <td>-</td>
                    <td>-</td>

                </tr>
                </tbody>
            </table>
        </div>
    </div>



@endsection
