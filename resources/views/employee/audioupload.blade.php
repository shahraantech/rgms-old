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
                        <h3 class="page-title"> Audio Upload</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"> Audio Upload</li>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-lg-12">
                    <form method="post" action="{{ url('add-audio-upload') }}" class="needs-validation" novalidate
                        id="regForm" enctype="multipart/form-data">
                        @csrf
                        <div class="card tab">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Personal Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>Audio <span class="text-danger">*</span></label>
                                        <input name="file" type="file" class="form-control audio" required>



                                    </div>

                                </div>
                                <button type="submit" class=" btn btn-success">Save</button>

                            </div>
                        </div>
                        @foreach ($audio as $val)
                            <audio controls>
                                <source src="data:audio/mpeg;base64,{{ $val->audio }}">
                                The “audio” tag is not supported by your browser.
                            </audio>
                        @endforeach
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

                                url: '{{ url('/getDeptRespectToCompany') }}',

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

                                            html += '<option value="' + data[i].id + '">' + data[i]
                                                .departments + '</option>';
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

                                url: '{{ url('/getLocationOnTheBaseOfCompany') }}',

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

                                            html += '<option value="' + data[i].id + '">' + data[i]
                                                .branch_name + '</option>';
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

                                            html += '<option value="' + data[i].id + '">' + data[i]
                                                .desig_name + '</option>';

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
                    @if (count($errors) > 0)

                        @foreach ($errors->all() as $error)

                            toastr.error("{{ $error }}");
                        @endforeach
                    @endif


                    @if (Session::has('success'))
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
