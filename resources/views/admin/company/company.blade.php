@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <style>
            /* Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            /* Firefox */
            input[type=number] {
                -moz-appearance: textfield;
            }
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Company</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Company Settings</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ url('company') }}" class="btn add-btn" title="Company List"><i
                                class="fa fa-list"></i></a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-body">
                        <form method="post" action="" id="addCompanyForm" class="needs-validation" novalidate
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Company Name<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="company_name"
                                            placeholder="Company Name" required>
                                        <div class="invalid-feedback">
                                            Please Enter Company Name.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Working Hrs<span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="working_days"
                                            placeholder="Working Hrs" required>
                                        <div class="invalid-feedback">
                                            Please Enter Working Hrs.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Monthly Leaves<span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="allow_holidays"
                                            placeholder="Monthly Leaves" required>
                                        <div class="invalid-feedback">
                                            Please Enter Monthly Leaves.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Company Address<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="address" id="autocomplete"
                                            required>

                                        <input type="hidden" id="latitude" name="lat">
                                        <input type="hidden" id="longitude" name="lang">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Company Favicon <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" name="favicon" id="favicon" required
                                            onchange="favPriviewFunction();">
                                        <div class="invalid-feedback">
                                            Please Enter Company Favicon.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">

                                    <div style="display: none" id="favDiv">
                                        <div class="form-group">
                                            <img id="favPreview" style="height: 150px" width="150px;"
                                                class="img img-thumbnail">
                                        </div>
                                    </div>


                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Company Logo <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" name="file" id="logo" required
                                            onchange="previewFile(this);">
                                        <div class="invalid-feedback">
                                            Please Enter Comapny Logo.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">

                                    <div style="display: none" id="logDiv">
                                        <div class="form-group">
                                            <img id="previewLogo" style="height: 150px" width="150px;"
                                                class="img img-thumbnail">
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-section w-100 mt-3">
                                    <button type="submit" class="btn btn-primary pull-right mr-2 btn-company">Save</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
        <!-- Add Department Modal -->
        <!-- /Add Department Modal -->
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        function favPriviewFunction() {

            $("#favDiv").css("display", "block");
            var file = $("input[name=favicon]").get(0).files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function() {
                    $("#favPreview").attr("src", reader.result);
                }
                reader.readAsDataURL(file);

            }
        }

        function previewFile(input) {

            $("#logDiv").css("display", "block");
            var file = $("input[name=file]").get(0).files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function() {
                    $("#previewLogo").attr("src", reader.result);
                }
                reader.readAsDataURL(file);

            }
        }
    </script>

    <script>
        $(document).ready(function() {


            // save company
            $('#addCompanyForm').unbind().on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                let favicon = $('#favicon')[0];
                let logo = $('#logo')[0];

                formData.append('favicon', favicon.files[0]);
                formData.append('file', logo.files[1]);

                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{ url('add-company') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    async: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('.btn-company').text('Saving...');
                        $(".btn-company").prop("disabled", true);
                    },
                    success: function(data) {
                        console.log(data);

                        if (data.errors) {
                            toastr.error(data.errors);
                            $('.btn-company').text('Save');
                            $(".btn-company").prop("disabled", false);
                        }

                        if (data.success) {

                            toastr.success(data.success);
                            var url = '{{ url('company') }}';
                            window.location.href = url;
                            $('.btn-company').text('Save');
                            $(".btn-company").prop("disabled", false);
                        }

                    },

                    error: function() {
                        toastr.error('something went wrong');
                        $('.btn-company').text('Save');
                        $(".btn-company").prop("disabled", false);
                    },

                });
            })
        })
    </script>
    <script
        src="https://maps.google.com/maps/api/js?key=AIzaSyAY904LGu2DEpfjOloBWBtPof8Zx8e6gyQ&libraries=places&callback=initAutocomplete">
    </script>

    <script>
        google.maps.event.addDomListener(window, 'load', initialize);

        function initialize() {
            var input = document.getElementById('autocomplete');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                $('#latitude').val(place.geometry['location'].lat());
                $('#longitude').val(place.geometry['location'].lng());
                // --------- show lat and long ---------------
                $("#lat_area").removeClass("d-none");
                $("#long_area").removeClass("d-none");
            });
        }
    </script>
@endsection
