

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
                        <h3 class="page-title bold-heading">Expense Head List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Expense Head List</li>
                        </ul>
                    </div>


                    <div class="col-auto float-right ml-auto">
                        <a href="{{url('/expense-head')}}" class="btn add-btn" title="Add Expense Head"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-body">



                    <table class="table table-striped">
                        <tr>
                            <th>SR#</th>
                            <th> Name</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>

                        <tbody>

                        <tr>
                            <td>1</td>
                            <td>Expense Account</td>
                            <td>Testing description</td>
                            <td>02-02-2022</td>

                        </tr>

                        <tr>
                            <td>1</td>
                            <td>Expense Account</td>
                            <td>Testing description</td>
                            <td>02-02-2022</td>

                        </tr>



                        </tbody>

                    </table>
                </div>
            </div>

            <!-- /Page Content -->
        </div>



        @endsection


