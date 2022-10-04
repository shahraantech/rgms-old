@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Edit Journal</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Journal Voucher</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#payments-list" class="btn add-btn" title="Payments List"><i class="fa fa-list" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form method="post" id="JvForm" class="needs-validation" novalidate action="{{url('update-jv')}}">
                        @csrf
                        <input type="hidden" name="hidden_trans_id" value="{{$data['edit_rec']['trans_id']}}">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>DEBT ACCOUNTS</label>
                                    <select name="debetors" id="" class="form-control" required>
                                        <option value="">Choose One</option>

                                        <option value="1" @php
                                            if($data['edit_rec']['dr_company_ac_id'] > 0) {
                                                echo "selected";
                                            }
                                        @endphp>Cash A/C</option>
                                        <option value="2" @php
                                            if($data['edit_rec']['dr_bank_ac_id'] > 0) {
                                                echo "selected";
                                            }
                                        @endphp>Bank A/C</option>
                                        <option value="3" @php
                                            if($data['edit_rec']['dr_client_ac_id'] > 0) {
                                                echo "selected";
                                            }
                                        @endphp>Customers</option>
                                        <option value="4" @php
                                            if($data['edit_rec']['dr_vendor_ac_id'] > 0) {
                                                echo "selected";
                                            }
                                        @endphp>Vendors</option>
                                        <option value="5">Expenses</option>
                                        <option value="6">Liability</option>
                                        <option value="7">Assets</option>
                                    </select>
                                </div>
                            </div>
                            @if($data['edit_rec']['dr_company_ac_id'] > 0)
                            <div class="col-sm-6 de-cash-ac">
                                <div class="form-group">
                                    <label>Cash A/C</label>
                                    <select name="dr_cash_ac_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['accounts'])
                                            @foreach($data['accounts'] as $accounts)
                                                @php
                                                    $headName=App\Models\Ledger::getLevelHeadName($accounts->level_no,$accounts->ac_head_id);
                                                @endphp
                                                <option value="{{$accounts->id}}"
                                                    @php
                                                    if($data['edit_rec']['dr_company_ac_id']==$accounts->id) {
                                                        echo "selected";
                                                    }
                                                @endphp>{{$headName}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            @endif
                            @if($data['edit_rec']['dr_bank_ac_id'] > 0)
                            <div class="col-sm-6 de-bank-ac" >
                                <div class="form-group">
                                    <label>Banks</label>
                                    <select name="dr_bank_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['banks'])
                                            @foreach($data['banks'] as $bank)
                                                @php
                                                    $headName=App\Models\Ledger::getLevelHeadName($bank->level_no,$bank->head_id);
                                                @endphp
                                                <option value="{{$bank->id}}"
                                                    @php
                                                    if($data['edit_rec']['dr_bank_ac_id']==$bank->id) {
                                                        echo "selected";
                                                    }
                                                @endphp
                                                >{{$headName}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            @endif
                            @if($data['edit_rec']['dr_client_ac_id'] > 0)
                            <div class="col-sm-6 de-client-ac">
                                <div class="form-group">
                                    <label>Customers</label>
                                    <select name="dr_client_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['customer'])
                                            @foreach($data['customer'] as $customer)
                                                <option value="{{$customer->id}}"
                                                    @php
                                                    if($data['edit_rec']['dr_client_ac_id']==$customer->id) {
                                                        echo "selected";
                                                    }
                                                @endphp>{{$customer->name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            @endif

                            @if($data['edit_rec']['dr_vendor_ac_id'] > 0)
                            <div class="col-sm-6 de-vendor-ac" >
                                <div class="form-group">
                                    <label>Vendors</label>
                                    <select name="dr_vendor_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['vendors'])
                                            @foreach($data['vendors'] as $vendor)
                                                <option value="{{$vendor->id}}"
                                                    @php
                                                    if($data['edit_rec']['dr_vendor_ac_id']==$vendor->id) {
                                                        echo "selected";
                                                    }
                                                @endphp>{{$vendor->name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-sm-6 de-expense-ac" style="display: none">
                                <div class="form-group">
                                    <label>Expenses</label>
                                    <select name="dr_expense_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['level4'])
                                            @foreach($data['level4'] as $head)
                                                <option value="{{$head->id}}">{{$head->level_head}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 de-liability-ac" style="display: none">
                                <div class="form-group">
                                    <label>Liability</label>
                                    <select name="dr_liability_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['liability'])
                                            @foreach($data['liability'] as $head)
                                                <option value="{{$head->id}}">{{$head->level_head}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 de-assets-ac" style="display: none">
                                <div class="form-group">
                                    <label>Assets</label>
                                    <select name="dr_assets_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['assets'])
                                            @foreach($data['assets'] as $head)
                                                <option value="{{$head->id}}">{{$head->level_head}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>CREDIT ACCOUNTS</label>

                                    <select name="creditor" id="" class="form-control selectpicker creditor" data-container="body" data-live-search="true" required>

                                        <option value="">Choose One</option>
                                        <option value="1" @php
                                            if($data['edit_rec']['cr_company_ac_id'] > 0) {
                                                echo "selected";
                                            }
                                        @endphp>Cash A/C</option>
                                        <option value="2" @php
                                            if($data['edit_rec']['cr_bank_ac_id'] > 0) {
                                                echo "selected";
                                            }
                                        @endphp>Bank A/C</option>
                                        <option value="3" @php
                                            if($data['edit_rec']['cr_client_ac_id'] > 0) {
                                                echo "selected";
                                            }
                                        @endphp>Customers</option>
                                        <option value="4" @php
                                            if($data['edit_rec']['cr_vendor_ac_id'] > 0) {
                                                echo "selected";
                                            }
                                        @endphp>Vendors</option>
                                        <option value="5" >Expenses</option>
                                        <option value="6" >Liability</option>
                                        <option value="7">Assets</option>
                                    </select>
                                </div>
                            </div>

                            @if($data['edit_rec']['cr_company_ac_id'] > 0)
                            <div class="col-sm-6 cash-ac">
                                <div class="form-group">
                                    <label>Cash A/C</label>
                                    <select name="cr_cash_ac_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['accounts'])
                                            @foreach($data['accounts'] as $accounts)
                                                @php
                                                    $headName=App\Models\Ledger::getLevelHeadName($accounts->level_no,$accounts->ac_head_id);
                                                @endphp
                                                <option value="{{$accounts->id}}" @php
                                                    if($data['edit_rec']['cr_company_ac_id']==$accounts->id) {
                                                        echo "selected";
                                                    }
                                                @endphp>{{$headName}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            @endif
                            @if($data['edit_rec']['cr_bank_ac_id'] > 0)
                            <div class="col-sm-6 bank-ac" >
                                <div class="form-group">
                                    <label>Banks</label>
                                    <select name="cr_bank_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['banks'])
                                            @foreach($data['banks'] as $bank)
                                                @php
                                                    $headName=App\Models\Ledger::getLevelHeadName($bank->level_no,$bank->head_id);
                                                @endphp
                                                <option value="{{$bank->id}}"  @php
                                                    if($data['edit_rec']['cr_bank_ac_id']==$bank->id) {
                                                        echo "selected";
                                                    }
                                                @endphp>{{$headName}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            @endif
                            @if($data['edit_rec']['cr_client_ac_id'] > 0)
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Customers</label>
                                    <select name="cr_client_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['customer'])
                                            @foreach($data['customer'] as $customer)
                                                <option value="{{$customer->id}}" @php
                                                    if($data['edit_rec']['cr_client_ac_id']==$customer->id) {
                                                        echo "selected";
                                                    }
                                                @endphp>{{$customer->name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            @endif
                            @if($data['edit_rec']['cr_vendor_ac_id'] > 0)
                            <div class="col-sm-6 vendor-ac">
                                <div class="form-group">
                                    <label>Vendors</label>
                                    <select name="cr_vendor_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['vendors'])
                                            @foreach($data['vendors'] as $vendor)
                                                <option value="{{$vendor->id}}" @php
                                                    if($data['edit_rec']['cr_vendor_ac_id']==$vendor->id) {
                                                        echo "selected";
                                                    }
                                                @endphp>{{$vendor->name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-sm-6 expense-ac" style="display: none">
                                <div class="form-group">
                                    <label>Expenses</label>
                                    <select name="cr_expense_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['level4'])
                                            @foreach($data['level4'] as $head)
                                                <option value="{{$head->id}}">{{$head->level_head}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 liability-ac" style="display: none">
                                <div class="form-group">
                                    <label>Liability</label>
                                    <select name="cr_liability_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['liability'])
                                            @foreach($data['liability'] as $head)
                                                <option value="{{$head->id}}">{{$head->level_head}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 assets-ac" style="display: none">
                                <div class="form-group">
                                    <label>Assets</label>
                                    <select name="cr_assets_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['assets'])
                                            @foreach($data['assets'] as $head)
                                                <option value="{{$head->id}}">{{$head->level_head}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" class="form-control" required name="payment_amount" placeholder="Amount" value="{{$data['edit_rec']['amount']}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <input type="text" class="form-control" required name="desc" placeholder="Remarks" value="{{$data['edit_rec']['remarks']}}">
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type='text/javascript'>
        $(document).ready(function (){

            //submit JV form
            $('#JvForm').unbind().on('submit', function(e) {
                e.preventDefault();
                var formData = $('#JvForm').serialize();
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{url("update-jv")}}',
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
                            window.location = '{{url("jv")}}';
                        }
                        if (data.errors) {
                            toastr.error(data.errors);
                        }
                    },
                    complete : function(data){
                        $(".btn-save-changes").html("Save");
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
