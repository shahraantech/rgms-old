
@extends('setup.master')
@section('content')


    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12 main-chart">
                    <div class="bg-white p-3" style="background: white; padding: 15px" >


                        <div class="border-head">
                            <div style="display: flex;" class="d-flex">
                                <h3 class="" ><i class="fa fa-resistance"></i>&nbsp; Response</h3>
                            </div>

                        </div>
                        
                        <div style="margin-top: 25px;" class="row">


@for($i=0;$i<4;$i++)
                            <div class="col-md-4" style="margin-top: 10px;">
                                <div class="d-flex content-manage">

                                    <img src="{{asset('assets/img/social/fb.png')}}" alt="" style="height: 90px" width="80px" class="img-rounded">
                                    <div class="details">
                                        <a href="#" class="text-dark">
                                            <span class="f-s-18">Payroll Reports</span>
                                            <p class="text-dark">On-Time payroll records</p>
                                        </a>
                                        <div class="dropdown" style="text-align: right;">
                                            <a  class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-chevron-down"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" id="dropdown-menu_1">
                                                <a class="dropdown-item" href="#">Employee Payrun</a>
                                                <a class="dropdown-item" href="#">Payrun</a>
                                                <a class="dropdown-item" href="#">Payrun Summary</a>
                                                <a class="dropdown-item" href="#">Employee Contact List</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>

                    </div>

                </div>
            </div>
            <!-- /row -->
        </section>
    </section>



@endsection
