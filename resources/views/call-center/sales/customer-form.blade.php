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

                </div>
            </div>
            <div class="card">


                <form method="post" action="{{url("save-customer-form")}}" class="needs-validation" novalidate id="CustomerForm" enctype="multipart/form-data">
                    @csrf

                    <div class="card tab">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Personal Information</h4>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="lead_id" value="{{$data['lead_id']}}">
                            <div class="row">
                                <div class="form-group col-md-4 col-sm-4">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="name" placeholder="Name" value="{{!empty($data['leadInfo'])?$data['leadInfo']->name:''}}" required>
                                </div>
                                <div class="form-group col-md-4 col-sm-4">
                                    <label>F-Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="f_name" placeholder="Father Name" required>
                                </div>
                                <div class="form-group col-md-4 col-sm-4">
                                    <label>CNIC <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="cnic" placeholder="CNIC" required>
                                </div>
                                <div class="form-group col-md-4 col-sm-4">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email" placeholder="Email"   value="{{!empty($data['leadInfo'])?$data['leadInfo']->email:''}}" required>
                                </div>
                                <div class="form-group col-md-4 col-sm-4">
                                    <label>Contact <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="contact" placeholder="Contact"   value="{{!empty($data['leadInfo'])?$data['leadInfo']->contact:''}}" required>
                                </div>
                                <div class="form-group col-md-4 col-sm-4">
                                    <label>City <span class="text-danger">*</span></label>
                                    <select name="city_id" class="form-control selectpicker"
                                            data-container="body" data-live-search="true" required>
                                        <option value="" selected>Choose City</option>
                                        @isset($data)
                                            @foreach ($data['city'] as $city)
                                                <option value="{{ $city->id }}"
                                                <?php
                                                if($city->id== $data['leadInfo']->city_id){
                                                    echo "selected";
                                                }
                                                ?>
                                                >{{ $city->city_name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="row">

                                <div class="form-group col-sm-4">
                                    <label>Project<span class="text-danger">*</span></label>
                                    <select name="project_id" class="selectpicker form-control"  required>
                                        <option value="">Choose One</option>
                                        @isset($data['society'])
                                            @foreach($data['society'] as $society)
                                                <option value="{{$society->id}}">{{$society->project_name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label>Size Of Plot<span class="text-danger">*</span></label>
                                        <select name="product_id" class="selectpicker form-control"  required>
                                        <option value="">Choose Item</option>
                                        @isset($data['items'])
                                            @foreach($data['items'] as $item)
                                                <option value="{{$item->id}}">{{$item->item}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label>Is Dependent ?<span class="text-danger">*</span></label>
                                    <select name="dependent" id="" class="form-control" required>
                                        <option value="">Choose One</option>
                                        <option value="">Yes</option>
                                        <option value="">No</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Profession <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="profession" placeholder="Profession" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Age <span class="text-danger">*</span></label>
                                    <div class="cal-">
                                        <input class="form-control " type="text" name="age" required placeholder="Age" required></div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Marital Status <span class="text-danger">*</span></label>
                                    <select class="form-control " name="marital_status" id="marital_status" required>
                                        <option value="">Choose Status</option>
                                        <option value="1">Married</option>
                                        <option value="0">UnMarried</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please choose marital status.
                                    </div>

                                </div>

                            </div>
                            <div class="row">



                                <div class="form-group col-sm-4">
                                    <label>Sale Price <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="sale_price" placeholder="Sale Price" required>
                                    <div class="invalid-feedback">
                                        Please choose marital status.
                                    </div>

                                </div>

                                <div class="form-group col-sm-4">
                                    <label>Processing Fee <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="processing_fee" placeholder="Processing Fee" required>
                                    <div class="invalid-feedback">
                                        Please choose marital status.
                                    </div>

                                </div>


                                <div class="form-group col-sm-4">
                                    <label>CNIC Attachment <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" >
                                    <div class="invalid-feedback">
                                        Please choose marital status.
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
        $(document).ready(function() {
            // save inboundLeadForm
            $('#CustomerForm').unbind().on('submit', function(e) {
                e.preventDefault();
                var formData = $('#CustomerForm').serialize();
                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{ url('save-customer-form') }}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {

                        $(".btn-submit").prop("disabled", true);
                        $(".btn-submit").html("please wait...");

                    },
                    success: function(data) {
                        if (data.message) {
                            toastr.success(data.message);
                            window.location.reload();
                        }
                        if (data.error) {
                            toastr.error('Please Enter Values');
                        }
                    },
                    complete: function(data) {
                        $(".btn-submit").html("Save");
                        $(".btn-submit").prop("disabled", false);
                    },
                    error: function() {
                        toastr.error('something went wrong');

                    },

                });


            });

        });
    </script>

@endsection
