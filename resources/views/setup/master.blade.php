<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>RGMS</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/assets/img/logo/fav.png')}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('public/assets/css/accounts-style.css') }}">
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
    <!-- Calendar CSS -->
    {{-- <link rel="stylesheet" href="{{asset('public/assets/css/fullcalendar.min.css')}}"> --}}


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>

    <div class="main-wrapper">

        @yield('content')
       {{-- Loader --}}

			<div id="loader-wrapper">
				<div id="loader">
					<div class="loader-ellips">
					  <span class="loader-ellips__dot"></span>
					  <span class="loader-ellips__dot"></span>
					  <span class="loader-ellips__dot"></span>
					  <span class="loader-ellips__dot"></span>
					</div>
				</div>
			</div>
			{{-- Loader --}}
        @include('setup.header')
        @include('setup.sidebar')

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
        <script src="{{ asset('public/assets/js/recorder.js') }}"></script>
        <script src="{{ asset('public/assets/js/jQuery.print.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets//ratings/rating.js') }}"></script>

        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css"
            href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <!-- Calendar JS -->
        <script src="{{asset('public/assets/js/moment.min.js')}}"></script>
        <script src="{{asset('public/assets/js/jquery-ui.min.js')}}"></script>
        {{-- <script src="{{asset('public/assets/js/fullcalendar.min.js')}}"></script>
        <script src="{{asset('public/assets/js/jquery.fullcalendar.js')}}"></script> --}}

        <script>
            $(document).ready(function() {

                //Datatables
                $('.data-table').DataTable();
                //date range
                $('.date_range').daterangepicker({
                    opens: 'left'
                }, function(start, end, label) {
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                        .format('YYYY-MM-DD'));
                });
            });
        </script>


    </div>
</body>

</html>
