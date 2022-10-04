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

        .coment {
            border-radius: 7px;
        }

        #comment_card {
            background: #000;
            color: #fff;
        }

        .pos {
            top: 16rem;
            position: fixed;
            width: 50%;
            /* left: 45rem; */
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
                            <h3 class="page-title bold-heading">{{ $data['leadType'] }} Leads</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">My Leads</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_department"
                                title="Add Inbound Leads"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Search Filter -->
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ url('my-leads') }}">
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
                                        <select name="city_id" class="form-control selectpicker" data-container="body" --}}
                                            data-live-search="true">
                                            <option value="" selected>Choose City</option>
                                            @isset($data)
                                                @foreach ($data['city'] as $city)
                                                    <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name"
                                            placeholder="Search Client Name">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="lead_id"
                                            placeholder="Search Lead ID">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="phone" placeholder="Search Phone">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <a class="btn btn-primary" data-toggle="modal" data-target="#import_leads"
                                            title="Import"><i class="fa fa-upload"></i></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Search Filter -->

                <div class="card">
                    <div class="card-body">



                        <table class="table table-striped" id="yy">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>LeadID</th>
                                    <th>Name</th>
                                    {{-- <th>Email</th> --}}
                                    <th>Contact</th>
                                    <th>City</th>
                                    <th>Temp</th>
                                    <th>Type</th>
                                    <th>Query</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="leadsTable">

                            {{-- <input type="text" name="hello" /> --}}

                            <div class="pos w-100 text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3">
                                        <div class="card" id="comment_card">
                                            <div class="card-body">
                                                <span class="coment">

                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-7"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                                {{-- @php $c=0 @endphp --}}
                                @isset($data)
                                    @foreach ($data['assigned_leads'] as $key => $row)
                                        {{-- @php $c++ @endphp --}}
                                        <tr class="first_tr">
                                            <td>{{ $data['assigned_leads']->firstItem() + $key }}</td>
                                            <td>
                                                <a class="name_column" href="{{ url('lead-detail') . '/' . encrypt($row->lead_id) }}"
                                                    data="{{ $row->lead_id }}">{{ $row->lead_id }}
                                                </a>
                                            </td>
                                            <td>{{ $row->leads['name'] }}</td>
                                            <td>{{ $row->leads['contact'] }}</td>
                                            <td>{{ $row->leads->cityname->city_name }}</td>
                                            <td>
                                                @php
                                                    $comment = '';
                                                    $approachId = '';
                                                    $row->leads['lead_type'] == 'Inbound' ? ($className = 'success') : ($className = 'primary');
                                                    $lead = App\Models\ApprochedLeads::with('temp')
                                                        ->where('lead_id', $row->leads['id'])
                                                        ->latest('id')
                                                        ->first();
                                                    $comm = $lead;
                                                    $countApproach = App\Models\ApprochedLeads::where('lead_id', $row->leads['id'])->count();
                                                    if ($lead) {
                                                        $comment = $lead->comments;
                                                        $approachId = $lead->id;
                                                        echo '<span class="badge bg-inverse-info">' . $lead->temp['temp'] . '</span>(' . $countApproach . ')</br>';
                                                        echo '<small> ' . $lead->created_at . '</small>';
                                                    } else {
                                                        echo '<span class="badge bg-inverse-danger">Open</span>';
                                                    }
                                                @endphp
                                            </td>
                                            <td><span
                                                    class="badge bg-inverse-{{ $className }}">{{ $row->leads['lead_type'] }}</span>
                                            </td>
                                            <td>{{ $row->leads['interest'] }}</td>
                                            <td>{{ $row->created_at }}</td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                        aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="#" class="dropdown-item bg-inverse-primary lead-status"
                                                            data-toggle="modal" data-target="#add_lead_status"
                                                            data="{{ $row->leads['id'] }}">Add Lead Status</a>
                                                        <a href="#" class="dropdown-item bg-inverse-success edit-lead-status"
                                                            data-toggle="modal" data-target="#edit_lead_status"
                                                            data="{{ $approachId }}"><i class="fa fa-edit"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset
                                <tr>
                                    <td colspan="10">
                                        <div class="float-right"
                                        >
                                            {{ $data['assigned_leads']->links('pagination::bootstrap-4') }}
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
        <!-- Add Department Modal -->
        <div id="add_lead_status" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Leads Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ url('save-leads-status') }}" id="LeadForm"
                            class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <input type="hidden" name="hidden_lead_id">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <select class="form-control selectpicker" name="temp_id" data-container="body"
                                            data-live-search="true" required>
                                            <option value="">Choose Temperature</option>
                                            @isset($data)
                                                @foreach ($data['temp'] as $temp)
                                                    <option value="{{ $temp->id }}">{{ $temp->temp }}</option>
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

                                        <input type="text" name="lead_name" class="form-control" placeholder="Name"
                                            required>
                                        <div class="invalid-feedback">
                                            Please enter name.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="city" class="select" required>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please choose city.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="source" class="select" required>
                                            <option value="" selected>Choose Source</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please choose source .
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label>Follow up Date <span class="text-danger">*</span></label>
                                        <input class="form-control" type="date" name="follow_date"
                                            placeholder="Followup Date" required>
                                        <div class="invalid-feedback">
                                            Please date.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 followup-section">
                                    <div class="form-group">
                                        <label>Time<span class="text-danger">*</span></label>
                                        <input class="form-control" type="time" name="time" placeholder="Followup Time">
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
                                        <textarea name="comments" cols="10" rows="3" class="form-control" required></textarea>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ url('update-leads-status') }}" id="UpdateApprLeadForm"
                            class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <input type="hidden" name="edit_lead_id">

                                <div class="col-md-12">
                                    <div class="form-group">

                                        <select class="form-control" name="tempDropdown" required>
                                            <option value="">Choose Temperature</option>

                                        </select>
                                        <div class="invalid-feedback">
                                            Please choose leads temperature .
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
                                        <textarea name="edit_comments" cols="10" rows="3" class="form-control" required></textarea>
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
                        <form method="post" action="{{ url('leads') }}" id="inboundLeadForm" class="needs-validation"
                            novalidate>
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
                                        <select class="select" name="city_id" id="deptId" required>
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
                                        <select class="select" name="source_id" required>
                                            <option value="">Choose Source</option>
                                            @isset($data)
                                                @foreach ($data['platforms'] as $platforms)
                                                    <option value="{{ $platforms->id }}">{{ $platforms->platform }}
                                                    </option>
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
                                        <select class="select" name="temp_id" required>
                                            <option value="">Choose Temperature</option>
                                            @isset($data)
                                                @foreach ($data['temp'] as $temp)
                                                    <option value="{{ $temp->id }}">{{ $temp->temp }}</option>
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
                                        <input class="form-control" type="date" name="follow_date"
                                            placeholder="Followup Date" required>
                                        <div class="invalid-feedback">
                                            Please date.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Time<span class="text-danger">*</span></label>
                                        <input class="form-control" type="time" name="time" placeholder="Followup Time">
                                        <div class="invalid-feedback">
                                            Please enter time.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Interest<span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="interest" id="" cols="6" rows="2" placeholder="Enter Interested Project/Query"
                                            required></textarea>
                                        <div class="invalid-feedback">
                                            Please Interest .
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Comments<span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="comments" id="" cols="6" rows="2" placeholder="Enter Comments"
                                            required></textarea>
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
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {

            // $(".last_td").hide();
            // $('#leadsTable tr').mouseenter(function() {
            //     // alert('dd');
            //     var $val = $(this).find(".last_td").html();
            //     if ($val != null) {
            //         $(".pos").show();
            //         $('.coment').text($val);
            //     }

            // }).mouseleave(function() {
            //     $(".pos").hide();
            // });

            $(".pos").hide();
            $('#leadsTable').on('mouseover', '.name_column', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('get-comment') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('.coment').text('Processing...');
                    },
                    success: function(data) {

                        $(".pos").show(1000);
                         $('.coment').text(data.comments);
                    },
                    complete: function(){
                        $('.coment').text(data.comments);
                    },
                });
            }).mouseleave(function() {
                $(".pos").hide(1000);
            });


            $('#LeadForm').unbind().on('submit', function(e) {
                e.preventDefault();

                var formData = $('#LeadForm').serialize();

                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{ url('save-leads-status') }}',
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

                            toastr.error('missing some fileds');
                            //toastr.error(data.errors);
                        }
                    },

                    complete: function(data) {
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
                    url: '{{ url('leads') }}',
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

                    complete: function(data) {
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
                    url: '{{ url('getLeadsInfo') }}',
                    data: {
                        lead_id: id
                    },
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
                                    .append(
                                        `<option value="${city.id}" ${city.id == data.leads.city_id ? 'selected' : ''}>${city.city_name}</option>`
                                    )
                            });

                            $.each(data.platform, function(key, platform) {

                                $('select[name="source"]')
                                    .append(
                                        `<option value="${platform.id}" ${platform.id == data.leads.platform_id ? 'selected' : ''}>${platform.platform}</option>`
                                    )
                            });

                        }
                        if (data.errors) {
                            toastr.error(data.errors);
                        }
                    },

                    complete: function(data) {
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
                    url: '{{ url('editLeadsInfo') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {

                        $(".btnUpdate").prop("disabled", true);
                        $(".btnUpdate").html("loading...");

                    },

                    success: function(data) {

                        console.log(data);
                        if (data) {

                            $('textarea[name=edit_comments]').val(data.appLeads.comments);
                            $.each(data.temp, function(key, temp) {

                                $('select[name="tempDropdown"]')
                                    .append(
                                        `<option value="${temp.id}" ${temp.id == data.appLeads.temp_id ? 'selected' : ''}>${temp.temp}</option>`
                                    )
                            });



                        }
                        if (data.errors) {
                            toastr.error(data.errors);
                        }
                    },


                    complete: function(data) {
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
                    url: '{{ url('update-leads-status') }}',
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

                    complete: function(data) {
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
