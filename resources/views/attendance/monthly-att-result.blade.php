<div>

    <head>
        <title>CRM</title>

        <link rel="shortcut icon" type="image/x-icon" href="public/assets/img/logo/favicon.png">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('public/assets/css/table-style.css') }}">
        <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        <style>
            .name {
                padding: 1px;
                font-weight: bold;
                font-size: 11px;
            }

            .daily {
                background-color: #000;
                /* width: 100%; */
                color: #fff;
                padding: 5px 5px;
                -webkit-print-color-adjust: exact;

            }

            .cell-width {
                width: 50px;
                text-align: center;
                padding-left: 1px;
                padding-right: 1px;
            }

            #searchAttendence {
                height: 34px;
                border-radius: 20px;
            }
        </style>

    </head>

    <div class="container-fluid mt-4">
        <div class="daily" style="margin-bottom: 15px">
            @php
                $data['month'] ? ($month = $data['month']) : ($month = date('m'));
                $data['year'] ? ($year = $data['year']) : ($year = date('Y'));
                $a_date = $year . '-' . $month;
                $lastDayOfThisMonth = date('t', strtotime($a_date));
                $month_name = date('F', mktime(0, 0, 0, $month, 10));
            @endphp
            <div class="row">
                <div class="col-md-4">
                    <a href="{{ url('/monthly-att-report') }}" style="float:left;" title="Back"><button
                            class="btn btn-info">Back</button></a> &nbsp;
                    <button onclick="ExportToExcel('xlsx')" class="btn btn-success">Export to Excel</button>
                    <button class="btn btn-success" id="printBtn">Print</button>
                </div>
                <div class="col-md-5">
                    <h4 style="text-align: center"> {{ $data['company'] }} Attendance Sheet Month Of
                        {{ $month_name }}
                        {{ $year }}</h4>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="searchAttendence" placeholder="Search here...">
                </div>
            </div>
        </div>

        <table class="table-responsive" id="tbl_exporttable_to_xls">

            <tr>
                <strong>
                    <h2>Att Report </h2>
                </strong>

            </tr>
            <tr style="background-color:#ECF9FF;">
                <th class="name">#</th>
                <th class="name">Name</th>



                @for ($i = 1; $i <= $lastDayOfThisMonth; $i++)
                    <th class="cell-width">{{ $i }}</th>
                @endfor

            </tr>

            @php $c=0; @endphp
            @isset($data['employee'])
                @foreach ($data['employee'] as $emp)
                    @php $c++; @endphp
                    <tbody id="ddd">
                        <tr>
                            <td class="name">{{ $c }}</td>
                            <td class="name">{{ $emp->name }}</td>


                            <?php

                            for ($k = 1; $k <= $lastDayOfThisMonth; $k++) {
                                $att = App\Models\Attendance::getEmpAttendanceWithParams($emp->id, $k, $month, $year);
                                $off = \App\Models\EmpWeekOff::getEmpOffWeekWithParams($emp->id);
                                $off ? ($empOffWeekDay = $off->day_off) : ($empOffWeekDay = 'Sun');

                                if ($att->count() > 0) {
                                    echo '<td class="cell-width">';
                                    foreach ($att as $value => $att) {
                                        $attDate = date('d', strtotime($att->date));
                                        $attDay = date('d', strtotime($att->date));

                                        if ($k == $attDay) {
                                            if ($att->status == 'Present') {
                                                echo "<span class='bg-inverse-success'>" . date('H:i', strtotime($att->created_at)) . '</span>';
                                            }
                                            if ($att->status == 'Absent') {
                                                echo "<span class='bg-inverse-danger'>A</span>";
                                            }
                                            if ($att->status == 'wo') {
                                                echo "<span class='bg-inverse-primary'>Weekly Off</span>";
                                            }
                                            if ($att->status == 'leave') {
                                             $leave_name=App\Models\LeaveType::getLeaveName($att->leave_id);
                                                echo "<span class='bg-inverse-warning'>.$leave_name.</span>";
                                            }
                                        }

                                        echo '</td>';
                                    }
                                } else {
                                    $date = $k;
                                    $date = $date . '-' . $month . '-' . $year;
                                    $dayName = date('D', strtotime($date));

                                    //                                     $date = date_create(date($k . 'M-Y'));
                                    //                                    $dayName = date_format($date, 'l');
                                    if ($dayName == $empOffWeekDay) {
                                        echo '<td class="cell-width" style="background: #330000; color: white">' . substr($empOffWeekDay, 0, 3) . '</td>';
                                    } else {
                                        echo '<td class="cell-width">-</td>';
                                    }
                                }
                            }
                            ?>


                        </tr>
                    </tbody>
                @endforeach
            @endisset


        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>

<script src="{{ asset('public/assets/js/jQuery.print.min.js') }}"></script>

<script>


    function ExportToExcel(type, fn, dl) {
        var elt = document.getElementById('tbl_exporttable_to_xls');
        var wb = XLSX.utils.table_to_book(elt, {
            sheet: "sheet1"
        });
        return dl ?
            XLSX.write(wb, {
                bookType: type,
                bookSST: true,
                type: 'base64'
            }) :
            XLSX.writeFile(wb, fn || ('MonthlyAttReport.' + (type || 'xlsx')));
    }
</script>
<script>
    $(document).ready(function() {

        //search
        $('#searchAttendence').keyup(function(e) {
            search_table($(this).val());
        });

        function search_table(value) {
            $('#ddd tr').each(function() {
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



        $('#printBtn').on('click', function() {
            $.print("#tbl_exporttable_to_xls");
        });

    });
</script>
