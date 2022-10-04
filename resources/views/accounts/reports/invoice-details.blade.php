@extends('setup.master')
@section('content')


<style type="text/css">
    body {
        font-family: Arial;
        font-size: 10pt;
    }
</style>
<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header my-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title bold-heading">{{$data['invoice']? 'Sale':''}} Invoice Details</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Invoice Details</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{url('sale-report')}}" class="btn add-btn" title="Back"><i class="fas fa-arrow-left"></i></a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered mt-5 table-hover table-striped">
                    <thead>
                    <tr class="bold-tr">
                        <th># </th>
                        <th>Item </th>
                        <th>Qty </th>
                        <th>Price </th>
                        @isset($data['is_purchase'])
                        <th>Sale Price </th>
                        @endisset
                        <th>Sub Total</th>
                        <th>Created At </th>

                    </tr>
                    </thead>
                    <tbody id="purchaseTable">
                    @php $c=0;
                     $subTotal=0;
                     $grandTotal=0;

                    @endphp
                    @isset($data['invoice_items'])
                        @foreach($data['invoice_items'] as $items)
                            @php $c++;
                            $subTotal=$items->qty * $items->sale_price;
                            $grandTotal=$grandTotal+ $subTotal;
                            @endphp
                            <tr>
                                <td>{{ $c }}</td>
                                <td>{{ $items->item }} {{($items->reg_no)? '-'.$items->reg_no:''}}</td>
                                <td>{{ $items->qty }}</td>
                                <td>{{number_format($items->sale_price,2) }}</td>
                                @isset($data['is_purchase'])
                                <td>{{number_format( $items->sale_price,2) }}</td>
                                @endisset
                                <td>{{number_format($subTotal,2)}}</td>
                                <td>{{ $items->created_at }}</td>
                            </tr>
                        @endforeach
                    @endisset
                    <tr>
                        <td  colspan="4">
                            <div class="float-right"><strong> Grand Total: </strong></div>
                        </td>
                        <td> <strong>{{ number_format($grandTotal,2)}} </strong></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
    @endsection
