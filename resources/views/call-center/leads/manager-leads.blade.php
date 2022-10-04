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
                            <h3 class="page-title bold-heading">Manager Leads</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Manager Leads List</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Search Filter -->
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ url('manager-leads') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="date">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select name="lead_type" class="select">
                                            <option value="">Choose One</option>
                                            <option value="Inbound">INBOUND</option>
                                            <option value="outbound">OUTBOUND</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select name="city_id" class="select">
                                            <option value="" selected>Choose City</option>
                                            @isset($data)
                                                @foreach ($data['city'] as $city)
                                                    <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name"
                                               placeholder="Search Client Name">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">Action</button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" data-toggle="modal" data-target="#assign_leads"
                                                   href="#">Allocate</a>

                                            </div>
                                        </div>
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
                                <th width="50px"><input type="checkbox" id="master"></th>
                                <th>#</th>
                                <th>LeadID</th>
                                <th>Name</th>
                                <th>Contact</th>
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
                                @foreach ($data['leadsMarketing'] as $market)
                                    @php $c++; @endphp
                                    <tr id="tr_'.{{ $market->id }}">
                                        <td><input type="checkbox" class="sub_chk" data-id="{{ $market->id }}">
                                        </td>
                                        <td>{{ $c }}</td>
                                        <td><a
                                                href="{{ url('lead-detail/') . '/' . encrypt($market->id) }}">{{ $market->id }}</a>
                                        </td>
                                        <td>{{ $market->name }}</td>
                                        <td>{{ $market->contact }}</td>
                                        <td>
                                            @php

                                                $lead = App\Models\AssignedLeads::with('agent')
                                                ->where('lead_id', $market->id)
                                                ->first();

                                                if ($lead) {
                                                echo '<span class="badge bg-inverse-success">' . $lead->agent['name']. '</span>';
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
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
        <div id="assign_leads" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Allocate Lead</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group manager_section">
                                <label>Agent<span class="text-danger">*</span></label>
                                <select name="agent_id" class="form-control selectpicker" data-container="body" data-live-search="true">
                                    <option value="">Choose Manager</option>


                                    @isset($data['team_member'] )
                                        @foreach($data['team_member'] as $member)
                                            <option value="{{$member['id']}}">{{$member['name']}}</option>
                                        @endforeach
                                    @endisset

                                </select>
                                <div class="invalid-feedback">
                                    Please choose agent.
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary btn-save-assign-leads" type="button">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Wrapper -->
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            //chek all boxes
            $('#master').on('click', function(e) {
                if ($(this).is(':checked', true)) {
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked', false);
                }
            });
            // save assign leaves
            $('.btn-save-assign-leads').on('click', function(e) {


                var allVals = [];
                $(".sub_chk:checked").each(function() {
                    allVals.push($(this).attr('data-id'));
                });


                if (allVals.length <= 0) {
                    toastr.error("Please select row.");
                } else {
                    var agent_id = $('select[name=agent_id]').val();


                    $.ajax({
                        url: '{{ url('/customeAssignLeads') }}',
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            ids: allVals,
                            agent_id: agent_id,
                            type: 'lead'
                        },
                        beforeSend: function() {
                            $(".btn-save-assign-leads").prop("disabled", true);
                            $(".btn-save-assign-leads").html("loading...");

                        },
                        success: function(data) {

                            if (data.success) {
                                toastr.success(data.success);
                                $(".sub_chk:checked").each(function() {
                                    $(this).parents("tr").remove();
                                });
                                window.location.reload();
                            } else {
                                toastr.error('something went wrong');
                            }
                        },
                        complete: function(data) {
                            $('.close').click();
                            $(".btn-save-assign-leads").html("Save");
                            $(".btn-save-assign-leads").prop("disabled", false);
                        },
                        error: function(data) {
                            toastr.error(data.responseText);
                        }
                    });


                    $.each(allVals, function(index, value) {
                        $('table tr').filter("[data-row-id='" + value + "']").remove();
                    });

                }
            });





        });
    </script>

    @include('call-center.general.dont-copy');

@endsection
