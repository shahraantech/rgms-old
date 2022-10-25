

@extends('setup.master')

@section('content')



    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">{{$data['letterTitle']}}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{$data['letterTitle']}}</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <div class="btn-group btn-group-sm">
                            <button type="submit" class="btn btn-white" id="printBtn"><i class="fa fa-print fa-lg"></i> Print</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card" id="tablePrint" contenteditable="true">
                        <div class="card-body">
                            <h4 class="text-center">Employee Experience Certificate <br>
                               <span>{{$data['companyName']?$data['companyName']:''}}</span> <br>
                               <small> Get your groove  </small>
                            </h4>


                            <div class="row">
                                <div class="col-sm-6 m-b-20">

                                    <ul class="list-unstyled">
                                        <li><?php echo date('d M Y')?></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="invoice-info">

                                <p contenteditable="true">
                                    This is to certify that Mr./Ms.   <strong>{{$data['employee']->name}} </strong> Son/Daughter of Mr.
                                    <b>{{$data['employee']->father_name}} </b> worked as in <b>{{$data['companyName']}}</b>
                                    from <strong >{{$data['employee']->doj}}</strong> to <strong>{{date('d m Y')}}</strong> with our entire satisfaction.
                                    During his working period, we find him a sincere, honest, hardworking, dedicated employee with a professional attitude and very good job knowledge.
                                    He is amiable in nature and character as well.
                                    We have no objection to allow him in any better position and have no liabilities in our company. </p>

                                <p contenteditable="true"> His basic pay is <strong>{{$data['employee']->gross_salary}}</strong> only. <br>
                                    We wish him every success in life. <br>
                                   </p>



                                <p contenteditable="true">
                                    Sincerely, <br>
                                    Name ………… <br>
                                    Designation …………. <br>
                                    Alpha Buzz Co
                                </p>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

    </div>

    <script>
        $(document).ready(function() {

            $('#printBtn').on('click', function() {
                $.print("#tablePrint");
            });

        });
    </script>

@endsection



