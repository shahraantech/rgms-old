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
                            <h3 class="page-title bold-heading">Meetings</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Meetings List</li>
                            </ul>
                        </div>

                    </div>
                </div>
                <!-- Search Filter -->
                @csrf
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group" style="margin: 10px">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" data-toggle="modal" data-target="#assign_leads" href="#">Allocate</a>
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
                                <th>Temperature</th>
                                <th>Assigned</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody >
                            @php $c=0; @endphp
                            @isset($data['deals'])
                                @foreach($data['deals'] as $deal)
                                    @php $c++; @endphp
                                    <tr id="tr_'.{{$deal->id}}">
                                        <td><input type="checkbox" class="sub_chk" data-id="{{$deal->leads->id}}"></td>
                                        <td>{{$c}}</td>
                                        <td><a href="{{url('meet-detail').'/'.encrypt($deal->leads->id)}}">{{$deal->leads->id}}</a></td>
                                        <td>{{$deal->leads->name}}</td>
                                        <td>{{$deal->leads->contact}}</td>
                                        <td>{{$deal->leads->cityname['city_name']}}</td>

                                        <td>
                                            @php
                                                $temp_id=0;
                                                    $lead=App\Models\ApprochedLeads::with('temp')->where('lead_id',$deal->leads['id'])->latest('id')->first();
                                                    if($lead){
                                                        $temp_id=$lead->temp['id'];
                                                    echo '<span class="badge bg-inverse-info">'.$lead->temp['temp'].'</span>';
                                                    }else{
                                                    echo '<span class="badge bg-inverse-danger">Not Approach</span>';
                                                    }
                                            @endphp
                                        </td>

                                        <td>
                                                  @php
                                                      $manager=App\Models\AssignedLeads::where('lead_id',$deal->leads['id'])->where('type','meeting')->first();
                                                      $manager_name='';
                                                      $type='';
                                                      if($manager){
                                                          $emp=App\Models\Employee::find($manager->manager_id);
                                                          $manager_name=$emp->name;
                                                          $type='manager';
                                                      }
                                                      $source_name='';
                                                      $source=App\Models\AssignedMeetings::where('lead_id',$deal->leads['id'])->first();
                                                         if($source){
                                                              $source=App\Models\Employee::find($source->source_id);
                                                              $source_name=$source->name;
                                                              }
                                                              if($manager_name ){
                                                         echo '<span class="badge bg-inverse-success">'.$manager_name.' (manager) </span></br>';
                                                         }if($source_name){
                                                         echo '<span class="badge bg-inverse-primary">'.$source_name.' (salesman) </span>';
                                                         }
                                                              if(empty($manager_name) AND empty($source_name)){
                                                         echo '<span class="badge bg-inverse-danger">Open</span>';
                                                         }
                                                  @endphp
                                        </td>

                                        <td>{{date('d-m-Y',strtotime($deal->created_at))}}</td>

                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if($temp_id==9)
                                                    <a href="{{url('customer-form').'/'.encrypt($deal->leads->id)}}" class="dropdown-item" title="Add Customer Info"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                               @endif
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
            <!-- Page Content -->
        </div>
        <div id="assign_leads" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Allocate  Meeting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalDismiss">
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
                                    <option value="2">Resource</option>
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

            //chek all boxes
            $('#master').on('click', function(e) {
                if($(this).is(':checked',true))
                {
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked',false);
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
                    var source_id=$('select[name=agent_id]').val();
                    var manager_id = $('select[name=manager_id]').val();
                    (manager_id)?manager_id=manager_id:manager_id=0;


                    $.ajax({
                        url: '{{url("/saveMeetings")}}',
                        type: 'GET',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data:{
                            ids:allVals,
                            source_id:source_id,
                            type:'meeting',
                            manager_id: manager_id,
                        } ,
                        beforeSend: function() {
                            $(".btn-save-assign-leads").prop("disabled", true);
                            $(".btn-save-assign-leads").html("processing...");

                        },
                        success: function (data) {

                            console.log(data);
                            if (data.success) {
                                toastr.success(data.success);
                                $(".sub_chk:checked").each(function() {
                                    $(this).parents("tr").remove();
                                });
                                window.location.reload();
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
