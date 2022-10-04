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
                            <h3 class="page-title bold-heading">CSR Leads</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">CSR Leads List</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Search Filter -->

                @if($data['filter']!=0)
                    <div class="card">
                        <div class="card-body">
                            <form method="get" action="{{ url('allocated-leads') }}" id="searchForm">
                                @csrf
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="agent_id" class="form-control selectpicker" data-container="body"
                                                    data-live-search="true">>
                                                <option value="" selected>Choose Source</option>
                                                @isset($data)
                                                    @foreach ($data['atl'] as $atl)
                                                        <option value="{{ $atl->id }}">{{ $atl->name }}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="temp_id" class="form-control selectpicker" data-container="body"
                                                    data-live-search="true">>
                                                <option value="" selected>Choose Temp</option>
                                                @isset($data)
                                                    @foreach ($data['temp'] as $temp)
                                                        <option value="{{ $temp->id }}">{{ $temp->temp }}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-search"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>

                                    <div class="col-md-3">

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
                @endif
                <!-- Search Filter -->
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover ">
                            <thead>
                            <tr>
                                <th width="50px"><input type="checkbox" id="master"></th>
                                <th>#</th>
                                <th>LeadID</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>City</th>
                                <th>CSR</th>
                                <th>Temperature</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $c=0; @endphp
                            @isset($data['leadsMarketing'])
                                @foreach ($data['leadsMarketing'] as $key => $market)
                                    @php $c++; @endphp
                                    <tr id="tr_'.{{ $market->lead_id }}">
                                        <td><input type="checkbox" class="sub_chk" data-id="{{ $market->lead_id }}">
                                        </td>
                                        <td>{{ $c }}</td>
                                        <td><a
                                                href="{{ url('lead-detail/') . '/' . encrypt($market->lead_id) }}">{{ $market->lead_id }}</a>
                                        </td>
                                        <td>{{ $market->leads->name }}</td>
                                        <td>{{ $market->leads->contact }}</td>
                                        <td>{{ $market->leads->cityname->city_name }}</td>
                                        <td><span class="badge bg-inverse-success">{{ $market->agent->name }}</span></td>


                                        <td>
                                            @php
                                                if($data['tempId']==0){
                                                    $lead = App\Models\ApprochedLeads::with('temp')
                                                    ->where('lead_id', $market->lead_id)->latest('id')
                                                    ->first();
                                                    }else{
                                                    $lead = App\Models\ApprochedLeads::with('temp')
                                                    ->where('lead_id', $market->lead_id)
                                                    ->where('temp_id',$data['tempId'])
                                                    ->first();
                                                    }
                                                    if ($lead) {
                                                    echo '<span class="badge bg-inverse-warning">' . $lead->temp['temp'] . '</span>';
                                                    } else {
                                                    echo '<span class="badge bg-inverse-danger">Open</span>';
                                                    }
                                            @endphp
                                        </td>

                                        <td>{{ date('d-m-Y', strtotime($market->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            @endisset

                            <tr>
                                <td colspan="12">
                                    <div class="float-right">
                                        {{ $data['leadsMarketing']->appends(Request::query())->links('pagination::bootstrap-4') }}
                                    </div>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
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

                                {{--                                <div class="form-group manager_section">--}}
                                {{--                                    <label>Manager<span class="text-danger">*</span></label>--}}
                                {{--                                    <select name="manager_id" class="form-control selectpicker" data-container="body" data-live-search="true" required>--}}

                                {{--                                        <option value="">Choose Manager</option>--}}
                                {{--                                        @isset($data)--}}
                                {{--                                            @foreach ($data['manager'] as $manager)--}}

                                {{--                                                <option value="{{$manager->leader_id}}">{{$manager->name}}</option>--}}

                                {{--                                            @endforeach--}}
                                {{--                                        @endisset--}}
                                {{--                                    </select>--}}
                                {{--                                    <div class="invalid-feedback">--}}
                                {{--                                        Please choose agent.--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}


                                <div class="form-group">
                                    <label>Allocate To<span class="text-danger">*</span></label>
                                    <select name="to_allocate" class="form-control selectpicker" data-container="body"
                                            data-live-search="true">
                                        <option value="">Choose One</option>
                                        <option value="1">Manager</option>
                                        <option value="2">Source</option>

                                    </select>
                                    <div class="invalid-feedback">
                                        Please choose agent.
                                    </div>
                                </div>
                                <div class="form-group manager_section" style="display: none">
                                    <label>Manager<span class="text-danger">*</span></label>
                                    <select name="manager_id" class="form-control selectpicker" data-container="body" data-live-search="true">

                                        <option value="">Choose Manager</option>
                                        @isset($data)
                                            @foreach ($data['manager'] as $manager)

                                                <option value="{{$manager->leader_id}}">{{$manager->name}}</option>

                                            @endforeach
                                        @endisset
                                    </select>
                                    <div class="invalid-feedback">
                                        Please choose agent.
                                    </div>
                                </div>
                                <div class="form-group csr_section" style="display: none">
                                    <label>Agent<span class="text-danger">*</span></label>
                                    <select name="atl_id" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose Agent</option>
                                        @isset($data)
                                            @foreach ($data['employee'] as $emp)

                                                <option value="{{$emp->id}}">{{$emp->name}}</option>

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
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


    <script>




        $('.btn-search').on('click', function() {
            $(".btn-search").prop("disabled", true);
            $(".btn-search").html("Please wait...");
            $('#searchForm').submit();
        });
    </script>
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
                    var agent_id = $('select[name=atl_id]').val();
                    var manager_id = $('select[name=manager_id]').val();
                    (manager_id)?manager_id=manager_id:manager_id=0;


                    $.ajax({
                        url: '{{ url('/csrToManagerLeadsAssign') }}',
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            ids: allVals,
                            agent_id: agent_id,
                            manager_id: manager_id,
                            type: 'lead'
                        },
                        beforeSend: function() {
                            $(".btn-save-assign-leads").prop("disabled", true);
                            $(".btn-save-assign-leads").html("processing...");

                        },
                        success: function(data) {
                            if (data.success) {
                                toastr.success(data.success);
                                $(".sub_chk:checked").each(function() {
                                    $(this).parents("tr").remove();
                                });
                                window.location.reload();
                            }
                            if(data.errors) {
                                toastr.error(data.errors);
                            }
                        },
                        complete: function(data) {
                            $('.close').click();
                            $(".btn-save-assign-leads").html("Save");
                            $(".btn-save-assign-leads").prop("disabled", false);
                        },
                        error: function(data) {
                            toastr.error(data.errors);
                            //toastr.error(data.responseText);
                        }
                    });


                    $.each(allVals, function(index, value) {
                        $('table tr').filter("[data-row-id='" + value + "']").remove();
                    });

                }
            });
            //company_id dependent dropdown for all employees
            $('select[name=to_allocate]').change(function(){
                var to_allocate=$('select[name=to_allocate]').val();

                if(to_allocate==1) {

                    $(".manager_section").css("display", "block");
                    $(".csr_section").css("display", "none");
                }else{
                    $(".manager_section").css("display", "none");
                    $(".csr_section").css("display", "block");
                }

                (ac_type=='vendors')? $('#ac_label').html('Vendors'):$('#ac_label').html('Customers')
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{url("/getAccountsName")}}',
                    data: {ac_type: ac_type},
                    async: false,
                    dataType: 'json',
                    success: function(response) {
                        var html = '<option value="">Choose File</option>';
                        var i;
                        if(response.length > 0) {
                            for (i = 0; i < response.length; i++) {
                                html += '<option value="' + response[i].id + '">' + response[i].name + '</option>';

                            }
                        }else{
                            var html = '<option value="">Choose One</option>';
                            toastr.error('data not found');
                        }


                        $('#showAccounts').html(html);

                    },

                    error: function() {

                        toastr.error('data not found');

                    }

                });
            });
        });
    </script>
@endsection
