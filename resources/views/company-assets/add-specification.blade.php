@extends('setup.master')
@section('content')



    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Add Specification</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Specification</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="card">
                <div class="card-body">

                    <form action="{{ url('store-add-specification') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Asset</label>
                                    <select class="select" name="asset_id" required>
                                        <option value="" selected disabled>Choose asset</option>
                                        @isset($specs)
                                            @foreach ($specs as $spec)
                                                <option value="{{ $spec->id }}">{{ $spec->title }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Model</label>
                                    <input class="form-control" type="text" name="model" placeholder="Model"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input class="form-control" type="text" name="price" placeholder="Price"
                                        required>
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

                $('select[name=asset_id]').change(function() {

                    var asset_id = $('select[name=asset_id]').val();

                    $.ajax({
                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('getSpecificationBaseAsset') }}',
                        data: {
                            asset_id: asset_id
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
                                        '<label>' + data[i].specification + '</label>' +
                                        '<input class="form-control" type="hidden" name="specification_id[]" value="' +
                                        data[i].id + '">' +
                                        '<input class="form-control" type="text" name="value[]" placeholder="' +
                                        data[i].specification + '"  required>' +
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
