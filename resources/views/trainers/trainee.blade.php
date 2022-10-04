@extends('setup.master')
@section('content')
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Trainee</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Trainee</li>
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
                                <th>Name</th>
                                <th>Training Type</th>
                                <th>Cost </th>
                                <th>From</th>
                                <th>To</th>
                                <th>Descripton</th>
                                <th>Status</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody id="ratingTable">
                            @isset($data['trainee'])
                            @foreach($data['trainee'] as $key => $train)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$train->name}}</td>
                                <td>{{$train->training_type}}</td>
                                <td>{{$train->cost}}</td>
                                <td>{{$train->from}}</td>
                                <td>{{$train->to}}</td>
                                <td>{{$train->desc}}</td>
                                <td>{{$train->status}}</td>
                                <td>{{$train->created_at}}</td>
                            </tr>
                            @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
                <div class="float-right mt-3">
                    {{ $data['trainee']->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->


</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- CDN for Sweet Alert -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type='text/javascript'>
    $(document).ready(function() {

    });
</script>


@endsection