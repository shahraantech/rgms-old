@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Edit {{($data['voucherType']==1)?'Receipt':'Payment'}} Voucher</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit  {{($data['voucherType']==1)?'Receipt':'Payment'}} Voucher</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#payments-list" class="btn add-btn" title="Payments List"><i class="fa fa-list" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="post" id="EditReceiptForm" class="needs-validation" novalidate action="{{url('update-voucher')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" value="{{$data['edit_rec']['trans_id']}}" name="trans_id">
                            <input type="hidden" value="{{$data['edit_rec']['ac_type']}}" name="old_ac_type">
                            <input type="hidden" value="{{$data['edit_rec']['oldBankAcType']}}" name="oldBankAcType">
                            <input type="hidden" value="{{$data['voucherType']}}" name="voucher_type">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Account Type</label>
                                    <select class="select" name="ac_type" required>
                                        <option value="">Choose Type</option>
                                        <option value="vendors"
                                            @php
                                                if($data['edit_rec']['vendor_ac_id'] > 0) {
                                                    echo "selected";
                                                }
                                         @endphp >Vendors</option>
                                        <option value="clients"   @php
                                            if($data['edit_rec']['client_ac_id'] > 0) {
                                                echo "selected";
                                            }
                                        @endphp>Customers</option>
                                    </select>
                                </div>
                            </div>

{{--                            @if($data['edit_rec']['client_ac_id'] > 0)--}}
                            <div class="col-sm-4 customer-section">
                                <div class="form-group">
                                    <label id="ac_label">Customer</label>
                                    <select name="client_id" id="" class="form-control">
                                        <option value="">Choose Clients</option>
                                        @isset($data['clients'])
                                            @foreach($data['clients'] as $client)
                                                <option
                                                    @php
                                                        if($data['edit_rec']['client_ac_id']==$client->id) {
                                                            echo "selected";
                                                        }
                                                    @endphp
                                                    value="{{$client->id}}">{{$client->name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
{{--                            @endif--}}
{{--                        @if($data['edit_rec']['vendor_ac_id'] > 0)--}}
                            <div class="col-sm-4 vendor-section">
                                <div class="form-group">
                                    <label id="ac_label">Suppliers</label>
                                    <select name="vendor_id" id="" class="form-control">
                                        <option value="">Choose Supplier</option>
                                        @isset($data['vendors'])
                                            @foreach($data['vendors'] as $vendors)
                                                <option
                                                    @php
                                                        if($data['edit_rec']['vendor_ac_id']==$vendors->id) {
                                                            echo "selected";
                                                        }
                                                    @endphp
                                                    value="{{$vendors->id}}">{{$vendors->name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>

                            @if($data['voucherType']== 1)
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label id="ac_label">Purpose</label>
                                    <select class="select" name="against" required  class="form-control">
                                        <option value="">Choose One</option>
                                        <option value="token"   @php
                                            if($data['edit_rec']['purpose']=='token') {
                                                echo "selected";
                                            }
                                        @endphp >Token</option>
                                        <option value="pp"
                                            @php
                                                if($data['edit_rec']['purpose']=='pp') {
                                                    echo "selected";
                                                }
                                            @endphp
                                        >Partially Paid</option>
                                        <option value="fp"       @php
                                            if($data['edit_rec']['purpose']=='fp') {
                                                echo "selected";
                                            }
                                        @endphp>Fully Paid</option>
                                        <option value="inv"   @php
                                            if($data['edit_rec']['purpose']=='inv') {
                                                echo "selected";
                                            }
                                        @endphp>Invoice</option>
                                    </select>
                                </div>
                            </div>
                @endif

                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Transaction Mode</label>
                                    <select class="select" name="trans_mode" required>
                                        <option value="">Choose One</option>
                                        <option value="cash" @php
                                            if($data['edit_rec']['trans_mode']=='cash') {
                                                echo "selected";
                                            }
                                        @endphp>Cash</option>
                                        <option value="bank"  @php
                                            if($data['edit_rec']['trans_mode']=='bank') {
                                                echo "selected";
                                            }
                                        @endphp>Bank</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Receipt Amount</label>
                                    <input type="number" name="payment_amount" class="form-control" placeholder="Receipt Amount" required value="{{$data['edit_rec']['amount']}}" >
                                </div>
                            </div>


                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <input type="text" class="form-control" required name="desc" placeholder="Remarks" value="{{$data['edit_rec']['remarks']}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-sm-3 payment-mode">
                                <div class="form-group">
                                    <label>Payment Mode</label>
                                    <select name="payment_mode" id="" class="form-control">
                                        <option value="">Choose One</option>
                                        <option value="1"   @php
                                            if($data['edit_rec']['payment_mode']==1) {
                                                echo "selected";
                                            }
                                        @endphp>Online</option>
                                        <option value="2"  @php
                                            if($data['edit_rec']['payment_mode']==2) {
                                                echo "selected";
                                            }
                                        @endphp>Cheque</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 cheque-section">
                                <div class="form-group">
                                    <label>Cheque#</label>
                                    <input type="text" class="form-control" name="cheque_no" placeholder="Cheque Number" value="{{$data['edit_rec']['cheque_no']}}">
                                </div>
                            </div>
                            <div class="col-sm-3 cheque-section">
                                <div class="form-group">
                                    <label>Cheque Status</label>
                                    <select name="cheque_status" id="" class="form-control">
                                        <option value="">Choose One</option>
                                        <option value="1" @php
                                            if($data['edit_rec']['cheque_status']==1) {
                                                echo "selected";
                                            }
                                        @endphp>Clear</option>
                                        <option value="2" @php
                                            if($data['edit_rec']['cheque_status']==2) {
                                                echo "selected";
                                            }
                                        @endphp>Deposited</option>
                                        <option value="3" @php
                                            if($data['edit_rec']['cheque_status']==3) {
                                                echo "selected";
                                            }
                                        @endphp>Bounced</option>
                                        <option value="4" @php
                                            if($data['edit_rec']['cheque_status']==4) {
                                                echo "selected";
                                            }
                                        @endphp>Only Receive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 bank-section bank-list">
                                <div class="form-group">
                                    <label>Bank</label>
                                    <select name="bank_id" id="" class="form-control">
                                        <option value="">Choose Bank</option>
                                        @isset($data['banks'])
                                            @foreach($data['banks'] as $bank)
                                                @php
                                                    $headName=App\Models\Ledger::getLevelHeadName($bank->level_no,$bank->head_id);
                                                @endphp
                                                <option value="{{$bank->id}}" @php
                                                    if($data['edit_rec']['bank_ac_id']==$bank->id) {
                                                        echo "selected";
                                                    }
                                                @endphp>{{$headName}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4 cash-section">
                                <div class="form-group">
                                    <label>Cash A/C</label>
                                    <select name="company_account_id" id="" class="form-control">
                                        <option value="">Choose Account</option>
                                        @isset($data['accounts'])
                                            @foreach($data['accounts'] as $accounts)
                                                @php
                                                    $headName=App\Models\Ledger::getLevelHeadName($accounts->level_no,$accounts->ac_head_id);
                                                @endphp
                                                <option value="{{$accounts->id}}"  @php
                                                    if($data['edit_rec']['company_ac_id']==$accounts->id) {
                                                        echo "selected";
                                                    }
                                                @endphp>{{$headName}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="float-right">
                            <button class="btn btn-primary btn-save-changes" type="submit">Save Changes</button>

                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>

    <script type='text/javascript'>
        $(document).ready(function (){

            var ac_type=$('select[name=ac_type]').val();
            if(ac_type=='clients') {
                $(".vendor-section").css("display", "none");
                $(".customer-section").css("display", "block");
            }
            else{
                $(".vendor-section").css("display", "block");
                $(".customer-section").css("display", "none");
            }

            //cash section
            var trans_mode=$('select[name=trans_mode]').val();

            if(trans_mode=='cash') {
                $(".bank-section").css("display", "none");
                $(".payment-mode").css("display", "none");
                $(".cheque-section").css("display", "none");
                $(".cash-section").css("display", "block");
            }
            if(trans_mode=='bank') {
                $(".bank-section").css("display", "block");
                $(".cash-section").css("display", "none");
                $(".payment-mode").css("display", "block");
                $(".cheque-section").css("display", "none");

            }


            //Payment Mode section
            var payment_mode=$('select[name=payment_mode]').val();

            if(payment_mode==1) {
                $(".cheque-section").css("display", "none");
            }

            if(payment_mode==2) {
                $(".cheque-section").css("display", "block");
            }





            //account type
            $('select[name=ac_type]').change(function(){

                var ac_type=$('select[name=ac_type]').val();
                if(ac_type=='clients') {
                    $(".vendor-section").css("display", "none");
                    $(".customer-section").css("display", "block");
                }else{
                    $(".vendor-section").css("display", "block");
                    $(".customer-section").css("display", "none");
                }
            });

            //payment Mode
            $('select[name=trans_mode]').change(function(){

                var trans_mode=$('select[name=trans_mode]').val();
                if(trans_mode=='cash') {
                    $(".bank-section").css("display", "none");
                    $(".payment-mode").css("display", "none");
                    $(".cheque-section").css("display", "none");
                    $(".cash-section").css("display", "block");
                }else{
                    $(".cash-section").css("display", "none");
                    $(".bank-section").css("display", "block");
                    $(".payment-mode").css("display", "block");
                }
            });

            // On change Cheque Status
            $('select[name=cheque_status]').change(function(){
                //Cheque Status section
                var cheque_status=$('select[name=cheque_status]').val();
                if(cheque_status==1) {
                    $(".bank-list").css("display", "block");
                }else{
                    $(".bank-list").css("display", "none");
                }
            });

            // On change Payment Mode
            $('select[name=payment_mode]').change(function(){
                //Cheque Status section
                var payment_mode=$('select[name=payment_mode]').val();
                if(payment_mode==1) {
                    $(".cheque-section").css("display", "none");
                }else{
                    $(".cheque-section").css("display", "block");
                }
            });

            //update forms
            $('#EditReceiptForm1').unbind().on('submit', function(e) {
                e.preventDefault();
                var formData = $('#EditReceiptForm').serialize();

                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{url("update-voucher")}}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $(".btn-save-changes").prop("disabled", true);
                        $(".btn-save-changes").html("please wait...");
                    },
                    success: function(data) {

                        if (data.success) {
                            toastr.success(data.success);
                        }
                        if (data.errors) {
                            toastr.error(data.errors);
                        }
                    },
                    complete : function(data){
                        $(".btn-save-changes").html("Save Changesd");
                        $(".btn-save-changes").prop("disabled", false);
                    },
                    error: function() {
                        toastr.error('something went wrong');
                    },
                });
            });
        })
    </script>


@endsection
