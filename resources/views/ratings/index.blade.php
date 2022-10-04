@extends('setup.master')
@section('content')
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Feedbacks</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Feedbacks</li>
                    </ul>
                </div>
                @isset($data['routeName'])
                @if($data['routeName']=='write-feedback')
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_leave" title="Give Feedback"><i class="fa fa-plus"></i></a>
                </div>
                @endif
                @endisset
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th style="width: 30px;">#</th>
                                <th>Training Type</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Trainer Name</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Created At</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php $c=0; @endphp
                            @isset($data['rating'])
                            @foreach($data['rating'] as $rate)

                            @php $c++ @endphp
                            <tr>
                                <td>{{$c}}</td>
                                <td>{{$rate->training_type}}</td>
                                <td>{{$rate->from}}</td>
                                <td>{{$rate->to}}</td>
                                <td>{{$rate->f_name}} {{$rate->l_name}}</td>

                                <td>

                                    <nav class=" navbar-expand-lg">

                                        <?php

                                        $overAllRatings = $rate->rating;
                                        $count_rows = 1;

                                        //                                            $r=App\Models\Rating:: all();
                                        //                                            if($r){
                                        //                                                $count_rows = $r->count();
                                        //                                                $count_row=$count_rows;
                                        //                                                $sum=0;
                                        //                                                foreach($r as $r){
                                        //                                                    $rate= $r->rating;
                                        //                                                    $sum=$sum+$rate;
                                        //
                                        //                                                }
                                        //                                                $overAllRatings=($sum/$count_row);
                                        //
                                        //                                            }

                                        ?>

                                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                            <ul class="navbar-nav mr-auto">
                                                <li class="nav-item active">


                                                    <div class="placeholder" style="color: orange;">
                                                        <i class="far fa-star" style="color:"></i>
                                                        <i class="far fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                        <span class="small">({{ $count_rows }})</span>
                                                    </div>

                                                    <div class="overlay" style="position: relative;top: -21px; color:orange">

                                                        @while($overAllRatings>0)
                                                        @if($overAllRatings >0.5)
                                                        <i class="fas fa-star"></i>
                                                        @else
                                                        <i class="fas fa-star-half"></i>
                                                        @endif
                                                        @php $overAllRatings--; @endphp
                                                        @endwhile

                                                    </div>
                                                </li>
                                            </ul>




                                        </div>
                                    </nav>
                                </td>
                                <td>{{$rate->comment}}</td>
                                <td>{{$rate->created_at}}</td>
                            </tr>
                            @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
                <div class="float-right mt-3">
                    {{ $data['rating']->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
    <div id="add_leave" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Write Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="ratingForm" action="{{url('trainer-feedback')}}" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Training <span class=""></span></label>
                                <select class="select" name="trainingId" id="trainingId" required>
                                    <option value="">Choose Training</option>
                                    @isset($data)
                                    @foreach($data['training'] as $train)
                                    <option value="{{$train->id}}">{{$train->training_type}} {{date('d-M-Y', strtotime($train->from))}} {{date('d-M-Y', strtotime($train->to))}}</option>
                                    @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Trainer <span class=""></span></label>
                                <select class="select" name="trainer_id" id="showTrainer" required>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Rating <span class=""></span></label>
                                <input type="text" class="ratingEvent rating5" value="1" name="rating" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label>Comment <span class="text-danger">*</span></label>
                                <textarea name="comment" cols="10" rows="3" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn" type="submit" id="btnSubmit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

        $('#trainingId').change(function() {
            var trainingId = $('select[name=trainingId]').val();
            $.ajax({
                type: 'ajax',
                method: 'get',

                url: '{{url("/getTrainerName")}}',

                data: {
                    trainingId: trainingId
                },

                async: false,

                dataType: 'json',

                success: function(data) {


                    var html = '<option>Choose Trainer</option>';

                    var i;
                    if (data.length > 0) {

                        for (i = 0; i < data.length; i++) {

                            html += '<option value="' + data[i].id + '">' + data[i].f_name + '</option>';

                        }
                    } else {
                        var html = '<option value="">Choose Trainer</option>';
                        toastr.error('data not found');
                    }


                    $('#showTrainer').html(html);

                },

                error: function() {

                    alert('Could not get Data from Database');

                }

            });
        });

        $('#ratingForm').unbind().on('submit', function(e) {
            e.preventDefault();
            var formData = $('#ratingForm').serialize();


            $.ajax({

                type: 'ajax',
                method: 'post',
                url: '{{url("trainer-feedback")}}',
                data: formData,
                async: false,
                dataType: 'json',
                success: function(data) {

                    if (data.success) {

                        $('#ratingForm')[0].reset();
                        $('.close').click();
                        toastr.success('Record save successfully');
                        window.location.reload();
                    }
                    if (data.error) {
                        $('.close').click();
                        toastr.error('Already reviewed');
                    }


                },

                error: function() {
                    toastr.error('something went wrong');

                }

            });


        });
        //Datatables
        $('#datatable').DataTable();
    });
</script>

<!--Use for ratings!-->

@endsection
