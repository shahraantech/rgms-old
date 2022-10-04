@extends('setup.master')

@section('content')


<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->


        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">My Trainings</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">My Trainings</li>
                    </ul>
                </div>

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
                                <th>Trainer</th>

                                <th>Time Duration</th>
                                <th>Description </th>
                                <th>Cost </th>
                                <th>Status </th>
                            </tr>
                        </thead>
                        <tbody>

                            @php $c=0; @endphp
                            @isset($data['training'])
                            @foreach($data['training'] as $train)
                            @php $c++; @endphp
                            <tr>
                                <td>{{$c}}</td>
                                <td>{{$train->training_type}}</td>

                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#">
                                            <img alt="" class="target-img" src="{{asset('public/assets/img/profiles/avatar-02.jpg')}}"></a>
                                        <a href="#">{{$train->trainer}} </a>
                                    </h2>
                                </td>

                                <td>{{ date("d M Y", strtotime($train->from))}} - {{ date("d M Y", strtotime($train->to))}}</td>
                                <td>{{$train->desc}}</td>
                                <td>{{$train->cost}}</td>


                                <td>
                                    <div class="dropdown action-label">
                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false" <i class="fa fa-dot-circle-o text-success"></i> {{$train->status}}
                                        </a>

                                    </div>
                                </td>

                            </tr>

                            @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /Page Content -->
</div>


<script>
    $(document).ready(function() {

        //Datatables
        $('#datatable').DataTable();
    });
</script>

@endsection