@extends('setup.master')
@section('content')
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header my-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Builders</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Buildings Cost List</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{url('/buildings')}}" class="btn add-btn" title="Add Buildings"><i class="fa fa-plus" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">


                <table class="table table-bordered mt-5">
                    <thead>
                        <tr>
                            <th># </th>
                            <th>Item  </th>
                            <th>Qty </th>
                            <th>Price </th>
                            <th>Sub Total </th>

                            <th>Created At </th>

                        </tr>
                    </thead>
                    <tbody id="buildingTable">
                    @php $c=0; @endphp
                    @php $grandTotal=0; @endphp
                    @isset($data)
                    @foreach($data['buildingCost'] as $row)
                        @php
                            $c++;
                        $grandTotal= ($grandTotal) +($row->price * $row->qty);

                        @endphp
<tr>
    <td>{{$c}}</td>
    <td>{{$row->item}}</td>
    <td>{{$row->qty}}</td>
    <td>{{$row->price}}</td>
     <td>{{$row->price * $row->qty}}</td>
     <td>{{$row->created_at}}</td>


</tr>

                    @endforeach
                    @endisset


                    <tr>
                        <td  colspan="4">
                            <div class="float-right"><strong> Grand Total: </strong></div>
                        </td>
                        <td> <strong>{{ $grandTotal}} </strong></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>


</div>



@endsection
