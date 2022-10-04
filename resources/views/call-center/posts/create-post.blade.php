@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Add Post</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add New Post</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{url('/posts')}}" class="btn add-btn" title="Posts List"><i class="fa fa-list" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{url('create-post')}}" method="POST" id="postForm" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for=""> Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Enter Post Title" required>
                                    <div class="invalid-feedback">
                                        Please Enter Post Title.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for=""> Desc</label>
                                    <textarea name="detail" id="" cols="10" rows="3" class="form-control" required></textarea>
                                    <div class="invalid-feedback">
                                        Please Enter Description.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for=""> Image</label>
                                    <input type="file" name="image" class="form-control"  required id="pic">
                                    <div class="invalid-feedback">
                                        Please Enter Account Holder Email.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn add_vendor" id="btnSubmit">Save</button>
                            </div>
                        </div>

                </form>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>



    <script>
        $(document).ready(function() {

            $('#postForm').unbind().on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                let file = $('#pic')[0];
                formData.append('image', file.files[0]);

                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{url("create-post")}}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    async: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {

                        $("#btnSubmit").prop("disabled", true);
                        $("#btnSubmit").html(".....");

                    },
                    success: function(data) {


                        if (data.errors) {
                            toastr.error(data.errors);
                        }

                        if (data.success) {

                            $('#postForm')[0].reset();
                            toastr.success(data.success);
                        }

                    },
                    complete : function(data){
                        $("#btnSubmit").html("Save");
                        $("#btnSubmit").prop("disabled", false);
                    },
                    error: function() {
                        toastr.error('something went wrong');
                    },

                });

            });


        });
    </script>

    <script type="text/javascript">
        CKEDITOR.replace('detail', {
            filebrowserUploadUrl: "{{url('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });

    </script>
@endsection
