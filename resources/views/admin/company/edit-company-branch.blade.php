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
                            <li class="breadcrumb-item active">Edit Company Branch</li>
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
                        <form method="POST" action="{{ url('update-company-branches/'.$comp_branch->id) }}"
                            class="needs-validation" novalidate enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Company <span class="text-danger">*</span></label>
                                        <select name="company_id" id="" class="form-control">
                                            <option value="">Choose One</option>
                                            @isset($company)
                                                @foreach ($company as $row)
                                                    <option value="{{ $row->id }}"
                                                    {{ $comp_branch->company_id == $row->id ? 'selected' : '' }}
                                                    >{{ $row->name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <div class="invalid-feedback">
                                            Please Choose Company Name.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Branch<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="branch_name"
                                            placeholder="Branch Name" value="{{ $comp_branch->branch_name }}" required>
                                        <div class="invalid-feedback">
                                            Please Enter Branch Name
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>F-Person<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="f_person"
                                            placeholder="Focal Person" value="{{ $comp_branch->focal_person }}" required>
                                        <div class="invalid-feedback">
                                            Please Enter F-Person Name.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone<span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="phone" value="{{ $comp_branch->contact }}" placeholder="Phone"
                                            required>
                                        <div class="invalid-feedback">
                                            Please Enter Phone.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Branch Address<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" value="{{ $comp_branch->address }}" name="address" id="autocomplete"
                                            required>

                                        <input type="hidden" id="latitude" name="lat">
                                        <input type="hidden" id="longitude" name="lang">
                                    </div>
                                </div>


                                <div class="submit-section text-center w-100">

                                    <button type="submit" class="btn btn-primary btnSubmit">Update</button>

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
        $(document).ready(function() {


            toastr.options.timeOut = 3000;
                @if (Session::has('error'))
                    toastr.error('{{ Session::get('error') }}');
                @elseif (Session::has('success'))
                    toastr.success('{{ Session::get('success') }}');
                @endif

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
