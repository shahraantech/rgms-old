<!DOCTYPE html>
<html lang="en">
<head>

    <title>CRM</title>

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
                    <h3>The A Team </h3>
                </div>


            </div>
            <!-- /Header -->


            <!-- Page Wrapper -->
            <div class="page-wrapper job-wrapper">

				<!-- Page Content -->
                <div class="content container">

					<!-- Page Header -->
					<div class="page-header">
						<div class="row align-items-center">
							<div class="col">
								<h3 class="page-title">Jobs</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{url('/job/list')}}">Dashboard</a></li>
									<li class="breadcrumb-item active">Jobs Portal</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->

                    <input type="hidden" name="hidden_job_id" value="{{$data['id']}}">

                    @isset($data['jobs'])
                        @foreach($data['jobs'] as $job)
					<div class="row">
						<div class="col-md-8">
							<div class="job-info job-widget">
                                <input type="hidden" name="hidden_job_id" value="{{$data['id']}}">
								<h3 class="job-title">{{$job->desig_name}}</h3>
								<span class="job-dept">{{$job->departments}}</span>
								<ul class="job-post-det">
									<li><i class="fa fa-calendar"></i> Post Date: <span class="text-blue">
                                            {{ $job->created_at->format('d M Y') }}
                                        </span></li>
									<li><i class="fa fa-calendar"></i> Last Date: <span class="text-blue">
                                            {{ date('d M Y', strtotime($job->last_date)) }}

                                            <input type="hidden" value=" {{ date('Y-m-d', strtotime($job->last_date)) }}" name="hidden_last_date">
                                        </span></li>
									<li><i class="fa fa-user-o"></i> Applications: <span class="text-blue">  @isset($data['totalApplicant']) {{$data['totalApplicant']}} @endisset</span></li>
									<li><i class="fa fa-eye"></i> Views: <span class="text-blue"> @isset($data['jobViews']) {{$data['jobViews']}} @endisset </span> </li>
								</ul>
							</div>
							<div class="job-content job-widget">
								<div class="job-desc-title"><h4>Job Description</h4></div>
								<div class="job-description">
                                    {!!  $job->desc !!}
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="job-det-info job-widget">
                                @isset($data['isApplied'])
                                    @if($data['isApplied'] > 0)

								<a class="btn applied-job-btn" disabled="true">Applied</a>
                                    @else
								<a class="btn job-btn" href="#" data-toggle="modal" data-target="#apply_job">Apply For This Job</a>
                                        @endif
                                    @endisset
								<div class="info-list">
									<span><i class="fa fa-bar-chart"></i></span>
									<h5>Job Type</h5>
									<p> {{$job->job_type}}</p>
								</div>
								<div class="info-list">
									<span><i class="fa fa-money"></i></span>
									<h5>Salary</h5>
									<p>{{$job->salary}}</p>
								</div>
								<div class="info-list">
									<span><i class="fa fa-suitcase"></i></span>
									<h5>Experience</h5>
									<p>{{$job->experience}}</p>
								</div>
								<div class="info-list">
									<span><i class="fa fa-ticket"></i></span>
									<h5>Vacancy</h5>
									<p>{{$job->vacancies}}</p>
								</div>
								<div class="info-list">
									<span><i class="fa fa-map-signs"></i></span>
									<h5>Location</h5>
									<p>
                                        {{$job->location}}
                                    </p>
								</div>

								<div class="info-list text-center">
                                    <small>Application ends in
									<a class="app-ends" href="#" id="time"> </a></small>

								</div>
							</div>
						</div>
					</div>
                        @endforeach
                    @endisset
                </div>
				<!-- /Page Content -->

				<!-- Apply Job Modal -->
				<div class="modal custom-modal fade" id="apply_job" role="dialog">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Add Your Details</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">

								<form action="{{url('apply-job')}}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate id="applyJobForm" >
                                    @csrf
									<div class="form-group">
										<label>Name</label>
                                        <input type="hidden" name="job_id" value="{{$data['id']}}">
										<input class="form-control" type="text"  name="name" required>
                                        <div class="invalid-feedback">
                                            Please enter  name.
                                        </div>
									</div>
									<div class="form-group">
										<label>Email Address</label>
										<input class="form-control" type="email" required name="email">
                                        <div id="emailId"></div>
                                        <div class="invalid-feedback">
                                            Please enter  email.
                                        </div>
									</div>
									<div class="form-group">
										<label>Phone</label>
                                        <input class="form-control" type="number" required name="phone">  <div class="invalid-feedback">
                                            Please enter  phone.
                                        </div>
									</div>
									<div class="form-group">
										<label>Upload your CV</label>
										<div class="custom-file">
											<input type="file" class="custom-file-input"  required name="file">
											<label class="custom-file-label" for="cv_upload">Choose file</label>
                                            <div class="invalid-feedback">
                                                Please choose  your cv in pdf format.
                                            </div>
										</div>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn" type="submit">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Apply Job Modal -->

            </div>
			<!-- /Page Wrapper -->

        </div>
		<!-- /Main Wrapper -->



<!-- jQuery -->


        <script type="text/javascript" src="{{asset('public/assets/js/custom-js/validations.js')}}"></script>
        <script src="{{asset('public/assets/js/toastr.min.js')}}"></script>

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

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>


<script>
    $(document).ready(function(){


        countDownFunction();
        $('input[name=email]').change(function(){
            var email=$('input[name=email]').val();
            var id=$('input[name=hidden_job_id]').val();


            $.ajax({

                url: '{{url("/check-job-applied")}}',
                type: 'get',
                async: false,
                dataType: 'json',
                data:{email:email,id:id},
                success: function(data)
                {

           if(data==1){
               var p='<span style="color:red">already applied</span>';
               $('#emailId').html(p);
               $(".submit-btn").attr('disabled', true);
           }else{
               $(".submit-btn").attr('disabled', false);
               $('#emailId').hide();
           }


                },
                error:function()
                {
                    //toastr.error('something went wrong');
                }

            });



        });
        function countDownFunction(){

            var lastDate=$('input[name=hidden_last_date]').val();

            var lastdateTime='23:59:59';
            var dateNow=lastDate;
            var today=dateNow+' '+lastdateTime;

            var myTime=new Date(today);
            // var myTime=new Date("2021-12-24,18:00:00");

            var countDownDate = new Date(myTime).getTime();

            // Update the count down every 1 second
            var x = setInterval(function() {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);


                document.getElementById("time").innerHTML = days + "d " + hours + "h "
                    + minutes + "m " + seconds + "s ";

                // If the count down is over, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("time").innerHTML = "EXPIRED";
                    $(".job-btn").prop("disabled", true);
                }
            }, 1000);
        }




    })
</script>
<script type="text/javascript">

    @if(count($errors) > 0)
    @foreach($errors->all() as $error)

    toastr.error("{{ $error }}");
    @endforeach
    @endif


    @if(Session::has('success'))
    toastr.success("You have applied successfully");

    @endif


</script>



