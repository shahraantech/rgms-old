
@extends('setup.master')
@section('content')

<!-- Main Wrapper -->
<div class="main-wrapper">



    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Policies</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Policies</li>
                        </ul>
                    </div>

                    <div class="col-auto float-right ml-auto">
                        <a href="{{url('/create-policies')}}" class="btn add-btn" ><i class="fa fa-plus"></i></a>

                </div>
            </div>
            <!-- /Page Header -->


            <div class="row">
                <div class="col-lg-12">
                    <div class="tab-content profile-tab-content">

                        <!-- Projects Tab -->
                        <div id="myprojects" class="tab-pane fade show active">
                            <div class="row">


                                @isset($data['policy'])
                                    @foreach($data['policy'] as $policy)


                                <div class="col-lg-6 col-sm-6 col-md-6 col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="dropdown profile-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{url('edit-polciy/'.$policy->id)}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="{{url('delete-polciy/'.$policy->id)}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>

                                            <h4 class="project-title"><a href="#" style="color: #8053CB">Company Name</a></h4>
                                            <p class="text-muted">{{ $policy->company->name }}</p>

                                            <h4 class="project-title"><a href="#" style="color: #8053CB">Company Policies</a></h4>
                                            <p class="text-muted">{!! $policy->policies !!}</p>

                                            <h4 class="project-title"><a href="#" style="color: #8053CB">Rules & Regulation</a></h4>
                                            <p class="text-muted">{!! $policy->rules !!}</p>
                                                <h4 class="project-title"><a href="#" style="color: #8053CB">Confidential Information</a></h4>
                                            <p class="text-muted">{!! $policy->confidentional_info !!}</p>


                                        </div>
                                    </div>
                                </div>

                                    @endforeach
                                @endisset



                            </div>
                        </div>
                        <!-- /Projects Tab -->


                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

    </div>
</div>
<!-- /Main Wrapper -->



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    <script>
        @if(count($errors) > 0)

        @foreach($errors->all() as $error)

        toastr.error("{{ $error }}");
        @endforeach
        @endif


        @if(Session::has('success'))
        toastr.success("Record deleted successfully!");

        @endif

    </script>



@endsection
