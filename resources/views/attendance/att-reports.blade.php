@extends('setup.master')

@section('content')


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


<div class="main-wrapper">

	<style>
		.att-btn{
            width: 72%;
        }
	</style>

	<!-- /Sidebar -->

	<!-- Page Wrapper -->
	<div class="page-wrapper">

		<!-- Page Content -->
		<div class="content container-fluid">

			<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Attendance Reports</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
							<li class="breadcrumb-item active">Attendance Reports</li>
						</ul>
					</div>
				</div>

			</div>
			<!-- /Page Header -->



			<div class="card">
				<div class="card-body">
					<!-- <h4 class="card-title">Solid justified</h4> -->
					<ul class="nav nav-tabs nav-tabs-solid nav-justified">
						<li class="nav-item"><a class="nav-link att-btn" href="{{url('att-dashboard')}}">Dashboard</a></li>

						<li class="nav-item"><a class="nav-link att-btn" href="{{url('attendance')}}">Mark Attendance</a></li>
						<li class="nav-item"><a class="nav-link att-btn" href="{{url('view-attendance')}}">View Attendance</a></li>
						<li class="nav-item"><a class="nav-link att-btn active" href="{{url('attendance-reports')}}">Attendance Reports</a></li>

					</ul>
				</div>

			</div>

			<!-- Search Filter -->
			<form action="{{url('attendance-reports')}}" method="post">
				<input type="hidden" name="search" value="1">
				@csrf
				<div class="row">
					<div class="col-md-2">
						<div class="form-group">
						<select name="company_id" class="select">
									<option value="" selected disabled>Choose Company</option>
									@isset($data['company'])
										@foreach($data['company'] as $comp)
											<option value="{{ $comp->id }}">{{ $comp->name }}</option>
										@endforeach
									@endisset
								</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<select class="livesearch form-control p-3" name="emp_id">
								<option value="" selected disabled>Choose Employee Name</option>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="cal">

							<select class="select " name="search_month">
								<option value="" selected disabled>Choose Month</option>
								<option value="1">Jan</option>
								<option value="2">Feb </option>
								<option value="3">Mar</option>
								<option value="4">Apr</option>
								<option value="5">May</option>
								<option value="6">June</option>
								<option value="7">Jul</option>
								<option value="8">Aug</option>
								<option value="9">Sep</option>
								<option value="10">Oct</option>
								<option value="11">Nov</option>
								<option value="12">Dec</option>

							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="cal">

							<select class="select" name="year">
								<option value="">Choose Year</option>
								@for($y=2021; $y<=date('Y');$y++) <option value="{{$y}}">{{$y}} </option>
									@endfor

							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-block"> Search </button>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<button class="btn btn-white" id="btnExport">Export</button>
						</div>
					</div>
				</div>
			</form>
			<!-- Search Filter -->

			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-striped custom-table mb-0 datatable" id="tblPdf">
							<thead>
								<tr>
									<th>#</th>
									<th>Employee</th>
									<th>Date</th>
									<th>Clock In</th>
									<th>Clock Out</th>
									<th> Status</th>
								</tr>
							</thead>
							<tbody>
								@php $c=0; @endphp
								@isset($data['report'])
								@foreach($data['report'] as $report)
								@php $c++ @endphp
								<tr>
									<td>{{$c}}</td>
									<td>
										<h2 class="table-avatar">
											<a href="#"><img alt="" class="target-img" src="{{asset('storage/app/public/uploads/staff-images/').'/'.$report->image}}"></a>
											<a href="#">{{$report->name }}<span>{{$report->desig_name }}</span></a>
										</h2>
									</td>
									<td>{{date('d M Y',strtotime($report->date)) }}</td>
									@if($report->status=='Present')
									<td>{{date('H:i:s a',strtotime($report->created_at)) }}</td>
									@else
									<td>-</td>
									@endif
									@if($report->chek_out==1)
									<td>{{$report->updated_at}}</td>
									@else
									<td>-</td>
									@endif
									<td>{{$report->status}}</td>

								</tr>
								@endforeach
								@endisset

							</tbody>
						</table>
					</div>
				</div>
			</div>

			<!-- /Content End -->

		</div>
		<!-- /Page Content -->

	</div>
	<!-- /Page Wrapper -->



</div>



<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script type="text/javascript">
	$("body").on("click", "#btnExport", function() {
		html2canvas($('#tblPdf')[0], {
			onrendered: function(canvas) {
				var data = canvas.toDataURL();
				var docDefinition = {
					content: [{
						image: data,
						width: 500
					}]
				};
				pdfMake.createPdf(docDefinition).download("Table.pdf");
			}
		});
	});
</script>

<script type="text/javascript">
	$('.livesearch').select2({

		ajax: {
			url: '{{url("ajax-autocomplete-search")}}',
			dataType: 'json',
			delay: 250,
			processResults: function(data) {
				console.log(data);
				return {
					results: $.map(data, function(item) {
						return {
							text: item.name,
							id: item.id
						}
					})
				};
			},
			cache: true
		}
	});
</script>

@endsection
