@extends('setup.master')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <style type="text/css">
        body
        {
            font-family: Arial;
            font-size: 10pt;
        }
        table
        {
            border: 1px solid #ccc;
            border-collapse: collapse;
        }
        table th
        {
            background-color: #F7F7F7;
            color: #333;
            font-weight: bold;
        }
        table th, table td
        {
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
                        <h3 class="page-title bold-heading">Payment Voucher</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payments Voucher</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#payments-list" class="btn add-btn" title="Payments List"><i class="fa fa-list" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-body">
                    <form method="post" id="PaymentsForm" action="{{url('payments')}}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <select class="select" name="ac_type" required>
                                        <option value="">Account Type</option>
                                        <option value="vendors">Vendor</option>
                                        <option value="clients">Customer</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">

                                    <select class="select" name="ac_id" required id="showAccounts" class="form-control">
                                        <option value="">Choose Account</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <a type="button" class="btn btn-primary"  data-toggle="modal" data-target="#add_department">+</a>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="date" class="form-control" required name="payment_date">
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <select class="select" name="trans_mode" required>
                                        <option value="" selected disabled>Transaction Mode</option>
                                        <option value="cash">Cash</option>
                                        <option value="bank">Bank</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-sm-4 payment-mode" style="display:none">
                                <div class="form-group">

                                    <select name="payment_mode" id="" class="form-control" required>
                                        <option value="">Payment Mode</option>
                                        <option value="1">Online</option>
                                        <option value="2">Cheque</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4 cheque-section" style="display:none">
                                <div class="form-group">

                                    <input type="text" class="form-control" name="cheque_no" placeholder="Cheque Number">
                                </div>
                            </div>
                            <div class="col-sm-4 cheque-section" style="display:none">
                                <div class="form-group">
                                    <select name="cheque_status" id="" class="form-control" required>
                                        <option value="">Cheque Status</option>
                                        <option value="1">Clear</option>
                                        <option value="3">Bounced</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 cheque-section" style="display:none">
                                <div class="form-group">
                                    <input type="file" id="pic" class="form-control"  name="file">
                                </div>
                            </div>

                            <div class="col-sm-4 bank_section" style="display:none">
                                <div class="form-group">
                                    <select name="bank_id" id="" class="form-control ac-bank" required>
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
                            </div>

                            <div class="col-sm-4 cash_section" style="display:none">
                                <div class="form-group">

                                    <select name="company_account_id" id="" class="form-control ac-bank" required>
                                        <option value="">Pay To Account</option>
                                        @isset($data['accounts'])
                                            @foreach($data['accounts'] as $accounts)
                                                @php
                                                   $headName=App\Models\Ledger::getLevelHeadName($accounts->level_no,$accounts->ac_head_id);
                                                    @endphp
                                                <option value="{{$accounts->id}}">{{$headName}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="number" name="payment_amount" class="form-control" placeholder="Payment Amount" required>
                                    <div class="balance-error"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" required name="desc" placeholder="Remarks">
                                </div>
                            </div>
                        </div>

                        <div class="float-right">
                            <button class="btn btn-primary btn-submit" type="submit" id="btnSubmit">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="my-header">
                <div class="row">
                    <form method="post" class="needs-validation" novalidate action="{{url('payments')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-3 col-md-2">
                                <div class="form-group">
                                    <label>Account Type</label>
                                    <select class="select" name="ac_type_filter" required>
                                        <option value="">Choose Type</option>
                                        <option value="vendor">Vendor</option>
                                        <option value="client">Client</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label>Account</label>
                                    <select class="select" name="ac_id" required id="showAccountsFilter">
                                        <option value="">Choose Account</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label>From:</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="form-group">
                                    <label for=""></label>
                                    <button class="btn btn-primary " style="margin-top: 30px"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <table class="table table-striped" id="payments-list">
                        <tr>
                            <th>#</th>
                            <th>Payee's Name</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>To</th>
                            <th>Remarks</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        <tbody>
                        @php $c=0;
                  $subTotal=0;
                        @endphp
                        @isset($data['transaction'])
                            @foreach($data['transaction'] as $trans)
                                @php $c++;
                  $subTotal=$subTotal+$trans['amount'];
                                @endphp
                                <tr>
                                    <td>{{$c}}</td>
                                    @php
                                        $res='';
                                        if($trans->ac_type=='VENDORS'){
                                        $res=App\Models\Vendor::find($trans->account_id);
                                        }
                                        if($trans->ac_type=='CLIENTS'){
                                        $res=App\Models\Client::find($trans->account_id);
                                        }
                                    @endphp
                                    <td>{{($res)?$res->name:''}}</td>
                                    <td>{{$trans['ac_type']}}</td>
                                    <td>{{number_format($trans['amount'],2)}}</td>
                                    <td>{{strtoupper($trans['mode'])}}</td>
                                    <td>{{substr($trans['desc'],0,40)}}</td>
                                    <td>{{date('d-M-Y',strtotime($trans['created_at']))}}</td>
                                    <td>
                                        <a href="{{url('rv').'/'.$trans->id}}"><i class="fa fa-print" aria-hidden="true"></i></a> &nbsp;
                                        <a href="{{url('edit-voucher/2').'/'.$trans->id}}" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endisset

                        <tr>
                            <td>
                                <div class="float-right"> <strong>Total:</strong></div>
                            </td>
                            <td colspan="3">
                                <div class="float-right"> <strong> {{number_format($subTotal,2)}} PKR</strong></div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div id="add_department" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{url('create-vend-cus-account')}}" method="POST" id="CustomVendorForm" class="needs-validation" novalidate enctype="multipart/form-data">
                      @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Account Type</label>

                                    <select class="select" name="account_type" required>
                                        <option value="">Choose Type</option>
                                        <option value="vendors">Vendor</option>
                                        <option value="clients">Customer</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Choose A/C Type.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for=""> Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Cleint Name" required>
                                    <div class="invalid-feedback">
                                        Please Enter Cleint Name.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12" id="fp_section" style="display: none">
                                <div class="form-group">
                                    <label for="">F-P Name</label>
                                    <input type="text" name="fp_name" class="form-control" placeholder="Focal Person Name" required>
                                    <div class="invalid-feedback">
                                        Please Enter Focal Person Name.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""> Contact</label>
                                    <input type="number" name="contact" autocomplete="off" id="contact" class="form-control" placeholder="Cleint Contact" required>
                                    <div id="show_error"></div>
                                    <div class="invalid-feedback">
                                        Please Enter Client Contact.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""> City</label>
                                    <input type="text" name="city" class="form-control" placeholder="Cleint City" required>
                                    <div class="invalid-feedback">
                                        Please Enter Cleint City.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Open Balance</label>
                                    <input type="number" name="open_bal" class="form-control" placeholder="Open Balance" required>
                                    <div class="invalid-feedback">
                                        Please Enter Cleint Open Balance.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Balance Type</label>
                                    <select name="bal_type" id="" class="form-control">
                                        <option value="cr">Credit</option>
                                        <option value="db">Dedit</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please Enter Open Balance.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 ">
                                <div class="submit-section">
                                    <button type="submit" class="btn btn-primary submit-btn add_cleint">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

    <script type='text/javascript'>
        $(document).ready(function (){

            $('#PaymentsForm').validate({

                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
                });

            $('select[name=ac_type]').change(function(){
                var ac_type=$('select[name=ac_type]').val();
                (ac_type=='vendors')? $('#ac_label').html('Vendors'):$('#ac_label').html('Customers')

                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{url("/getAccountsName")}}',
                    data: {ac_type: ac_type},
                    async: false,
                    dataType: 'json',
                    success: function(response) {
                        var html = '';
                        var i;
                        if(response.length > 0) {
                            for (i = 0; i < response.length; i++) {
                                html += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                            }
                        }else{
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
            $('select[name=ac_type_filter]').change(function(){
                var ac_type=$('select[name=ac_type_filter]').val();

                (ac_type=='vendors')? $('#ac_label').html('Vendors'):$('#ac_label').html('Customers')
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{url("/getAccountsName")}}',
                    data: {ac_type: ac_type},
                    async: false,
                    dataType: 'json',
                    success: function(response) {
                        var html = '';
                        var i;
                        if(response.length > 0) {
                            for (i = 0; i < response.length; i++) {
                                html += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                            }
                        }else{
                            var html = '<option value="">Choose One</option>';
                            toastr.error('data not found');
                        }

                        $('#showAccountsFilter').html(html);

                    },
                    error: function() {
                        toastr.error('data not found');
                    }

                });
            });

            $('select[name=trans_mode]').change(function(){
                var trans_mode=$('select[name=trans_mode]').val();

                if(trans_mode=='bank'){
                    $(".bank_section").css("display", "block");
                    $(".payment-mode").css("display", "block");
                }else{

                    $(".bank_section").css("display", "none");
                    $(".payment-mode").css("display", "none");
                }

                if(trans_mode=='cash'){

                    $(".cash_section").css("display", "block");
                }else{

                    $(".cash_section").css("display", "none");
                }
            });

                $('#PaymentsForm').unbind().on('submit', function(e) {
                    e.preventDefault();
                    var $form = $(this);
                // check if the input is valid
                if (!$form.validate().form()) return false;
                var formData = new FormData(this);
                let file = $('#pic')[0];
                formData.append('file', file.files[0]);
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{url("payments")}}',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    async: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(data) {
                        if(data) {
                            $('#PaymentsForm')[0].reset();
                            toastr.success('Amount received successfully!');
                            window.location.reload();
                        }
                    },
                    complete: function(data) {
                        $("#btn-submit").html("Save");
                        $("#btn-submit").prop("disabled", false);
                    },

                    error: function() {
                        toastr.error('something went wrong');
                    },
                });
            });
            // chek available Account Balance

            //save Payments
            $('#CustomVendorForm').on('submit',function(e){
                e.preventDefault();

                var formData= $('#CustomVendorForm').serialize();


                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{url("create-vend-cus-account")}}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        if(data.success) {
                            $('#CustomVendorForm')[0].reset();
                            toastr.success(data.success);
                            window.location.reload();
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');

                    }
                });
            });
            //account type
            $('select[name=account_type]').change(function(){
                var account_type=$('select[name=account_type]').val();
                if(account_type=='clients') {
                    $("#fp_section").css("display", "none");
                }else{
                    $("#fp_section").css("display", "block");
                }



            });

            // payment mode
            $('select[name=payment_mode]').change(function(){
                var payment_mode=$('select[name=payment_mode]').val();
                // use 1 for online
                if(payment_mode==1){

                    $(".cheque-section").css("display", "none");
                    $(".bank_section").css("display", "block");
                }

                if(payment_mode==2){

                    $(".cheque-section").css("display", "block");
                    $(".bank_section").css("display", "block");
                }

            });
            //cheque_status
            $('select[name=cheque_status]').change(function(){
                var cheque_status=$('select[name=cheque_status]').val();

                // use 1 for online
                if(cheque_status==1){
                    $(".bank_section").css("display", "block");
                }else{
                    $(".bank_section").css("display", "none");
                }
            });

            // fetch account balance
            $('input[name=payment_amount]').on('keyup', function() {
                var trans_mode=$('select[name=trans_mode]').val();
                var amount=$('input[name=payment_amount]').val();
                if(trans_mode=='cash'){
                    var acType='company-account';
                    var ac_id=$('select[name=company_account_id]').val();
                }
                if(trans_mode=='bank'){
                    var acType='bank';
                    var ac_id=$('select[name=bank_id]').val();
                }

                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{url("get-account-balance")}}',
                    data: {ac_id: ac_id,ac_type:acType},
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        var currBalance=data;
                        if(parseFloat(amount) > parseFloat(currBalance)){
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
                        toastr.error('something went wrong');
                    }
                });
            });
        })
    </script>
@endsection
