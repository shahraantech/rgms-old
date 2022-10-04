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
                    <h3 class="page-title bold-heading">Purchase Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Purchase Report</li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- /Page Header -->
        <div class="card">
            <div class="card-body">


                <!-- <form action="" method="post">
                    @csrf
                    <div class="row filter-row">
                        <input type="hidden" name="search" value="1">

                        <div class="col-sm-6 col-md-3">
                            <div class="form-group form-focus">

                                <select class="livesearch form-control p-3" name="emp_id"></select>
                                <label class="focus-label">Vandor Name</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group form-focus">
                                <div class="cal">
                                    <select class="form-control floating select " name="search_month">
                                        <option value="">Month</option>
                                        <option value="1">Jan</option>
                                        <option value="2">Feb </option>
                                        <option value="3">Mar</option>
                                        <option value="4">Apr</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">Jul</option>
                                        <option value="8">Aug</option>
                                        <option value="9">Sep</option>
                                        <option value="10">Oct</option>
                                        <option value="11">Nov</option>
                                        <option value="12">Dec</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group form-focus">
                                <div class="cal">
                                    <select class="form-control floating select" name="year">
                                        <option value="">Year</option>
                                        @for($y=2021; $y<=date('Y');$y++)
                                            <option  value="{{$y}}">{{$y}} </option>
                                        @endfor

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-2">
                            <button type="submit" class="btn btn-success btn-block"> Search </button>
                        </div>


                    </div>
                </form> -->

                <table class="table table-striped table-hover" id="datatable">
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
                        @php $c=0; @endphp
                        @isset( $data['purchase_invoices'])
                        @foreach( $data['purchase_invoices'] as $invoice)
                        @php $c++; @endphp
                        <tr>
                            <td>{{$c}}</td>
                            <td>INV-{{$invoice->id}}</td>
                            <td>{{$invoice->name}}</td>
                            <td>{{$invoice->amount}}</td>
                            <td>{{$invoice->comment}}</td>
                            <td>{{$invoice->created_at}}</td>
                            <td class="text-center"><a href="{{url('invoice-details/').'/'.encrypt($invoice->id).'/purchase-details'}}" title="view details"><i class="fa fa-eye"></i></a></td>


                        </tr>
                        @endforeach
                        @endisset

                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <script>
        $(document).ready(function() {

            //Datatables
            $('#datatable').DataTable();
        });
    </script>

    @endsection