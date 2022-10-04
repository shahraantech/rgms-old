

@extends('setup.master')

@section('content')



    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Offer Letter</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Offer Letter</li>
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
                    <div class="card" id="tablePrint">
                        <div class="card-body">
                            @isset($data['employee'])

                            <div class="row">
                                <div class="col-sm-6 m-b-20">

                                    <h3>Job Offer Letter</h3>
                                    <ul class="list-unstyled">
                                        <li><?php echo date('d-M-Y')?></li>
                                        <li>{{$data['employee']->name}},</li>
                                        <li>{{$data['employee']->email}}</li>

                                    </ul>
                                </div>

                            </div>


                            <div>

                                <div class="invoice-info">
                                    <h5>Dear Candidate</h5>

                                    <p contenteditable="true">
                                        We are pleased to offer you at <b> {!! $data['companyName'] !!} </b> with a start date of {{date('d-M-Y',strtotime($data['employee']->doj))}},
                                        contingent upon a background check.
                                        It is in our opinion that your abilities and experience will be the perfect fit for our company.
                                    </p>

{{--                                    <p contenteditable="true">--}}
{{--                                    --}}
{{--                                        {!! empty($data['policy']->policies)?'':$data['policy']->policies !!}--}}
{{--                                    </p>--}}

{{--                                    <p class="text-muted">--}}
{{--                                        {!! empty($data['policy']->rules)?'':$data['policy']->rules !!}--}}
{{--                                    </p>--}}

{{--                                    <p class="text-muted">--}}
{{--                                        {!! empty($data['policy']->confidentional_info)?'':$data['policy']->confidentional_info !!}--}}
{{--                                    </p>--}}
                                </div>
                            </div>

                            @endisset
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


