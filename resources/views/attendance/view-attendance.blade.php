@extends('setup.master')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <div class="page-wrapper">

        <style>
            body {
                overflow-y: hidden;
            }

            #view-attendence-table1 {
                overflow: scroll;
                height: 60vh;
            }

            #newTable {
                overflow-x: scroll;
            }

            table tbody td:first-child {
                position: sticky;
                left: 0;
                z-index: 1;
                background: white;
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

            .att-btn {
                width: 72%;
            }
        </style>

        <div class="content container-fluid">

            <div class="card">
                <div class="card-body">
                    <!-- <h4 class="card-title">Solid justified</h4> -->
                    <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                        <li class="nav-item att-btn"><a class="nav-link " href="{{ url('att-dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item att-btn"><a class="nav-link" href="{{ url('attendance') }}">Mark
                                Attendance</a></li>
                        <li class="nav-item att-btn"><a class="nav-link active" href="{{ url('view-attendance') }}">View
                                Attendance</a></li>
                        <li class="nav-item att-btn"><a class="nav-link"
                                href="{{ url('attendance-reports') }}">Attendance Reports</a></li>
                    </ul>
                </div>
            </div>
            <!-- /Page Header -->


            <div class="container">
                <div class="row">
                    <div class="col-md-9">

                        <form action="{{ url('view-attendance') }}" method="post" id="searchhAtt">
                            @csrf
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="company_id" class="form-control selectpicker" data-container="body"
                                            data-live-search="true">
                                            <option value="" selected disabled>Choose Company</option>
                                            @isset($data)
                                                @foreach ($data['company'] as $com)
                                                    <option value="{{ $com->id }}">{{ $com->name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="month" class="form-control">
                                            <option value="" selected disabled>Month</option>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="year" class="form-control ">
                                            <option value="" selected>Year</option>

                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-search"> <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="search_user" placeholder="search...">
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="table-responsive">
                    <div id="view-attendence-table1">


                        <table class="table table-striped custom-table table-nowrap mb-0" id="newTable">
                            <thead>
                                <tr>
                                    <th>Employee</th>

                                        <?php

                                        $data['month'] ? ($month = $data['month']) : ($month = date('m'));
                                        $data['year'] ? ($year = $data['year']) : ($year = date('Y'));
                                        $a_date = $year . '-' . $month;
                                        $lastDayOfThisMonth = date('t', strtotime($a_date));
                                        if ($data['month']) {
                                            $dayLoop = $lastDayOfThisMonth;
                                        } else {
                                            $todayOfThisMonth = date('d');
                                            $dayLoop = $todayOfThisMonth;
                                        }
                                        $month_name = date('F', mktime(0, 0, 0, $month, 10));
                                        ?>

                                    @for ($i = 1; $i <= $dayLoop; $i++)
                                        <th>{{ $i }}-{{ substr($month_name, 0, 3) }}-{{ $year }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody id="view-attendence-table">
                                @php $c=0; @endphp
                                @isset($data['employee'])
                                    @foreach ($data['employee'] as $emp)
                                        @php $c++; @endphp
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="#"><img alt="" class="target-img"
                                                            src="{{ asset('storage/app/public/uploads/staff-images/') . '/' . $emp->image }}"></a>
                                                    <a>{{ $emp->name }}<span>{{ $emp->desig_name }}</span></a>
                                                </h2>
                                            </td>

                                                <?php
                                                for ($k = 1; $k <= $dayLoop; $k++) {
                                                    $att = App\Models\Attendance::getEmpAttendanceWithParams($emp->id,$k,$month,$year);
                                                    $off=\App\Models\EmpWeekOff::getEmpOffWeekWithParams($emp->id);
                                                    ($off)? $empOffWeekDay=$off->day_off:$empOffWeekDay='Sun';


                                                    if ($att->count() > 0) {
                                                        echo '<td>';
                                                        foreach ($att as $value => $att) {
                                                            $attDate = date('d', strtotime($att->date));
                                                            $attDay = date('d', strtotime($att->date));
                                                            if ($k == $attDay) {
                                                                if ($att->status == 'Present') {
                                                                    echo '<a href="#" title="Edit Attendance" data="' . $att->id . '" class="btn-edit">   <i class="fa fa-check text-success"></i></a>';
                                                                }
                                                                if ($att->status == 'Absent') {
                                                                    echo '<a href="#" title="Edit Attendance" data="' . $att->id . '" class="btn-edit">     <i class="fa fa-close text-danger"></i> </a>';
                                                                }

                                                                if ($att->status == 'wo') {
                                                                    echo '<a href="#" title="Edit Attendance" data="' . $att->id . '" class="btn-edit">Weekly Off</a>';
                                                                }

                                                                if ($att->status == 'leave') {
                                                                    $leave_name=App\Models\LeaveType::getLeaveName($att->leave_id);
                                                                    echo "<span class='bg-inverse-warning'>.$leave_name.</span>";
                                                                }
                                                            }

                                                            echo '</td>';
                                                        }
                                                    }
                                                    else {
//                                                        $date = date_create(date($k . 'M-Y'));
//                                                        $dayName = date_format($date, 'l');
                                                        $date=$k;
                                                        $date = $date.'-'.$month.'-'.$year;
                                                        $dayName = date('D', strtotime($date));
                                                        if ($dayName ==$empOffWeekDay) {
                                                            echo '<td style="color: red">'.$dayName.'</td>';
                                                        } else {
                                                            echo '<td> <a href="#" title="Mark Attendance" data="' . $k . '"  emp_id="' . $emp->id . '" month="' . $month . '" year="' . $year . '" class="btn-mark"> - </a></td>';
                                                        }
                                                    }
                                                }
                                                ?>

                                        </tr>
                                    @endforeach
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->


        <!-- /Attendance Modal -->
        <div id="attendance_info" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Attendance</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="btnDissmissEdit">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="attendanceForm" method="post">
                            <input type="hidden" name="hiiden_att_id">

                            <div class="form-group ">
                                <select name="update_status" class="form-control att-status">
                                    <option value="">Choose One</option>
                                    <option value="present">Present</option>
                                    <option value="absent">Absent</option>
                                    <option value="wo">Weekly Off</option>
                                    <option value="leave">Leave</option>
                                </select>

                            </div>
                            <div class="form-group leave_section" style="display:none">
                                <select name="leave_id" class="form-control att-status">
                                    <option value="">Choose One</option>
                                    @isset($data)
                                        @foreach ($data['leave_type'] as $leave_type)
                                            <option value="{{ $leave_type->id }}">{{ $leave_type->laeve_type }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn" id="btn-update" type="button">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Attendance Modal -->

        <!--attendance_mark-->
        <div id="attendance_mark" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Mark Attendance</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="btnDissmissEdit">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="attendanceMarkForm" method="post" action="{{ url('single-emp-att-mark') }}">
                            @csrf
                            <input type="hidden" name="hiiden_att_date">
                            <input type="hidden" name="hiiden_emp_id">
                            <input type="hidden" name="hiiden_month">
                            <input type="hidden" name="hiiden_year">
                            <center>

                            <div class="form-group ">
                                <select name="mark_status" class="form-control att-status">
                                    <option value="">Choose One</option>
                                    <option value="present">Present</option>
                                    <option value="absent">Absent</option>
                                    <option value="wo">Weekly Off</option>
                                    <option value="leave">Leave</option>
                                </select>

                            </div>


                                <div class="form-group leave_section" style="display:none">
                                    <select name="leave_id" class="form-control att-status">
                                        <option value="">Choose One</option>
                                        @isset($data)
                                            @foreach ($data['leave_type'] as $leave_type)
                                                <option value="{{ $leave_type->id }}">{{ $leave_type->laeve_type }}</option>
                                            @endforeach
                                        @endisset
                                    </select>

                                </div>
                            </center>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn" id="btn-update" type="submit">Mark</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        $('.livesearch').select2({
            ajax: {
                url: '{{ url('ajax-autocomplete-search') }}',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    console.log(data);
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {

            //edit data

            $('.btn-edit').on('click', function() {
                var id = $(this).attr('data');
                $('#attendance_info').modal('show');
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('edit-attendance') }}',
                    data: {id: id},
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        $('input[name=hiiden_att_id]').val(data.id);
                        var html = '<div class="form-group ">';
                        if (data.status == 'Present') {
                            html +=
                                '<i class="fa fa-check text-success"></i> <input  type="radio" name="status" value="present" checked> &nbsp;';
                        } else {
                            html +=
                                '<i class="fa fa-check text-success"></i> <input  type="radio" name="status" value="present" >';
                        }
                        if (data.status == 'Absent') {

                            html +=
                                '<i class="fa fa-close text-danger"></i></i> <input  type="radio" name="status" value="absent" checked>';
                        } else {
                            html +=
                                '<i class="fa fa-close text-danger"></i></i> <input  type="radio" name="status" value="absent">';
                        }
                        html += '</div>';
                        $('#attendanceRadio').html(html);
                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }
                });
            });

            // btn update
            $('#btn-update').on('click', function() {
                var formData = $('#attendanceForm').serialize();
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('update-attendance') }}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('#attendance_info').modal('hide');
                        toastr.success('Record updated successfully');
                        window.location.reload();

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }
                });
            });

            // btn Mark
            $('.btn-mark').on('click', function() {
                var date = $(this).attr('data');
                var emp_id = $(this).attr('emp_id');
                var month = $(this).attr('month');
                var year = $(this).attr('year');
                $('input[name=hiiden_att_date]').val(date);
                $('input[name=hiiden_month]').val(month);
                $('input[name=hiiden_year]').val(year);
                $('input[name=hiiden_emp_id]').val(emp_id);
                $('#attendance_mark').modal('show');

            });

            $('#attendanceMarkForm').unbind().on('submit', function(e) {
                e.preventDefault();
                var formData = $('#attendanceMarkForm').serialize();
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ url('single-emp-att-mark') }}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (data.success) {
                            $('#attendanceMarkForm')[0].reset();
                            $('.close').click();
                            toastr.success(data.success);
                            window.location.reload();
                        }
                    },

                    error: function() {
                        toastr.error('something went wrong');

                    }
                });
            });
            //search
            $('#search_user').keyup(function(e) {
                search_table($(this).val());
            });
            function search_table(value) {
                $('#view-attendence-table tr').each(function() {
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

            $('select[name=mark_status]').change(function(){
                var status = $("select[name=mark_status]").val();
                if(status=='leave') {
                    $(".leave_section").css("display", "block");
                }else{
                    $(".leave_section").css("display", "none");
                }
            });


            $('select[name=update_status]').change(function(){
                var status = $("select[name=update_status]").val();
                if(status=='leave') {
                    $(".leave_section").css("display", "block");
                }else{
                    $(".leave_section").css("display", "none");
                }
            });

            //please wwait section
            $('.btn-search').on('click', function() {
                $(".btn-search").prop("disabled", true);
                $(".btn-search").html("loading...");
                $('#searchhAtt').submit();
            });

        });
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
@endsection
