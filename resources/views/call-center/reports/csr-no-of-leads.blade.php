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
                            <h3 class="page-title bold-heading">CSR No Of Leads</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">CSR No Of Leads</li>
                            </ul>
                        </div>

                    </div>
                </div>

                <!-- Search Filter -->
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{url('csr-no-of-leads')}}" id="searchForm">
                            <input type="hidden" name="search" value="1">
                            @csrf
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">CSR</label>
                                        <select name="agent_id" class="form-control selectpicker" data-container="body"
                                                data-live-search="true">
                                            <option value="" selected >Choose CSR</option>
                                            @isset($data)
                                                @foreach($data['csr'] as $csr)
                                                    <option value="{{$csr->account_id}}">{{$csr->name}}</option>
                                                @endforeach
                                            @endisset

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="">From</label>
                                    <input type="date" class="form-control" name="from_date" required/>
                                </div>

                                <div class="col-md-3">
                                    <label for="">To</label>
                                    <input type="date" class="form-control" name="to_date" required/>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" id="btn-search" style="margin-top: 30px"><i class="fa fa-search"></i></button>
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
                                    <th>SR#</th>
                                    <th>CSR</th>
                                    <th>Total Leads</th>
                                </tr>
                            </thead>
                            <tbody id="csrTable">
                            @php $c=0 @endphp
                            @isset($data['csrLeads'])
                                @foreach($data['csrLeads'] as $row)
                                    @php $c++ @endphp
                            <tr>
                                <td>{{$c}}</td>
                                <td>{{$row['name']}}
                                </td>

                                <td>{{$row['totalLeads']}}</td>
                                <td><a href="{{url('csr-leads').'/'.$row['emp_id'].'/'.$data['from_date'].'/'.$data['to_date']}}"><i class="fa fa-eye"></i></a></td>

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


    <div id="temp_wise_leads" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card flex-fill dash-statistics">
                        <div class="card-body">

                            <div id="tempArea">
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    <script>
        $(document).ready(function() {

            $('.date_range').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                    .format('YYYY-MM-DD'));
            });

            $('#csrTable').on('click', '.btn-view-temp', function() {
                var csr_id = $(this).attr('csr-id');

                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{url("csr-performance")}}',
                    data: {agent_id:csr_id},
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $(".btn-view-temp").prop("disabled", true);
                        $(".btn-view-temp").html("loading...");

                        },
                    success: function(data) {
                        var html = '';
                        var i;
                        if(data.length > 0) {
                            for (i = 0; i < data.length; i++) {
                                html += '<p><i class="fa fa-dot-circle-o text-success mr-2"></i>' + data[i].temp + '<span class="float-right">' + data[i].totalLeads + '</span></p>';
                            }
                        }
                        else
                            {
                                html += '<p><i class="fa fa-dot-circle-o text-danger mr-2"></i>Not work any lead</span></p>';
                        }
                        $('#tempArea').html(html);

                    },
                    complete : function(data){
                        $(".btn-view-temp").html("view Temp ");
                        $(".btn-view-temp").prop("disabled", false);
                    },
                    error: function() {
                        toastr.error('something went wrong');

                    },

                });
            });


                //search filter
            $('#searchForm1').unbind().on('submit', function(e) {
                e.preventDefault();

                var formData = $('#searchForm').serialize();
                var date_range=$('input[name=date_range]').val();
                alert(formData);

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


        });
    </script>

@endsection
