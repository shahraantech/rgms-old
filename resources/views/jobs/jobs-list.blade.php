<!DOCTYPE html>
<html lang="en">
<head>

    <title>CRM</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('public/assets/img/logo/favicon.png')}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('public/assets/css/bootstrap.min.css')}}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{asset('public/assets/css/font-awesome.min.css')}}">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="{{asset('public/assets/css/line-awesome.min.css')}}">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{asset('public/assets/css/dataTables.bootstrap4.min.css')}}">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{asset('public/assets/css/select2.min.css')}}">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{asset('public/assets/css/bootstrap-datetimepicker.min.css')}}">

    <!-- Chart CSS -->
    <link rel="stylesheet" href="{{asset('public/assets/plugins/morris/morris.css')}}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('public/assets/css/style.css')}}">

    <script src="{{asset('public/assets/js/toastr.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/toastr.css')}}">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
			<script src="{{asset('public/assets/js/html5shiv.min.js')}}"></script>
			<script src="{{asset('public/assets/js/respond.min.js')}}"></script>
		<![endif]-->
</head>

<body>



    <!-- Main Wrapper -->
<div class="main-wrapper">

    <!-- Header -->
    <div class="header">
        <!-- Logo -->
        <div class="header-left">
        </div>
        <!-- /Logo -->

        <!-- Header Title -->
        <div class="page-title-box float-left">
            <h3>RGMD</h3>
        </div>


    </div>
    <!-- /Header -->

    <!-- Page Wrapper -->
    <div class="page-wrapper job-wrapper">

        <!-- Page Content -->
        <div class="content container">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Jobs</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/job/list')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Jobs Portal</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
@isset($data['jobs'])
    @foreach($data['jobs'] as $job)
                <div class="col-md-6">
                    <a class="job-list" href="{{url('job/view/'.encrypt($job->id))}}">
                        <div class="job-list-det">
                            <div class="job-list-desc">
                                <h3 class="job-list-title">{{$job->desig_name}}</h3>
                                <h4 class="job-department">{{$job->departments}}</h4>
                            </div>
                            <div class="job-type-info">
                                <span class="job-types">{{$job->job_type}}</span>
                            </div>
                        </div>
                        <div class="job-list-footer">
                            <ul>
                                <li><i class="fa fa-location-arrow"></i> {{$job->location}}</li>
                                <li><i class="fa fa-money"></i> PKR {{$job->salary}}</li>
                                <li><i class="fa fa-clock-o"></i>
                                <?php
                                    $date1 = date($job->created_at);
                                    echo $date2 =  date('d M Y',strtotime($date1));
                                    ?>
                                </li>
                            </ul>
                        </div>
                    </a>
                </div>
                    @endforeach
                @endisset
            </div>
        </div>

    </div>
    <!-- /Page Wrapper -->

</div>
<!-- /Main Wrapper -->





<!-- jQuery -->

<script src="{{asset('public/assets/js/jquery-3.5.1.min.js')}}"></script>

<!-- Bootstrap Core JS -->
<script src="{{asset('public/assets/js/popper.min.js')}}"></script>
<script src="{{asset('public/assets/js/bootstrap.min.js')}}"></script>

<!-- Slimscroll JS -->
<script src="{{asset('public/assets/js/jquery.slimscroll.min.js')}}"></script>

<!-- Select2 JS -->
<script src="{{asset('public/assets/js/select2.min.js')}}"></script>

<!-- Datetimepicker JS -->
<script src="{{asset('public/assets/js/moment.min.js')}}"></script>
<script src="{{asset('public/assets/js/bootstrap-datetimepicker.min.js')}}'"></script>

<!-- Datatable JS -->
<script src="{{asset('public/assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/assets/js/dataTables.bootstrap4.min.js')}}'"></script>

<!-- Chart JS -->
<script src="{{asset('public/assets/plugins/morris/morris.min.js')}}"></script>
<script src="{{asset('public/assets/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('public/assets/js/chart.js')}}"></script>

<!-- Custom JS -->
<script src="{{asset('public/assets/js/app.js')}}"></script>

</body>
</html>

