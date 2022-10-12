@extends('setup.master')
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Edit Employee</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Employee</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ url('recruitment/new') }}" class="btn add-btn"><i class="fa fa-plus"></i>Employees</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-lg-12">
                    <form method="post" action="{{ url('update-employee') }}" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        @isset($data['employeeData'])
                            @foreach ($data['employeeData'] as $employeeData)
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Personal Information</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="form-group col-sm-3">
                                                <label>Company <span class="text-danger">*</span></label>
                                                <select name="company_id" class="form-control selectpicker"
                                                    data-container="body" data-live-search="true" title="Choose Company">

                                                    @isset($data)
                                                        @foreach ($data['companies'] as $company)
                                                            <option value="{{ $company->id }}"
                                                                @if ($employeeData->company_id == $company->id) selected @endif>
                                                                {{ $company->name }}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                            </div>

                                            <div class="form-group col-sm-3">
                                                <label>Company Location<span class="text-danger">*</span></label>
                                                <select name="location_id" class="form-control selectpicker"
                                                    data-container="body" data-live-search="true" title="Choose Company">

                                                    @isset($data)
                                                        @foreach ($data['company_branch'] as $comp_branch)
                                                            <option value="{{ $comp_branch->id }}"
                                                                @if ($employeeData->location_id == $comp_branch->id) selected @endif>
                                                                {{ $comp_branch->branch_name }}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                            </div>

                                            <div class="form-group col-sm-3">
                                                <label>Departments <span class="text-danger">*</span></label>
                                                <select class="form-control selectpicker" data-container="body"
                                                    data-live-search="true" name="dept_id" id="showDept" data-container="body"
                                                    data-live-search="true">
                                                    <option value="">Choose Department</option>
                                                    @isset($data)
                                                        @foreach ($data['department'] as $dept)
                                                            <option value="{{ $dept->id }}"
                                                                @if ($employeeData->dept_id == $dept->id) selected @endif>
                                                                {{ $dept->departments }}</option>
                                                        @endforeach
                                                    @endisset

                                                </select>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label>Designation <span class="text-danger">*</span></label>
                                                <select class="form-control selectpicker" data-container="body"
                                                    data-live-search="true" id="showDesig" name="designation"
                                                    data-container="body" data-live-search="true">
                                                    <option value="">Choose Designation</option>
                                                    @isset($data)
                                                        @foreach ($data['desig'] as $designation)
                                                            <option value="{{ $designation->id }}"
                                                                @if ($employeeData->desg_id == $designation->id) selected @endif>
                                                                {{ $designation->desig_name }}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <input type="hidden" name="hidden_emp_id" value="{{ $employeeData->id }}">
                                            <div class="form-group col-md-3 col-sm-4">
                                                <label>Employee ID <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="employee_ID"
                                                    placeholder="employee_ID" value="{{ $employeeData->emp_id }}">
                                            </div>
                                            <div class="form-group col-md-3 col-sm-4">
                                                <label>Name <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="name" placeholder="Name"
                                                    required value="{{ $employeeData->name }}">
                                            </div>
                                            <div class="form-group col-md-3 col-sm-4">
                                                <label>Email <span class="text-danger">*</span></label>
                                                <input class="form-control" type="email" name="email" placeholder="Email"
                                                    required value="{{ $employeeData->email }}">
                                            </div>
                                            <div class="form-group col-md-3 col-sm-4">
                                                <label>Father Name <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="father_name"
                                                    placeholder="Father Name" required
                                                    value="{{ $employeeData->father_name }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label>CNIC <span class="text-danger">*</span></label>
                                                <input class="form-control" type="number" name="cnic" placeholder="CNIC"
                                                    required value="{{ $employeeData->cnic }}">
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label>Phone <span class="text-danger">*</span></label>
                                                <input class="form-control" type="number" name="phone"
                                                    placeholder="Phone" required value="{{ $employeeData->phone }}">
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label>DOB <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="dob" required
                                                    value="{{ $employeeData->dob }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label>Marital Status <span class="text-danger">*</span></label>
                                                <select class="select" name="marital_status" id="marital_status" required>
                                                    <option value="">Choose Status</option>
                                                    <option value="married" <?php
                                                    if ($employeeData->marital_status == 'married') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Married</option>
                                                    <option value="un_married" <?php
                                                    if ($employeeData->marital_status == 'un_married') {
                                                        echo 'selected';
                                                    }
                                                    ?>>UnMarried</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Probation Period <span class="text-danger">*</span></label>
                                                <input class="form-control" type="number" name="prob"
                                                    placeholder="Probation Period In Month" required
                                                    value="{{ $employeeData->prob_period }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label>Grade <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="grade"
                                                    placeholder="Grade" required value="{{ $employeeData->grade }}">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Nationality <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="nationality"
                                                    placeholder="Nationality" required
                                                    value="{{ $employeeData->nationality }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label>Gross Salary <span class="text-danger">*</span></label>
                                                <input class="form-control" type="number" name="salary"
                                                    placeholder="Gross Salary" required
                                                    value="{{ $employeeData->gross_salary }}">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Date Of Joining <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="doj" required
                                                    value="{{ $employeeData->doj }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label>Bank Name <span class="text-danger"></span></label>
                                                <select class="select" name="bank_id" required>
                                                    <option value="1" <?php
                                                    if ($employeeData->bank_id == 1) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Choose Bank</option>
                                                    <option value="2" <?php
                                                    if ($employeeData->bank_id == 2) {
                                                        echo 'selected';
                                                    }
                                                    ?>>HBL</option>
                                                    <option value="3" <?php
                                                    if ($employeeData->bank_id == 3) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Bank Al Habib</option>
                                                    <option value="4" <?php
                                                    if ($employeeData->bank_id == 4) {
                                                        echo 'selected';
                                                    }
                                                    ?>>MCB</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Account# <span class="text-danger"></span></label>
                                                <input class="form-control" type="number" name="bank_ac_no" required
                                                    placeholder="Bank Ac number" value="{{ $employeeData->bank_ac_no }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endisset
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Qualification Details</h4>
                            </div>
                            @isset($data['qualification'])
                                @foreach ($data['qualification'] as $qua)
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Qualification</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Qualification" name="qualification" required
                                                            value="{{ $qua->qualification }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Institute</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" name="institute"
                                                            placeholder="Institute" required value="{{ $qua->institute }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">From</label>
                                                    <div class="col-lg-9">
                                                        <input type="date" class="form-control" name="from"
                                                            placeholder="From" required value="{{ $qua->from }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">To</label>
                                                    <div class="col-lg-9">
                                                        <input type="date" class="form-control" name="to"
                                                            placeholder="To" required value="{{ $qua->to }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Devision/CGPA</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Devision/CGPA" name="cgpa" required
                                                            value="{{ $qua->cgpa }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Attachment</label>
                                                    <div class="col-lg-6">
                                                        <input type="file" class="form-control" name="attachment_edu">
                                                        
                                                    </div>
                                                    <div class="col-md-3">
                                                        <img src="{{ asset('storage/app/public/uploads/education/' . $qua->attachment) }}"
                                                            width="50" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            @endisset
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Professional Certifications</h4>
                            </div>
                            <div class="card-body">
                                @isset($data['certification'])
                                    @foreach ($data['certification'] as $cer)
                                        <div class="row">
                                            <div class="col-xl-3">
                                                <div class="form-group row">
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" placeholder="Course Title"
                                                            name="course_title" required value="{{ $cer->course_title }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group row">
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" name="exp_organization"
                                                            placeholder="organization" required
                                                            value="{{ $cer->orgnazations }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group row">
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" name="period"
                                                            placeholder="Duration Period" required
                                                            value="{{ $cer->duration_period }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group row">
                                                    <div class="col-lg-8">
                                                        <input type="file" class="form-control" name="attachment_cer">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <img src="{{ asset('storage/app/public/uploads/certification/' . $cer->attachment ?? '') }}"
                                                            width="50" height="50px" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endisset
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Employment Experience</h4>
                            </div>
                            @isset($data['experience'])
                                @foreach ($data['experience'] as $exp)
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label>Position <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="position"
                                                    placeholder="Position" required value="{{ $exp->position }}">
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label>Skills <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="skill"
                                                    placeholder="Skills" required value="{{ $exp->skills }}">
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label>Organization <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="relevent_exp_organization"
                                                    placeholder="Organization" required value="{{ $exp->organization }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label>Start Date <span class="text-danger">*</span></label>
                                                <input class="form-control" type="date" name="start_date"
                                                    placeholder="Start Date" required value="{{ $exp->start_date }}">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>End Date <span class="text-danger">*</span></label>
                                                <input class="form-control" type="date" name="end_date"
                                                    placeholder="End Date" required value="{{ $exp->end_date }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-3">
                                                <label>Annual Duration <span class="text-danger">*</span></label>
                                                <input class="form-control" type="number" name="annual_duartion"
                                                    placeholder="Annual Duration In Years" required
                                                    value="{{ $exp->annual_duration }}">
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label>Relevant Experience <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="relevent_exp"
                                                    placeholder="End Date" required value="{{ $exp->exp }}">
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label>Attachment <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="attachment_exp">
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <img src="{{ asset('storage/app/public/uploads/experience/' . $exp->attachment) }}"
                                                    class="mt-4" width="50" alt="">
                                            </div>
                                        </div>
                                        
                                    </div>
                                @endforeach
                            @endisset
                            
                                        <div class="row mt-4">
                                            <div class="text-center w-100">
                                                <button class="btn add-btn" type="submit">Save Changes</button>
                                            </div>
                                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type='text/javascript'>
        $(document).ready(function() {


            //company_id
            // $('select[name=company_id]').change(function(){
            var company_id = $('select[name=company_id]').val();


            $.ajax({

                type: 'ajax',

                method: 'get',

                url: '{{ url('/getDeptRespectToCompany') }}',

                data: {
                    company_id: company_id
                },

                async: false,

                dataType: 'json',

                success: function(data) {


                    var html = '<option value=""> Choose Dept</option>';

                    var i;
                    if (data.length > 0) {

                        for (i = 0; i < data.length; i++) {

                            html += '<option value="' + data[i].id + '">' + data[i].departments +
                                '</option>';

                        }
                    } else {
                        var html = '<option value="">Choose Dept</option>';
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

            url: '{{ url('/getDesignations') }}',

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

                        html += '<option value="' + data[i].id + '">' + data[i].desig_name +
                            '</option>';

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





        })
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script>
        @if (count($errors) > 0)

            @foreach ($errors->all() as $error)

                toastr.error("{{ $error }}");
            @endforeach
        @endif


        @if (Session::has('success'))
            toastr.success("Record save updated successfully!");
            window.location.href = "{{ url('employees') }}";
        @endif
    </script>
@endsection
