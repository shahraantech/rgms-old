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
                    <h3 class="page-title bold-heading">Ledgers</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Ledgers  List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-hover" id="datatable">
                    <thead>
                        <tr>
                            <th>SR#</th>
                            <th>COA Head</th>
                            <th>Activity</th>
                            <th>Narration</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $c=0; @endphp
                    @isset($data['ledger'])
                        @foreach ($data['ledger'] as $ledger)
                            @php $c++; @endphp
                    <tr>
                        <td>{{$c}}</td>
                        <td>
@php
    $levelHeadName=App\Models\Ledger::getLevelHeadName($ledger->coa_level,$ledger->coa_head_id)

    @endphp
                            {{$levelHeadName}}
                        </td>
                        <td>{{strtoupper($ledger->trans_type)}}</td>

                        <td>{{$ledger->desc}}</td>
                        <td>{{$ledger->amount}}</td>

                    </tr>
                        @endforeach
                    @endisset
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
