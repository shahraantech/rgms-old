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

            </div>
        </div>
        <!-- /Page Header -->


        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0" id="datatable">
                                <thead>
                                    <tr>
                                        <th style="width: 30px;">#</th>
                                        <th>Training Type</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Trainy Name</th>
                                        <th>Rated By</th>
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
                                        <td>{{$rate->name}}</td>
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
                                                                <i class="far fa-star"></i>
                                                                <i class="far fa-star"></i>
                                                                <i class="far fa-star"></i>
                                                                <i class="far fa-star"></i>
                                                                <i class="far fa-star"></i>
                                                                <span class="small">({{ $count_rows }})</span>
                                                            </div>

                                                            <div class="overlay" style="position: relative;top: -23px; color:orange">

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
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- /Page Content -->
</div>

<script>
    //Datatables
    $('#datatable').DataTable();
</script>

@endsection