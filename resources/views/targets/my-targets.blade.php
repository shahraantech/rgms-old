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
                            <h3 class="page-title bold-heading">{{ $data['view'] }} Targets</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ $data['view'] }} Targets</li>
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped mb-0" id="datatable">
                            <thead>
                                <tr>
                                    <th style="width: 30px;">#</th>
                                    <th>Target</th>
                                    <th>From </th>
                                    <th>To </th>
                                    <th>Progress </th>
                                    @if ($data['view'] == 'Manager')
                                        <th>Action </th>
                                    @endif
                                </tr>
                            </thead>


                            <tbody>
                                @php $c=0; @endphp
                                @isset($data['targets'])
                                    @foreach ($data['targets'] as $target)
                                        @php $c++; @endphp
                                        <tr>
                                            <td>{{ $c }}</td>
                                            <td>{{ $target->target_in_numbers }} {{ strtoupper($target->target_type) }}'s
                                            </td>
                                            <td>{{ $target->from }}</td>
                                            <td>{{ $target->to }}</td>

                                            @php
                                                if($data['view'] == 'Manager'){
                                                $totalAcheive= getManagerTeamAcheivements($target->manager_id,$target->target_type);
                                                }else{
                                                $totalAcheive= getSalesManTargetAcheive($target->agent_id,$target->target_type);
                                                }

                                                $pers=($totalAcheive *100)/$target->target_in_numbers;
                                                $bg='warning';
                                                ($pers<50)?$bg='danger':'';
                                                ($pers>50 && $pers<70)?$bg='info':'';
                                                ($pers>70 && $pers<80)?$bg='primary':'';
                                                ($pers>80)?$bg='success':'';
                                            @endphp

                                            <td>
                                                <div class="progress progress-xs progress-striped">
                                                    <div class="progress-bar bg-{{$bg}}" role="progressbar" data-toggle="tooltip" title="{{$pers}}%" style="width: {{$pers}}%"></div>
                                                </div>

                                            </td>

                                            @if ($data['view'] == 'Manager')
                                                <td>

                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                            aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a title="Assign"
                                                                href="{{ url('assign-target') . '/' . $target->id }}"
                                                                class="dropdown-item bg-inverse-primary">Assign</a>
                                                            <a title="View " href="{{ url('team-target') . '/' . $target->id }}"
                                                                class="dropdown-item bg-inverse-success"><i
                                                                    class="fa fa-eye"></i></a>


                                                        </div>
                                                    </div>
                                                </td>
                                            @endif

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

@endsection
