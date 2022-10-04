@extends('setup.master')
@section('content')
    <style type="text/css">
        body
        {
            font-family: Arial;
            font-size: 10pt;
        }
        table
        {
            border: 1px solid #ccc;
            border-collapse: collapse;
        }
        table th
        {
            background-color: #F7F7F7;
            color: #333;
            font-weight: bold;
        }
        table th, table td
        {
            padding: 5px;
            border: 1px solid #ccc;
        }
    </style>
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Customer Form</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Customer Form</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{url('/walkin-customer-list')}}" class="btn add-btn" title="Banks List"><i class="fa fa-list" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="card">


                <form method="post" action="{{url("walkin-customer")}}" class="needs-validation" novalidate id="CustomerForm" enctype="multipart/form-data">
                    @csrf

                    <div class="card tab">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Personal Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" placeholder=" Name"
                                               required>
                                        <div class="invalid-feedback">
                                            Please enter name.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="contact"
                                               placeholder="92-333-4636416" required>
                                        <div class="invalid-feedback">
                                            Please enter contact.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City <span class="text-danger">*</span></label>

                                        <select class="form-control selectpicker" data-container="body" data-live-search="true" name="city_id" required>
                                            <option value="">Choose City</option>
                                            @isset($data)
                                                @foreach ($data['city'] as $city)
                                                    <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <div class="invalid-feedback">
                                            Please choose city.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="display: none">
                                    <div class="form-group">
                                        <label>Lead Type<span class="text-danger">*</span></label>
                                        <select class="select" name="lead_type" required>
                                            <option value="">Choose Leed Type</option>
                                            <option value="outbound">Outbound</option>
                                            <option value="inbound" selected>Inbound</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please enter Source.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Source<span class="text-danger">*</span></label>

                                        <select class="select" name="source_id" required>
                                            <option value="">Choose Source</option>
                                            @isset($data)
                                                @foreach ($data['platforms'] as $platforms)
                                                    <option value="{{ $platforms->id }}"
                                                    <?php
                                                        if($platforms->id==5){
                                                            echo "selected";
                                                        }
                                                        ?>
                                                    >{{ $platforms->platform }}
                                                    </option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <div class="invalid-feedback">
                                            Please enter Source.
                                        </div>
                                    </div>
                                </div>

                            </div>



                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-submit">Save</button>
                            </div>

                        </div>
                    </div>
                </form>




            </div>
        </div>
        <!-- /Page Content -->
    </div>




    <script>
        $('.btn-submit').on('click', function() {
            $(".btn-submit").prop("disabled", true);
            $(".btn-submit").html("Please wait...");
            $('#CustomerForm').submit();
        });
    </script>

@endsection
