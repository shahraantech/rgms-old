                @extends('setup.master')
            @section('content')
            <div class="page-wrapper">
                <div class="content container-fluid">
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Welcome {{Auth::user()->name}}!</h3>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
							<div class="card dash-widget">
								<div class="card-body">
									<span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
									<div class="dash-widget-info">
										<h3>{{$data['employees']->count()}}</h3>
										<span>Employees</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
							<div class="card dash-widget">
								<div class="card-body">
									<span class="dash-widget-icon"><i class="fa fa-usd"></i></span>
									<div class="dash-widget-info">
										<h3>{{$data['jobs']}}</h3>
										<span>Jobs</span>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
							<div class="card dash-widget">
								<div class="card-body">
									<span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
									<div class="dash-widget-info">
										<h3>{{$data['tickets']->count()}}</h3>
										<span>Tickets</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
							<div class="card dash-widget">
								<div class="card-body">
									<span class="dash-widget-icon"><i class="fa fa-user"></i></span>
									<div class="dash-widget-info">
										<h3>{{$data['cvBank']}}</h3>
										<span>Cv Bank</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">

						<div class="col-md-12 col-lg-12 col-xl-6 d-flex">
							<div class="card flex-fill dash-statistics">
								<div class="card-body">
									<h5 class="card-title">Today</h5>
									<div class="stats-list">
										<div class="stats-info">
											<p>Leaves Request <strong>{{$data['leaves']->count()}} <small></small></strong></p>
											<div class="progress">
												<div class="progress-bar bg-primary" role="progressbar" style="width: 31%" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
										<div class="stats-info">
											<p>Pending Leaves Request <strong>{{$data['pendingLeaves']->count()}} <small>/ {{$data['leaves']->count()}}</small></strong></p>
											<div class="progress">
												<div class="progress-bar bg-warning" role="progressbar" style="width: 31%" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
										<div class="stats-info">
											<p>Approved Leaves Request <strong>{{$data['approvedLeaves']->count()}} <small>/ {{$data['leaves']->count()}}</small></strong></p>
											<div class="progress">
												<div class="progress-bar bg-success" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
										<div class="stats-info">
                                            @php
                                                $totalTickets=$data['tickets']->count();
                                                @endphp
											<p>Pending Tickets <strong>{{$data['tickets']->where('status','pending')->count()}} <small>/ {{$totalTickets}}</small></strong></p>
											<div class="progress">
												<div class="progress-bar bg-danger" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
										<div class="stats-info">
											<p>Close Tickets <strong>{{$data['close']->count()}} <small>/ {{$totalTickets}}</small></strong></p>
											<div class="progress">
												<div class="progress-bar bg-info" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>


						<div class="col-md-12 col-lg-6 col-xl-6 d-flex" >
							<div class="card flex-fill" style="overflow-y:visible">
								<div class="card-body" >
									<h4 class="card-title">Today Absent <span class="badge bg-inverse-danger ml-2">{{$data['absents']->count()}}</span></h4>

                                    @isset($data['absents'])
                                        @foreach($data['absents'] as $att)
									<div class="leave-info-box">
										<div class="media align-items-center">
											<a href="" ><img class="avatar" alt="" src="{{asset('storage/app/public/uploads/staff-images/').'/'.$att->image}}"></a>
											<div class="media-body">
												<div class="text-sm my-0">{{$att->name}}</div>
											</div>
										</div>

										<div class="row align-items-center mt-3">
											<div class="col-6">
												<h6 class="mb-0">{{date('d M Y',strtotime($att->created_at))}}</h6>
												<span class="text-sm text-muted">Leave Date</span>
											</div>
											<div class="col-6 text-right">
												<span class="badge bg-inverse-danger">Pending</span>
											</div>
										</div>
									</div>
                                        @endforeach
@endisset

								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
			@endsection



