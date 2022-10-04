@extends('setup.master')
@section('content')

    <style type="text/css">
        body
        {
            font-family: Arial;
            font-size: 10pt;
        }
        table
        {
            border: 1px solid #ccc;
            border-collapse: collapse;
        }
        table th
        {
            background-color: #F7F7F7;
            color: #333;
            font-weight: bold;
        }
        table th, table td
        {
            padding: 5px;
            border: 1px solid #ccc;
        }
    </style>
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header my-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title bold-heading">Ledger History</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Ledger History</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h3>{{(($data['acName'])?$data['acName']:'')}}</h3>
                @if($data['ledgerDetail']->count() > 0)
                <table class="table table-striped table-hover" id="datatable">

                    <thead>
                        <tr>
                            <th>SR#</th>
                            <th>Date</th>
                            <th>Particular</th>
                            <th>DR</th>
                            <th>CR</th>
                            <th>Balance</th>
                        </tr>


                    <tbody>
                    @php
                     $c=0;
                    $totalDr=0;
                    $totalCr=0;
                    $currBalance=0;
                    $crBalanceAmount=0;
                    $drBalanceAmount=0;



                    @endphp
                    @isset($data['ledgerDetail'])
                        @foreach ($data['ledgerDetail'] as $ledger)
                            @php
                                $c++;

                if($ledger->ledger_type=='dr'){
                    $drBalanceAmount=$ledger->amount;
                $totalDr=$totalDr+$ledger->amount;
                }
                 if($ledger->ledger_type=='cr'){
                     $crBalanceAmount=$ledger->amount;
                $totalCr=$totalCr+$ledger->amount;
                }
                @endphp
                    <tr>
                        <td>{{$c}}</td>
                        <td>{{$ledger->created_at}}</td>
                        @php

                            $particular=App\Models\Transaction::find($ledger->transaction_id);
                            @endphp
                        <td>{{ !empty($particular->desc)?$particular->desc:'' }}</td>
                        <td>

                            @if($ledger->ledger_type=='dr')
                            {{number_format($ledger->amount)}}
                            @else
                               @php
                                   $drBalanceAmount=0;
                               @endphp
                            -
                                @endif
                        </td>
                        <td>
                            @if($ledger->ledger_type=='cr')
                                {{number_format($ledger->amount)}}
                            @else
                               @php $crBalanceAmount=0; @endphp
                                -
                            @endif
                        </td>
                        @php
                        $currBalance=$currBalance + $drBalanceAmount - $crBalanceAmount;
                        @endphp

                        <td>{{number_format($currBalance)}}</td>

                    </tr>
                        @endforeach
                    @endisset
                    </tbody>
                    <tr>
                        <td>
                            <div class="float-right"> <strong>Total:</strong></div>
                        </td>
                        <td colspan="3">
                            <div class="float-right"> <strong> {{number_format($totalDr)}} PKR</strong></div>
                        </td>
                        <td><div class="float-right"> <strong> {{number_format($totalCr)}} PKR</strong></div></td>
                        <td><div class="float-right"> <strong>Balance: {{number_format($totalDr - $totalCr)}} PKR</strong></div></td>
                    </tr>
                </table>
                @else
                <div class="alert alert-danger">Record not exist</div>
                    @endif
            </div>
        </div>

    </div>
</div>
@endsection
