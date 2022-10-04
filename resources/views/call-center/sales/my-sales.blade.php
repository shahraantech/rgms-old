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
    <div class="main-wrapper">
        <!-- /Sidebar -->
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <div class="page-header my-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title bold-heading">My Sales</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">My Sales</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover data-table" >
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>LeadID</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>City</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="leadsTable">

                            @php $c=0 @endphp
                            @isset($data)
                                @foreach($data['myDeal'] as $row)
                                    @php $c++ @endphp
                                    <tr>
                                        <td>{{$c}}</td>
                                        <td><a href="{{url('meet-detail').'/'.encrypt($row->leads->id)}}">{{$row->leads['id']}}</a></td>
                                        <td>{{$row->leads['name']}}</td>
                                        <td>{{$row->leads['contact']}}</td>
                                        <td>{{$row->leads->cityname->city_name}}</td>

                                        <td>{{$row->created_at}}</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="{{url('customer-form').'/'.encrypt($row->leads['id'])}}" class="dropdown-item" title="Add Customer Info"><i class="fa fa-plus" aria-hidden="true"></i></a>
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
            </div>
            <!-- /Page Content -->
        </div>


@endsection
