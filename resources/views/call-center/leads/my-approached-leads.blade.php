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
                            <h3 class="page-title bold-heading">{{ $data['leadType']}} Leads</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">My Leads</li>
                            </ul>
                        </div>

                    </div>
                </div>
                <!-- Search Filter -->
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{url('my-approached-leads')}}">
                            @csrf

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="follow_date">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select name="city_id" class="form-control selectpicker" data-container="body"--}}
                                                data-live-search="true">
                                            <option value="" selected >Choose City</option>
                                            @isset($data)
                                                @foreach($data['city'] as $city)
                                                    <option value="{{$city->id}}">{{$city->city_name}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select name="temp_id" class="form-control selectpicker" data-container="body"
                                                data-live-search="true">
                                            <option value="" selected >Choose Temp</option>
                                            @isset($data)
                                                @foreach($data['temp'] as $temp)
                                                    <option value="{{$temp->id}}">{{$temp->temp}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="lead_id" placeholder="Search Lead ID">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="phone" placeholder="Search Phone">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <!-- Search Filter -->
                <div class="card">
                    @if($data['res']==1)
                    <div class="m-l-5 mt-1"> <span style="color: red"> {{$data['approachedLeads']->count()}} records found </span> </div>
                    @endif
                    <div class="card-body">
                        <table class="table table-striped table-hover data-table table-responsive">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>LeadID</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>City</th>
                                <th>Temp.</th>
                                <th>Comment.</th>
                                <th>Type</th>
                                <th>Query</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="leadsTable">
                            @php $c=0 @endphp
                            @if($data['approachedLeads']->count() > 0)
                                @foreach($data['approachedLeads'] as $row)
                                    @php $c++ @endphp
                                    <tr>
                                        <td>{{$c}}</td>
                                        <td>
                                            <a href="{{url('lead-detail').'/'.encrypt($row->lead_id)}}" class="btn-lead-id" data="{{$row->lead_id}}">
                                                {{$row->lead_id}}
                                            </a>
                                        </td>
                                        <td>{{$row->leads['name']}}</td>
                                        <td>{{$row->leads['contact']}}</td>
                                        <td>{{$row->leads->cityname->city_name}}</td>
                                        <td>
                                            <span class="badge bg-inverse-info">{{$row->temp['temp']}}</span>
                                            </td>
                                        <td>{{substr($row->comments,0,20)}} <br>
                                            <span class="badge bg-danger" style="color: white">

                                                    Followup:{{$row->followup_date}}
                                                  </span>
                                        </td>

                                        <td>{{$row->leads['lead_type']}}</td>
                                        <td>{{substr($row->leads['interest'],0,30)}}</td>
                                        <td>{{$row->created_at}}</td>


                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item bg-inverse-primary lead-status" data-toggle="modal" data-target="#add_lead_status" data="{{$row->leads['id']}}">Add Lead Status</a>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
{{--                            --}}
{{--                            <tr>--}}
{{--                                <td colspan="11">--}}
{{--                                    <div class="float-right">--}}
{{--                                        {{ $data['approachedLeads']->links('pagination::bootstrap-4') }}--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
        <!-- Add Department Modal -->
        <div id="add_lead_status" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Leads Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{url('save-leads-status')}}" id="LeadForm" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <input type="hidden" name="hidden_lead_id">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <select class="form-control selectpicker" name="temp_id" data-container="body"
                                                data-live-search="true"  required>
                                            <option value="">Choose Temperature</option>
                                            @isset($data)
                                                @foreach($data['temp'] as $temp)
                                                    <option value="{{$temp->id}}">{{$temp->temp}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <div class="invalid-feedback">
                                            Please choose leads temperature .
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <input type="text" name="lead_name" class="form-control" placeholder="Name" required>
                                        <div class="invalid-feedback">
                                            Please enter name.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="city" class="form-control" required>

                                        </select>
                                        <div class="invalid-feedback">
                                            Please choose  city.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="source" class="select" required>
                                            <option value="" selected >Choose Source</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please choose source .
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label>Follow up Date <span class="text-danger">*</span></label>
                                        <input class="form-control" type="date" name="follow_date" placeholder="Followup Date" required>
                                        <div class="invalid-feedback">
                                            Please date.
                                        </div>
                                    </div>
                                </div >
                                <div class="col-md-6 followup-section">
                                    <div class="form-group">
                                        <label>Time</label>
                                        <input class="form-control" type="time" name="time" placeholder="Followup Time" >
                                        <div class="invalid-feedback">
                                            Please enter time.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Is Connected?<span class="text-danger">*</span></label>
                                        <select name="is_connected" id="" class="form-control">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Comments<span class="text-danger">*</span></label>
                                        <textarea name="comments"  cols="10" rows="3" class="form-control" required></textarea>
                                        <div class="invalid-feedback">
                                            Please enter comments.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary btnSubmit" type="submit" id="btnSubmit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {


            $('#LeadForm').unbind().on('submit', function(e) {
                e.preventDefault();

                var formData = $('#LeadForm').serialize();

                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{url("save-leads-status")}}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {

                        $(".btnSubmit").prop("disabled", true);
                        $(".btnSubmit").html("loading...");

                    },
                    success: function(data) {

                        if (data.success) {
                            $('.close').click();
                            $('#LeadForm')[0].reset();
                            toastr.success(data.success);
                            window.location.reload();

                        }
                        if (data.errors) {

                            toastr.error(data.errors);
                            //toastr.error('missing some fileds');

                        }
                    },

                    complete : function(data){
                        $("#btnSubmit").html("Save");
                        $("#btnSubmit").prop("disabled", false);
                    },
                    error: function() {
                        toastr.error('something went wrong');

                    },

                });


            });

            // save inboundLeadForm


            $('#inboundLeadForm').unbind().on('submit', function(e) {
                e.preventDefault();

                var formData = $('#inboundLeadForm').serialize();

                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{url("leads")}}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {

                        $(".btnSubmit").prop("disabled", true);
                        $(".btnSubmit").html("loading...");

                    },
                    success: function(data) {
                        console.log(data);
                        if (data.success) {
                            $('.close').click();
                            $('#inboundLeadForm')[0].reset();
                            toastr.success(data.success);
                            window.location.reload();

                        }
                        if (data.errors) {
                            toastr.error(data.errors);
                        }
                    },

                    complete : function(data){
                        $(".btnSubmit").html("Save");
                        $(".btnSubmit").prop("disabled", false);
                    },
                    error: function() {
                        toastr.error('something went wrong');

                    },

                });


            });

            //save lead status

            $('#leadsTable').on('click', '.lead-status', function() {
                var id = $(this).attr('data');
                $('input[name=hidden_lead_id]').val(id);


                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{url("getLeadsInfo")}}',
                    data: {lead_id:id},
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {

                        $(".btnSubmit").prop("disabled", true);
                        $(".btnSubmit").html("loading...");

                    },
                    success: function(data) {
                        console.log(data);
                        if (data) {
                            $('input[name=lead_name]').val(data.leads.name);

                            $.each(data.city, function(key, city) {

                                $('select[name="city"]')
                                    .append(`<option value="${city.id}" ${city.id == data.leads.city_id ? 'selected' : ''}>${city.city_name}</option>`)
                            });

                            $.each(data.platform, function(key, platform) {

                                $('select[name="source"]')
                                    .append(`<option value="${platform.id}" ${platform.id == data.leads.platform_id ? 'selected' : ''}>${platform.platform}</option>`)
                            });

                        }
                        if (data.errors) {
                            toastr.error(data.errors);
                        }
                    },

                    complete : function(data){
                        $("#btnSubmit").html("Save");
                        $("#btnSubmit").prop("disabled", false);
                    },
                    error: function() {
                        toastr.error('something went wrong');

                    },

                });
            });


            //edit lead info
            $('#leadsTable').on('click', '.edit-lead-status', function() {
                var id = $(this).attr('data');
                $('input[name=edit_lead_id]').val(id);


                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{url("editLeadsInfo")}}',
                    data: {id:id},
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {

                        $(".btnUpdate").prop("disabled", true);
                        $(".btnUpdate").html("loading...");

                    },

                    success: function(data) {

                        console.log(data);
                        if (data) {

                            $('textarea[name=edit_comments]').val(data.appLeads.comments );
                            $('input[name=edit_followup]').val(data.appLeads.followup_date );
                            $.each(data.temp, function(key, temp) {

                                $('select[name="tempDropdown"]')
                                    .append(`<option value="${temp.id}" ${temp.id == data.appLeads.temp_id ? 'selected' : ''}>${temp.temp}</option>`)
                            });



                        }
                        if (data.errors) {
                            toastr.error(data.errors);
                        }
                    },


                    complete : function(data){
                        $("#btnUpdate").html("Update");
                        $("#btnUpdate").prop("disabled", false);
                    },
                    error: function() {
                        toastr.error('something went wrong');

                    },

                });
            });


        // update lead approach lead
            $('#UpdateApprLeadForm').unbind().on('submit', function(e) {
                e.preventDefault();

                var formData = $('#UpdateApprLeadForm').serialize();

                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{url("update-leads-status")}}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {

                        $(".btnUpdate").prop("disabled", true);
                        $(".btnUpdate").html("loading...");

                    },
                    success: function(data) {
                        console.log(data);
                        if (data.success) {
                            $('.close').click();
                            $('#UpdateApprLeadForm')[0].reset();
                            toastr.success(data.success);
                            window.location.reload();

                        }
                        if (data.errors) {
                            toastr.error(data.errors);
                        }
                    },

                    complete : function(data){
                        $(".btnUpdate").html("Save");
                        $(".btnUpdate").prop("disabled", false);
                    },
                    error: function() {
                        toastr.error('something went wrong');

                    },

                });


            });




        });


    </script>

    @include('call-center.general.dont-copy');
@endsection
