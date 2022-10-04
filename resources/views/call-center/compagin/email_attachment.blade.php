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
                        <h3 class="page-title">Campaign</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Email Campaign</li>
                        </ul>
                    </div>
                </div>
            </div>

            @if (\Session::has('success'))
                <div class="alert alert-success m-3">{{ \Session::get('success') }}</div>
                {{ \Session::forget('success') }}
            @endif
            @if (\Session::has('error'))
                <div class="alert alert-danger m-3">{{ \Session::get('error') }}</div>
                {{ \Session::forget('error') }}
            @endif


            <!-- /Page Header -->
            <form method="POST" action="{{ url('email-send-attachments') }}" id="emailSendForm" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="text" placeholder="Subject" class="form-control" name="subject"
                                        required>
                                </div>
                                <div class="form-group">
                                    <textarea rows="4" class="form-control" placeholder="Enter your message here" name="text_body" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="attachment" class="form-label">Attachment</label>
                                    <input class="form-control" type="file" id="attachment" name="attachment" required>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Import</label>
                                    <input class="form-control" type="file" name="file" required>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="">

                                        <button type="submit" class="btn btn-primary pull-right" title="Send"><i class="fa fa-send"></i></button>
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
        CKEDITOR.replace('text_body', {

        });
        CKEDITOR.editorConfig = function( config ) {
            config.extraPlugins = 'imageuploader';
        };
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
            toastr.success("Leads import successfully!");
        @endif
    </script>
@endsection
