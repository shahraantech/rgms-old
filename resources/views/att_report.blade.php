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
        .name {
            padding: 27px 7px;
            font-weight: bold;
            font-size: 11px;
        }

        .dep {
            padding: 4px 43px;
        }

        .dep1 {
            padding: 4px 43px;
            background-color: #000;
            color: #fff;
            -webkit-print-color-adjust: exact;
        }

        .mm {
            text-align: center;
            padding: 20px 1px;
            font-weight: bold;
            font-size: 12px;
        }

        .tablediv {
            border: 1px solid #000;
        }

        .daily {
            background-color: #000;
            width: 100%;
            color: #fff;
            padding: 10px 0px;
            -webkit-print-color-adjust: exact;
        }
    </style>

</head>

<body>


    <div class="container-fluid">
        <button class="btn btn-success mt-3" id="fff">Print</button>
    </div>
    <div class="container-fluid mt-4" id="printTable">
        <div class="text-center">
            <h4 class="daily">Daily Attendence Sheet</h3>
        </div>
        <table class="tablediv">
            <tr>
                <td>#SR</td>
                <td class="name">Name</td>
                <td class="mm">1 Mar</td>
                <td class="mm">2 Mar</td>
                <td class="mm">3 Mar</td>
                <td class="mm">4 Mar</td>
                <td class="mm">5 Mar</td>
                <td class="mm">6 Mar</td>
                <td class="mm">7 Mar</td>
                <td class="mm">8 Mar</td>
                <td class="mm">9 Mar</td>
                <td class="mm">10 Mar</td>
                <td class="mm">11 Mar</td>
                <td class="mm">12 Mar</td>
                <td class="mm">13 Mar</td>
                <td class="mm">14 Mar</td>
                <td class="mm">15 Mar</td>
                <td class="mm">16 Mar</td>
                <td class="mm">17 Mar</td>
                <td class="mm">18 Mar</td>
                <td class="mm">19 Mar</td>
                <td class="mm">20 Mar</td>
                <td class="mm">21 Mar</td>
                <td class="mm">22 Mar</td>
                <td class="mm">23 Mar</td>
                <td class="mm">24 Mar</td>
                <td class="mm">25 Mar</td>
                <td class="mm">26 Mar</td>
                <td class="mm">27 Mar</td>
                <td class="mm">28 Mar</td>
                <td class="mm">29 Mar</td>
                <td class="mm">30 Mar</td>
                <td class="mm">31 Mar</td>
            </tr>
            <tr>
                <td class="dep1" colspan="17">
                    <h4 class="mt-2">THE A TEAM</h4>
                </td>
                <td colspan="4">NM=Not Marked</td>
                <td colspan="4">L=Leave& A=Absent</td>
                <td colspan="4">SL# Short Leave</td>
                <td colspan="5">HDL=Half Day Leave</td>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td class="name">Tanveer Khan Alpha Buzz</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
            </tr>
            <tr>
                <td></td>
                <td class="dep" colspan="15">
                    <h4 class="mt-2">Hr Department</h4>
                </td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td class="name">Tanveer Khan</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
            </tr>
            <tr>
                <td></td>
                <td class="dep" colspan="15">
                    <h4 class="mt-2">Admin & Security Department</h4>
                </td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td class="name">Zaeem Asif</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
            </tr>
            <tr>
                <td></td>
                <td class="dep" colspan="15">
                    <h4 class="mt-2">Sales Department</h4>
                </td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td class="name">Zaeem Asif</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td class="name">Zaeem Asif</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td class="name">Zaeem Asif</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td class="name">Zaeem Asif</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
            </tr>
            <tr>
                <td></td>
                <td class="dep" colspan="15">
                    <h4 class="mt-2">Quality Asurance Department</h4>
                </td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td class="name">Zaeem Asif</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
            </tr>
            <tr>
                <td></td>
                <td class="dep" colspan="15">
                    <h4 class="mt-2">It Department</h4>
                </td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td class="name">Zaeem Asif</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
            </tr>
            <tr>
                <td></td>
                <td class="dep" colspan="15">
                    <h4 class="mt-2">Accounts Department</h4>
                </td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td class="name">Zaeem Asif</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
            </tr>
            <tr>
                <td></td>
                <td class="dep" colspan="15">
                    <h4 class="mt-2">Internal Audit & Complaince Department</h4>
                </td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
                <td class="mm"></td>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td class="name">Zaeem Asif</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
                <td class="mm">12:20</td>
            </tr>
        </table>
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
