
@extends('setup.master')

@section('content')



        <div class="main-wrapper">


			<!-- /Sidebar -->

			<!-- Page Wrapper -->
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
                                <a href="{{url('/new-employee')}}" class="btn add-btn" ><i class="fa fa-plus"></i> Add Employee</a>
								<div class="view-icons">
									<a href="{{url('employees')}}" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
									<a href="{{url('employees-list')}}" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
								</div>
							</div>
						</div>
					</div>
					<!-- /Page Header -->

					<!-- Search Filter -->

                    <form action="{{url('employees-list')}}" method="post">
                        @csrf
                        <div class="row filter-row">

                            <div class="col-sm-6 col-md-3">
                                <div class="form-group form-focus">
                                    <input type="text" class="form-control floating" name="emp_id">
                                    <label class="focus-label">Employee ID</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group form-focus">
                                    <input type="text" class="form-control floating" name="emp_name">
                                    <label class="focus-label">Employee Name</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group form-focus select-focus">
                                    <select class="select floating" name="desig_id">
                                        <option>Select Designation</option>
                                        @isset($data['designation'])
                                            @foreach($data['designation'] as $desig)
                                                <option value="{{$desig->id}}">{{$desig->desig_name}}</option>
                                            @endforeach
                                        @endisset

                                    </select>
                                    <label class="focus-label">Designation</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <button type="submit"  class="btn btn-success btn-block"> Search </button>
                            </div>

                        </div>
                    </form>
					<!-- /Search Filter -->

					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-striped custom-table datatable">
									<thead>
										<tr>
											<th>Name</th>
											<th>Employee ID</th>
											<th>Email</th>
											<th>Mobile</th>
											<th class="text-nowrap">Join Date</th>
											<th>Role</th>
											<th class="text-right no-sort">Action</th>
										</tr>
									</thead>
									<tbody>
                                @php $c=0; @endphp
                                    @isset($data['employee'])
                                        @foreach($data['employee'] as $emp)
                                            @php $c++; @endphp
										<tr>
											<td>
												<h2 class="table-avatar">
													<a href="{{url('user-profile').'/'.encrypt($emp->id)}}" >
                                                        <img class="avatar" alt="" src="{{asset('storage/app/public/uploads/staff-images/').'/'.$emp->image}}"></a>
													<a href="{{url('user-profile').'/'.encrypt($emp->id)}}">{{$emp->name}} <span>{{$emp->desi_name}}</span></a>
												</h2>
											</td>
											<td>{{$emp->cnic}} </td>
											<td>{{$emp->email}} </td>
											<td>{{$emp->phone}} </td>
											<td>{{$emp->created_at}} </td>
											<td>
												<div class="dropdown">
                                                    @php
                                                       $desig= App\Models\Designation::find($emp->desg_id);
                                                        @endphp
													<a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false">{{$desig->desig_name}} </a>

												</div>
											</td>
											<td class="text-right">
												<div class="dropdown dropdown-action">
													<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="{{url('edit-employee/'.encrypt($emp->id))}}" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
														<a class="dropdown-item btnDelete" href="javascript()!" data=""><i class="fa fa-trash-o m-r-5"></i> Delete</a>
													</div>
												</div>
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
											<a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
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
			<!-- /Page Wrapper -->

        </div>
		<!-- /Main Wrapper -->




@endsection




