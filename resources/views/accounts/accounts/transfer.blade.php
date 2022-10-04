@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <style>
            #right_side {
                background-color: #f7f7f7;
                padding: 25px 8px;
            }
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
        <!-- Page Content -->
        <div class="content">

            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Balance Transfer</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Balance Transfer</li>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- /Page Content -->
            <div class="card" id="mainCard">
                <div class="card-body">
                    <div class="container">

                        <div class="row">
                            <div class="col-lg-8 col-md-8">
                                <form action="{{url('transfer')}}" method="POST" id="transferForm" class="needs-validation" novalidate >
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Transfer</label>
                                                <select name="transfer" id="" class="form-control transfer-type" required>
                                                    <option value="1">Choose One</option>
                                                    <option value="ata">A/C To A/C</option>
                                                    <option value="atb">A/C to Bank</option>
                                                    <option value="btb">Bank to Bank</option>
                                                    <option value="bta">Bank to A/C</option>


                                                </select>
                                                <div class="invalid-feedback">
                                                    please choose account.
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12 from-account-section" style="display: none">
                                            <div class="form-group">
                                                <label for=""> From Account</label>
                                                <select name="from_account" id="" class="form-control " >
                                                    <option value="">Choose Account</option>
                                                    @isset($data['accounts'])
                                                        @foreach($data['accounts'] as $accounts)
                                                            @php
                                                                $headName=App\Models\Ledger::getLevelHeadName($accounts->level_no,$accounts->ac_head_id);
                                                            @endphp
                                                            <option value="{{$accounts->id}}">{{$headName}}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                <div class="invalid-feedback">
                                                    please choose account.
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12 from-bank-section" style="display: none">

                                            <div class="form-group">
                                                <label>From Bank</label>
                                                <select name="from_bank_id" id="" class="form-control bankName">
                                                    <option value="">Choose Bank</option>
                                                    @isset($data['banks'])
                                                        @foreach($data['banks'] as $bank)
                                                            @php
                                                                $headName=App\Models\Ledger::getLevelHeadName($bank->level_no,$bank->head_id);
                                                            @endphp
                                                            <option value="{{$bank->id}}"  data-bank-id="{{$bank->id}}">{{$headName}}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                            </div>
                                            <div class="invalid-feedback">
                                                please choose account.
                                            </div>
                                        </div>



                                        <div class="col-md-12 to-account-section" style="display: none">
                                            <div class="form-group">
                                                <label for=""> To Account</label>
                                                <select name="to_account" id="" class="form-control" >
                                                    <option value="">Choose Account</option>

                                                    @isset($data['accounts'])
                                                        @foreach($data['accounts'] as $accounts)
                                                            @php
                                                                $headName=App\Models\Ledger::getLevelHeadName($accounts->level_no,$accounts->ac_head_id);
                                                            @endphp
                                                            <option value="{{$accounts->id}}">{{$headName}}</option>
                                                        @endforeach
                                                    @endisset

                                                </select>
                                                <div class="invalid-feedback">
                                                    please choose account.
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-md-12 to-bank-section" style="display: none">

                                            <div class="form-group">
                                                <label>To Bank</label>
                                                <select name="to_bank_id" id="" class="form-control toBankName">
                                                    <option value="">Choose Bank</option>
                                                    @isset($data['banks'])
                                                        @foreach($data['banks'] as $bank)
                                                            @php
                                                                $headName=App\Models\Ledger::getLevelHeadName($bank->level_no,$bank->head_id);
                                                            @endphp
                                                            <option value="{{$bank->id}}"  data-bank-id="{{$bank->id}}">{{$headName}}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                            </div>
                                            <div class="invalid-feedback">
                                                please choose account.
                                            </div>
                                        </div>



                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Narration</label>
                                                <input type="text" name="narration" class="form-control" placeholder="Narration" required>
                                                <div class="invalid-feedback">
                                                    enter narration.
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for=""> Date</label>
                                                <input type="date" name="date" class="form-control"  required>
                                                <div class="invalid-feedback">
                                                    enter date.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Amount</label>
                                                <input type="number" name="amount" class="form-control" placeholder="Amount" required>
                                                <div class="invalid-feedback " >
                                                    enter amount
                                                </div>
                                                <span class="balance-error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 ">
                                            <div class="submit-section">
                                                <button type="submit" class="btn btn-primary submit-btn add_vendor" id="btnSubmit">Transfer</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>



                        </div>

                    </div>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script>
        $(document).ready(function() {

            $('#transferForm').unbind().on('submit',function(e){
                e.preventDefault();

                var formData= $('#transferForm').serialize();

                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{url("transfer")}}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btnSubmit').prop('disabled',true);
                        $('#btnSubmit').text('please wait...');
                    },
                    success: function(data) {

                        if(data.success) {

                            $('#transferForm')[0].reset();
                            toastr.success(data.success);
                        }
                        if(data.error){
                            toastr.error(data.error);
                        }
                    },
                    complete: function() {
                        $('#btnSubmit').prop('disabled',false);
                        $('#btnSubmit').text('Transfer');

                    },

                    error: function() {
                        toastr.error('something went wrong');

                    }

                });


            });
            // chek available Account Balance
            $('input[name=amount]').on('keyup', function() {
                var amount=$(this).val();
                var from_account=$('select[name=from_account]').val();

                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{url("/getAccountsAvailBalance")}}',
                    data: {account_id: from_account,bank:0},
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        var currBalance=data;


                        if(amount > currBalance){
                            $("#btnSubmit").prop("disabled", true);
                            var p='<span style="color:red">Balance insufficient</span>';
                            $('.balance-error').html(p);


                        }
                        else{
                            $("#btnSubmit").prop("disabled", false);
                            var p='';
                            $('.balance-error').html(p);
                        }

                    },
                    error: function() {
                        //
                        // toastr.error('something went wrong125');

                    }

                });



            });

            $('select[name=transfer]').change(function(){
                var transfer=$('select[name=transfer]').val();

                if(transfer=='ata') {

                    $(".from-account-section").css("display", "block");
                    $(".to-account-section").css("display", "block");

                    $(".from-bank-section").css("display", "none");
                    $(".to-bank-section").css("display", "none");
                }

                if(transfer=='atb') {

                    $(".to-account-section").css("display", "none");
                    $(".from-bank-section").css("display", "none");

                    $(".from-account-section").css("display", "block");
                    $(".to-bank-section").css("display", "block");


                }

                if(transfer=='btb') {

                    $(".to-account-section").css("display", "none");
                    $(".from-account-section").css("display", "none");

                    $(".from-bank-section").css("display", "block");
                    $(".to-bank-section").css("display", "block");
                }

                if(transfer=='bta') {


                    $(".from-account-section").css("display", "none");
                    $(".to-bank-section").css("display", "none");

                    $(".from-bank-section").css("display", "block");
                    $(".to-account-section").css("display", "block");
                }



            });


        });
    </script>
@endsection
