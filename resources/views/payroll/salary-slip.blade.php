@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Payslip</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payslip</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-white"><i class="fa fa-print fa-lg" onclick="window.print()"></i> Print</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="payslip-title">Payslip for the month of {{date('M Y',strtotime(date('d M Y')))}}</h4>
                            <div class="row">
                                <div class="col-sm-6 m-b-20">
                                    <ul class="list-unstyled mb-0">
                                        <li>Alpha Buzz Co</li>
                                        <li>Corporate Office, 61xx,</li>
                                        <li>DHA PHASE III, Lahore, Pakistan</li>
                                    </ul>
                                </div>
                                <div class="col-sm-6 m-b-20">
                                    <div class="invoice-details">
                                        <h3 class="text-uppercase">Payslip #{{$data['slipNo']->id}}</h3>
                                        <ul class="list-unstyled">
                                            <li>Salary Month: {{$data['month']}} <span></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 m-b-20">
                                    <ul class="list-unstyled">
                                        <li>
                                            <h5 class="mb-0"><strong>{{($data['employee']->name)?$data['employee']->name:''}}</strong></h5>
                                        </li>
                                        <li><span> {{($data['employee']->desig_name)?$data['employee']->desig_name:''}}</span></li>
                                        <li>Employee ID: AB-{{($data['employee']->id)?$data['employee']->id:''}}</li>
                                        <li>Joining Date:{{($data['employee']->doj)?date('d M Y',strtotime($data['employee']->doj)):''}}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div>
                                        <h4 class="m-b-10"><strong>Earnings</strong></h4>
                                        <table class="table table-bordered">
                                            <tbody>
                                            <tr>
                                                <td><strong>Basic Salary:</strong> <span class="float-right"><strong>RS {{$data['employee']->gross_salary}} </strong></span></td>

                                            </tr>

                                            @isset($data['allownce'])
                                                @foreach($data['allownce'] as $allow)

                                                    <tr>
                                                        <td><strong>{{$allow->allowance}}</strong> <span class="float-right">RS {{  ($allow->amount);}}</span></td>
                                                    </tr>
                                                @endforeach
                                            @endisset
                                            <tr>
                                                <td><strong>Gross Salary:</strong> <span class="float-right"><strong>RS {{ $data['incomeSalary']}}</strong></span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <h4 class="m-b-10"><strong>Claim Expense</strong></h4>
                                        <table class="table table-bordered">
                                            <tbody>

                                            <tbody>
                                            @isset($data['expense'])
                                                @foreach($data['expense'] as $exp)
                                                    <tr>
                                                        <td><strong>{{$exp->expense_type}}</strong> <span class="float-right">RS {{$exp->expense_amount}}</span></td>
                                                    </tr>
                                                @endforeach
                                            @endisset
                                            <tr>
                                                <td><strong>Total Expense</strong> <span class="float-right"><strong>RS {{ $data['sumOfExpense']}}</strong></span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <h4 class="m-b-10"><strong></strong></h4>
                                        <table class="table table-bordered">
                                            <tbody>
                                            <tbody>
                                            @isset($data['absent'])

                                                <tr>
                                                    <td><strong>Presents:</strong> <span class="float-right"> {{$data['present']}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Absents:</strong> <span class="float-right">  {{$data['absent']}}</span></td>
                                                </tr>
                                            @endisset
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <p><strong>Net Salary: RS <span style="background: yellow">{{round($data['incomeSalary'],2)}}</span></strong> {{App\Models\Payroll::numberTowords(round($data['incomeSalary']),2)}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
@endsection
