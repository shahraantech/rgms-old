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
                        <h3 class="page-title bold-heading">Bank List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Bank List</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{url('/bank')}}" class="btn add-btn" title="Add Bank"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>

        </div>


            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-hover" id="datatable">

                        <tr>
                            <th>SR#</th>
                            <th>Bank</th>
                            <th>Balance</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        <tbody>
                        @php $c=0; @endphp
                        @isset($data['branches'])
                            @foreach($data['branches'] as $row)
                                @php $c++; @endphp
                                <tr>
                                    <td>{{$c}}</td>
                                    <td>
                                        @php
                                       $headName=App\Models\Ledger::getLevelHeadName($row->level_no,$row->head_id);
                                      $balance=App\Models\Ledger::countAccountsBalance('bank',$row->id);

                                            @endphp
                                        {{$headName}}
                                    </td>

                                    <td>PKR {{number_format($balance,2)}}</td>
                                    <td>{{$row->created_at}}</td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{url('account-history/'.$row->id.'/bank')}}" class="dropdown-item"><i class="fa fa-pencil m-r-5n "></i> History</a>
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
        <script>
            $(document).ready(function() {

                //Datatables
                $('#datatable').DataTable();
            });
        </script>
@endsection
