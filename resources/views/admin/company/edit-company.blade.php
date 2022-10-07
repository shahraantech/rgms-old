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
                    <h3 class="page-title">Edit Company</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Company </li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{url('company')}}" class="btn add-btn" title="Company List"><i class="fa fa-list"></i></a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body">
                    <form method="POST" action="{{ url('update-company/'.$comp->id) }}" id="addCompanyForm" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Company Name<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="company_name" value="{{ $comp->name }}" placeholder="Company Name" required>
                                    <div class="invalid-feedback">
                                        Please Enter Company Name.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Working Hrs<span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="working_days" value="{{ $comp->working_days }}" placeholder="Working Hrs" required>
                                    <div class="invalid-feedback">
                                        Please Enter Working Hrs.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Monthly Leaves<span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="allow_holidays" value="{{ $comp->allow_holidays }}" placeholder="Monthly Leaves" required>
                                    <div class="invalid-feedback">
                                        Please Enter Monthly Leaves.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Company Address<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="address" value="{{ $comp->address }}" id="autocomplete" required>

                                    <input type="hidden" id="latitude" name="lat" value="{{ $comp->lat }}">
                                    <input type="hidden" id="longitude" name="lang" value="{{ $comp->lang }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Company Favicon <span class="text-danger">*</span></label>
                                    <input class="form-control" type="file" name="favicon" id="favicon">
                                    <img src="{{ asset('storage/app/public/uploads/company-assets/'.$comp->favicon) }}" class="mt-3" width="50px" alt="">
                                    <div class="invalid-feedback">
                                        Please Enter Company Favicon.
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Company Logo <span class="text-danger">*</span></label>
                                    <input class="form-control" type="file" name="logo" id="logo">
                                    <img src="{{ asset('storage/app/public/uploads/company-assets/'.$comp->logo) }}" class="mt-3" width="50px" alt="">
                                    <div class="invalid-feedback">
                                        Please Enter Comapny Logo.
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="submit-section">
                                    <button class="btn btn-primary company_update" type="submit">Save Changes</button>
                                </div>
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


    })
</script>

<script src="https://maps.google.com/maps/api/js?key=AIzaSyAY904LGu2DEpfjOloBWBtPof8Zx8e6gyQ&libraries=places&callback=initAutocomplete"></script>

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


    $('.company_update').on('click', function() {
        $(".company_update").prop("disabled", true);
        $(".company_update").html("Please wait...");
        $('#addCompanyForm').submit();
    });

</script>
@endsection