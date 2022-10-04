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
                    <h3 class="page-title bold-heading">Raw Material Stock Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item "><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Raw Material Stock</li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                    <!-- tabel start -->
                    <table class="table table-bordered table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Unit</th>
                                <th>Qty</th>
                                <th>Av Qty</th>
                                <th>Price</th>
                                <th>Tax%</th>
                                <th><strong>Total</strong></th>

                            </tr>
                        </thead>

                        <tbody>
                        @php $c=0;
               $subTotal=0;
               $grandTotal=0;
                        @endphp
                        @isset($data['stock'])
                            @foreach($data['stock'] as $stock)
                                @php $c++;
               $subTotal=$subTotal + ($stock->price * $stock->avl_qty);
               $grandTotal=$grandTotal+$subTotal;
                                @endphp
                                <tr>
                                    <td>{{$c}}</td>
                                    <td>{{$stock->products['item']}}</td>
                                    <td>{{$stock->products['unit']}}</td>
                                    <td>{{$stock->qty}}</td>
                                    <td>{{$stock->avl_qty}}</td>
                                    <td>{{number_format($stock->price,2)}}</td>
                                    <td>0.00</td>
                                    <td>{{number_format($subTotal,2)}}</td>
                                </tr>
                            @endforeach
                        @endisset
                        <tr>
                            <td>
                                <div class="float-right"> <strong>Total:</strong></div>
                            </td>
                            <td colspan="6">
                            </td>
                            <td> <strong>{{number_format($grandTotal,2)}} PKR<span></span></strong></td>
                        </tr>
                        </tbody>
                    </table>

            </div>
        </div>

        <!-- /Page Content -->



    </div>







    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {



            //Datatables
            $('#datatable').DataTable();

        });
    </script>

@endsection
