@extends('setup.master')
@section('content')
    <style type="text/css">
        body {
            font-family: Arial;
            font-size: 10pt;
        }

        table {
            border: 1px solid #ccc;
            border-collapse: collapse;
        }

        table th {
            background-color: #F7F7F7;
            color: #333;
            font-weight: bold;
        }

        table th,
        table td {
            padding: 5px;
            border: 1px solid #ccc;
        }

    </style>
    <div class="main-wrapper">
        <!-- /Sidebar -->
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <div class="page-header my-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title bold-heading">Leads Edit</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Leads Edit</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="{{ url('leads') }}" class="btn add-btn"
                                title="Add New Leads"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">

                        <form method="post" action="{{ url('updateLeeds') }}" id="LeadForm" class="needs-validation" novalidate>
                            <input type="hidden" name="Leed_id" value="{{ $data['leedsMarketing']->id }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" value="{{ $data['leedsMarketing']->name }}" placeholder=" Name" required>
                                        <div class="invalid-feedback">
                                            Please enter name.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email <span class="text-danger"></span></label>
                                        <input class="form-control" type="text" name="email" value="{{ $data['leedsMarketing']->email }}" placeholder="Email">
                                        <div class="invalid-feedback">
                                            Please enter email.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="contact" value="{{ $data['leedsMarketing']->contact }}" placeholder="Contact"
                                            required>
                                        <div class="invalid-feedback">
                                            Please enter contact.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City <span class="text-danger">*</span></label>

                                        <select class="form-control" name="city_id" required>
                                            <option value="" selected disabled>Choose City</option>

                                            @isset($data)
                                                @foreach ($data['city'] as $city)
                                                    <option value="{{ $city->id }}"
                                                    {{$data['leedsMarketing']->city_id == $city->id ? 'selected' : '' }}
                                                    >{{ $city->city_name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <div class="invalid-feedback">
                                            Please choose city.
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Lead Type<span class="text-danger">*</span></label>
                                        <select class="select" name="lead_type" required>
                                            <option value="" selected disabled>Choose Leeds</option>
                                            <option value="outbound"
                                            {{$data['leedsMarketing']->lead_type == 'outbound' ? 'selected' : '' }}
                                            >Outbound</option>
                                            <option value="Inbound"
                                            {{$data['leedsMarketing']->lead_type == 'Inbound' ? 'selected' : '' }}
                                            >Inbound</option>

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
                                            <option value="" selected disabled>Choose Source</option>
                                            @isset($data)
                                                @foreach ($data['platforms'] as $platforms)
                                                    <option value="{{ $platforms->id }}"
                                                        {{$data['leedsMarketing']->platform_id == $platforms->id ? 'selected' : '' }}
                                                        >{{ $platforms->platform }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <div class="invalid-feedback">
                                            Please enter Source.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="address" value="{{ $data['leedsMarketing']->address }}" placeholder="Address"
                                            required>
                                        <div class="invalid-feedback">
                                            Please enter Address.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary  " type="submit" id="btnSubmit">Update</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
            <!-- /Page Content -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js">
    </script>
    <script>
        $(document).ready(function() {

        });
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    <script>
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif


        @if (Session::has('success'))
            toastr.success("Leads updated successfully!");
        @endif
    </script>


@endsection
