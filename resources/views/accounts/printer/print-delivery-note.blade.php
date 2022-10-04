<!DOCTYPE html>
<html lang="en">

<head>

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
        #invoice {
            padding: 30px;
        }

        .invoice {
            position: relative;
            background-color: #FFF;
            min-height: 680px;
            padding: 15px
        }

        .invoice header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #000
        }

        .invoice .company-details {
            text-align: right
        }

        .invoice .company-details .name {
            margin-top: 0;
            margin-bottom: 0
        }

        .invoice .contacts {
            margin-bottom: 20px
        }

        .invoice .invoice-to {
            text-align: left
        }

        .invoice .invoice-to .to {
            margin-top: 0;
            margin-bottom: 0
        }

        .invoice .invoice-details {
            text-align: right
        }

        .invoice .invoice-details .invoice-id {
            margin-top: 0;
            color: #3989c6;
        }

        .invoice main {
            padding-bottom: 50px
        }

        .invoice main .thanks {
            margin-top: -100px;
            font-size: 2em;
            margin-bottom: 50px
        }

        .invoice main .notices {
            padding-left: 6px;
            border-left: 6px solid #000
        }

        .invoice main .notices .notice {
            font-size: 12px
        }

        .invoice table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px
        }

        .invoice table td,
        .invoice table th {
            padding: 8px;
            border: 1px solid #000
        }

        .invoice table th {
            white-space: nowrap;
            font-weight: bold;
            font-size: 16px
        }

        .invoice table td h3 {
            margin: 0;
            font-weight: 400;
            color: #000;
            font-size: 1.2em
        }

        .invoice table .qty,
        .invoice table .total,
        .invoice table .unit {
            text-align: right;
            font-size: 1.2em
        }

        .invoice table .no {
            color: #fff;
            font-size: 1.6em;
            color: #000;
        }

        .invoice table .unit {
            background: #ddd
        }

        .invoice table .total {
            color: #000;
            color: #000
        }

        .invoice table tbody tr:last-child td {
            /* border: none */
        }

        .invoice table tfoot td {
            background: 0 0;
            border-bottom: none;
            white-space: nowrap;
            text-align: right;
            padding: 10px 20px;
            font-size: 1.2em;
            border-top: 1px solid #aaa
        }

        .invoice table tfoot tr:first-child td {
            /* border-top: none */
        }

        .invoice table tfoot tr:last-child td {
            color: #000;
            font-size: 1.4em;
            border-top: 1px solid #000
        }

        .invoice table tfoot tr td:first-child {
            /* border: none */
        }

        .invoice footer {
            width: 100%;
            text-align: center;
            color: #777;
            border-top: 1px solid #aaa;
            padding: 8px 0
        }

        @media print {
            .invoice {
                font-size: 11px !important;
                overflow: hidden !important
            }

            .invoice footer {
                position: absolute;
                bottom: 10px;
                page-break-after: always
            }

            .invoice>div:last-child {
                page-break-before: always
            }
        }
    </style>
</head>

<body>
    <div id="printTable">

        <div class="invoice overflow-auto">
            <div style="min-width: 600px">
                <main>
                    <div class="row contacts mt-5">
                        <div class="col invoice-to">
                            <div class="text-gray-light">THE A TEAM</div>
                            <div class="address">Plaza No 3 Commercial, DHA Raya Phase 6, Lahore</div>
                            <div class="email">Phone: +92 341 333 3301</div>
                        </div>
                        <div class="col invoice-details">
                            <h3 class="invoice-id">{{$data['invType']}} INVOICE</h3>
                            <div class="date font-weight-bold">Date {{date('d-M-Y',strtotime($data['clientInfo']['date']))}}</div>
                            <div class="date font-weight-bold">INV: {{$data['clientInfo']['inv_no']}}</div>
                        </div>
                    </div>
                    <hr>
                    <div class="row contacts mt-5">
                        <div class="col invoice-to">
                            <div class="text-gray-light">Name: {{$data['clientInfo']['clientName']}}</div>
                            <div class="text-gray-light">Street Address: {{$data['clientInfo']['address']}}</div>
                            <div class="address">City, Lahore</div>
                            <div class="email">Phone: {{$data['clientInfo']['contact']}}</div>
                        </div>
                        <div class="col invoice-details">
                        </div>
                    </div>

                    <table>

                        <tbody>
                            <tr>
                                <th class="center">Sr No.</th>
                                <th class="text-center">DESCRIPTION</th>
                                <th class="text-center">CATEGORY</th>
                                <th class="text-center">SIZE</th>
                                <th class="text-center">QTY</th>
                            </tr>
                            @php $totalQty=0; @endphp
@isset($data['deliveryNotes'])
@foreach($data['deliveryNotes'] as $key=>$val)
    @php $totalQty=$totalQty+$val['qty']; @endphp
                            <tr>
                                <td class="center">{{$key+1}}</td>
                                <td class="text-center">{{$val['files']}}</td>
                                <td class="text-center">{{$val['projectName']}}</td>
                                <td class="text-center">{{$val['item']}}</td>
                                <td class="text-center">{{number_format($val['qty'],2)}}</td>

                            </tr>
@endforeach
                            @endisset

                        </tbody>

                        <tr>
                            <td colspan="4" ><strong>Total Qty:</strong></td>
                            <td class="text-center">
                                <div class="float-center"><strong>{{number_format($totalQty,2)}}</strong></div>
                            </td>


                        </tr>
                        <tr>
                            <td>Name : {{Auth::user()->name}}</td>
                            <td>Date:</td>
                            <td>Signature:</td>
                            <td>Thumb:</td>
                            <td></td>
                        </tr>
                    </table>

                </main>
            </div>

            <div></div>
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



{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            $.print("#printTable");--}}
{{--        });--}}
{{--    </script>--}}
</body>

</html>
