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
                            <h3 class="page-title bold-heading">Staff</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Staff List</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn"  data-toggle="modal" data-target="#add_department" title="Add New Leads"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Search Filter -->

                    @csrf
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group" style="margin: 10px">
                                <a class="btn btn-primary"  data-toggle="modal" data-target="#import_leads"  title="Import"><i class="fa fa-upload"></i></a>
                                <a class="btn btn-warning" href="{{ route('export-leads') }}" title="Export"><i class="fa fa-download"></i></a>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action With Selected</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" data-toggle="modal" data-target="#assign_leads" href="#">Assign</a>
                                        <a class="dropdown-item delete_all" href="#">Delete</a>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                <div class="card">
                    <div class="card-body">

                        <table class="table table-striped table-hover data-table" >
                            <thead>
                            <tr>
                                <th width="50px"><input type="checkbox" id="master"></th>
                                <th>#</th>
                                <th>LeadID</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>City</th>
                                <th>Assigned</th>
                                <th>Temperature</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody >
                            @php $c=0; @endphp
                            @isset($data['leadsMarketing'])
                                @foreach($data['leadsMarketing'] as $market)
                                    @php $c++; @endphp
                            <tr id="tr_'.{{$market->id}}">
                                <td><input type="checkbox" class="sub_chk" data-id="{{$market->id}}"></td>
                                <td>{{$c}}</td>
                                <td>{{$market->id}}</td>
                                <td>{{$market->name}}</td>
                                <td>{{$market->contact}}</td>
                                <td>{{$market->cityname->city_name}}</td>
                                <td>
                                    @php
                                        $lead=App\Models\AssignedLeads::with('agent')->where('lead_id',$market->id)->first();
                                        if($lead){

                                             echo '<span class="badge bg-inverse-success">'.$lead->agent['name'].'</span>';
                                        }else{
                                          echo '<span class="badge bg-inverse-danger">Not Assigned</span>';
                                        }

                                    @endphp
                                </td>
                                <td>
                                    @php
                                        $lead=App\Models\ApprochedLeads::with('temp')->where('lead_id',$market->id)->first();
                                        if($lead){

                                             echo '<span class="badge bg-inverse-warning">'.$lead->temp['temp'].'</span>';
                                        }else{
                                          echo '<span class="badge bg-inverse-danger">Not Approach</span>';
                                        }

                                    @endphp
                                </td>
                                <td>{{$market->created_at}}</td>

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
        <!-- Add Department Modal -->
        <div id="add_department" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Leads</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{url('leads')}}" id="LeadForm" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" placeholder=" Name" required>
                                        <div class="invalid-feedback">
                                            Please enter  name.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email <span class="text-danger"></span></label>
                                        <input class="form-control" type="text" name="email" placeholder="Email" >
                                        <div class="invalid-feedback">
                                            Please enter email.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="contact" placeholder="Contact" required>
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
                                                @foreach($data['city'] as $city)
                                                    <option value="{{$city->id}}">{{$city->city_name}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <div class="invalid-feedback">
                                            Please choose city.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="address" placeholder="Address" required>
                                        <div class="invalid-feedback">
                                            Please enter Address.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary  " type="submit" id="btnSubmit">Save</button>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                    <form action="{{ route('import-leads') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf

                                    <div class="form-group">
                                        <label>File <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" name="file" required>
                                        <div class="invalid-feedback">
                                            Please enter  excel file.
                                        </div>
                                    </div>

                            <div class="submit-section">
                                <button class="btn btn-primary  " type="submit" id="btnSubmit">Upload</button>
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
                        <h5 class="modal-title">Assign Leads</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf

                            <div class="form-group">
                                <label>Agent<span class="text-danger">*</span></label>

                                    <select name="agent_id" class="form-control selectpicker" data-container="body" data-live-search="true">
                                    <option value="">Choose Agent</option>

                                    @isset($data)
                                        @foreach($data['employee'] as $emp)
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script>
        $(document).ready(function() {
            getLeads();

            $('#LeadForm').unbind().on('submit', function(e) {
                e.preventDefault();
                var formData = $('#LeadForm').serialize();
                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{url("leads")}}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {

                        $("#btnSubmit").prop("disabled", true);
                        $("#btnSubmit").html("saving...");

                    },
                    success: function(data) {

                        if (data.success) {
                            getLeads();
                            $('.close').click();
                            $('#LeadForm')[0].reset();
                            toastr.success(data.success);

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


            function getLeads() {

                $.ajax({

                    url: '{{url("/getLeads")}}',
                    type: 'get',
                    async: false,
                    dataType: 'json',

                    success: function(data) {


                        var html = '';
                        var i;
                        var c = 0;

                        for (i = 0; i < data.length; i++) {

                            c++;

                            html += '<tr id="tr_'+data[i].id+'">'+
                                '+<td><input type="checkbox" class="sub_chk" data-id="'+data[i].id+'"></td>'+
                                '<td>'+c+'</td>' +
                                '<td>'+data[i].id+'</td>' +
                                '<td>'+data[i].name+'</td>' +
                                '<td>'+data[i].contact+'</td>' +
                                '<td>'+data[i].cityname.city_name+'</td>' +
                                '<td>'+data[i].address+'</td>' +
                                '<td>temp</td>' +
                                '<td>'+data[i].created_at+'</td>' +

                                '</tr>';
                        }


                        $('#leadsTable').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }

            //chek all boxes
            $('#master').on('click', function(e) {
                if($(this).is(':checked',true))
                {
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked',false);
                }
            });

// delte bulk
            $('.delete_all').on('click', function(e) {


                var allVals = [];
                $(".sub_chk:checked").each(function() {
                    allVals.push($(this).attr('data-id'));
                });


                if(allVals.length <=0)
                {
                    alert("Please select row.");
                }  else {


                    var check = confirm("Are you sure you want to delete this row?");
                    if(check == true){


                        var join_selected_values = allVals.join(",");



                        $.ajax({
                            url: '{{url("/deleteLeads")}}',
                            type: 'DELETE',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: 'ids='+join_selected_values,
                            success: function (data) {
                                getLeads();
                                if (data.success) {
                                    toastr.success(data.success);
                                    window.location.reload();
                                    $(".sub_chk:checked").each(function() {
                                        $(this).parents("tr").remove();
                                    });

                                }else{
                                    toastr.error('something went wrong');
                                }
                            },
                            error: function (data) {
                                toastr.error(data.responseText);
                            }
                        });


                        $.each(allVals, function( index, value ) {
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


                if(allVals.length <=0)
                {
                    toastr.error("Please select row.");
                }
                else {
                        var agent_id=$('select[name=agent_id]').val();

                        $.ajax({
                            url: '{{url("/customeAssignLeads")}}',
                            type: 'GET',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data:{ids:allVals,agent_id:agent_id} ,
                            beforeSend: function() {
                                $(".btn-save-assign-leads").prop("disabled", true);
                                $(".btn-save-assign-leads").html("saving...");

                            },
                            success: function (data) {
                                getLeads();
                                console.log(data);
                                if (data.success) {
                                    toastr.success(data.success);
                                    $(".sub_chk:checked").each(function() {
                                        $(this).parents("tr").remove();
                                    });

                                }else{
                                    toastr.error('something went wrong');
                                }
                            },
                            complete : function(data){
                                $('.close').click();
                                $(".btn-save-assign-leads").html("Save");
                                $(".btn-save-assign-leads").prop("disabled", false);
                            },
                            error: function (data) {
                                toastr.error(data.responseText);
                            }
                        });


                        $.each(allVals, function( index, value ) {
                            $('table tr').filter("[data-row-id='" + value + "']").remove();
                        });

                }
            });
        });
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    <script>
        @if(count($errors) > 0)

        @foreach($errors-> all() as $error)

        toastr.error("{{ $error }}");
        @endforeach
        @endif


        @if(Session::has('success'))
        toastr.success("Leads import successfully!");

        @endif
    </script>


@endsection
