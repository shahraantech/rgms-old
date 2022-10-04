@extends('setup.master')
@section('content')
<style>
    * {
        box-sizing: border-box;
    }

    body {
        background-color: #f1f1f1;
    }

    #regForm1 {
        background-color: #ffffff;
        margin: 100px auto;
        font-family: Raleway;
        padding: 40px;
        width: 70%;
        min-width: 300px;
    }

    h1 {
        text-align: center;
    }

    input {
        padding: 10px;
        width: 100%;
        font-size: 17px;
        font-family: Raleway;
        border: 1px solid #aaaaaa;
    }

    /* Mark input boxes that gets an error on validation: */
    input.invalid {
        background-color: #ffdddd;
    }

    select.invalid {
        background-color: #ffdddd;
    }

    /* Hide all steps by default: */
    .tab {
        display: none;
    }

    button {
        background-color: #04AA6D;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        font-size: 17px;
        font-family: Raleway;
        cursor: pointer;
    }

    button:hover {
        opacity: 0.8;
    }

    #prevBtn {
        background-color: #bbbbbb;
    }

    /* Make circles that indicate the steps of the form: */
    .step {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.5;
    }

    .step.active {
        opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step.finish {
        background-color: #04AA6D;
    }
</style>
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Add Employee Record</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add Employee Record</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{url('/employees')}}" class="btn add-btn">Employees List</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-lg-12">

                <form method="post" action="{{url("new-employee")}}" class="needs-validation" novalidate id="regForm" enctype="multipart/form-data">
                    @csrf
                    <div class="card tab">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Personal Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Company <span class="text-danger">*</span></label>
                                    <select name="company_id" class="form-control company_id" required>
                                        <option value="">Choose Company</option>

                                        @isset($data)
                                        @foreach($data['companies'] as $company)
                                        <option value="{{$company->id}}">{{$company->name}}</option>
                                        @endforeach
                                        @endisset
                                    </select>
                                    <div class="invalid-feedback">
                                        Please choose Company.
                                    </div>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label>Location <span class="text-danger">*</span></label>
                                    <select class="form-control" name="location_id" id="showLocations" required>
                                        <option value="">Choose Location</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please choose company location.
                                    </div>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label>Departments <span class="text-danger">*</span></label>
                                    <select class="form-control " name="dept_name" id="showDept" required>
                                        <option value="">Choose Department</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please choose departments.
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Designation <span class="text-danger">*</span></label>
                                    <select class="form-control
                                     select" id="showDesig" name="designation" data-container="body" data-live-search="true" required>
                                        <option value="">Choose Designation</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please choose designation.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-3 col-sm-4">
                                    <label>Employee ID <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="employee_ID" placeholder="Employee ID">
                                </div>
                                <div class="form-group col-md-3 col-sm-4">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="name" placeholder="Name" required>
                                </div>
                                <div class="form-group col-md-3 col-sm-4">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email" placeholder="Email" required>
                                </div>
                                <div class="form-group col-md-3 col-sm-4">
                                    <label>Father Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="father_name" placeholder="Father Name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label>CNIC <span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="cnic" placeholder="CNIC" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="phone" placeholder="Phone" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>DOB <span class="text-danger">*</span></label>
                                    <div class="cal-"> <input class="form-control " type="date" name="dob" required></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Marital Status <span class="text-danger">*</span></label>
                                    <select class="form-control " name="marital_status" id="marital_status" required>
                                        <option value="">Choose Status</option>
                                        <option value="married">Married</option>
                                        <option value="un_married">UnMarried</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please choose marital status.
                                    </div>

                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Probation Period <span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="prob" placeholder="Probation Period In Month" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Grade <span class="text-danger">*</span></label>
                                    <select class="select" name="grade" required>
                                        <option value="">Choose Grade</option>
                                        @isset($data['grades'])
                                        @foreach($data['grades'] as $grade)
                                        <option value="{{$grade->id}}">{{$grade->grade}}</option>
                                        @endforeach
                                        @endisset
                                    </select>
                                    <div class="invalid-feedback">
                                        Please choose grade.
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Nationality <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="nationality" placeholder="Nationality" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Basic Salary <span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="salary" placeholder="Gross Salary" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Date Of Joining <span class="text-danger">*</span></label>
                                    <div class="cal-"> <input class="form-control " type="date" name="doj" required></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Bank Name <span class="text-danger"></span></label>
                                    <select class="form-control " name="bank_id">
                                        <option value="1">Choose Bank</option>
                                        <option value="2">HBL</option>
                                        <option value="3">Bank Al Habib</option>
                                        <option value="4">Meezan</option>
                                        <option value="4">MCB</option>
                                        <option value="4">Islami Bank</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Account# <span class="text-danger"></span></label>
                                    <input class="form-control" type="number" name="bank_ac_no" placeholder="Bank Ac number">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Image<span class="text-danger">*</span></label>
                                    <input type="file" name="file" class="form-control" onchange="previewFile(this);">
                                </div>
                                <div class="col-sm-6" style="visibility: hidden" id="imagePreviewDiv">
                                    <div class="form-group">
                                        <img id="previewImg" style="height: 150px" width="150px;" class="img img-thumbnail">
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>

                        </div>
                    </div>
                </form>



                    <div class="card tab">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Qualification Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Qualification</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" placeholder="Qualification" name="qualification" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Institute</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="institute" placeholder="Institute" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">From</label>
                                        <div class="col-lg-9">
                                            <input type="date" class="form-control" name="from" placeholder="From" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">To</label>
                                        <div class="col-lg-9">
                                            <input type="date" class="form-control" name="to" placeholder="To" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Devision/CGPA</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" placeholder="Devision/CGPA" name="cgpa" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card tab">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Professional Certifications</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="form-group row">
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" placeholder="Course Title" name="course_title" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group row">
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="exp_organization" placeholder="organization" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group row">
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="period" placeholder="Duration Period" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card tab">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Employment Experience</h4>
                        </div>


                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label>Position <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="position" placeholder="Position" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Skills <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="skill" placeholder="Skills" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Organization <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="relevent_exp_organization" placeholder="Organization" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Start Date <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" name="start_date" placeholder="Start Date" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>End Date <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" name="end_date" placeholder="End Date" required>
                                </div>
                            </div>


                            <div class="row">

                                <div class="form-group col-sm-6">
                                    <label>Annual Duration <span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="annual_duartion" placeholder="Annual Duration In Years" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Relevant Experience <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="relevent_exp" placeholder="Experience" required>
                                </div>
                            </div>
                        </div>
                    </div>




                    {{-- <div style="overflow:auto;" class="btn-group-div">
                        <div style="float:right;">
                            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                        </div>
                    </div>
                    <center style="none" id="loader">
                        <img class="img img-circle" src=public/assets/img/loader/loader.gif />
                    </center>
                    <div style="text-align:center;margin-top:40px;">
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                    </div> --}}


            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type='text/javascript'>
    $(document).ready(function() {


        //company_id dependent dropdown
        $('.company_id').change(function() {

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


        //get location on the base of company
        $('.company_id').change(function() {

            var company_id = $('select[name=company_id]').val();

            $.ajax({

                type: 'ajax',

                method: 'get',

                url: '{{url("/getLocationOnTheBaseOfCompany")}}',

                data: {
                    company_id: company_id
                },

                async: false,

                dataType: 'json',

                success: function(data) {

                    var html = '<option value="">Choose Location</option>';

                    var i;
                    if (data.length > 0) {

                        for (i = 0; i < data.length; i++) {

                            html += '<option value="' + data[i].id + '">' + data[i].branch_name + '</option>';
                        }
                    } else {
                        var html = '<option value="">Choose Department</option>';
                        toastr.error('data not found');
                    }


                    $('#showLocations').html(html);

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


        // $('#regForm').unbind().on('submit', function(e) {
        //     e.preventDefault();
        //     alert('from submited');
        // })


    })
</script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>


<script>
    @if(count($errors) > 0)

    @foreach($errors-> all() as $error)

    toastr.error("{{ $error }}");
    @endforeach
    @endif


    @if(Session::has('success'))
    toastr.success("Record save successfully!");

    @endif
</script>


<script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {

        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";

        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Submit";
        } else {
            document.getElementById("nextBtn").innerHTML = "Next";
        }

        fixStepIndicator(n)
    }

    function nextPrev(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form...
        if (currentTab >= x.length) {

            document.getElementById("regForm").submit();
            $('.btn-group-div').hide();
            $("#loader").css("display", "block");
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
    }

    function validateForm() {
        // This function deals with validation of the form fields
        var x, y, i, valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");
        // A loop that checks every input field in the current tab:
        for (i = 0; i < y.length; i++) {
            // If a field is empty...
            if (y[i].value == "") {
                // add an "invalid" class to the field:
                y[i].className += " invalid";
                // and set the current valid status to false
                valid = false;
            }
        }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid; // return the valid status
    }

    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class on the current step:
        x[n].className += " active";
    }
</script>
<script>
    function previewFile(input) {

        $("#imagePreviewDiv").css('visibility', 'visible');
        var file = $("input[type=file]").get(0).files[0];

        if (file) {
            var reader = new FileReader();

            reader.onload = function() {
                $("#previewImg").attr("src", reader.result);
            }

            reader.readAsDataURL(file);

        }
    }
</script>
@endsection
