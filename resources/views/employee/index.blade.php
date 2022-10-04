@extends('setup.master')

@section('content')


<div class="page-wrapper">

	<!-- Page Content -->
	<div class="content container-fluid">

		<!-- Page Header -->
		<div class="page-header">
			<div class="row align-items-center">
				<div class="col">
					<h3 class="page-title">Employee</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
						<li class="breadcrumb-item active">Employee</li>
					</ul>
				</div>
				<div class="col-auto float-right ml-auto">
					<a href="{{url('/new-employee')}}" class="btn add-btn" title="Add Employee"><i class="fa fa-plus"></i></a>
					<div class="view-icons">
						<a href="{{url('employees')}}" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
						<a href="{{url('employees-list')}}" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
					</div>
				</div>
			</div>
		</div>
		<!-- /Page Header -->


        <!-- Search Filter -->
        <div class="card">
            <div class="card-body">

                <form method="post" action="{{url('employees')}}" id="SearchEmpForm">

                    @csrf
                    <div class="row">

                        <div class="col-md-3">

                                <select name="company_id" class="form-control selectpicker" data-container="body"
                                        data-live-search="true">
                                <option value="">Choose Company</option>
                                @isset($data['company'])
                                    @foreach($data['company'] as $company)
                                        <option value="{{$company->id}}">{{$company->name}}</option>
                                    @endforeach
                                @endisset

                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="dept_id" class="form-control selectpicker" data-container="body"
                                    data-live-search="true">

                                <option value=""> Dept</option>
                                @isset($data['dept'])
                                    @foreach($data['dept'] as $dept)
                                        <option value="{{$dept->id}}">{{$dept->departments}}</option>
                                    @endforeach
                                @endisset

                            </select>
                        </div>

                        <div class="col-md-3">


                                <select name="desig_id" class="form-control selectpicker" data-container="body"
                                        data-live-search="true">
                                <option value=""> Designation</option>
                                @isset($data['designation'])
                                    @foreach($data['designation'] as $desig)
                                        <option value="{{$desig->id}}">{{$desig->desig_name}}</option>
                                    @endforeach
                                @endisset

                            </select>
                        </div>

                        <div class="col-md-3">

                                <select name="grade_id" class="form-control selectpicker" data-container="body"
                                        data-live-search="true">
                                <option value=""> Grades</option>
                                @isset($data['grade'])
                                    @foreach($data['grade'] as $grade)
                                        <option value="{{$grade->id}}">{{$grade->grade}}</option>
                                    @endforeach
                                @endisset

                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for=""></label>
                            <input type="text" class="form-control floating" name="emp_name" placeholder="Emp Name">
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-search" style="margin-top: 30px"><i class="fa fa-search"></i></button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <!-- Search Filter -->
@if($data['search']==1)
        <div class="text-primary">{{  $data['foundedRec']}} Records Found</div>
        @endif
		<div class="row staff-grid-row">

			@isset($data['employee'])
			@foreach($data['employee'] as $emp)
			<div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">

				<div class="profile-widget">
					<div class="profile-img">
						<a href="{{url('user-profile/').'/'.encrypt($emp->id)}}">
							<img src="{{asset('storage/app/public/uploads/staff-images/').'/'.$emp->image}}" class="avatar" alt="">
						</a>
					</div>
					<div class="dropdown profile-action">
						<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="{{url('edit-employee/'.encrypt($emp->id))}}" data="{{$emp->id}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
							<a class="dropdown-item btn-delete" href="#" data="{{$emp->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
						</div>
					</div>
					<h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="{{url('profile')}}">{{$emp->name}}</a></h4>
					<div class="small text-muted">{{$emp->desig_name}}</div>
				</div>
			</div>
			@endforeach
			@endisset
		</div>

		<div class="float-right">
			{{ $data['employee']->links('pagination::bootstrap-4') }}
		</div>

	</div>
	<!-- /Page Content -->




	<!-- Delete Employee Modal -->
	<div class="modal custom-modal fade" id="delete_employee" role="dialog">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body">
					<div class="form-header">
						<h3>Delete Employee</h3>
						<p>Are you sure want to delete?</p>
					</div>
					<div class="modal-btn delete-action">
						<div class="row">
							<div class="col-6">
								<a href="javascript:void(0);" class="btn btn-primary continue-btn deleteNow">Delete</a>
							</div>
							<div class="col-6">
								<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Delete Employee Modal -->

</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
	$(document).ready(function() {


		$('.btn-delete').on('click', function() {


			var emp_id = $(this).attr('data');
			$('#delete_employee').modal('show');




			$('.deleteNow').on('click', function() {


				$.ajax({

					type: 'ajax',
					method: 'get',
					url: '{{url("delete-employee")}}',
					data: {
						emp_id: emp_id
					},
					async: false,
					dataType: 'json',
					success: function(data) {


						if (data.success) {

							toastr.success(data.success);
							$('#delete_employee').modal('hide');
						}
						window.location.reload();



					},

					error: function() {

						toastr.error('something went wrong');

					}

				});

			});


		});

	})
</script>



<script>
    $('.btn-search').on('click', function() {
        $(".btn-search").prop("disabled", true);
        $(".btn-search").html("Please wait...");
        $('#SearchEmpForm').submit();
    });
</script>



@endsection
