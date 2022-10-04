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
    <title>SADAT</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/assets/img/logo/favicon.jpeg') }}">
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        /* table .level_1 {
            border-right: 1px solid grey !important;
        }

        table #ff {
            border-top: 1px solid grey !important;
        } */

        .navbar .dropdown-toggle,
        .navbar .dropdown-menu a {
            cursor: pointer;
        }

        .navbar .dropdown-item.active,
        .navbar .dropdown-item:active {
            color: inherit;
            text-decoration: none;
            background-color: inherit;
        }

        .navbar .dropdown-item:focus,
        .navbar .dropdown-item:hover {
            color: #16181b;
            text-decoration: none;
            background-color: #f8f9fa;
        }

        @media (min-width: 767px) {
            .navbar .dropdown-toggle:not(.nav-link)::after {
                display: inline-block;
                width: 0;
                height: 0;
                margin-left: .5em;
                vertical-align: 0;
                border-bottom: .3em solid transparent;
                border-top: .3em solid transparent;
                border-left: .3em solid;
            }
        }
    </style>

</head>

<body>


<!-- Page Content -->
<div class="content container-fluid mt-5">
    <!-- /Page Header -->
    <div class="card">
        <div class="card-body">

            <div class="navbar navbar-expand-md navbar-light bg-light mb-4" role="navigation">
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" id="dropdown1" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">Dropdown1</a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown1">
                                <li class="dropdown-item" href="#"><a>Action 1</a></li>
                                <li class="dropdown-item" href="#"><a>Action 2</a></li>
                                <li class="dropdown-item" href="#"><a>Action 3</a></li>
                                <li class="dropdown-item dropdown">
                                    <a class="dropdown-toggle" id="dropdown1-1" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">Dropdown1.1</a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdown1-1">
                                        <li class="dropdown-item" href="#"><a>Action 1</a></li>
                                        <li class="dropdown-item" href="#"><a>Action 2</a></li>
                                        <li class="dropdown-item" href="#"><a>Action 3</a></li>
                                        <li class="dropdown-item dropdown">
                                            <a class="dropdown-toggle" id="dropdown1-1-1" data-toggle="dropdown"
                                               aria-haspopup="true" aria-expanded="false">Dropdown1.1.1</a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdown1-1-1">
                                                <li class="dropdown-item" href="#"><a>Action 1</a></li>
                                                <li class="dropdown-item" href="#"><a>Action 2</a></li>
                                                <li class="dropdown-item" href="#"><a>Action 3</a></li>
                                                <li class="dropdown-item dropdown">
                                                    <a class="dropdown-toggle" id="dropdown1-1-1"
                                                       data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false">Dropdown1.1.1</a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdown1-1-1">
                                                        <li class="dropdown-item" href="#"><a>Action 1</a>
                                                        </li>
                                                        <li class="dropdown-item" href="#"><a>Action 2</a>
                                                        </li>
                                                        <li class="dropdown-item" href="#"><a>Action 3</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- <table class="table mt-5">
                <tbody>
                    <tr style="border: none;">
                        <td style="border: none;" class="level_1">Level 1</td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" ></td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none;" class="level_1"></td>
                        <td  style="border: none;" class="level_1">from Level 1</td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;"></td>
                    <tr style="border: none;">
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td  style="border: none;" class="level_1">from first 1</td>
                    <tr>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;">first 1</td>
                    </tr>

                    <tr style="border: none;">
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;">first 1</td>
                    </tr>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1">from first 1</td>
                    <tr style="border: none;">
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;">second 1</td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;">second 1</td>
                    </tr>
                    </tr>
                    <td style="border: none;" class="level_1"></td>
                    <td style="border: none;" class="level_1" id="ff">from Level 1</td>
                    <td style="border: none;" class="level_1"></td>
                    <td style="border: none;"></td>
                    <tr style="border: none;">
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1" id="ff">from second 1</td>
                    <tr style="border: none;">
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;">second 1</td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;">second 1</td>
                    </tr>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1">from second 1</td>
                    <tr style="border: none;">
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;">second 1</td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;" class="level_1"></td>
                        <td style="border: none;">second 1</td>
                    </tr>
                    </tr>
                    </tr>
                </tbody>
            </table> --}}
        </div>
    </div>
    <!-- /Page Content -->
</div>



<!-- jQuery -->



<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
<script src="{{ asset('public/assets/js/toastr.min.js') }}"></script>
<!-- Task JS -->
<script src="{{ asset('public/assets/js/task.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/custom-js/validations.js') }}"></script>
<!--
      <script src="{{ asset('public/assets/js/jquery-3.5.1.min.js') }}"></script>
      -->
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

        $('.navbar .dropdown-item').on('click', function(e) {
            var $el = $(this).children('.dropdown-toggle');
            var $parent = $el.offsetParent(".dropdown-menu");
            $(this).parent("li").toggleClass('open');

            if (!$parent.parent().hasClass('navbar-nav')) {
                if ($parent.hasClass('show')) {
                    $parent.removeClass('show');
                    $el.next().removeClass('show');
                    $el.next().css({
                        "top": -999,
                        "left": -999
                    });
                } else {
                    $parent.parent().find('.show').removeClass('show');
                    $parent.addClass('show');
                    $el.next().addClass('show');
                    $el.next().css({
                        "top": $el[0].offsetTop,
                        "left": $parent.outerWidth() - 4
                    });
                }
                e.preventDefault();
                e.stopPropagation();
            }
        });

        $('.navbar .dropdown').on('hidden.bs.dropdown', function() {
            $(this).find('li.dropdown').removeClass('show open');
            $(this).find('ul.dropdown-menu').removeClass('show open');
        });

    });
</script>

</body>

</html>
