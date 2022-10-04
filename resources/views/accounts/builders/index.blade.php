@extends('setup.master')
@section('content')
<div class="page-wrapper">

    <div class="content container-fluid">


        <div class="page-header my-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Builders</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Buildings</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{url('/buildings-list')}}" class="btn add-btn" title="Buildings List"><i class="fa fa-list" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    
        <div class="card">
            <div class="card-body">
                <form method="post" id="AddBuilderForm" action="{{ url('buildings') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Title <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="title" required id="title" placeholder="Building Title">
                            <div id="dateError"></div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Plot# <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="plot_no" placeholder="Plot No" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Block <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="block" required id="block" placeholder="Block">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Size <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="size" placeholder="Area Size" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Society Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="society_name" required placeholder="Society Name">

                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn" type="submit" id="btnSubmit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Page Content -->
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            // save builder
            $('#AddBuilderForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $('#AddBuilderForm').serialize();

                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{url("buildings")}}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function(data) {


                        if (data.message) {
                            $('#AddBuilderForm')[0].reset();
                            toastr.success(data.message);
                        }


                    },

                    error: function() {
                        toastr.error('something went wrong');

                    }

                });


            });
        });
    </script>

@endsection
