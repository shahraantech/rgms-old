@extends('setup.master')

@section('content')
    <style>
        ol li {
            padding: 0px 0px;
        }

        ol li p {
            font-size: 17px;
        }

        .ff {
            font-size: 20px;
        }

        #background {
            position: absolute;
            opacity: 0.6;
            z-index: 99;
            color: white;
            width: 20%;
            left: 26rem;
            top: 38rem;
        }
    </style>

    <div class="page-wrapper">



        <!-- Page Content -->
        <div class="content container-fluid">


            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Offer Letter</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Offer Letter</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <div class="btn-group btn-group-sm">
                            <button type="submit" class="btn btn-white" id="printBtn"><i class="fa fa-print fa-lg"></i>
                                Print</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card" id="tablePrint" style="font-size: 16px;">

                        <div class="card-body">
                            <img src="{{ asset('public/assets/img/A-team.png') }}" id="background" class="img-fluid"
                            alt="">
                            @isset($data['employee'])
                                <div class="container" contenteditable="true">
                                    <div class="row text-right">
                                        <div class="w-100">
                                            <p><strong>Date:</strong> @php
                                                echo date('d-M-Y');
                                            @endphp</p>
                                        </div>
                                    </div>
                                    <div class="row text-center">
                                        <div class="w-100">
                                            <h5 class="font-weight-bold ff">APPOINTMENT LETTER</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h5 class="font-weight-bold ff">{{ $data['employee']->name }}</h5>
                                        <p>Reference is made to your application and subsequent interview; we are pleased to
                                            offer you an employment in Group sales on the following term and conditions.</p>
                                    </div>

                                    <div class="row">
                                        <div class="d-flex">
                                            <p class="font-weight-bold ff">Position Offered </p>&nbsp;&nbsp; : &nbsp;&nbsp;
                                            <p class="font-weight-bold ml-2 ff">sales executive </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="d-flex">
                                            <p class="font-weight-bold ff">Remuneration </p>&nbsp;&nbsp; : &nbsp;&nbsp;
                                            <p class="font-weight-bold ml-4 ff">Salary Rs:30000- Per Month </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="d-flex">
                                            <p class="font-weight-bold ff">Department </p>&nbsp;&nbsp; : &nbsp;&nbsp;
                                            <p class="font-weight-bold ml-5 ff">sales </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="d-flex">
                                            <p class="font-weight-bold ff">Job Timings </p>&nbsp;&nbsp; : &nbsp;&nbsp;
                                            <p class="font-weight-bold ml-5 ff">6 days a week, standard working hours (10: 00AM
                                                TO
                                                06:00PM) </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="d-flex">
                                            <p class="font-weight-bold ff">Job Status </p>&nbsp;&nbsp; : &nbsp;&nbsp;
                                            <p class="font-weight-bold ml-5 ff">permanent </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="d-flex">
                                            <p class="font-weight-bold ff">Period of Contract </p>&nbsp;&nbsp; : &nbsp;&nbsp;
                                            <p class="font-weight-bold ml-1 ff">one year </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <ol>
                                            <li>
                                                <p>You will be initially on probation period for three months during which
                                                    the services are liable to be terminated without any notice. Where after you
                                                    may be confirmed subject to your satisfactory work performance good conduct
                                                    and successful completion of the probation period.</p>
                                            </li>
                                            <li>
                                                <p>You will be entitled to 18 Annual leaves as per rules and regulations of the
                                                    company. If you do not utilize the leaves at the end of year, your leaves
                                                    automatically will be elapsed. Therefore, no leaves encashment or
                                                    accumulation will be entitled.</p>
                                            </li>
                                            <li>
                                                <p>After confirmation your employment may only be terminated by giving one month
                                                    notice in writing or one month salary on either side. Provided, no salary in
                                                    lieu of notice will be payable in the event of termination of your services
                                                    due to misconduct, which we shall be the sole judge.</p>
                                            </li>
                                            <li>
                                                <p>Upon termination/resign from the employment you are required to return to the
                                                    company all its property/assets in your possession inclusive of any
                                                    correspondence conducted by you officially or otherwise, in connection with
                                                    company’s affairs, and handover your physical charge to such employee as
                                                    authorized by the company</p>
                                            </li>
                                            <li>
                                                <p>You will abide by all the company’s rules and regulation of the company as
                                                    enforced from time to time with or without notice.</p>
                                            </li>
                                            <li>
                                                <p>You will promote the interest of company to the best of your abilities,
                                                    skills and knowledge according to the given job description, your targets
                                                    assigned by the management.</p>
                                            </li>
                                            <li>
                                                <p>You will discharge your duties and responsibilities efficiently, honestly and
                                                    diligently to the satisfaction of the management of company and you will not
                                                    act in any manner contrary to the interest of the company.</p>
                                            </li>
                                            <li>
                                                <p>During your services or after its termination you will not disclose any
                                                    information relating to the company or its customers and trade activities.
                                                </p>
                                            </li>
                                            <li>
                                                <p>Bonus will be awarded according to the company policiey and KPI’s
                                                </p>
                                            </li>
                                            <li>
                                                <p>We look forward to your prolific contributions towards our mutual success in
                                                    the future.
                                                </p>
                                            </li>
                                        </ol>

                                        <div>
                                            <h5 class="font-weight-bold ff">Yours Faithfully,</h5>
                                        </div>
                                        <div class="w-100">
                                            <h5 class="font-weight-bold mt-4 ff">Ghous Ur Rehman</h5>
                                            <h5 class="font-weight-bold pull-right ff">Froosha Kanwel</h5>
                                        </div>
                                        <div class="w-100">
                                            <h5 class="font-weight-bold mt-4 ff">Managing Partner</h5>
                                            <h5 class="font-weight-bold pull-right ff">HR HEAD</h5>
                                        </div>
                                    </div>

                                    <div class="row mt-5">
                                        <div>
                                            <h5 class="font-weight-bold ff">Accepted By:</h5>
                                            <h5 class="ff">Name: __________________________ Signature: _____________________
                                                Date of joining: &nbsp;{{ date('d-M-Y', strtotime($data['employee']->doj)) }}
                                            </h5>
                                        </div>
                                    </div>

                                </div>
                            @endisset

                            {{-- @isset($data['employee'])

                                <div class="row">
                                    <div class="col-sm-6 m-b-20">

                                        <h3>Job Offer Letter</h3>
                                        <ul class="list-unstyled">
                                            <li>@php
                                                echo date('d-M-Y');
                                            @endphp</li>
                                            <li>{{ $data['employee']->name }},</li>
                                            <li>{{ $data['employee']->email }}</li>

                                        </ul>
                                    </div>

                                </div>

                                <div>
                                    <div class="invoice-info">
                                        <h5>Dear Candidate</h5>

                                        <p contenteditable="true">
                                            We are pleased to offer you at <b> {!! $data['companyName'] !!} </b> with a start date of
                                            {{ date('d-M-Y', strtotime($data['employee']->doj)) }},
                                            contingent upon a background check.
                                            It is in our opinion that your abilities and experience will be the perfect fit for
                                            our company.
                                        </p>
                                    </div>
                                </div>

                            @endisset --}}
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
