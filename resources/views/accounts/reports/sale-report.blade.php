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
                        <h3 class="page-title bold-heading">Sale Report</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Sale Report</li>
                        </ul>
                    </div>


                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ url('sale-report') }}" method="POST" id="saleFilter">
                        @csrf
                        <div class="row filter-row">
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label class="focus-label">From Date</label>
                                    <input type="date" name="from" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label class="focus-label">To Date</label>
                                    <input type="date" name="to" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-2">
                                <label for=""></label>
                                <button type="submit" class="btn btn-primary btn-block searchDate"> <i class="fa fa-search"></i> </button>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
            <table class="table table-bordered mt-5 table-hover table-striped" id="datatable">
                <thead>
                <tr class="bold-tr">
                    <th># </th>
                    <th>INV#</th>
                    <th>Client Name </th>
                    <th>Amount </th>
                    <th>Comment </th>
                    <th>Created At </th>
                    <th>Action </th>
                </tr>
                </thead>
                <tbody>
             @php $c=0;
   $grandTotal=0;
@endphp
                @isset( $data['sale_invoices'])
                    @foreach( $data['sale_invoices'] as $key => $invoice)
                     @php $c++;
                     $grandTotal=$grandTotal + $invoice->amount;
                     @endphp
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>INV-{{$invoice->id}}</td>
                            <td>{{$invoice->name}}</td>
                            <td> {{number_format($invoice->amount,2)}}</td>
                            <td>
                                @php
                                    $inv=App\Models\Transaction::where('inv_id',$invoice->id)->first();
                                    @endphp
                                {{!empty($inv->desc)?$inv->desc:''}}
                            </td>
                            <td>{{$invoice->created_at}}</td>

                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                       aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="{{url('delivery-note').'/'.encrypt($invoice->id)}}" title="Delivery Notes" class="dropdown-item"><i class="fa fa-print"></i></a>
                                        <a href="{{url('invoice-details/').'/'.encrypt($invoice->id).'/sale-report'}}" title="view details" class="dropdown-item"><i class="fa fa-eye"></i></a>


                                    </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                @endisset

                <tr>
                    <td  colspan="4">
                        <div class="float-right"> <strong>Grand Total:{{number_format($grandTotal,2)}}</strong></div>
                    </td>
                    <td></td>
                </tr>


                </tbody>
            </table>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {

            //Datatables
            $('#datatable').DataTable();


            $('.searchDate').on('click', function() {
                $(".searchDate").prop("disabled", true);
                $(".searchDate").html("Please wait...");
                $('#saleFilter').submit();
            });

        });
    </script>

@endsection
