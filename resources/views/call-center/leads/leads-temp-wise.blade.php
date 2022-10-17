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
                                <li class="breadcrumb-item active">{{ $data['leadType']}}  Leads</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_department"
                               title="Add Inbound Leads"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Search Filter -->
                @if($data['leadType']=='My')
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="{{url('my-leads')}}">
                                @csrf
                                <input type="hidden" name="search" value="1">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="date" class="form-control" name="date">
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
                                            <input type="text" class="form-control" name="name" placeholder="Search Client Name">
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
            @endif

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
                                <th>Temp.</th>
                                <th>Comment.</th>
                                <th>Query</th>
                                @if($data['leadType']!='My')
                                    <th>CSR</th>
                                @endif
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="leadsTable">
                            @php $c=0 @endphp
                            @isset($data)
                                @foreach($data['assigned_leads'] as $key => $row)
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
                                            @php
                                                $comment='';
                                                $approachId='';
                                                $nextFollow='';
                                                $approcahDate='';
                                                $today=date('d-m-Y');
                                                ($row->leads['lead_type']=='Inbound')? $className='success': $className='primary';
                                                $lead=App\Models\ApprochedLeads::with('temp')->where('lead_id',$row->leads['id'])->latest('id')->first();
                                                $comm=$lead;
                                                $countApproach=App\Models\ApprochedLeads::where('lead_id',$row->leads['id'])->count();
                                                if($lead){
                                                    $comment=$lead->comments;
                                                    $approachId=$lead->id;
                                                    $nextFollow=$lead->followup_date;
                                                    $approcahDate=date('d-m-Y',strtotime($lead->created_at));
                                                echo '<span class="badge bg-inverse-info">'.$lead->temp['temp'].'</span>('.$countApproach.')</br>';
                                                echo '<small> '.$lead->created_at.'</small>';
                                                }else{
                                                echo '<span class="badge bg-inverse-danger">Open</span>';
                                                }
                                            @endphp
                                        </td>
                                        <td>{{$comment}} <br>
                                            @if($nextFollow)
                                                <span class="badge bg-danger" style="color: white">

                                                    Followup:{{$nextFollow}}
                                                  </span>
                                            @endif
                                        </td>

                                        <td>{{substr($row->leads['interest'],0,50)}} <span class="badge bg-inverse-success">Date: {{$row->created_at}}</span> </td>
                                        @if($data['leadType']!='My')
                                            <td>
                                                @php

                                                    $agent=App\Models\AssignedLeads::with('agent')->where('lead_id',$row->leads['id'])->first();
                                                    if($agent){
                                                    echo '<span class="badge bg-inverse-info">'.$agent->agent['name'].'</span></br>';
                                                    }else{
                                                    echo '<span class="badge bg-inverse-danger">Open</span>';
                                                    }
                                                @endphp
                                            </td>
                                        @endif
                                        <td class="text-right">

                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a title="Add Lead Status" href="#" class="dropdown-item bg-inverse-primary lead-status" data-toggle="modal" assign-id="{{$row->id}}"
                                                       data-target="#add_lead_status" data="{{$row->leads['id']}}">
                                                        <i class="fa fa-plus"></i></a>
                                                    @if($today==$approcahDate)
                                                        <a title="Edit" href="#" class="dropdown-item bg-inverse-success edit-lead-status" data-toggle="modal" data-target="#edit_lead_status" data="{{$approachId}}">
                                                            <i class="fa fa-edit"></i></a>
                                                    @endif
                                                    <a title="Share to WhatsApp" target="_blank" href="https://api.whatsapp.com/send?phone={{ str_replace(array('-','-'), '',$row->leads['contact'])}}" class="dropdown-item bg-inverse-success " >
                                                        <img src="{{asset("public/assets/img/logo/socail-icon/whatsapp.png")}}" /> </a>

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
            </div>

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

        <!-- Edit Lead Status -->
        <div id="edit_lead_status" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Leads Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{url('update-leads-status')}}" id="UpdateApprLeadForm" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <input type="hidden" name="edit_lead_id">

                                <div class="col-md-12">
                                    <div class="form-group">

                                        <select class="form-control" name="tempDropdown"   required>
                                            <option value="">Choose Temperature</option>

                                        </select>
                                        <div class="invalid-feedback">
                                            Please choose leads temperature .
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="date" name="edit_followup" class="form-control">
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
                                        <textarea name="edit_comments"  cols="10" rows="3" class="form-control" required></textarea>
                                        <div class="invalid-feedback">
                                            Please enter comments.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary btnSubmit" type="submit" id="btnUpdate">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Inbound Leads -->
        <div id="add_department" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Lead</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ url('leads') }}" id="inboundLeadForm" class="needs-validation" novalidate>
                            @csrf
                            <input type="hidden" name="inbound" value="1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" placeholder=" Name" required>
                                        <div class="invalid-feedback">
                                            Please enter name.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="contact" placeholder="92-333-4636416"
                                               required>
                                        <div class="invalid-feedback">
                                            Please enter contact.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City <span class="text-danger">*</span></label>

                                        <select class="form-control selectpicker" name="city_id" data-container="body"
                                                data-live-search="true"  required>
                                            <option value="">Choose City</option>
                                            @isset($data)
                                                @foreach ($data['city'] as $city)
                                                    <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <div class="invalid-feedback">
                                            Please choose city.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="display: none">
                                    <div class="form-group">
                                        <label>Lead Type<span class="text-danger">*</span></label>
                                        <select class="select" name="lead_type" required>
                                            <option value="outbound">Outbound</option>
                                            <option value="inbound" selected>Inbound</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please enter Source.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Source<span class="text-danger">*</span></label>

                                        <select class="form-control selectpicker" name="source_id" data-container="body"
                                                data-live-search="true"  required>
                                            <option value="">Choose Source</option>
                                            @isset($data)
                                                @foreach ($data['platforms'] as $platforms)
                                                    <option value="{{ $platforms->id }}">{{ $platforms->platform }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <div class="invalid-feedback">
                                            Please enter Source.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Leads Temperature <span class="text-danger">*</span></label>

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
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label>Date <span class="text-danger">*</span></label>
                                        <input class="form-control" type="date" name="follow_date" placeholder="Followup Date" required>
                                        <div class="invalid-feedback">
                                            Please date.
                                        </div>
                                    </div>
                                </div >
                                <div class="col-md-6">
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
                                        <label>Interest<span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="interest" id="" cols="6" rows="2" placeholder="Enter Interested Project/Query" required></textarea>
                                        <div class="invalid-feedback">
                                            Please Interest .
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Comments<span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="comments" id="" cols="6" rows="2" placeholder="Enter Comments" required></textarea>
                                        <div class="invalid-feedback">
                                            Please Interest .
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary btnSubmit" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Department Modal -->

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
                var assign_id = $(this).attr('assign-id');
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
