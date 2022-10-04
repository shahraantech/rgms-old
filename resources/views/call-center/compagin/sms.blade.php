@extends('setup.master')
@section('content')


    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>


    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Compagin</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">SMS Compagin</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="{{url('email')}}">
                                @csrf


                                <div class="row">


                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Subject" class="form-control" name="subject">
                                </div>
                                <div class="form-group">
                                    <textarea rows="4" class="form-control" placeholder="Enter your message here" name="text_body"></textarea>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="text-center">
                                        <button class="btn btn-primary" type="submit"><span>Send</span> <i class="fa fa-send m-l-5"></i></button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

    </div>

    <script type="text/javascript">
        CKEDITOR.replace('text_body', {
            filebrowserUploadUrl: "{{url('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });


    </script>




@endsection


