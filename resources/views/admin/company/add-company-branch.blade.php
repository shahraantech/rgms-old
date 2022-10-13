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
                        <h3 class="page-title">Company Branch</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Company Branch</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ url('company-branches') }}" class="btn add-btn" title="Company List"><i
                                class="fa fa-list"></i></a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-body">
                        <form method="post" action="{{ url('add-company-branch') }}" id="BranchForm"
                            class="needs-validation" novalidate enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Company <span class="text-danger">*</span></label>
                                        <select name="company_id" id="" class="form-control" required>
                                            <option value="">Choose One</option>
                                            @isset($data)
                                                @foreach ($data['company'] as $row)
                                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Branch<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="branch_name"
                                            placeholder="Branch Name" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>F-Person<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="f_person"
                                            placeholder="Focal Person" required>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone<span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="phone" placeholder="Phone"
                                            required>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Branch Address<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="address" id="autocomplete"
                                            required>

                                        <input type="hidden" id="latitude" name="lat">
                                        <input type="hidden" id="longitude" name="lang">
                                    </div>
                                </div>


                                <div class="submit-section">

                                    <input type="submit" class="btn btn-primary btnSubmit" value="Save">

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>


    <script>
        $(document).ready(function() {

            $('#BranchForm').validate({

                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });


            $('#BranchForm').unbind().on('submit', function(e) {
                e.preventDefault();

                var $form = $(this);
                // check if the input is valid
                if (!$form.validate().form()) return false;

                var formData = $('#BranchForm').serialize();

                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{ url('add-company-branch') }}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {

                        $(".btnSubmit").prop("disabled", true);
                        $(".btnSubmit").val("processing...");

                    },
                    success: function(data) {

                        if (data.success) {
                            $('#BranchForm')[0].reset();
                            toastr.success(data.success);
                            $(".btnSubmit").prop("disabled", false);
                            $(".btnSubmit").val("Save");
                        }
                        if (data.errors) {
                            toastr.error(data.errors);
                            $(".btnSubmit").prop("disabled", false);
                            $(".btnSubmit").val("Save");
                        }
                    },

                    complete: function(data) {
                        $(".btnSubmit").prop("disabled", false);
                        $(".btnSubmit").val("Save");
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $(".btnSubmit").prop("disabled", false);
                        $(".btnSubmit").val("Save");
                    },

                });


            });

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
