@extends('setup.master')

@section('content')

<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content">
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
        <!-- Page Header -->
        <div class="page-header my-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Add Customer</h3>
                </div>
                <div class="col-auto float-right ml-auto">
                    <h3 class="page-title">Customers List</h3>
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

                            <form action="{{url('save-clients')}}" method="POST" id="Add_Clients_Form" class="needs-validation" novalidate enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> Name</label>
                                            <input type="text" name="name" class="form-control" placeholder="Cleint Name" required>
                                            <div class="invalid-feedback">
                                                Please Enter Client Name.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> Email</label>
                                            <input type="email" name="email" class="form-control" placeholder="Cleint Email">
                                            <div class="invalid-feedback">
                                                Please Enter Cleint Email.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> CNIC</label>
                                            <input type="number" name="cnic" class="form-control" placeholder="Cleint CNIC">
                                            <div class="invalid-feedback">
                                                Please Enter Cleint CNIC.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> Contact</label>
                                            <input type="number" name="contact" autocomplete="off" id="contact" class="form-control" placeholder="Cleint Contact" required>
                                            <div id="show_error"></div>
                                            <div class="invalid-feedback">
                                                Please Enter Client Contact.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> City</label>
                                            <input type="text" name="city" class="form-control" placeholder="Cleint City" required>
                                            <div class="invalid-feedback">
                                                Please Enter CLient City.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> Customer Group</label>
                                            <select name="c_group" id="" class="form-control">
                                                <option value="">choose one</option>
                                                <option value="1">Walk In</option>
                                                <option value="2">Sub Dealers</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please Enter CLient City.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Open Balance</label>
                                            <input type="number" name="open_bal" class="form-control" placeholder="Open Balance" required>
                                            <div class="invalid-feedback">
                                                Please Enter Cleint Open Balance.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Balance Type</label>
                                            <select name="bal_type" id="" class="form-control">
                                                <option value="cr">Credit</option>
                                                <option value="dr">Dedit</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please Enter Open Balance.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 ">
                                        <div class="submit-section">
                                            <button type="submit" class="btn btn-primary submit-btn add_cleint">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-6 col-md-6" id="right_side">

                            <input type="text" class="form-control search" id="search" autocomplete="off" placeholder="search...">

                            <div class="row mt-4">
                                @isset($data['clients'])
                                @foreach($data['clients'] as $cleint)
                                <div class="col-md-6" id="search-card">
                                    <a href="{{ url('client_detail/'.$cleint->id) }}">
                                        <div class="card">
                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <img src="{{ asset('storage/app/public/uploads/accounts/clients/users.png') }}" class="rounded img-fluid">
                                                </div>
                                                <div class="col-md-9">
                                                    <h5 class="text-dark">{{ $cleint->name }}</h5>
                                                    <h6 class="text-secondary">{{ $cleint->email }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                                @endisset
                            </div>
                            <div class="float-right">
                                {{ $data['clients']->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- CDN for Sweet Alert -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {

        //Add Clients
        $('#Add_Clients_Form').on('submit', function(e) {
            e.preventDefault();
            $('.add_vendor').text('Wait...');

            let formData = new FormData($('#Add_Clients_Form')[0]);
            console.log(formData);

            $.ajax({
                type: "POST",
                url: "{{ url('save-clients') }}",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.status == 200) {
                        $('#Add_Clients_Form')[0].reset();
                        window.location.reload();
                        toastr.success(response.message);
                        $('.add_vendor').text('Submit Now');
                    }

                    if(response.error){
                        toastr.error(response.error);
                    }
                },
                error: function() {
                    $('.add_vendor').text('Save');
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
            $('#mainCard #search-card').each(function() {
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

@endsection
