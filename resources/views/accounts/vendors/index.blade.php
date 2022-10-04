@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <style>
            #right_side {
                background-color: #f7f7f7;
                padding: 25px 8px;
            }
            .search {
                border-radius: 30px;
            }
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
        <div class="content">
            <!-- Page Header -->
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Add Vendor</h3>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <h3 class="page-title">Vendor List</h3>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <!-- /Page Content -->
            <div class="card" id="mainCard">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <form action="{{url('save-vendor')}}" method="POST" id="Add_Vendor_Form" class="needs-validation" novalidate enctype="multipart/form-data">
@csrf

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Vendor Group</label>
                                                <select name="v_group" id="" class="form-control">
                                                    <option value="">choose one</option>
                                                    <option value="1" selected>Main Dealer</option>
                                                    <option value="2">Sub Dealer</option>

                                                </select>
                                                <div class="invalid-feedback">
                                                    Please Enter CLient City.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for=""> Name</label>
                                                <input type="text" name="name" class="form-control" placeholder="Vendor Name" required>
                                                <div class="invalid-feedback">
                                                    Please Enter Name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for=""> Email</label>
                                                <input type="email" name="email" class="form-control" placeholder="Vendor Email" >
                                                <div class="invalid-feedback">
                                                    Please Enter Email.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for=""> F-P Name</label>
                                                <input type="text" name="fp_name" class="form-control" placeholder="Focal Person Name" required>
                                                <div class="invalid-feedback">
                                                    Please F-P Name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for=""> Contact</label>
                                                <input type="number" name="contact" autocomplete="off" id="contact" class="form-control" placeholder="Vendor Contact" required>
                                                <div id="show_error"></div>
                                                <div class="invalid-feedback">
                                                    Please Enter Contact.
                                                </div>
                                            </div>
                                        </div>

{{--                                        --}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for=""> City</label>--}}
{{--                                                <input type="text" name="city" class="form-control" placeholder="Vendor City" required>--}}
{{--                                                <div class="invalid-feedback">--}}
{{--                                                    Please Enter City.--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Open Balance</label>
                                                <input type="number" name="open_bal" class="form-control" placeholder="Open Balance" required>
                                                <div class="invalid-feedback">
                                                    Please Enter Open Balance.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Balance Type</label>
                                                <select name="bal_type" id="" class="form-control">
                                                    <option value="cr">Credit</option>
                                                    <option value="dr">Debit</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Please Enter Open Balance.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Address</label>
                                                <input class="form-control" type="text" name="address" id="autocomplete" >
                                                <div class="invalid-feedback">
                                                    Please Enter Address.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 ">
                                            <div class="submit-section">
                                                <button type="submit" class="btn btn-primary submit-btn add_vendor">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-6 col-md-6" id="right_side">
                                <input type="text" class="form-control search" id="search" autocomplete="off" placeholder="search...">
                                <div class="row mt-4">
                                    @isset($data['vendor'])
                                        @foreach($data['vendor'] as $ven)
                                            <div class="col-md-6" id="card-search">
                                                <a href="{{ url('vendor-detail/'.$ven->id) }}">
                                                    <div class="card">
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <img src="{{ asset('storage/app/public/uploads/accounts/vendor/users.png') }}" class="rounded img-fluid">
                                                            </div>
                                                            <div class="col-md-9">
                                                                <h5 class="text-dark">{{ $ven->name }}</h5>
{{--                                                                <h6 class="text-secondary">{{ $ven->email }}</h6>--}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    @endisset
                                </div>
                                <div class="float-right">
                                    {{ $data['vendor']->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            //Add Vendor
            $('#Add_Vendor_Form').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData($('#Add_Vendor_Form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('save-vendor') }}",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if (response.status == 200) {
                            $('#Add_Vendor_Form').find('input').html("");
                            $('#Add_Vendor_Form')[0].reset();
                            window.location.reload();
                            toastr.success(response.message);
                        }
                        if(response.error){
                            toastr.error(response.error);
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                    },
                });

            });

            //validation for contact
            var minLength = 11;
            var maxLength = 11;
            $('#contact').on('keydown keyup change', function() {
                var char = $(this).val();
                var charLength = $(this).val().length;
                if (charLength < minLength) {
                    $('#show_error').html('Length is short minimum ' + minLength);
                    $('#show_error').css('color', 'red');
                } else if (charLength > maxLength) {
                    $('#show_error').html('Length is not valid maximum ' + maxLength + ' allowed.');
                    $('#show_error').css('color', 'red');
                    $(this).val(char.substring(0, maxLength));
                } else {
                    $('#show_error').html('');
                }
            });


            //search
            $('#search').keyup(function(e) {
                search_table($(this).val());
            });

            function search_table(value) {
                $('#mainCard #card-search').each(function() {
                    var found = 'false';
                    $(this).each(function() {
                        if ($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0) {
                            found = 'true';
                        }
                    });
                    if (found == 'true') {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }

        });
    </script>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyAB6y4kRx41p5krahkuc_dT2n5HJJwQP7w&amp;libraries=places&amp;callback=initAutocomplete" type="text/javascript"></script>
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
