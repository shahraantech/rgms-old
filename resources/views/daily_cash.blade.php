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
    <title>CRM</title>
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
        table{
            border: 2px solid #000;
        }
        tr{
            border: 2px solid #000;
        }
        td{
            border: 2px solid #000 !important;
        }
    </style>

</head>

<body>


    <div class="container-fluid">
        <button class="btn btn-success mt-3" id="fff">Print</button>
    </div>
    <div class="container-fluid mt-4" id="printTable">
        <div class="card">
            <div class="card-body">
                <table class="table" id="printCard">
                    <div class="text-center">
                        <h4 class="font-weight-bold">The a Team</h4>
                        <h5 class="">DAILY CASH & BANK POSTION</h5>
                        <h4 class="font-weight-bold">RECEIPTS</h4>
                        <h6 class="">DATED 26 August 2022</h6>
                    </div>

                    <tr>
                        <td>Date</td>
                        <td>Particulars <br> Account Head & Detail</td>
                        <td>CASH IN <br> HAND </td>
                        <td>MEEZAN BANK <br> The A Team </td>
                        <td>Arslan Ghous <br> The A Team </td>
                        <td>TOTAL</td>
                    </tr>
                    <tr>
                        <td>26/08/2022</td>
                        <td>B/f</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>

                    <tr class="text-center">
                        <td colspan="6">
                            <h4 class="font-weight-bold mt-2 mb-0">PAYMENT</h4>
                        </td>
                    </tr>

                    <tr>
                        <td>Date</td>
                        <td>Particulars</td>
                        <td>CASH OUT</td>
                        <td>BANK</td>
                        <td></td>
                        <td>TOTAL</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="font-weight-bold">Total</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td class="font-weight-bold">Balance</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>

                    <tr>
                        <td colspan="3" class="font-weight-bold">PREPARE BY</td>
                        <td colspan="3" class="font-weight-bold">CHECKED BY</td>
                    </tr>

                    <tr class="text-center">
                        <td colspan="6">
                            <h4 class="font-weight-bold mt-2 mb-0">CASH CLOSING STATEMENT</h4>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3" class="text-center font-weight-bold">Prepaid</td>
                        <td>5000</td>
                        <td>10</td>
                        <td>#Ref</td>
                    </tr>

                    <tr>
                        <td colspan="2">Driver Mumtaz</td>
                        <td></td>
                        <td>5000</td>
                        <td>100</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td colspan="2">Driver Mumtaz</td>
                        <td></td>
                        <td>5000</td>
                        <td>10</td>
                        <td>#Ref</td>
                    </tr>

                    <tr>
                        <td colspan="2">Waseem</td>
                        <td>5870</td>
                        <td>500</td>
                        <td>10</td>
                        <td>#Ref</td>
                    </tr>

                    <tr>
                        <td colspan="2">Waseem</td>
                        <td>5870</td>
                        <td>500</td>
                        <td>10</td>
                        <td>#Ref</td>
                    </tr>
                    <tr>
                        <td colspan="2">Waseem</td>
                        <td>5870</td>
                        <td>500</td>
                        <td>10</td>
                        <td>#Ref</td>
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

            $('#fff').click(function() {
                $.print("#printTable");
            })

            //Datatables
            $('.data-table').DataTable();
        });
    </script>

    </div>
</body>

</html>
