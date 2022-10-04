

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
            <div class="page-wrapper">
                <!-- Page Content -->
                <div class="content container-fluid">
                    <div class="page-header my-header">
                        <div class="row align-items-center">

                            <div class="col">
                                <h3 class="page-title bold-heading">Balance Sheet Report</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Balance Sheet Report Profit</li>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-body">

                            @if(!empty($data['coa']))
                            <table class="table table-striped table-hover" id="datatable">
                                <thead>
                                <tr class="bold-tr">
                                    <th>#</th>
                                    <th>Head</th>
                                    <th>Balance</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody id="profileReportTable">
                                @isset($data['coa'])
                                    @foreach ($data['coa'] as $key => $coa)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $coa['coa_head'] }}</td>
                                            <td>{{ $coa['coa_balance'] }}</td>

                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if($coa['coa_level']!=6)
                                                        <a class="dropdown-item btn_edit_expense_head" href="{{url('balance-sheet').'/'.$coa['coa_head_id'].'/'.$coa['coa_level']}}"><i class="fa fa-pencil m-r-5n "></i>Detail</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                @endisset
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
@endsection

