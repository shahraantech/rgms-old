@extends('setup.master')
@section('content')

    <div class="main-wrapper">
        <!-- /Sidebar -->
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <div class="page-header my-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title bold-heading">Leads Analysis</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Leads Analysis</li>
                            </ul>
                        </div>

                    </div>
                </div>
                <!-- Search Filter -->
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{url('manager-no-of-leads')}}" id="searchForm">
                            <input type="hidden" name="search" value="1">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="csr_id" class="form-control selectpicker" data-container="body"
                                                data-live-search="true">
                                            <option value="" selected >Choose Platforms</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">

                                    <input type="text" class="form-control date_range" name="date_range" />
                                </div>


                                <div class="col-md-1">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" id="btn-search"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <!-- Search Filter -->
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>SR#</th>
                                <th>Agent</th>
                                <th>Leads</th>
                                <th>Calls</th>
                                <th>Not Approach</th>
                                <th>Visits</th>
                                <th>Sale</th>
                                <th>Dead</th>
                            </tr>
                    <tbody>
                            @isset($data)
                                @foreach ($data['analysis'] as $key=>$analysis)
                            <tr>
                            <td>{{$key++}}</td>
                            <td>{{$analysis['agent']}}</td>
                            <td>{{($analysis['totalLeads'] > 0)?$analysis['totalLeads'] :'-'}}</td>
                            <td>{{($analysis['calls'] > 0)?$analysis['calls'] :'-'}}</td>
                            <td>{{($analysis['not_approach'] > 0)?$analysis['not_approach'] :'-'}}</td>
                            <td>{{($analysis['visit'] > 0)?$analysis['visit'] :'-'}}</td>
                            <td>{{($analysis['sale'] > 0)?$analysis['sale'] :'-'}}</td>
                            <td>{{($analysis['dead'] > 0)?$analysis['dead'] :'-'}}</td>
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
    </div>


    <div id="temp_wise_leads" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card flex-fill dash-statistics">
                        <div class="card-body">

                            <div id="tempArea">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
