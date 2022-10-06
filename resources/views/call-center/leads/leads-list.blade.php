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
                            <h3 class="page-title bold-heading">Leads</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Leads List</li>
                            </ul>
                        </div>

                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_department"
                               title="Add New Leads"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>


                <!-- Search Filter -->
                <div class="card">
                    <div class="card-body">

                        <form method="post" action="{{ url('leads-list') }}">
                            @csrf
                            <div class="row">

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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" name="contact" placeholder="Search Phone" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="lead_id"
                                               placeholder="Search Lead ID">
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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10"></div>
                            <div class="col-md-2">

                                <div class="form-group">

                                    <a class="btn btn-primary" data-toggle="modal" data-target="#import_leads"
                                       title="Import"><i class="fa fa-upload"></i></a>

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">Action</button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" data-toggle="modal" data-target="#assign_leads"
                                               href="#">Allocate</a>
                                            <a class="dropdown-item delete_all" href="#">Delete</a>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @if($data['leadsMarketing']->count() > 0)
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th width="50px"><input type="checkbox" id="master"></th>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>LeadID</th>
                                    <th>Name</th>
                                    <th>Contact</th>
{{--                                    <th>City</th>--}}
                                    <th>Allocate</th>
                                    <th>Source</th>
                                    <th>Temp</th>
{{--                                    <th>Type</th>--}}
                                    <th>Query</th>

                                </tr>
                                </thead>

                                <tbody>
                                @php $c=0; @endphp
                                @isset($data['leadsMarketing'])
                                    @foreach ($data['leadsMarketing'] as $key => $market)
                                        @php $c++; @endphp
                                        <tr id="tr_'.{{ $market->id }}">
                                            <td><input type="checkbox" class="sub_chk" data-id="{{ $market->id }}">
                                            </td>
                                            <td>{{ $data['leadsMarketing']->firstItem() + $key }}</td>
                                            <td>{{ date('d-m-Y', strtotime($market->created_at)) }}</td>
                                            <td><a
                                                    href="{{ url('lead-detail/') . '/' . encrypt($market->id) }}">{{ $market->id }}</a>
                                            </td>
                                            <td>{{ $market->name }}</td>
                                            <td>{{ $market->contact }}</td>
{{--                                            <td>{{ $market->cityname->city_name }}</td>--}}
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
{{--                                            --}}
{{--                                            <td>--}}
{{--                                                @php--}}
{{--                                                 ($market->lead_type=='Inbound')? $className='success': $className='primary';--}}
{{--                                                $lead = App\Models\ApprochedLeads::with('temp')--}}
{{--                                                ->where('lead_id', $market->id)--}}
{{--                                                ->first();--}}
{{--                                                if ($lead) {--}}
{{--                                                echo '<span class="badge bg-inverse-warning">' . $lead->temp['temp'] . '</span>';--}}
{{--                                                } else {--}}
{{--                                                echo '<span class="badge bg-inverse-danger">Open</span>';--}}
{{--                                                }--}}
{{--                                                @endphp--}}
{{--                                            </td>--}}

                                            <td><span class="badge bg-inverse-{{$className}}">{{$market->lead_type}}</span></td>
                                            <td>{{ substr($market->interest,10)}}</td>

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
                            <div class="alert alert-danger">Record not found!</div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
        <!-- Add Department Modal -->
        <div id="add_department" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Lead</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ url('store-leads') }}" id="LeadForm" class="needs-validation" novalidate>
                            @csrf
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
                                        <label>Email (optional)<span class="text-danger"></span></label>
                                        <input class="form-control" type="text" name="email" placeholder="Email">
                                        <div class="invalid-feedback">
                                            Please enter email.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="contact" placeholder="92-333-4636416"
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Lead Type<span class="text-danger">*</span></label>
                                        <select class="select" name="lead_type" required>
                                            <option value="">Choose Leed Type</option>
                                            <option value="outbound">Outbound</option>
                                            <option value="Inbound">Inbound</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please enter Leed Type.
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
                                        <label>Interest<span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="interest" id="" cols="6" rows="2" placeholder="Enter Interested Project/Query" required></textarea>
                                        <div class="invalid-feedback">
                                            Please Interest .
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="address" placeholder="Address"
                                               required>
                                        <div class="invalid-feedback">
                                            Please enter Address.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary" type="submit" id="btnSubmit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Department Modal -->
        <div id="import_leads" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import Leads</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form action="{{ route('import-leads') }}" method="POST" enctype="multipart/form-data"
                              class="needs-validation" novalidate id="ImportExcelForm">
                            @csrf
                            <div class="form-group">
                                <label>File <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" name="file" required id="csvFile">
                                <div class="invalid-feedback">
                                    Please enter excel file.
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary" type="submit" id="btnImportLeads">Upload</button>
                            </div>
                        </form>

                    </div>
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
                                <select name="agent_id" class="form-control selectpicker" data-container="body" data-live-search="true">
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
        <!-- /Page Wrapper -->
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function() {



            $('#btnImportLeads').on('click', function() {

                if( $('#csvFile').val()){
                    $("#btnImportLeads").prop("disabled", true);
                    $("#btnImportLeads").html("uploading...");
                    $('#ImportExcelForm').submit();
                }
                else{
                    toastr.error('Excel file missing');
                }
            });

            $('#LeadForm').unbind().on('submit', function(e) {
                e.preventDefault();
                var formData = $('#LeadForm').serialize();
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ url('store-leads') }}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $("#btnSubmit").prop("disabled", true);
                        $("#btnSubmit").html("processing...");

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

            //chek all boxes
            $('#master').on('click', function(e) {
                if ($(this).is(':checked', true)) {
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked', false);
                }
            });

            // delte bulk
            $('.delete_all').on('click', function(e) {


                var allVals = [];
                $(".sub_chk:checked").each(function() {
                    allVals.push($(this).attr('data-id'));
                });


                if (allVals.length <= 0) {
                    alert("Please select row.");
                } else {


                    var check = confirm("Are you sure you want to delete this row?");
                    if (check == true) {


                        var join_selected_values = allVals.join(",");



                        $.ajax({
                            url: '{{ url('/deleteLeads') }}',
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: 'ids=' + join_selected_values,
                            success: function(data) {

                                if (data.success) {
                                    toastr.success(data.success);
                                    window.location.reload();
                                    $(".sub_chk:checked").each(function() {
                                        $(this).parents("tr").remove();
                                    });

                                } else {
                                    toastr.error('something went wrong');
                                }
                            },
                            error: function(data) {
                                toastr.error(data.responseText);
                            }
                        });


                        $.each(allVals, function(index, value) {
                            $('table tr').filter("[data-row-id='" + value + "']").remove();
                        });
                    }
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
                    var manager_id = $('select[name=manager_id]').val();
                    (manager_id)?manager_id=manager_id:manager_id=0;



                    $.ajax({
                        url: '{{ url('/customeAssignLeads') }}',
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

                            console.log(data);
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script>
        @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
        toastr.error("{{ $error }}");
        @endforeach
        @endif


        @if (Session::has('success'))
        toastr.success("Leads import successfully!");
        @endif
        @if (Session::has('errors'))
        toastr.success("CSV File Required!");
        @endif
    </script>


    @include('call-center.general.dont-copy');

@endsection


