

@extends('setup.master')

@section('content')

<style>
	.att-btn{
            width: 72%;
        }
</style>

			<!-- Page Wrapper --><div class="page-wrapper">

				<!-- Page Content -->
                <div class="content container-fluid">

					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Attendance Dashboard</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{url('att-dashboard')}}">Dashboard</a></li>
									<li class="breadcrumb-item" a>Attendance</li>

								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->

					<!-- Content Starts -->
					<div class="card">
						<div class="card-body">
							<!-- <h4 class="card-title">Solid justified</h4> -->
							<ul class="nav nav-tabs nav-tabs-solid nav-justified">
								<li class="nav-item"><a class="nav-link active" href="{{url('att-dashboard')}}">Dashboard</a></li>

								<li class="nav-item att-btn"><a class="nav-link" href="{{url('attendance')}}">Mark Attendance</a></li>
								<li class="nav-item att-btn"><a class="nav-link" href="{{url('view-attendance')}}">View Attendance</a></li>
								<li class="nav-item att-btn"><a class="nav-link" href="{{url('attendance-reports')}}">Attendance Reports</a></li>

							</ul>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
							<div class="card dash-widget">
								<div class="card-body">
									<span class="dash-widget-icon"><i class="fa fa-users"></i></span>
									<div class="dash-widget-info">
										<h3 id="totalStaff"></h3>
										<span>Staff</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
							<div class="card dash-widget">
								<div class="card-body">
									<span class="dash-widget-icon"><i class="fa fa-users"></i></span>
									<div class="dash-widget-info">
										<h3 id="presentStaff"></h3>
										<span>Present</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
							<div class="card dash-widget">
								<div class="card-body">
									<span class="dash-widget-icon"><i class="fa fa-users"></i></span>
									<div class="dash-widget-info">
										<h3 id="absentStaff"></h3>
										<span>Absent</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
							<div class="card dash-widget">
								<div class="card-body">
									<span class="dash-widget-icon"><i class="fa fa-users"></i></span>
									<div class="dash-widget-info">
										<h3 id="leaves"></h3>
										<span>On Leave</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-6 text-center d-flex">
									<div class="card flex-fill">
										<div class="card-body">
											<h3 class="card-title">Overview</h3>
											<canvas id="lineChart"></canvas>
										</div>
									</div>
								</div>
								<div class="col-md-6 d-flex">
									<div class="card flex-fill">
										<div class="card-body">
											<h3 class="card-title text-center">Latest Punch In</h3>
											<ul class="list-group" id="chekInsSections">


											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>


					<div class="row">
						<div class="col-md-12">
							<div class="card card-table">
								<div class="card-header">
									<h3 class="card-title mb-0">Today Absents</h3>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-nowrap custom-table mb-0">
											<thead>
												<tr>
													<th>#</th>
													<th>Name</th>
													<th>Job Title</th>

												</tr>
											</thead>
											<tbody id="absentTable">

											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>


                </div>
				<!-- /Page Content -->

            </div>
			<!-- /Page Wrapper -->



            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script>

                $(document).ready(function (){
                    getData();

                    function getData(){


                        $.ajax({

                            url: '{{url("/att-dashboard")}}',
                            type: 'get',
                            async: false,
                            dataType: 'json',

                            success: function(data)
                            {

                                var html = '';
                                var timeHtml = '';
                                var i;
                                var c=0;

                                for(i=0; i<data.absent.length; i++){

                                    c++;

                                    html +='<tr>'+
                                        '<td>'+c+'</td>'+
                                        '<td>'+data.absent[i].name+'</td>'+
                                        '<td>'+data.absent[i].desig_name+'</td>'+
                                        '</tr>';
                                }


                                for(i=0; i<data.chekIns.length; i++){

                                    c++;
                                    timeHtml +='<li class="list-group-item list-group-item-action">'+data.chekIns[i].name+' <span class="float-right text-sm text-muted">'+data.chekIns[i].time+'</span></li>';
                                }


                                $('#totalStaff').html(data.totalStaff);
                                $('#presentStaff').html(data.presentStaff);
                                $('#absentStaff').html(data.absentStaff);
                                $('#leaves').html(data.leaves);
                                $('#leaves').html(data.leaves);
                                $('#chekInsSections').html(timeHtml);

                                $('#absentTable').html(html);

                            },
                            error:function()
                            {
                                toastr.error('something went wrong');
                            }

                        });
                    }


                })
            </script>


@endsection


