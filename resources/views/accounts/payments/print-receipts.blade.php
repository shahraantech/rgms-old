@extends('setup.master')

@section('content')

<div class="page-wrapper" >

    <style type="text/css">
        body {
            font-family: Arial;
            font-size: 10pt;
        }

        .thanks {
            width: 100%;
            border-bottom: 1px solid #000;
        }

        .by {
            border-top: 1px solid #000;
        }
    </style>

    <!-- Page Content -->
    <div class="content container-fluid">

        <div class="card">
            <div class="card-body">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center text-center">
                        <div class="col">
                            <h5 class="page-title">{{$data['transaction']['company_name']}}</h5>
                            <h5 class="mt-3">Address Ferozpur Interchange. Main Sharaqpur Road. Lahore. Punjab</h5>
                            <h5 class="mt-3">Phone 0322-8777333 UAN : 042-111-333-987 E-Mail: info@aljalildevelopers.com</h5>
                            <h5 class="mt-5 font-weight-bold"><u>CASH RECEIPT VOUCHER</u></h5>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-md-4">
                        <h5 class="">Cash Reciept :{{$data['transaction']['payment_type']}} - {{$data['transaction']['customer_id']}}</h5>
                        <h5 class="">Customer Code : {{$data['transaction']['customer_id']}}</h5>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4 float-right">
                        <div class="float-right">
                            <h5 class="">Date : {{date('d-M-Y')}}</h5>
                            <h5 class="">Client Copy</h5>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row mt-4">
                        <h6 class="thanks">Received With Thanks !</h6>
                        <h6 class="thanks mt-2">Cash Recieved From : {{$data['transaction']['client_name']}}</h6>
                        <h5 class="thanks mt-2">Amount : Rs.{{number_format($data['transaction']['amount'])}}
                           ({{App\Models\Payroll::numberTowords(round($data['transaction']['amount'],2))}})</h5>
                        <h5 class="thanks mt-2">CASH RECIEVED FROM {{$data['transaction']['reecived_by']}} ({{$data['transaction']['company_name']}})
                            AS PAYMENT AGAINST {{$data['transaction']['project_name']}}</h5>
                        <h5 class="thanks mt-3"></h5>
                        <h5 class="thanks mt-3"></h5>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-1"></div>
                        <div class="col-md-3">
                            <h6 class="by text-center">Prepaied By</h6>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-3">
                            <h6 class="by text-center">Recieved By</h6>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                </div>

            </div>
        </div>



    </div>

    @endsection
