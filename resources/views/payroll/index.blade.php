@extends('setup.master')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!-- Page Wrapper -->
<div class="page-wrapper">

	<!-- Page Content -->
	<div class="content container-fluid">

		<!-- Page Header -->
		<div class="page-header">
			<div class="row align-items-center">
				<div class="col">
					<h3 class="page-title">Employee Salary</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
						<li class="breadcrumb-item active">Salary</li>
					</ul>
				</div>

			</div>
		</div>
		<!-- /Page Header -->

		<!-- Search Filter -->
		<div class="card">
			<div class="card-body">
				<form action="{{url('salary')}}" method="post">
					@csrf
					<div class="row filter-row">
						<input type="hidden" name="search" value="1">
						<div class="col-md-3">
							<div class="form-group form-focus">
								<select class="livesearch form-control p-3" name="emp_id" required></select>
								<label class="focus-label">Employee Name</label>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group form-focus select-focus">
								<select class="select floating" name="month" required>
									<option value=""> -- Select -- </option>
									<option value="1">Jan</option>
									<option value="2">Feb</option>
									<option value="3">March</option>
									<option value="4">Apr</option>
									<option value="5">May</option>
									<option value="6">June</option>
									<option value="7">July</option>
									<option value="8">Aug</option>
									<option value="9">Sep</option>
									<option value="10">Oct</option>
									<option value="11">Nov</option>
									<option value="12">Dec</option>

								</select>
								<label class="focus-label">Month</label>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group form-focus select-focus">
								<select class="select floating" name="year" required>
									<option value=""> -- Select -- </option>
									<option value="2021"> 2021 </option>
									<option value="2022"> 2022 </option>
									<option value="2023"> 2023 </option>
									<option value="2024"> 2024 </option>
									<option value="2025"> 2025 </option>

								</select>
								<label class="focus-label">Year</label>
							</div>
						</div>
						<div class="col-md-3">
							<button type="submit" class="btn btn-success btn-block"> Search </button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- /Search Filter -->

		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-striped table-responsive" id="datatable">
								<thead>
									<tr>
										<th>#</th>
										<th>Employee</th>
										<th>Join Date</th>
										<th>Role</th>
										<th>Salary</th>
										<th>Income</th>
										<th>Payslip</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody id="salaryTable">
									@php $c=0; @endphp
									@isset($collection)
									@foreach($collection as $emp)
									@php $c++; @endphp

									<tr>
										<td>{{$c}}</td>
										<td>
											<h2 class="table-avatar">
												<a href="#"><img alt="" class="target-img" src="{{asset('storage/app/public/uploads/staff-images/').'/'.$emp['image']}}"></a>
												<a href="#">{{$emp['name']}} <span>{{$emp['desig']}}</span></a>
											</h2>
										</td>


										<td>{{date('d M Y', strtotime($emp['doj']))}}</td>
										<td>
											<div class="dropdown">
												<a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false">{{$emp['desig']}}</a>

											</div>
										</td>
										<td>RS {{$emp['gross_salary']}}</td>
										<td>RS {{$emp['income']}}</td>
										<td><a class="btn btn-sm btn-primary" href="{{url('view-salary-slip').'/'.$data['month'].'/'.$data['year'].'/'.encrypt($emp['id'])}}" title="view salary slip"><i class="fa fa-eye"></i></a></td>
										<td>

											@if($emp['salaryStatus']==0)
											<a class="btn btn-sm btn-primary btn-salary-pay" href="#" month="{{$data['month']}}" year="{{$data['year']}}" data="{{$emp['id']}}" title="Pay Now">Pay Now</a>
											@else
											<a class="btn btn-sm btn-success " href="#" title="view salary slip">Paid</a>
											@endif
										</td>

									</tr>
									@endforeach
									@endisset
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

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
	$(document).ready(function() {

		//edit data
		$('#salaryTable').on('click', '.btn-salary-pay', function() {

			var emp_id = $(this).attr('data');
			var month = $(this).attr('month');
			var year = $(this).attr('year');

			$.ajax({

				type: 'ajax',
				method: 'get',
				url: '{{url("update-salary-slip")}}',
				data: {
					emp_id: emp_id,
					month: month,
					year: year
				},
				async: false,
				dataType: 'json',
				success: function(data) {
					if (data.success) {
						toastr.success(data.success);
						window.location.reload();
					}
				},

				error: function() {

					toastr.error('something went wrong');

				}

			});


		});


		//Datatables
		$('#datatable').DataTable();
	});
</script>
@endsection