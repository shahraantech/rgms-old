@extends('setup.master')
@section('content')
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
    <style>
        .MultiCheckBox {
            border: 1px solid #e2e2e2;
            padding: 5px;
            border-radius: 4px;
            cursor: pointer;
        }

        .MultiCheckBox .k-icon {
            font-size: 15px;
            float: right;
            font-weight: bolder;
            margin-top: -7px;
            height: 10px;
            width: 14px;
            color: #787878;
        }

        .MultiCheckBoxDetail {
            display: none;
            position: absolute;
            border: 1px solid #e2e2e2;
            overflow-y: hidden;
        }

        .MultiCheckBoxDetailBody {
            overflow-y: scroll;
        }

        .MultiCheckBoxDetail .cont {
            clear: both;
            overflow: hidden;
            padding: 2px;
        }

        .MultiCheckBoxDetail .cont:hover {
            background-color: #cfcfcf;
        }

        .MultiCheckBoxDetailBody>div>div {
            float: left;
        }

        .MultiCheckBoxDetail>div>div:nth-child(1) {}

        .MultiCheckBoxDetailHeader {
            overflow: hidden;
            position: relative;
            height: 28px;
            background-color: #3d3d3d;
        }

        .MultiCheckBoxDetailHeader>input {
            position: absolute;
            top: 4px;
            left: 3px;
        }

        .MultiCheckBoxDetailHeader>div {
            position: absolute;
            top: 5px;
            left: 24px;
            color: #fff;
        }
    </style>
    <script>
        $(document).ready(function() {
            $("#test").CreateMultiCheckBox({
                width: '230px',
                defaultText: 'Select Below',
                height: '250px'
            });
        });
    </script>
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Add Quotation</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Quotation</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <form method="POST" action="{{ url('store-quotation') }}">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-body">
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success alert-block">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <select name="vendor_id" class="select" required>
                                        <option value="" selected disabled>Choose Vendor</option>
                                        @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Subject" class="form-control" name="subject"
                                        required>
                                </div>
                                <div class="form-group">
                                    <textarea rows="4" class="form-control" placeholder="Enter your message here" name="message" required></textarea>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="text-center">
                                        <button class="btn btn-primary" type="submit"><span>Send</span> <i
                                                class="fa fa-send m-l-5"></i></button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /Page Content -->
    </div>
    <script type="text/javascript">
        CKEDITOR.replace('message', {
            filebrowserUploadUrl: "{{ url('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endsection
