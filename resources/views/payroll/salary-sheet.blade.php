@extends('setup.master')

@section('content')

    <div class="page-wrapper" id="body">
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
                font-size: 10px;
            }

            #table-scroll {
                overflow: auto;
            }

            .salary {
                background-color: #000;
                padding: 10px 10px;
            }
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">

                    <div class="col-auto float-left mr-auto">
                        <form action="{{ url('salary-sheet') }}" method="post" id="salarySheetForm">
                            @csrf
                            <div class="row" style="display: flex">

                                <div class="col-md-3">
                                    <div class="form-group">

                                        <select name="company_id" class="form-control selectpicker" data-container="body"
                                            data-live-search="true" title="Choose Company">

                                            @isset($data)
                                                @foreach ($data['companies'] as $company)
                                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
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
                                            <option value="9">September</option>
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
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-top:1px">
                                        <button type="submit" class="btn btn-primary sheet_search"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                    <div class="col-auto float-right ml-auto">
                        <div class="btn-group btn-group-sm">
                            <button type="submit" class="btn btn-white" id="printBtn"><i class="fa fa-print fa-lg"></i>
                                Print</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="table-scroll">
                        <table class="table table-bordered mt-3" id="tablePrint">
                            <thead>
                                <tr>
                                    <th colspan="16">
                                        <h5 class="text-white mt-2 salary">SALARY SHEET OF
                                            {{ empty($data['company_name']) ? '' : strtoupper($data['company_name']) }}
                                            STAFF
                                            FOR THE MONTH OF {{ date('M Y') }}</h5>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        @php
                                            $month = $data['month'];
                                            $year = $data['year'];
                                        @endphp
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sr.</td>
                                    <td>Name</td>
                                    <td>Designation</td>
                                    <td>Salary</td>
                                    <td>Days Working</td>
                                    <td>Working Days Salary</td>
                                    <td>Mobile Allowance</td>
                                    <td>Sales Commision</td>
                                    <td>Total Salary</td>
                                    <td>Tax Deduction</td>
                                    <td>Eobi Deduction</td>
                                    <td>Loan Deduction</td>
                                    <td>Net Salary</td>
                                    <td>Bank Account No.</td>
                                    {{-- <td>Total Salary</td> --}}
                                    <td colspan="5">Remarks</td>
                                </tr>

                                @isset($data['depts'])
                                    @foreach ($data['depts'] as $dept)
                                        @php
                                            $subTotal = 0;
                                            $emp = getEmployeesAcordingDept($dept->id);
                                            $c = 0;
                                        @endphp


                                        <tr>
                                            <td colspan="16" class="font-weight-bold text-center">{{ $dept->departments }}
                                            </td>
                                        </tr>
                                        @foreach ($emp as $emp)
                                            @php
                                                $c++;
                                                
                                            @endphp


                                            <?php
                                            $attendace1 = App\Models\Attendance::where('emp_id', $emp->id)
                                                ->where('status', '1')
                                                ->where('attendance_month', $month)
                                                ->count();
                                            $attendace2 = App\Models\Attendance::where('emp_id', $emp->id)
                                                ->where('status', '2')
                                                ->where('attendance_month', $month)
                                                ->count();
                                            
                                            $attendace = App\Models\Attendance::where('emp_id', $emp->id)
                                                ->where('status', '3')
                                                ->where('attendance_month', $month)
                                                ->count();
                                            
                                            $weekly = $month . '-' . $data['year'];
                                            
                                            $totalSundaysOfThisMonth = getNumberOfDays(1, $date = $weekly, $NameOfDay = 'sunday');
                                            
                                            //
                                            //  echo $total_work_days;
                                            //  echo  'total_work_days'.$total_work_days;
                                            $total_work_days = $attendace + $attendace2 + $attendace1;
                                            
                                            $salary = $emp->gross_salary / 30;
                                            //  echo 'sel'.$salary;
                                            //    $dasy=\Carbon\Carbon::createFromFormat('Y-m-d',$month)->format('d-m-Y');
                                            //  echo 'days'.$month;
                                            $emp_created = $emp->created_at;
                                            $d = new DateTime('first day of this month');
                                            // echo $emp_created->format('jS, F Y');
                                            $total_salary = (int) $salary * (int) $total_work_days;
                                            $newonee = App\Models\Attendance::where('attendance_date', '>=', '1')
                                                ->where('attendance_date', '<=', '31')
                                                ->where('emp_id', $emp->id)
                                                ->where('attendance_month', $month)
                                                ->get();
                                            
                                            // echo  'Name '.$emp->name.'dayof month'.$totalSundaysOfThisMonth.' Total works days'.$total_work_days.' Total_salry'.$total_salary."<br>";
                                            
                                            // echo  $emp->name;
                                            
                                            ?>


                                            <tr>
                                                <td>{{ $c }}</td>
                                                <td>{{ $emp->name }}</td>
                                                <td>{{ $emp->getDesignation['desig_name'] }}</td>
                                                <td>{{ $emp->gross_salary }}</td>
                                                <td>30</td>


                                                @php
                                                    $month = $data['month'];
                                                    $year = $data['year'];
                                                @endphp


                                                <td>
                                                    @php
                                                        $empSal = countEmpSalaryForViews($emp_id = $emp->id, $month = $month, $year = date('Y'));
                                                        $subTotal = $subTotal + $empSal['netSal'];
                                                    @endphp
                                                    <?php
                                                    $count1 = 0;
                                                    $count2 = 0;
                                                    $count3 = 0;
                                                    $count4 = 0;
                                                    $count5 = 0;
                                                    
                                                    ?>
                                                    <?php
                                                    
                                                    $days = getSundays(2022, $month);
                                                    print_r($days);
                                                    
                                                    ?>
                                                    @foreach ($newonee as $value)
                                                        <?php
                                                        $sdfnewonedata = $value->attendance_date . '<br>';
                                                        //    echo $days[0].$days[1].$days[2].$days[3].$days[4];
                                                        ?>

                                                        @if ($sdfnewonedata >= 1 && $sdfnewonedata <= $days[0])
                                                            <?php $count1 = 1; ?>
                                                        @endif

                                                        @if ($sdfnewonedata >= $days[0] && $sdfnewonedata <= $days[1])
                                                            <?php $count2 = 1; ?>
                                                        @endif

                                                        @if ($sdfnewonedata >= $days[1] && $sdfnewonedata <= $days[2])
                                                            <?php $count3 = 1; ?>
                                                        @endif



                                                        @if ($sdfnewonedata >= $days[2] && $sdfnewonedata <= $days[3])
                                                            <?php $count4 = 1; ?>
                                                        @endif

                                                        @if ($sdfnewonedata <= $days[3] && $sdfnewonedata <= $days[4])
                                                            <?php $count5 = 1; ?>
                                                        @endif
                                                    @endforeach

                                                    {{ $total_work_days + $count1 + $count2 + $count3 + $count4 + $count5 }}

                                                </td>
                                                <td> {{ $empSal['allowance'] }}</td>
                                                <td>-</td>
                                                <td> {{ $empSal['netSal'] }}</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>

                                                <td>
                                                    @if (isset($daysm))
                                                        <?php echo $daysm; ?>
                                                        @foreach ($newonee as $value)
                                                            <?php echo $value->attendance_date; ?>
                                                        @endforeach
                                                        @if ($daysm >= 15 && $daysm <= 30)
                                                            @php
                                                                $salarynew = $emp->gross_salary / 30;
                                                                $total_work_daysn = (int) (4 * $salarynew);
                                                                
                                                                $total_salary_new = (int) $salary * (int) $total_work_days + $total_work_daysn;
                                                            @endphp
                                                            {{ $total_salary_new }}
                                                        @else
                                                            @php
                                                                
                                                                $salarynew = $emp->gross_salary / 30;
                                                                $total_work_daysn = (int) (2 * $salarynew);
                                                                $total_salary_new = (int) $salary * (int) $total_work_days + 2;
                                                            @endphp
                                                            {{ $total_salary_new }}
                                                        @endif
                                                    @endif

                                                </td>
                                                <td>{{ $emp->bank_ac_no }}</td>
                                                {{-- <td> {{ $total_salary }}</td> --}}
                                                <td colspan="5"></td>

                                            </tr>
                                        @endforeach


                                        <tr>
                                            <td>
                                                <div class="float-right"> <strong>Sub Total:</strong></div>
                                            </td>
                                            <td colspan="14">
                                                <div class="float-right"> <strong>{{ $subTotal }}</strong></div>
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
        <script>
            $(document).ready(function() {

                $('#printBtn').on('click', function() {
                    $.print("#tablePrint");
                });


                $('.sheet_search').on('click', function() {
                    $(".sheet_search").prop("disabled", true);
                    $(".sheet_search").html("Searching...");
                    $('#salarySheetForm').submit();
                });

            });
        </script>
    @endsection
