@extends('setup.master')
@section('content')
<div class="page-wrapper">
    <style>
        body {
            overflow-y: hidden;
        }

        .attendence_table {
            height: 60vh;
            overflow: scroll;
            overflow-x: scroll;
        }

        table thead th:first-child {
            position: sticky;
            left: 0;
            z-index: 2;
            background: white;
        }


        table thead th {
            position: sticky;
            top: 0;
            z-index: 1;
            background: white;
        }


        #search_user {
            border-radius: 30px;
        }

        .att-btn{
            width: 72%;
        }
    </style>
    <!-- Page Content -->

    <div class="content container-fluid">

        <div class="card">
            <div class="card-body">
                <!-- <h4 class="card-title">Solid justified</h4> -->
                <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                    <li class="nav-item att-btn"><a class="nav-link " href="{{url('att-dashboard')}}">Dashboard</a></li>
                    <li class="nav-item att-btn"><a class="nav-link active" href="{{url('attendance')}}">Mark Attendance</a></li>
                    <li class="nav-item att-btn"><a class="nav-link" href="{{url('view-attendance')}}">View Attendance</a></li>
                    <li class="nav-item att-btn"><a class="nav-link" href="{{url('attendance-reports')}}">Attendance Reports</a></li>
                </ul>
            </div>
        </div>


        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <form action="{{url('attendance')}}" method="get" id="search_att_form">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <select name="company_id" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="" selected disabled>Choose Company</option>
                                        @isset($data)
                                        @foreach($data['company'] as $com)
                                        <option value="{{ $com->id }}">{{ $com->name }}</option>
                                        @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn_search_company"> <i class="fa fa-search"></i> </button>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="search_user" placeholder="search...">
                </div>
                <div class="col-md-2">
                    <form action="{{url('attendance')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block"> Mark </button>
                        </div>


                </div>
            </div>
        </div>


        <div class="row">
            <div class="table-responsive">
                <div class="attendence_table">
                    <table class="table table-striped custom-table mb-0">
                        <thead>
                            <tr>
                                <th>SR#</th>
                                <th>Employee</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $c=0; @endphp
                            @isset($data['employee'])
                            @foreach($data['employee'] as $emp)
                            @php $c++; @endphp
                            <tr>
                                <td>{{$c}}</td>
                                <td>
                                    <input type="hidden" name="emp_id[]" value="{{$emp->id}}">
                                    <h2 class="table-avatar">
                                        <a href="#"><img alt="" class="target-img" src="{{asset('storage/app/public/uploads/staff-images/').'/'.$emp->image}}"></a>
                                        <a>{{$emp->name}}<span>{{$emp->desig_name}}</span></a>
                                    </h2>
                                </td>
                                <td><i class="fa fa-check text-success"></i> <input type="radio" name="status_{{$c}}" value="present" checked> &nbsp;
                                    <i class="fa fa-close text-danger"></i></i> <input type="radio" name="status_{{$c}}" value="absent">
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
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script>
    @if(count($errors) > 0)

    @foreach($errors->all() as $error)

    toastr.error("{{ $error }}");
    @endforeach
    @endif


    @if(Session::has('success'))
    toastr.success("Attendance marked successfully!");

    @endif


    //search
    $('#search_user').keyup(function(e) {
        search_table($(this).val());
    });

    function search_table(value) {
        $('table tr').each(function() {
            var found = 'false';
            $(this).each(function() {
                if ($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0) {
                    found = 'true';
                }
            });
            if (found == 'true') {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }



    $('.btn_search_company').on('click', function() {
        $(".btn_search_company").prop("disabled", true);
        $(".btn_search_company").html("Please wait...");
        $('#search_att_form').submit();
    });
</script>
@endsection
