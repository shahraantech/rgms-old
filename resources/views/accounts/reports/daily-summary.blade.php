@extends('setup.master')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<style type="text/css">
    body {
        font-family: Arial;
        font-size: 10pt;
    }

    table {
        border: 1px solid #ccc;
        border-collapse: collapse;
    }

    table th {
        background-color: #F7F7F7;
        color: #333;
        font-weight: bold;
    }

    table th,
    table td {
        padding: 5px;
        border: 1px solid #ccc;
    }
</style>
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">

        <div class="page-header my-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title bold-heading">Daily Summary</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Daily Summary</li>
                    </ul>
                </div>
                <!-- <div class="col-auto float-right ml-auto">
                    <a href="#payments-list" class="btn add-btn" title="Payments List"><i class="fa fa-list" aria-hidden="true"></i></a>
                </div> -->
            </div>
        </div>
        <div class="my-header">
            <div class="row">
                <form method="post" action="{{url('daily-summary')}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Account Type</label>
                                <select class="select" name="ac_type">
                                    <option value="">Choose Type</option>
                                    <option value="vendors">Vendors</option>
                                    <option value="clients">Clients</option>
                                    <option value="expense">Expense</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Account</label>
                                <select class="select" name="ac_id" id="showAccounts">
                                    <option value="">Choose Account</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>From:</label>
                                <input type="date" class="form-control" name="from">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>To:</label>
                                <input type="date" class="form-control" name="to">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="">Search</label>
                            <div class="form-group">
                                <button class="btn btn-success mt-2" type="submit">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="card">

            <div class="card-body">


                <table class="table table-striped table-hover" id="payments-list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>TID</th>
                            <th>A/C Name</th>
                            <th>Type</th>
                            <th>Comments</th>
                            <th>Receipt Amount</th>
                            <th>Paid Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $c=0;

                        $totaReceipt=0;
                        $totaPayments=0;
                        @endphp
                        @isset($data['transaction'])
                        @foreach($data['transaction'] as $trans)

                        @php $c++;


                        @endphp
                        <tr>
                            <td>{{$c}}</td>
                            <td>TRNS-{{$trans['id']}}</td>
                            @php
                                $res=[];
                                $exp=[];
                                if($trans['ac_type']=='VENDORS'){
                                $res=App\Models\Vendor::find($trans['ac_id']);
                                }
                                if($trans['ac_type']=='CLIENTS'){
                                $res=App\Models\Client::find($trans['ac_id']);
                                }

                             if($trans['ac_type']=='COMPANY' && $trans['mode']=='expense'){
                                $exp=App\Models\AccountHead::find($trans['exp_head_id']);
                                }
                            @endphp
                            <td>
                                @if($exp)
                                {{ $exp->exp_head }}
                                @endif

                                    @if($res)
                                        {{ $res->name }}
                                    @endif
                            </td>
                            <td>{{$trans['ac_type']}}</td>
                            <td>{{$trans['desc']}}</td>
                            @if($trans->trans_type=='dr')
                            @php $totaReceipt=$totaReceipt + $trans['amount'] @endphp
                            <td>{{number_format($trans['amount'],2)}}</td>
                            <td>-</td>
                            @else
                            <td>-</td>
                            @php $totaPayments=$totaPayments + $trans['amount'] @endphp
                            <td>{{number_format($trans['amount'],2)}}</td>
                            @endif
                            <td>{{date('d-M-Y',strtotime($trans['created_at']))}}</td>
                        </tr>
                        @endforeach
                        @endisset

                        <tr>
                            <td>
                                <div class="float-right"> <strong>Total:</strong></div>
                            </td>
                            <td colspan="4">

                            </td>
                            <td> <strong>{{number_format($totaReceipt,2)}} PKR</strong></td>
                            <td> <strong>{{number_format($totaPayments,2)}} PKR</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type='text/javascript'>
    $(document).ready(function() {

        $('select[name=ac_type]').change(function() {

            var ac_type = $('select[name=ac_type]').val();

            $.ajax({

                type: 'ajax',
                method: 'get',

                url: '{{url("/getAccountsName")}}',

                data: {
                    ac_type: ac_type
                },

                async: false,

                dataType: 'json',

                success: function(response) {

                    var html = '<option value="">Choose One</option>';

                    var i;
                    if (response.length > 0) {

                        for (i = 0; i < response.length; i++) {

                            html += '<option value="' + response[i].id + '">' + response[i].name + '</option>';

                        }
                    } else {
                        var html = '<option value="">Choose One</option>';
                        toastr.error('data not found');
                    }


                    $('#showAccounts').html(html);

                },

                error: function() {

                    toastr.error('data not found');

                }

            });
        });

        //Datatables
        $('#payments-list').DataTable();
    });
</script>
@endsection
