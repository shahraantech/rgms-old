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
                            <h3 class="page-title bold-heading">{{ ($data['leadType'])?$data['leadType']:''}} Leads</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ ($data['leadType'])?$data['leadType']:''}}  Leads</li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>LeadID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>City</th>
                                <th>Temperature</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody id="leadsTable">
                            @php $c=0 @endphp
                            @isset($data)
                                @foreach($data['assigned_leads'] as $row)
                                    @php $c++ @endphp
                                    <tr>
                                        <td>{{$c}}</td>
                                        <td>
                                            <a href="{{url('lead-detail').'/'.encrypt($row->lead_id)}}">
                                                {{$row->leads['id']}}
                                            </a>
                                        </td>

                                        <td>{{$row->leads['name']}}</td>
                                        <td>{{$row->leads['email']}}</td>
                                        <td>{{$row->leads['contact']}}</td>
                                        <td>{{$row->leads->cityname->city_name}}</td>
                                        <td>
                                            @php
                                                $lead=App\Models\ApprochedLeads::with('temp')->where('lead_id',$row->leads['id'])->latest('id')->first();
                                                if($lead){

                                                     echo '<span class="badge bg-inverse-info">'.$lead->temp['temp'].'</span>';
                                                }else{
                                                  echo '<span class="badge bg-inverse-danger">Open</span>';
                                                }

                                            @endphp

                                        </td>
                                        <td>{{$row->created_at}}</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item lead-status" data-toggle="modal" data-target="#add_lead_status" data="{{$row->leads['id']}}">Add Lead Status</a>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="hidden" name="hidden_lead_id">
                                        <label>Leads Type <span class="text-danger">*</span></label>
                                        <select class="select"  required name="lead_type">
                                            <option value="Outbound">Outbound</option>
                                            <option value="Inbound">Inbound</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please Leads Type.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Leads Temperature <span class="text-danger">*</span></label>
                                        <select class="select" name="temp_id"  required>
                                            <option value="">Choose Temperature</option>
                                            <option value="5585355">Deal Done</option>
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Require Followup <span class="text-danger"></span></label>
                                        <select class="select"  required name="is_follow">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please choose followup.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 followup-section">
                                    <div class="form-group">
                                        <label>Date <span class="text-danger">*</span></label>
                                        <input class="form-control" type="date" name="follow_date" placeholder="Follow Date" >
                                        <div class="invalid-feedback">
                                            Please date.
                                        </div>
                                    </div>
                                </div >
                                <div class="col-md-6 followup-section">
                                    <div class="form-group">
                                        <label>Time<span class="text-danger">*</span></label>
                                        <input class="form-control" type="time" name="time" placeholder="Follow Time" >
                                        <div class="invalid-feedback">
                                            Please enter time.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Comments<span class="text-danger">*</span></label>
                                        <textarea name="comments"  cols="10" rows="3" class="form-control"></textarea>
                                        <div class="invalid-feedback">
                                            Please enter comments.
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

                        $("#btnSubmit").prop("disabled", true);
                        $("#btnSubmit").html("loading...");

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

                    complete : function(data){
                        $("#btnSubmit").html("Save");
                        $("#btnSubmit").prop("disabled", false);
                    },
                    error: function() {
                        toastr.error('something went wrong');

                    },

                });


            });

            $('#leadsTable').on('click', '.lead-status', function() {
                var id = $(this).attr('data');
                $('input[name=hidden_lead_id]').val(id);


                });


            //is_follow
            $('select[name=is_follow]').change(function() {
                var follow = $('select[name=is_follow]').val();
                if(follow==1){
                    $('.followup-section').show();
                }else{
                    $('.followup-section').hide();
                }
            });
            });


    </script>

    @include('call-center.general.dont-copy');
@endsection
