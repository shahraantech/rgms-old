@extends('setup.master')
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Today Summary</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Today Summary</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6 d-flex">
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Payable</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table  custom-table mb-0">
                                    <thead>
                                    <tr>
                                        <th>Invoice#</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @php $paybaleTotal=0; @endphp
                                    @isset($data['payAbale'])
                                        @foreach($data['payAbale'] as $payable)

                                            @php $paybaleTotal=$paybaleTotal+ $payable->amount; @endphp
                                    <tr>
                                        <td>INV-{{$payable->id}}</td>
                                        <td>{{$payable->name}}</td>
                                        <td>{{number_format($payable->amount)}}</td>

                                    </tr>
                                        @endforeach
                                    @endisset

                                    <tr>
                                        <td>
                                            <div class="float-right"> <strong>Total:</strong></div>
                                        </td>
                                        <td colspan="1">

                                        </td>
                                        <td> <strong>{{number_format($paybaleTotal,2)}}</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 d-flex">
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Paid</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table custom-table table-nowrap mb-0">
                                    <thead>
                                    <tr>
                                        <th>SR#</th>
                                        <th>Name</th>
                                        <th>Receipt Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @php $paidTotal=0; @endphp
                                    @isset($data['todayPaid'])
                                        @foreach($data['todayPaid'] as $paid)

                                            @php $paidTotal=$paidTotal+ $paid->amount; @endphp
                                            <tr>
                                                <td>TRNS-{{$paid->id}}</td>


                                                @php
                                                    $res='';
                                                    $exp=[];
                                                    if($paid->ac_type=='VENDORS'){
                                                    $res=App\Models\Vendor::find($paid->ac_id);
                                                    }
                                                    if($paid->ac_type=='CLIENTS'){
                                                    $res=App\Models\Client::find($paid->ac_id);
                                                    }
                                                    if($paid['ac_type']=='COMPANY' && $paid['mode']=='expense'){
                                                    $exp=App\Models\ExpenseHead::find($paid['exp_head_id']);
                                                     }
                                                @endphp
                                                <td>
                                                    @if($exp)
                                                        {{ $exp->exp_head }}
                                                    @endif

                                                    @if($res)
                                                        {{ $res->name }}
                                                    @endif
                                                </td>
                                                <td>{{number_format($paid->amount,2)}}</td>

                                            </tr>
                                        @endforeach
                                    @endisset

                                    <tr>
                                        <td>
                                            <div class="float-right"> <strong>Total:</strong></div>
                                        </td>
                                        <td colspan="1">

                                        </td>
                                        <td> <strong>{{number_format($paidTotal,2)}}</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">

                <div class="col-md-6 d-flex">
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Receiveable</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table  custom-table mb-0">
                                    <thead>
                                    <tr>
                                        <th>Invoice#</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    @php $totalReceiveable=0; @endphp
                                    @isset($data['receiveAble'])
                                        @foreach($data['receiveAble'] as $recvable)

                                            @php $totalReceiveable=$totalReceiveable+ $recvable->amount; @endphp
                                            <tr>
                                                <td>INV-{{$recvable->id}}</td>
                                                <td>{{$recvable->name}}</td>
                                                <td>{{number_format($recvable->amount)}}</td>

                                            </tr>
                                        @endforeach
                                    @endisset

                                    <tr>
                                        <td>
                                            <div class="float-right"> <strong>Total:</strong></div>
                                        </td>
                                        <td colspan="1">

                                        </td>
                                        <td> <strong>{{number_format($totalReceiveable,2)}}</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 d-flex">
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Receipts</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table custom-table table-nowrap mb-0">
                                    <thead>
                                    <tr>
                                        <th>SR#</th>
                                        <th>Name</th>
                                        <th>Receipt Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @php $totalReceipts=0; @endphp
                                    @isset($data['todayReceipts'])
                                        @foreach($data['todayReceipts'] as $receipts)

                                            @php $totalReceipts=$totalReceipts+ $receipts->amount; @endphp
                                            <tr>
                                                <td>TRNS-{{$receipts->id}}</td>


                                                @php
                                                    $res='';
                                                    $exp=[];
                                                    if($receipts->ac_type=='VENDORS'){
                                                    $res=App\Models\Vendor::find($receipts->ac_id);
                                                    }
                                                    if($receipts->ac_type=='CLIENTS'){
                                                    $res=App\Models\Client::find($receipts->ac_id);
                                                    }
                                                    if($receipts['ac_type']=='COMPANY' && $receipts['mode']=='expense'){
                                                    $exp=App\Models\ExpenseHead::find($receipts['exp_head_id']);
                                                     }
                                                @endphp
                                                <td>
                                                    @if($exp)
                                                        {{ $exp->exp_head }}
                                                    @endif

                                                    @if($res)
                                                        {{ $res->name }}
                                                    @endif
                                                </td>
                                                <td>{{number_format($receipts->amount,2)}}</td>

                                            </tr>
                                        @endforeach
                                    @endisset

                                    <tr>
                                        <td>
                                            <div class="float-right"> <strong>Total:</strong></div>
                                        </td>
                                        <td colspan="1">

                                        </td>
                                        <td> <strong>{{number_format($totalReceipts,2)}}</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-6 d-flex">
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Bank Payments</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-nowrap custom-table mb-0">
                                    <thead>
                                    <tr>
                                        <th>TransId</th>
                                        <th>Bank</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    @php $paymentsTotal=0; @endphp
                                    @isset($data['bankPayments'])
                                        @foreach($data['bankPayments'] as $payments)

                                            @php $paymentsTotal=$paymentsTotal+ $payments->amount; @endphp
                                            <tr>
                                                <td>TRNS-{{$payments->id}}</td>
                                                <td>{{$payments->bank_name}}</td>
                                                <td>{{$payments->desc}}</td>
                                                <td>{{number_format($payments->amount,2)}}</td>

                                            </tr>
                                        @endforeach
                                    @endisset

                                    <tr>
                                        <td>
                                            <div class="float-right"> <strong>Total:</strong></div>
                                        </td>
                                        <td colspan="2">

                                        </td>
                                        <td> <strong>{{number_format($paymentsTotal,2)}}</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex">
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Bank Receipts</h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-nowrap custom-table mb-0">
                                    <thead>
                                    <tr>
                                        <th>Invoice#</th>
                                        <th>Bank</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    @php $receiptsTotal=0; @endphp
                                    @isset($data['bankReceipts'])
                                        @foreach($data['bankReceipts'] as $receipts)

                                            @php $receiptsTotal=$receiptsTotal+ $receipts->amount; @endphp
                                            <tr>
                                                <td>TRNS-{{$receipts->id}}</td>
                                                <td>{{$receipts->bank_name}}</td>
                                                <td>{{$receipts->desc}}</td>
                                                <td>{{number_format($receipts->amount,2)}}</td>

                                            </tr>
                                        @endforeach
                                    @endisset

                                    <tr>
                                        <td>
                                            <div class="float-right"> <strong>Total:</strong></div>
                                        </td>
                                        <td colspan="2">

                                        </td>
                                        <td> <strong>{{number_format($receiptsTotal,2)}}</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">

                <div class="col-md-6 d-flex">

                    <div class="card card-table flex-fill">


                                <div class="card-body">
                                    <div class="card-header">
                                        <h3 class="card-title mb-0">Expense</h3>
                                    </div>
                                    <div class="table-responsive">


                                        <table class="table table-striped table-hover" id="datatable">
                                            <thead>

                                            <tr>
                                                <th>SR#</th>
                                                <th>Exp Head</th>
                                                <th>Account</th>
                                                <th>Amount</th>


                                            </tr>
                                            </thead>
                                            <tbody id="summaryTable">
                                            @php $total=0; @endphp
                                            @isset($data['exp'])
                                                @foreach($data['exp'] as $key => $exp)

                                                    @php $total=$total + $exp->amount; @endphp
                                                    <tr>
                                                        <td>{{$key + 1}}</td>
                                                        <td>{{$exp->headname->exp_head}}</td>
                                                        <td>{{$exp->acname->actype['ac_type']}}</td>
                                                        <td>{{$exp->amount}}</td>



                                                    </tr>
                                                @endforeach
                                            @endisset

                                            </tbody>

                                            <tr>
                                                <td>
                                                    <div class="float-right"> <strong>Total:</strong></div>
                                                </td>
                                                <td colspan="2">

                                                </td>
                                                <td> <strong>PKR {{number_format($total,2)}}</strong></td>

                                            </tr>
                                        </table>
                                    </div>
                                </div>

                    </div>
                </div>
{{--                --}}
{{--                <div class="col-md-6 d-flex">--}}
{{--                    <div class="card card-table flex-fill">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="table-responsive">--}}
{{--                                <table class="table table-nowrap custom-table mb-0">--}}
{{--                                    <thead>--}}
{{--                                    <tr>--}}
{{--                                        <td>Total Bank Payments</td>--}}
{{--                                        <td><input type="text" class="form-control" readonly value="{{$paymentsTotal}}"></td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>Total Bank Receipts</td>--}}
{{--                                        <td><input type="text" class="form-control" readonly value="{{$receiptsTotal}}"></td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>Total  Payable</td>--}}
{{--                                        <td><input type="text" class="form-control" readonly value="{{$paybaleTotal}}"></td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>Total Receivable</td>--}}
{{--                                        <td><input type="text" class="form-control" readonly value=""></td>--}}
{{--                                    </tr>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
        <!-- /Page Content -->
    </div>
@endsection
