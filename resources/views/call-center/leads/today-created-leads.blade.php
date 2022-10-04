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
                            <h3 class="page-title bold-heading">Today Created Leads</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Today Created Leads</li>
                            </ul>
                        </div>

                    </div>
                </div>


                <!-- Search Filter -->
                <div class="card">
                    <div class="card-body">

                        @if($data['leadsMarketing']->count() > 0)
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>

                                <th>#</th>
                                <th>LeadID</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>City</th>
                                <th>Allocate</th>
                                <th>Source</th>
                                <th>Temp</th>
                                <th>Type</th>
                                <th>Query</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $c=0; @endphp
                            @isset($data['leadsMarketing'])
                                @foreach ($data['leadsMarketing'] as $key => $market)
                                    @php $c++; @endphp


                                        <td>{{ $data['leadsMarketing']->firstItem() + $key }}</td>
                                        <td><a
                                                href="{{ url('lead-detail/') . '/' . encrypt($market->id) }}">{{ $market->id }}</a>
                                        </td>
                                        <td>{{ $market->name }}</td>
                                        <td>{{ $market->contact }}</td>
                                        <td>{{ $market->cityname->city_name }}</td>
                                        <td>
                                            @php
                                            $name='';
                                            if($market->manager_id){
                                             $emp=\App\Models\Employee::find($market->manager_id);
                                                $name=$emp->name;
                                                $className='success';
                                                }else{
                                                $lead = App\Models\AssignedLeads::with('agent')
                                                ->where('lead_id', $market->id)
                                                ->first();
                                                ($lead)?$name=$lead->agent['name']:$name='';
                                                 $className='primary';


                                                }
                                                if ($name) {
                                                echo '<span class="badge bg-inverse-'.$className.'">' . $name. '</span>';
                                                } else {
                                                echo '<span class="badge bg-inverse-danger">Open</span>';
                                                }
                                            @endphp
                                        </td>
                                        <td>
                                            {{ $market->platformname->platform ? $market->platformname->platform : '' }}
                                        </td>
                                        <td>
                                            @php
                                             ($market->lead_type=='Inbound')? $className='success': $className='primary';
                                                $lead = App\Models\ApprochedLeads::with('temp')
                                                ->where('lead_id', $market->id)
                                                ->first();
                                                if ($lead) {
                                                echo '<span class="badge bg-inverse-warning">' . $lead->temp['temp'] . '</span>';
                                                } else {
                                                echo '<span class="badge bg-inverse-danger">Open</span>';
                                                }
                                            @endphp
                                        </td>

                                        <td><span class="badge bg-inverse-{{$className}}">{{$market->lead_type}}</span></td>
                                        <td>{{ substr($market->interest,10); }}</td>
                                        <td>{{ date('d-m-Y', strtotime($market->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            @endisset

                            <tr>
                                <td colspan="12">
                                    <div class="float-right">
                                        {{ $data['leadsMarketing']->links('pagination::bootstrap-4') }}
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        @else
                            <div class="alert alert-danger">Record Not FOund</div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
        </div>

        </div>
    @include('call-center.general.dont-copy');

    @endsection

