@extends('setup.master')

@section('content')
			
			<!-- Page Wrapper -->
            <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Welcome Trainer!</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item active">Dashboard</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
				
					<div class="row">
						<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
							<div class="card dash-widget">
								<div class="card-body">
									<span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
									<div class="dash-widget-info">
										<h3>{{ $data['trainer'] }}</h3>
										<span>Trainer</span>

									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
							<div class="card dash-widget">
								<div class="card-body">
									<span class="dash-widget-icon"><i class="fa fa-usd"></i></span>
									<div class="dash-widget-info">
										<h3>{{ $data['cost'] }}</h3>
										<span>Total Cost</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
							<div class="card dash-widget">
								<div class="card-body">
									<span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
									<div class="dash-widget-info">
										<h3>{{ $data['comments'] }}</h3>
										<span>Comment</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
							<div class="card dash-widget">
								<div class="card-body">
									<span class="dash-widget-icon"><i class="fa fa-user"></i></span>
									<div class="dash-widget-info">
										<h3>218</h3>
										<span>Employees</span>
									</div>
								</div>
							</div>
						</div>
					</div>


					<div class="row">
					<div class="col-md-6 d-flex">
							<div class="card card-table flex-fill">
								<div class="card-header">
									<h3 class="card-title mb-0">Training</h3>
								</div>
								<div class="card-body">
									<div class="table-responsive">	
										<table class="table custom-table table-nowrap mb-0">
											<thead>
												<tr>
													<th>Name</th>
													<th>Training Type</th>
													<th>Cost</th>
													<th>From</th>
													<th>To</th>
												</tr>
											</thead>
											<tbody>
											@isset($data['trainee'])
                            				@foreach($data['trainee'] as $key => $train)
												<tr>
													<td><a href="#">{{$train->name}}</a></td>
													<td>
														<h2><a href="#">{{$train->training_type}}</a></h2>
													</td>
													<td>{{$train->cost}}</td>
													<td>{{$train->from}}</td>
													<td>{{$train->to}}</td>
												</tr>
											@endforeach
											@endisset
											</tbody>
										</table>
									</div>
								</div>
								<div class="card-footer">
									<a href="payments.html">View all payments</a>
								</div>
							</div>
						</div>
						<div class="col-md-6 d-flex">
							<div class="card card-table flex-fill">
								<div class="card-header">
									<h3 class="card-title mb-0">Trainer</h3>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-nowrap custom-table mb-0">
											<thead>
												<tr>
													<th>First Name</th>
													<th>Last Name</th>
													<th>Email</th>
													<th>Contact</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												@isset($data)
												@foreach($data['alltrainer'] as $t)
												<tr>
													<td><a href="#">{{ $t->f_name }}</a></td>
													<td>
														<h2><a href="#">{{ $t->l_name }}</a></h2>
													</td>
													<td>{{ $t->email }}</td>
													<td>{{ $t->contact }}</td>
													<td>
														<span class="badge bg-inverse-warning">{{ $t->status }}</span>
													</td>
												</tr>
												@endforeach
												@endisset
											</tbody>
										</table>
									</div>
								</div>
								<div class="card-footer">
									<a href="invoices.html">View all invoices</a>
								</div>
							</div>
						</div>
						
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-6 text-center">
									<div class="card">
										<div class="card-body">
											<h3 class="card-title">Total Revenue</h3>
											<div id="bar-charts"></div>
										</div>
									</div>
								</div>
								<div class="col-md-6 text-center">
									<div class="card">
										<div class="card-body">
											<h3 class="card-title">Sales Overview</h3>
											<div id="line-charts"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					

				</div>
				<!-- /Page Content -->

            </div>


			@endsection
			
 
		
	