<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords"
          content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>RGMS</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/assets/img/logo/favicon.png') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('public/assets/css/accounts-style.csss') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/font-awesome.min.css') }}">
    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/line-awesome.min.css') }}">


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">



    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/select2.min.css') }}">
    <!-- Datetimepicker CSS -->

    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap-datetimepicker.min.css') }}">
    <!-- Chart CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/morris/morris.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/table-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/ratings/rating.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/toastr.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
          integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
          crossorigin="anonymous" />

    <link rel="stylesheet" href="{{ asset('public/assets/select/bootstrap-select.css') }}">

    <style>
        table {
            border: 1px solid #000;
        }

        tr {
            border: 1px solid #000;
        }

        td {
            border: 1px solid #000 !important;
            font-weight: bold;
        }
    </style>

</head>

<body>



<div class="container-fluid mt-4" id="printTable">
    <div class="card">
        <div class="card-body">
            <table class="table" id="printCard">

                <tr>
                    <td class="text-center" colspan="5">
                        <h4>THE A TEAM</h4>
                        @php
                            $res=App\Models\Account::find($data['account_id']);
                               $headName=App\Models\Ledger::getLevelHeadName($res->level_no,$res->ac_head_id);
                        @endphp
                        <h5>{{$headName}}</h5>
                        <h6>Date:{{date('d-M-Y')}}</h6>
                    </td>
                </tr>


                <tr>
                    <td colspan="6"><h4>PAYMENTS</h4></td>
                </tr>

                <tr>
                    <td class="text-center">Date</td>
                    <td class="text-center">PARTICULARS</td>
                    <td class="text-center">A/C Head</td>
                    <td class="text-center">AMOUNT</td>
                </tr>
                @php $totalExp=0; @endphp
                @isset($data['exp'])
                @foreach($data['exp'] as $exp)
                        @php
                            $totalExp=$totalExp + $exp->amount;
                        @endphp

                <tr>
                    <td class="text-center">{{date('d-M-Y',strtotime($exp->date))}}</td>
                    <td class="text-center">{{$exp->desc}}</td>
                    <td>
                        @php
                            $headName=App\Models\Ledger::getLevelHeadName($exp->coa_level,$exp->coa_head_id);
                        @endphp
                        {{$headName}}     </td>
                    <td class="text-center">{{number_format($exp->amount,2)}}</td>
                </tr>

                    @endforeach
                @endisset
                </tbody>
                        <tr>
                            <td><div class="float-right"> <strong>Total Exp:</strong></div></td>
                            <td  colspan="3"><div class="float-right"> <strong>{{number_format($totalExp,2)}}</strong></td>
                        </tr>
                        <tr>
                            <td><div class="float-right"> <strong>CLOSING BALANCE:</strong></div></td>
                            <td  colspan="3"><div class="float-right"> <strong>{{number_format($data['balance'],2)}}</strong></td>
                        </tr>
                        <tr>
                            <td>PREPARED BY : {{Auth::user()->name}}</td>
                            <td>CHECKED BY</td>
                            <td>APPROVED BY</td>
                            <td>ACKNOWLEDGEMENT</td>
                        </tr>
            </table>
        </div>
    </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
<script src="{{ asset('public/assets/js/toastr.min.js') }}"></script>
<!-- Task JS -->
<script src="{{ asset('public/assets/js/task.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/custom-js/validations.js') }}"></script>
<!-- Bootstrap Core JS -->
<script src="{{ asset('public/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('public/assets/js/bootstrap.min.js') }}"></script>
<!-- Slimscroll JS -->
<script src="{{ asset('public/assets/js/jquery.slimscroll.min.js') }}"></script>
<!-- Select2 JS -->
<script src="{{ asset('public/assets/js/select2.min.js') }}"></script>
<!-- Datetimepicker JS -->
<script src="{{ asset('public/assets/js/moment.min.js') }}"></script>

<script src="{{ asset('public/assets/js/bootstrap-datetimepicker.min.js') }}"></script>

<!-- Datatable JS -->
<!-- <script src="{{ asset('public/assets//js/jquery.dataTables.min.js') }}"></script>
                <script src="{{ asset('public/assets//js/dataTables.bootstrap4.min.js') }}"></script> -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>



<!-- Chart JS -->
<script src="{{ asset('public/assets/plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('public/assets/js/chart.js') }}"></script>

<!-- Chart JS -->
<script src="{{ asset('public/assets/js/Chart.min.js') }}"></script>
<script src="{{ asset('public/assets/js/line-chart.js') }}"></script>
<!-- Custom JS -->
<script src="{{ asset('public/assets/js/app.js') }}"></script>
<script src="{{ asset('public/assets/js/jQuery.print.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets//ratings/rating.js') }}"></script>



<script>
    $(document).ready(function() {
        $.print("#printTable");
    });
</script>
</body>

</html>
