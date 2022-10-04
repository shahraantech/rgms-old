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
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_leave" title="Give Feedback"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0">
                        <thead>
                            <tr>
                                <th style="width: 30px;">#</th>
                                <th>Training Type</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Trainy Name</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Created At</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody id="ratingTable">
                            @php $c=0; @endphp
                            @isset($data['rating'])
                            @foreach($data['rating'] as $rate)

                            @php $c++ @endphp
                            <tr>
                                <td>{{$c}}</td>
                                <td>{{$rate->training_type}}</td>
                                <td>{{$rate->from}}</td>
                                <td>{{$rate->to}}</td>
                                <td>{{$rate->name}}</td>

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
                                                        <i class="far fa-star"></i>
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
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="{{ url('edit-trainee-feedback/'.$rate->id) }}" class="dropdown-item btn_edit_clients" id="btn_edit_clients"><i class="fa fa-pencil m-r-5n "></i> Edit</a>
                                            <a href="" class="dropdown-item btn_delete_rate" data="{{ $rate->id }}" id="btn_delete_clients"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>
                                </td>
                            </tr>
                            @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to 1 of 1 entries</div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_simple_numbers float-right" id="DataTables_Table_0_paginate">
                            <ul class="pagination">
                                <li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
                                <li class="paginate_button page-item active"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                                <li class="paginate_button page-item next disabled" id="DataTables_Table_0_next"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" class="page-link">Next</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->



    <!-- add rating -->
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
                    <form method="post" id="ratingForm" action="{{url('trainee-feedback')}}" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Training Type <span class=""></span></label>
                                <select class="select" name="trainingId" id="trainingId" required>
                                    <option value="">Choose Trainer</option>
                                    @isset($data)
                                    @foreach($data['training'] as $train)
                                    <option value="{{$train->id}}">{{$train->training_type}} {{date('d-M-Y', strtotime($train->from_date))}} {{date('d-M-Y', strtotime($train->to_date))}}</option>
                                    @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Traine <span class=""></span></label>
                                <select class="select" name="trainy_id" id="showTrainy" required>
                                    <option value="">Choose Trainy</option>
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
    <!-- add rating -->




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
<!-- CDN for Sweet Alert -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type='text/javascript'>
    $(document).ready(function() {




        $('#trainingId').change(function() {
            var trainingId = $('select[name=trainingId]').val();

            $.ajax({

                type: 'ajax',

                method: 'get',

                url: '{{url("/getTrainyName")}}',

                data: {
                    trainingId: trainingId
                },

                async: false,

                dataType: 'json',

                success: function(data) {


                    var html = '';

                    var i;
                    if (data.length > 0) {

                        for (i = 0; i < data.length; i++) {

                            html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';

                        }
                    } else {
                        var html = '<option value="">Choose Trainy</option>';
                        toastr.error('data not found');
                    }


                    $('#showTrainy').html(html);

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
                url: '{{url("trainee-feedback")}}',
                data: formData,
                async: false,
                dataType: 'json',
                success: function(data) {

                    if (data.success) {

                        $('#ratingForm')[0].reset();
                        $('.close').click();
                        toastr.success(data.success);
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


        // script for delete data
        $('#ratingTable').on('click', '.btn_delete_rate', function(e) {
            e.preventDefault();

            var id = $(this).attr('data');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to Delete this Data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('/delete-trainee-feedback/') }}/" + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status == 200) {
                                toastr.success(response.message);
                                setTimeout(function () {
                                    window.location.reload();
                                 },1000);
                            }
                        }
                    });
                }
            });

        });

    });
</script>
@endsection
