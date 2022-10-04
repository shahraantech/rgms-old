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
                            <h3 class="page-title bold-heading">Leads Response Report</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Leads Response Report</li>
                            </ul>
                        </div>

                    </div>
                </div>


                <!-- Search Filter -->
                <div class="card">
                    <div class="card-body">

                        <div class="col-md-3">
                            <input type="text" class="form-control date_range" name="leads_date_range" />

                        </div>
                    </div>
                </div>
                <!-- Search Filter -->
                <div class="card">
                    <div class="card-body">

                        <table class="table table-striped table-hover data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Lead ID</th>
                                    <th>CSR</th>
                                    <th>Created At</th>
                                    <th>Assigned At</th>
                                    <th>Responded At</th>
                                    <th>Interval</th>
                                </tr>
                            </thead>
                            <tbody id="responseLeads">

                                @php $c=0; @endphp
                                @isset($data['lastWeekLeads'])
                                    @foreach ($data['lastWeekLeads'] as $lead)
                                        @php
                                            $assign = \App\Models\AssignedLeads::where('lead_id', $lead->id)->first();
                                            $approach = \App\Models\ApprochedLeads::where('lead_id', $lead->id)->first();
                                            $assign ? ($assign_at = $assign->created_at) : ($assign_at = '-');
                                            $approach ? ($approach_at = $approach->created_at) : ($approach_at = '-');
                                            $c++;
                                            if ($approach_at != '-') {
                                                $interval = '';
                                                $tz = new DateTimeZone('UTC');
                                                $dt1 = new DateTime($lead->created_at, $tz);
                                                $dt2 = new DateTime($approach_at, $tz);
                                                $year = $dt1->diff($dt2)->format('%r%y');
                                                $month = $dt1->diff($dt2)->format('%m');
                                                $days = $dt1->diff($dt2)->format('%d');
                                                $time = $dt1->diff($dt2)->format('%h hours, %i minutes, %s seconds');
                                            
                                                $year > 0 ? ($interval = $interval . '' . $year . ' ' . 'Year') : '';
                                                $month > 0 ? ($interval = $interval . ' ' . $month . ' ' . 'Month') : '';
                                                $days > 0 ? ($interval = $interval . ' ' . $days . ' ' . 'Days') : '';
                                                $interval = $interval . ' ' . $time;
                                            } else {
                                                $interval = '-';
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $c }}</td>

                                            <td>{{ $lead->id }}</td>


                                            <td>
                                                @php
                                                    $emp='';
                                                    if ($assign) {
                                                        $emp = App\Models\User::where('account_id', $assign->agent_id)
                                                            ->select('name')
                                                            ->first();
                                                    }
                                                    
                                                    if ($emp) {
                                                        echo '<span class="badge bg-inverse-success">' . $emp->name . '</span>';
                                                    } else {
                                                        echo '<span class="badge bg-inverse-danger">Open</span>';
                                                    }
                                                    
                                                @endphp</td>
                                            <td>{{ $lead->created_at }}</td>
                                            <td>{{ $assign_at }}</td>
                                            <td>{{ $approach_at }}</td>
                                            <td>
                                                <span class="badge bg-inverse-danger"> {{ $interval }}</span>
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
    </div>



    <script>
        $(document).ready(function() {

            $('.date_range').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                    .format('YYYY-MM-DD'));
            });


            $('input[name=leads_date_range]').change(function() {
                var leads_date_range = $('input[name=leads_date_range]').val();



                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('get_responsed_leads') }}',
                    data: {
                        leads_date_range: leads_date_range
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        $('#responseLeads').html(data);
                    },
                    error: function() {
                        toastr.error('something went wrong');

                    },
                });

            });


        });
    </script>
@endsection
