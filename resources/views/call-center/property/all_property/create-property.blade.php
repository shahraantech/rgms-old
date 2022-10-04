@extends('setup.master')
@section('content')



    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Add Property</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Property</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="card">
                <div class="card-body">

                    <form method="POST" action="{{ url('create-property') }}" class="needs-validation" novalidate
                        id="productForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Property Type</label>
                                    <select class="select" name="property_type_id" required>
                                        <option value="">Choose property type</option>
                                        @isset($data)
                                            @foreach ($data['props'] as $prop)
                                                <option value="{{ $prop->id }}">{{ $prop->type }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" type="text" name="owner_name" placeholder="Owner Name"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Owner Category</label>
                                    <select name="type" class="select" required>
                                        <option value="" selected disabled>Choose type</option>
                                        <option value="Seller">Seller</option>
                                        <option value="Buyer">Buyer</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Property Project</label>
                                    <select class="select" name="project_id" required>
                                        <option value="">Choose property project</option>
                                        @isset($data)
                                            @foreach ($data['project'] as $proj)
                                                <option value="{{ $proj->id }}">{{ $proj->name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Property Category</label>
                                    <select name="property_category" class="select" required>
                                        <option value="" selected disabled>Choose property category</option>
                                        <option value="Residential">Residential</option>
                                        <option value="Commercial">Commercial</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input class="form-control" type="text" name="location" placeholder="Location"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Contact</label>
                                    <input class="form-control" type="number" name="owner_contact"
                                        placeholder="Owner Contact Name" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Property For</label>
                                    <select name="property_for" class="select" required>
                                        <option value="" selected disabled>Choose type</option>
                                        <option value="Sell">Sell</option>
                                        <option value="Purchase">Purchase</option>
                                        <option value="Rent">Rent</option>
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div class="row" id="FeatureSection">
                        </div>

                        <div class="submit-section">
                            <button class="btn btn-primary btn-submit" type="submit">Save</button>
                        </div>
                    </form>

                </div>
            </div>
            <!-- /Page Content -->
        </div>




        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

        <script>
            $(document).ready(function() {

                toastr.options.timeOut = 3000;
                @if (Session::has('error'))
                    toastr.error('{{ Session::get('error') }}');
                @elseif(Session::has('success'))
                    toastr.success('{{ Session::get('success') }}');
                @endif

                $('select[name=property_type_id]').change(function() {

                    var type_id = $('select[name=property_type_id]').val();

                    $.ajax({
                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('get-property-base-variation') }}',
                        data: {
                            type_id: type_id
                        },
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            var html = '';
                            var i;
                            if (data.length > 0) {
                                for (i = 0; i < data.length; i++) {
                                    html += '<div class="col-sm-4">' +
                                        '<div class="form-group">' +
                                        '<label>' + data[i].variation + '</label>' +
                                        '<input class="form-control" type="hidden" name="variation_id[]" value="' +
                                        data[i].id + '">' +
                                        '<input class="form-control" type="text" name="value[]" placeholder="' +
                                        data[i].variation + '"  required>' +
                                        '</div>' +
                                        '</div>';
                                }
                            }
                            $('#FeatureSection').html(html);

                        },

                        error: function() {
                            toastr.error('db error');


                        }

                    });
                });

            });
        </script>
    @endsection
