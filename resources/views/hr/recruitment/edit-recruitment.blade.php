
@extends('setup.master')

@section('content')



    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>


    <!-- Page Wrapper -->
            <div class="page-wrapper">

				<!-- Page Content -->
                <div class="content container-fluid">

					<!-- Page Header -->
					<div class="page-header">
						<div class="row align-items-center">
							<div class="col">
								<h3 class="page-title">Recruitment</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
									<li class="breadcrumb-item active">Recruitment</li>
								</ul>
							</div>
							<div class="col-auto float-right ml-auto">
								<a href="{{url('recruitment/new')}}" class="btn add-btn" ><i class="fa fa-plus"></i>Recruitment</a>
							</div>
						</div>
					</div>
					<!-- /Page Header -->


					<div class="row">
						<div class="col-lg-12">
							<div class="card">

								<div class="card-body">
            <form method="post"  action="{{url("update-recruitment")}}">
                                    @csrf
									<div class="row">


                                        <input type="hidden" name="hidden_rec_id" value="{{$data['hiring']->id}}">
                                        <div class="form-group col-sm-6">
                                            <label>Designation <span class="text-danger">*</span></label>
                                            <select class="select"  name="designation">
                                                <option value="">Choose Designation</option>
                                                @isset($data)
                                                    @foreach($data['desig'] as $desig)
                                                <option value="{{$desig->id}}"
                                                <?php
                                                    if( $data['hiring']->desg_id==$desig->id){
                                                        echo "selected";
                                                    }
                                                    ?>
                                                >{{$desig->desig_name}}</option>
                                                    @endforeach
                                       @endisset
                                            </select>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select class="select" name="job_status">
                                                <option value="">Choose Status</option>
                                                <option value="open"  <?php
                                                    if( $data['hiring']->status=='OPEN'){
                                                        echo "selected";
                                                    }
                                                    ?>>OPEN</option>
                                                <option value="close" <?php
                                                    if( $data['hiring']->status=='CLOSE'){
                                                        echo "selected";
                                                    }
                                                    ?>>CLOSE</option>
                                            </select>
                                        </div>


									</div>

									<div class="row">


                                        <div class="form-group col-sm-4">
                                            <label>Job Type <span class="text-danger">*</span></label>
                                            <select class="select" name="job_type">
                                                <option value="">Job Type</option>
                                                <option value="Full Time"     <?php
                                                    if( $data['hiring']->job_type=='Full Time'){
                                                        echo "selected";
                                                    }
                                                    ?>>Full Time</option>
                                                <option value="Part Time"   <?php
                                                    if( $data['hiring']->job_type=='Part Time'){
                                                        echo "selected";
                                                    }
                                                    ?>>Part Time</option>
                                            </select>
                                        </div>


                                        <div class="form-group col-sm-4">
											<label>Experience <span class="text-danger">*</span></label>
											<input class="form-control" type="text" name="exp" placeholder="1 year" value="{{$data['hiring']->experience}}">
										</div>


                                        <div class="form-group col-sm-4">
                                            <label>Vacancies <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="vacancies" placeholder="1" value="{{$data['hiring']->vacancies}}">
                                        </div>
									</div>



                                    <div class="row">



                                        <div class="form-group col-sm-6">
                                            <label>Last Date <span class="text-danger">*</span></label>
                                            <input class="form-control" type="date" name="last_date" value="{{$data['hiring']->last_date}}">
                                        </div>


                                        <div class="form-group col-sm-6">
                                            <label>Location <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="location" placeholder="Lahore" value="{{$data['hiring']->location}}">
                                        </div>
                                    </div>



                                    <div class="row">
{{--                                        --}}
{{--                                        <div class="form-group col-sm-4">--}}
{{--                                            <label>Timing <span class="text-danger">*</span></label>--}}
{{--                                            <div class="cal-">--}}
{{--                                                <input type="date"  class="form-control" name="timing" value="{{$data['hiring']->timings}}">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                        <div class="form-group col-sm-6">
                                            <label>Shift <span class="text-danger">*</span></label>
                                            <select class="select" name="shift">
                                                <option value="">Choose Shift</option>
                                                <option value="morning"  <?php
                                                    if( $data['hiring']->shift=='MORNING'){
                                                        echo "selected";
                                                    }
                                                    ?>>Morning</option>
                                                <option value="evening" <?php
                                                    if( $data['hiring']->shift=='EVENING'){
                                                        echo "selected";
                                                    }
                                                    ?>>Evening</option>
                                            </select>
                                        </div>


                                        <div class="form-group col-sm-6">
                                            <label>Salary <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="salary" placeholder="12000 - 15000"  value="{{$data['hiring']->salary}}">
                                        </div>
                                    </div>

									<div class="form-group">
										<label>Description <span class="text-danger">*</span></label>
										<textarea rows="4" class="form-control" name="des" >{{$data['hiring']->desc}}</textarea>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn" type="submit" id="btnSubmit">Update</button>
									</div>
								</form>

								</div>
							</div>

						</div>
					</div>
                </div>
				<!-- /Page Content -->



            </div>
			<!-- /Page Wrapper -->


    <script type="text/javascript">

        CKEDITOR.replace('des', {
            filebrowserUploadUrl: "{{url('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });





    </script>




<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>




<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

<script>
    @if(count($errors) > 0)

    @foreach($errors->all() as $error)

    toastr.error("{{ $error }}");
    @endforeach
    @endif


    @if(Session::has('success'))
    toastr.success("Record update successfully!");

    @endif

</script>


@endsection

