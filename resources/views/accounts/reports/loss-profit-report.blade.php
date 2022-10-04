@extends('setup.master')

@section('content')

<div class="page-wrapper">

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

        table .total{
            background-color: #c4c4c2;
            color: #000;
        }

        table .profit{
            background-color: #09942a;
            color: #fff;
        }
    </style>

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header my-header">
            <div class="row align-items-center text-center">
                <div class="col">
                    <h4 class="page-title bold-heading">Statement of Comprehensive Icome</h4>
                    <h5 class="mt-3">{{date('01-M-Y')}} &nbsp; {{date('d-M-Y')}}</h5>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered mt-5">
                <tr class="total">
                        <td>
                            <h5 class="text-center">Particulars</h5>
                        </td>
                        <td>
                            <h5 class="float-right">Amount</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Income</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Product Sales (Invoice Wise)</h5>
                        </td>
                        <td>
                            <h5 class="float-right">{{ number_format($data['sale'],2)}}</h5>
                        </td>
                    </tr>
                    <tr class="total">
                        <td><h5 class="float-right ">Total Income</h5></td>
                        <td>
                            <h5 class="float-right">{{ number_format($data['sale'],2)}}</h5>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <h5>Expense</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5>Product Purchasing Costs (Invoice Wise)</h5>
                        </td>
                        <td>
                            <h5 class="float-right">{{ number_format($data['purchase'],2)}}</h5>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <h5>Office Expense</h5>
                        </td>
                        <td>
                            <h5 class="float-right">{{number_format($data['exp'],2)}}</h5>
                        </td>
                    </tr>


                    <tr class="total">
                        <td><h5 class="float-right ">Total Expense</h5></td>
                        <td>
                            <h5 class="float-right">{{ number_format($data['purchase'],2)}}</h5>
                        </td>
                    </tr>

                    <tr class="profit">
                        <td><h4 class="float-right">Income - Expense = Profit</h4></td>
                        <td>
                            <h5 class="float-right">{{ number_format($data['sale'] - $data['purchase'],2) }}</h5>
                        </td>
                    </tr>

                </table>
            </div>
        </div>

    </div>

    @endsection
