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
                            <h3 class="page-title bold-heading">Dead Lead Report</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Dead Lead Report</li>
                            </ul>
                        </div>

                    </div>
                </div>

                <!-- Search Filter -->
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{url('sales-report')}}" id="searchForm">
                            <input type="hidden" name="search" value="1">
                            @csrf
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">

                                        <select name="agent_id" class="form-control selectpicker" data-container="body"
                                                data-live-search="true">
                                            <option value="" selected >Sale Person</option>
                                            @isset($data)
                                                @foreach($data['csr'] as $csr)
                                                    <option value="{{$csr->id}}">{{$csr->name}}</option>
                                                @endforeach
                                            @endisset

                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="search_month" class="form-control selectpicker" data-container="body"
                                                data-live-search="true">
                                            <option value="" selected disabled>Choose Month</option>
                                            <option value="01">Jan</option>
                                            <option value="02">Feb </option>
                                            <option value="03">Mar</option>
                                            <option value="04">Apr</option>
                                            <option value="05">May</option>
                                            <option value="06">Jun</option>
                                            <option value="07">Jul</option>
                                            <option value="08">Aug</option>
                                            <option value="09">Sep</option>
                                            <option value="10">Oct</option>
                                            <option value="11">Nov</option>
                                            <option value="12">Dec</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">

                                        <select class="select" name="search_year">
                                            <option value="">Choose Year</option>
                                            @for ($y = 2021; $y <= date('Y'); $y++)
                                                <option value="{{ $y }}">{{ $y }} </option>
                                            @endfor

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" id="btnSubmit"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <!-- Search Filter -->
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover data-table">
                            <thead>
                                <tr>
                                    <th>SR#</th>
                                    <th>Date</th>
                                    <th>Lead ID</th>
                                    <th>Client Name</th>
                                    <th>Sale Person</th>
                                    <th>Reason</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="deptTable">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
    </div>



    <script>
        $(document).ready(function() {
            getSaleReport();
            function getSaleReport() {

                $.ajax({
                    url: '{{url("/get-dead-lead-report")}}',
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        $('#deptTable').html(data);
                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }


            $('#searchForm').unbind().on('submit', function(e) {
                e.preventDefault();
                var formData = $('#searchForm').serialize();
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ url('dead-lead-report') }}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $("#btnSubmit").prop("disabled", true);
                        $("#btnSubmit").html("processing...");

                    },
                    success: function(data) {

                        $('#deptTable').html(data);
                    },
                    complete: function(data) {
                        $("#btnSubmit").html('<i class="fa fa-search"></i>');
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
