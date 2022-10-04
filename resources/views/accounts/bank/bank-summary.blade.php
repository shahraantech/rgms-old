@extends('setup.master')
@section('content')

    <style type="text/css">
        body {
            font-family: Arial;
            font-size: 10pt;
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
    </style>
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Bank Summary</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Bank Summary</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Sr</th>
                            <th>Bank Name</th>
                            <th>Branch</th>
                            <th>A/C Name</th>
                            <th>A/C Number</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Balance</th>
                        </tr>
                        <tbody>
                        @php $c=0; @endphp
                        @isset($data['summary'])
                            @foreach($data['summary'] as $summary)
                                @php $c++; @endphp
                                <tr>
                                    <td>{{$c}}</td>
                                    <td>{{$summary->branchname['bankname']['bank_name']}}</td>
                                    <td>{{$summary->branchname['branch']}}</td>
                                    <td>{{$summary->branchname['ac_name']}}</td>
                                    <td>{{$summary->branchname['ac_number']}}</td>

                                    <td>
                                        {{$summary->transaction_type}}
                                        @if($summary->transaction_type=='db')
                                           (+)
                                            @else
                                            (-)
                                            @endif
                                    </td>

                                    <td>{{$summary->amount}}</td>
                                    <td>{{$summary->balance}}</td>
                                </tr>
                            @endforeach
                        @endisset
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
@endsection
