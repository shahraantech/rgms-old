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
                        <h3 class="page-title bold-heading">Purchase List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Purchase List</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{url('/purchase')}}" class="btn add-btn" title="Add Product"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('purchase-list') }}" method="POST" id="purchaseFilter">
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
            <!-- /Page Header -->
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered mt-5 table-hover table-striped" id="datatable">
                        <thead>
                        <tr class="bold-tr">
                            <th># </th>
                            <th>INV#</th>
                            <th>Supplier Name </th>
                            <th>Amount</th>
                            <th>Comment</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $c=0; @endphp
                        @isset($data['purchaseList'])
                            @foreach($data['purchaseList'] as $key => $p)
                                @php $c++; @endphp
                                <tr>
                                    <td>{{$c}}</td>
                                    <td>INV-{{$p->id}} </td>
                                    <td> {{empty($p->supplier['name'])?'':$p->supplier['name']}} </td>
                                    <td>
                                        {{number_format($p->amount,2)}}
                                    </td>
                                    <td> {{$p->comment}} </td>
                                    <td>{{$p->created_at}} </td>


                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                               aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{url('purchase-delivery-note').'/'.encrypt($p->id)}}" title="Delivery Notes" class="dropdown-item"><i class="fa fa-print"></i></a>
                                                <a href="{{url('view-purchase').'/'.$p->id}}" title="view details" class="dropdown-item"><i class="fa fa-eye"></i></a>


                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endisset
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

                $('.searchDate').on('click', function() {
                    $(".searchDate").prop("disabled", true);
                    $(".searchDate").html("Please wait...");
                    $('#purchaseFilter').submit();
                });

            });
        </script>
@endsection
