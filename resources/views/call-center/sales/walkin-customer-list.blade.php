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
                        <h3 class="page-title bold-heading">Customer List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Customer List</li>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="card">


                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Name</td>
                                <td>Email</td>
                                <td>Cnic</td>
                                <td>Contact</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $key => $client)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->cnic }}</td>
                                <td>{{ $client->contact }}</td>
                                <td class="text-center">
                                    <a href="{{ url('client_detail/'.$client->id) }}"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <!-- /Page Content -->
    </div>




    <script>
        $('.btn-submit').on('click', function() {
            $(".btn-submit").prop("disabled", true);
            $(".btn-submit").html("Please wait...");
            $('#CustomerForm').submit();
        });
    </script>
@endsection
