@extends('setup.master')
@section('content')
    <div class="main-wrapper">
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <div class="page-header my-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title bold-heading">QA Report</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">QA Report</li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="tab-content">
                    <!-- Profile Info Tab -->
                    <div id="emp_profile" class="pro-overview tab-pane fade show active">
                        <div class="row">
                            @isset($data['qa'])
                                @foreach ($data['qa'] as $qa)
                                    <div class="col-md-4 d-flex">
                                        <div class="card profile-box flex-fill">
                                            <div class="card-body">
                                            <span class="card-title">
                                                <small
                                                    class="text-secondary">{{ $qa->created_at }}</small></span>
                                                <ul class="personal-info">
                                                    <li>
                                                        <div class="title">Lead ID.</div>
                                                        <div class="text badge bg-inverse-info">{{ $qa->leads['id'] }}</div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Client Name</div>
                                                        <div class="text">
                                                            <div class="text badge bg-inverse-info">{{ $qa->leads['name'] }}</div>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <div class="title">Agent Name</div>
                                                        <div class="text">
                                                            <div class="text badge bg-inverse-info">{{ $qa->agent['name'] }}</div>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <div class="title">Rating</div>
                                                        <div class="text">
                                                            <div class="text badge bg-inverse-warning">

                                                                    <nav class=" navbar-expand-lg">

                                                                            <?php
                                                                            $overAllRatings = $qa->rating;
                                                                            $count_rows = 1;
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

                                                                                    </div>

                                                                                    <div class="overlay" style="position: relative;top: -12px; color:orange">

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

                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <div class="title">Remarks</div>
                                                        <div class="text">
                                                            <div class="text badge bg-inverse-info">{{ $qa->remarks }}</div>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
