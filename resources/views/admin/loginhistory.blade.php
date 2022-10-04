@extends('setup.master')
@section('content')
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
    <style>
        .MultiCheckBox {
            border: 1px solid #e2e2e2;
            padding: 5px;
            border-radius: 4px;
            cursor: pointer;
        }

        .MultiCheckBox .k-icon {
            font-size: 15px;
            float: right;
            font-weight: bolder;
            margin-top: -7px;
            height: 10px;
            width: 14px;
            color: #787878;
        }

        .MultiCheckBoxDetail {
            display: none;
            position: absolute;
            border: 1px solid #e2e2e2;
            overflow-y: hidden;
        }

        .MultiCheckBoxDetailBody {
            overflow-y: scroll;
        }

        .MultiCheckBoxDetail .cont {
            clear: both;
            overflow: hidden;
            padding: 2px;
        }

        .MultiCheckBoxDetail .cont:hover {
            background-color: #cfcfcf;
        }

        .MultiCheckBoxDetailBody>div>div {
            float: left;
        }

        .MultiCheckBoxDetail>div>div:nth-child(1) {}

        .MultiCheckBoxDetailHeader {
            overflow: hidden;
            position: relative;
            height: 28px;
            background-color: #3d3d3d;
        }

        .MultiCheckBoxDetailHeader>input {
            position: absolute;
            top: 4px;
            left: 3px;
        }

        .MultiCheckBoxDetailHeader>div {
            position: absolute;
            top: 5px;
            left: 24px;
            color: #fff;
        }
    </style>
    <script>
        $(document).ready(function() {
            $("#test").CreateMultiCheckBox({
                width: '230px',
                defaultText: 'Select Below',
                height: '250px'
            });
        });
    </script>
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Login History</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"> Login History</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->


            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-hover data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Login</th>
                                <th>Location</th>
                                <th>Guard</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($log_history)
                                @foreach ($log_history as $key => $history)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $history->history->name }}</td>
                                        <td>{{ $history->check_in_time }}</td>
                                        <td>{{ $history->address }}</td>
                                        <td>{{ strtoupper($history->guard) }}</td>
                                    </tr>
                                @endforeach
                            @endisset
                            <tr>
                                <td colspan="12">
                                    <div class="float-right">
                                        {{ $log_history->links('pagination::bootstrap-4') }}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!-- /Page Content -->
    </div>

    <script>
        //Datatables
        $('#datatable').DataTable();
    </script>

@endsection
