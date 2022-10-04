@extends('setup.master')
@section('content')
<div class="page-wrapper">
    <style>
        body {
            font-family: Arial;
            font-size: 10pt;
        }
    </style>
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="card">
            <div class="card-body">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Edit Feedbacks</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit Feedbacks</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="{{ url('trainee-feedback') }}" class="btn add-btn" title="Give Feedback">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /Page Header -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="post" id="ratingForm" action="{{url('update-trainee-feedback/'.$rate->id)}}" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Training Type <span class=""></span></label>
                                    <select class="select form-control" name="trainingId" id="trainingId" required>
                                        <option value="">Choose Trainer</option>
                                        @foreach($training as $train)
                                        <option value="{{$train->id}}"
                                        @if($rate->training_id == $train->id) selected @endif
                                        >{{$train->training_type}} {{date('d-M-Y', strtotime($train->from_date))}} {{date('d-M-Y', strtotime($train->to_date))}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Traine <span class=""></span></label>
                                    <select class="select form-control" name="trainy_id" id="trainy_id" required>
                                        <option value="">Choose Trainee</option>
                                        @foreach($training as $train)
                                        <option value="{{$train->id}}"
                                        @if($rate->trainer_id == $train->id) selected @endif
                                        >{{$train->trainee->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Rating <span class=""></span></label>
                                    <input type="text" class="ratingEvent rating5" value="{{$rate->rating}}" name="rating" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label>Comment <span class="text-danger">*</span></label>
                                    <textarea name="comment" cols="10" rows="3" class="form-control" required>{{$rate->comment}}</textarea>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn" type="submit" id="btnSubmit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->






    </div>
    <script type="text/javascript">
        $(function() {
            $('.rating').rating();

            $('.ratingEvent').rating({
                rateEnd: function(v) {
                    $('#result').text(v);
                }
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type='text/javascript'>
        $(document).ready(function() {




            // $('#trainingId').change(function() {
            //     var trainingId = $('select[name=trainingId]').val();

            //     $.ajax({

            //         type: 'ajax',

            //         method: 'get',

            //         url: '{{url("/getTrainyName")}}',

            //         data: {
            //             trainingId: trainingId
            //         },

            //         async: false,

            //         dataType: 'json',

            //         success: function(data) {


            //             var html = '';

            //             var i;
            //             if (data.length > 0) {

            //                 for (i = 0; i < data.length; i++) {

            //                     html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';

            //                 }
            //             } else {
            //                 var html = '<option value="">Choose Trainy</option>';
            //                 toastr.error('data not found');
            //             }


            //             $('#showTrainy').html(html);

            //         },

            //         error: function() {

            //             alert('Could not get Data from Database');

            //         }

            //     });
            // });

        });
    </script>


    @endsection