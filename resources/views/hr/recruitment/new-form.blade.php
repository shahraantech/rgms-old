
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
								<h3 class="page-title">Jobs Portal</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
									<li class="breadcrumb-item active">Recruitment</li>
								</ul>
							</div>
							<div class="col-auto float-right ml-auto">
								<a href="{{url('recruitment/new')}}" class="btn add-btn" >Jobs List</a>
							</div>
						</div>
					</div>
					<!-- /Page Header -->


					<div class="row">
						<div class="col-lg-12">
							<div class="card">

								<div class="card-body">
            <form method="post" id="newHiringForm" action="{{url("save-new/hiring")}}" class="needs-validation" novalidate>
                                    @csrf


                <div class="row">
                    <div class="form-group col-sm-4">
                        <label>Company <span class="text-danger">*</span></label>
                        <select name="company_id" class="form-control selectpicker" data-container="body" data-live-search="true" title="Choose Company">

                            @isset($data)
                                @foreach($data['companies'] as $company)
                                    <option value="{{$company->id}}">{{$company->name}}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="form-group col-sm-4">
                        <label>Departments <span class="text-danger">*</span></label>
                        <select class="form-control select selectpicker" name="dept_name" id="showDept" data-container="body" data-live-search="true">
                            <option value="">Choose Department</option>

                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Designation <span class="text-danger">*</span></label>
                        <select class="form-control selectpicker select" id="showDesig" name="designation" data-container="body" data-live-search="true">
                            <option value="">Choose Designation</option>
                        </select>
                    </div>







                </div>

									<div class="row">


                                        <div class="form-group col-sm-4">
                                            <label>Job Type <span class="text-danger">*</span></label>
                                            <select class="select" name="job_type" required>
                                                <option value="">Job Type</option>
                                                <option value="Full Time">Full Time</option>
                                                <option value="Part Time">Part Time</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please choose job type.
                                            </div>
                                        </div>


                                        <div class="form-group col-sm-4">
											<label>Experience <span class="text-danger">*</span></label>
											<input class="form-control" type="text" name="exp" placeholder="Enter Experience" required>
										</div>


                                        <div class="form-group col-sm-4">
                                            <label>Vacancies <span class="text-danger">*</span></label>
                                            <input class="form-control" type="number" name="vacancies" placeholder="Enter Vacancies" required>
                                        </div>
									</div>



                                    <div class="row">



                                        <div class="form-group col-sm-6">
                                            <label>Last Date <span class="text-danger">*</span></label>
                                            <input class="form-control" type="date" name="last_date" required id="last_date">
                                            <div id="dateError"></div>
                                        </div>


                                        <div class="form-group col-sm-6">
                                            <label>Location <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="location" placeholder="Enter Job Location" required>
                                        </div>
                                    </div>



                                    <div class="row">
{{--                                        --}}
{{--                                        <div class="form-group col-sm-4">--}}
{{--                                            <label>Timing <span class="text-danger">*</span></label>--}}
{{--                                            <div class="cal-">--}}
{{--                                                <input type="time"  class="form-control" name="timing" required>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                        <div class="form-group col-sm-6">
                                            <label>Shift <span class="text-danger">*</span></label>
                                            <select class="select" name="shift"required>
                                                <option value="">Choose Shift</option>
                                                <option value="morning">Morning</option>
                                                <option value="evening">Evening</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please choose job shift.
                                            </div>
                                        </div>


                                        <div class="form-group col-sm-6">
                                            <label>Salary <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="salary" placeholder="Enter Salary Range" required>
                                        </div>
                                    </div>

									<div class="form-group">
										<label>Description <span class="text-danger">*</span></label>
										<textarea rows="4" class="form-control" name="job_description" required="true"></textarea>
                                        <div class="invalid-feedback">
                                            Please enter job description.
                                        </div>
									</div>


									<div class="submit-section">
										<button class="btn btn-primary submit-btn" type="submit" id="btnSubmit">Submit</button>
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

        CKEDITOR.replace('job_description', {
            filebrowserUploadUrl: "{{url('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });





    </script>




<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>



<script type='text/javascript'>

    $(document).ready(function (){




        $('#last_date').change(function (){
           var lastDate=$('#last_date').val();
            var toDay=moment().format("YYYY-MM-DD");


            if (lastDate >= toDay){
                $("#btnSubmit").removeAttr("disabled");
                var p='';
                $('#dateError').html(p);
            }else{
                $("#btnSubmit").attr("disabled", true);
                var p='<small style="color:red">Last date must be greater then today<small/>';
                $('#dateError').html(p);
            }
        });





        //company_id dependent dropdown
        $('select[name=company_id]').change(function() {

            var company_id = $('select[name=company_id]').val();


            $.ajax({

                type: 'ajax',

                method: 'get',

                url: '{{url("/getDeptRespectToCompany")}}',

                data: {
                    company_id: company_id
                },

                async: false,

                dataType: 'json',

                success: function(data) {

                    var html = '<option value="">Choose Department</option>';

                    var i;
                    if (data.length > 0) {

                        for (i = 0; i < data.length; i++) {

                            html += '<option value="' + data[i].id + '">' + data[i].departments + '</option>';
                        }
                    } else {
                        var html = '<option value="">Choose Department</option>';
                        toastr.error('data not found');
                    }


                    $('#showDept').html(html);

                },

                error: function() {

                    toastr.error('db error');


                }

            });
        });


        //dept
        $('#showDept').change(function() {

            var dept_id = $('select[name=dept_name]').val();

            $.ajax({

                type: 'ajax',

                method: 'get',

                url: '{{url("/getDesignations")}}',

                data: {
                    dept_id: dept_id
                },

                async: false,

                dataType: 'json',

                success: function(data) {

                    var html = '';

                    var i;
                    if (data.length > 0) {

                        for (i = 0; i < data.length; i++) {

                            html += '<option value="' + data[i].id + '">' + data[i].desig_name + '</option>';

                        }
                    } else {
                        var html = '<option value="">Choose Designation</option>';
                        toastr.error('data not found');
                    }


                    $('#showDesig').html(html);

                },

                error: function() {

                    alert('Could not get Data from Database');

                }

            });
        });



        $('#newHiringForm').unbind().on('submit',function(e){
            e.preventDefault();

            var formData= $('#newHiringForm').serialize();


            $.ajax({

                type: 'ajax',
                method: 'post',
                url: '{{url("save-new/hiring")}}',
                data: formData,
                async: false,
                dataType: 'json',
                success: function(data) {
console.log(data);
                    if(data.field_errors) {
                        toastr.error('description filed missing');
                    }

                    if(data.errors) {
                        toastr.error(data.errors);
                    }
                    if(data.success) {

                        $('#newHiringForm')[0].reset();
                        toastr.success('Record save successfully');
                        window.location.href="{{url('recruitment/new')}}"
                    }


                },

                error: function() {
                    toastr.error('something went wrong');

                }

            });


        })

    })
</script>


<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

<script>
    @if(count($errors) > 0)

    @foreach($errors->all() as $error)

    toastr.error("{{ $error }}");
    @endforeach
    @endif


    @if(Session::has('success'))
    toastr.success("Record save successfully!");

    @endif

</script>


@endsection

