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
                        <h3 class="page-title bold-heading">Journal Voucher</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Journal Voucher</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#journal-vochars-list" class="btn add-btn" title="Journal Vochars List"><i class="fa fa-list" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form method="post" id="JvForm" class="needs-validation" novalidate action="{{url('jv')}}">
                        @csrf

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>DEBT ACCOUNTS</label>
                                    <select name="debetors" id="" class="form-control" required>
                                        <option value="">Choose One</option>
                                        <option value="1">Cash A/C</option>
                                        <option value="2">Bank A/C</option>
                                        <option value="3">Customers</option>
                                        <option value="4">Vendors</option>
                                        <option value="5">Expenses</option>
                                        <option value="6">Liability</option>
                                        <option value="7">Assets</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 de-cash-ac" style="display: none">
                                <div class="form-group">
                                    <label>Cash A/C</label>
                                    <select name="dr_cash_ac_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
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
                            <div class="col-sm-6 de-bank-ac" style="display: none">
                                <div class="form-group">
                                    <label>Banks</label>
                                    <select name="dr_bank_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['banks'])
                                            @foreach($data['banks'] as $bank)
                                                @php
                                                    $headName=App\Models\Ledger::getLevelHeadName($bank->level_no,$bank->head_id);
                                                @endphp
                                                <option value="{{$bank->id}}">{{$headName}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 de-client-ac" style="display: none">
                                <div class="form-group">
                                    <label>Customers</label>
                                    <select name="dr_client_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['customer'])
                                            @foreach($data['customer'] as $customer)
                                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 de-vendor-ac" style="display: none">
                                <div class="form-group">
                                    <label>Vendors</label>
                                    <select name="dr_vendor_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['vendors'])
                                            @foreach($data['vendors'] as $vendor)
                                                <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
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
                                        <option value="1">Cash A/C</option>
                                        <option value="2">Bank A/C</option>
                                        <option value="3">Customers</option>
                                        <option value="4">Vendors</option>
                                        <option value="5">Expenses</option>
                                            <option value="6">Liability</option>
                                            <option value="7">Assets</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 cash-ac" style="display: none">
                                <div class="form-group">
                                    <label>Cash A/C</label>
                                    <select name="cr_cash_ac_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
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
                            <div class="col-sm-6 bank-ac" style="display: none">
                                <div class="form-group">
                                    <label>Banks</label>
                                    <select name="cr_bank_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['banks'])
                                            @foreach($data['banks'] as $bank)
                                                @php
                                                    $headName=App\Models\Ledger::getLevelHeadName($bank->level_no,$bank->head_id);
                                                @endphp
                                                <option value="{{$bank->id}}">{{$headName}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 client-ac" style="display: none">
                                <div class="form-group">
                                    <label>Customers</label>
                                    <select name="cr_client_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['customer'])
                                            @foreach($data['customer'] as $customer)
                                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 vendor-ac" style="display: none">
                                <div class="form-group">
                                    <label>Vendors</label>
                                    <select name="cr_vendor_id" id="" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="">Choose One</option>
                                        @isset($data['vendors'])
                                            @foreach($data['vendors'] as $vendor)
                                                <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
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
                                    <input type="number" class="form-control" required name="amount" placeholder="Amount">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <input type="text" class="form-control" required name="remarks" placeholder="Remarks">
                                </div>
                            </div>
                        </div>

                        <div class="float-right">
                            <button class="btn btn-primary btn-submit" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped" id="journal-vochars-list">
                        <tr>
                            <th>#</th>
                            <th>Dr</th>
                            <th>Cr</th>
                            <th>Amount</th>
                            <th>Remarks</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        <tbody>
                        @php $c=0;
                  $subTotal=0;
                        @endphp
                        @isset($data['jv'])
                            @foreach($data['jv'] as $jv)
                                @php $c++;
                  $subTotal=$subTotal+$jv['amount'];
                                @endphp
                                <tr>
                                    <td>{{$c}}</td>
                                    <td>{{$jv['dr']}}</td>
                                    <td>{{$jv['cr']}}</td>
                                    <td>{{number_format($jv['amount'],2)}}</td>
                                    <td>{{$jv['remarks']}}</td>
                                    <td>{{$jv['date']}}</td>


                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                               aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{url('rv').'/'.$jv['id']}}" title="Print" class="dropdown-item bg-inverse-primary"><i class="fa fa-print" aria-hidden="true"></i></a>&nbsp;
                                                <a title="Edit" href="{{url('edit-jv').'/'.$jv['id']}}" class="dropdown-item bg-inverse-primary"> <i class="fa fa-edit" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
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
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script type='text/javascript'>
            $(document).ready(function (){
                $('select[name=creditor]').change(function(){

                    var creditor=$('select[name=creditor]').val();
                    if(creditor==1) {
                        $(".cash-ac").css("display", "block");
                        $(".bank-ac").css("display", "none");
                        $(".client-ac").css("display", "none");
                        $(".vendor-ac").css("display", "none");
                        $(".expense-ac").css("display", "none");
                    }

                    if(creditor==2) {
                        $(".cash-ac").css("display", "none");
                        $(".bank-ac").css("display", "block");
                        $(".client-ac").css("display", "none");
                        $(".vendor-ac").css("display", "none");
                        $(".expense-ac").css("display", "none");
                    }

                    if(creditor==3) {
                        $(".cash-ac").css("display", "none");
                        $(".bank-ac").css("display", "none");
                        $(".client-ac").css("display", "block");
                        $(".vendor-ac").css("display", "none");
                        $(".expense-ac").css("display", "none");
                    }

                    if(creditor==4) {
                        $(".cash-ac").css("display", "none");
                        $(".bank-ac").css("display", "none");
                        $(".client-ac").css("display", "none");
                        $(".vendor-ac").css("display", "block");
                        $(".expense-ac").css("display", "none");
                    }


                    if(creditor==5) {
                        $(".cash-ac").css("display", "none");
                        $(".bank-ac").css("display", "none");
                        $(".client-ac").css("display", "none");
                        $(".vendor-ac").css("display", "none");
                        $(".expense-ac").css("display", "block");
                    }

                    // liability-ac
                    if(creditor==6) {

                        $(".cash-ac").css("display", "none");
                        $(".bank-ac").css("display", "none");
                        $(".client-ac").css("display", "none");
                        $(".vendor-ac").css("display", "none");
                        $(".expense-ac").css("display", "none");
                        $(".liability-ac").css("display", "block");


                    }

                   // assets-ac
                    if(creditor==7) {

                        $(".cash-ac").css("display", "none");
                        $(".bank-ac").css("display", "none");
                        $(".client-ac").css("display", "none");
                        $(".vendor-ac").css("display", "none");
                        $(".expense-ac").css("display", "none");
                        $(".liability-ac").css("display", "none");
                        $(".assets-ac").css("display", "block");


                    }


                });
                //debetors
                $('select[name=debetors]').change(function(){

                    var debetors=$('select[name=debetors]').val();

                    if(debetors==1) {
                        $(".de-cash-ac").css("display", "block");
                        $(".de-bank-ac").css("display", "none");
                        $(".de-client-ac").css("display", "none");
                        $(".de-vendor-ac").css("display", "none");
                        $(".de-expense-ac").css("display", "none");
                        $(".de-liability-ac").css("display", "none");
                        $(".de-assets-ac").css("display", "none");
                    }

                    if(debetors==2) {
                        $(".de-cash-ac").css("display", "none");
                        $(".de-bank-ac").css("display", "block");
                        $(".de-client-ac").css("display", "none");
                        $(".de-vendor-ac").css("display", "none");
                        $(".de-expense-ac").css("display", "none");
                        $(".de-liability-ac").css("display", "none");
                        $(".de-assets-ac").css("display", "none");
                    }

                    if(debetors==3) {
                        $(".de-cash-ac").css("display", "none");
                        $(".de-bank-ac").css("display", "none");
                        $(".de-client-ac").css("display", "block");
                        $(".de-vendor-ac").css("display", "none");
                        $(".de-expense-ac").css("display", "none");
                        $(".de-liability-ac").css("display", "none");
                        $(".de-assets-ac").css("display", "none");
                    }

                    if(debetors==4) {
                        $(".de-cash-ac").css("display", "none");
                        $(".de-bank-ac").css("display", "none");
                        $(".de-client-ac").css("display", "none");
                        $(".de-vendor-ac").css("display", "block");
                        $(".de-expense-ac").css("display", "none");
                        $(".de-liability-ac").css("display", "none");
                        $(".de-assets-ac").css("display", "none");
                    }
                    if(debetors==5) {
                        $(".de-cash-ac").css("display", "none");
                        $(".de-bank-ac").css("display", "none");
                        $(".de-client-ac").css("display", "none");
                        $(".de-vendor-ac").css("display", "none");
                        $(".de-expense-ac").css("display", "block");
                        $(".de-assets-ac").css("display", "none");
                        $(".de-liability-ac").css("display", "none");
                    }

                    //de-liability-ac
                    if(debetors==6) {

                        $(".de-cash-ac").css("display", "none");
                        $(".de-bank-ac").css("display", "none");
                        $(".de-client-ac").css("display", "none");
                        $(".de-vendor-ac").css("display", "none");
                        $(".de-expense-ac").css("display", "none");
                        $(".de-assets-ac").css("display", "none");
                        $(".de-liability-ac").css("display", "block");
                        $(".de-assets-ac").css("display", "none");

                    }

                    //assets

                    if(debetors==7) {

                        $(".de-cash-ac").css("display", "none");
                        $(".de-bank-ac").css("display", "none");
                        $(".de-client-ac").css("display", "none");
                        $(".de-vendor-ac").css("display", "none");
                        $(".de-expense-ac").css("display", "none");
                        $(".de-liability-ac").css("display", "none");
                        $(".de-assets-ac").css("display", "block");

                    }


                });
            //submit JV form
                $('#JvForm').unbind().on('submit', function(e) {
                    e.preventDefault();
                    var formData = $('#JvForm').serialize();
                    $.ajax({
                        type: 'ajax',
                        method: 'post',
                        url: '{{url("jv")}}',
                        data: formData,
                        async: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $(".btn-submit").prop("disabled", true);
                            $(".btn-submit").html("please wait...");
                        },
                        success: function(data) {

                            if (data.success) {
                                toastr.success(data.success);
                                window.location.reload();
                            }
                            if (data.errors) {
                                toastr.error(data.errors);
                            }
                        },
                        complete : function(data){
                            $(".btn-submit").html("Save");
                            $(".btn-submit").prop("disabled", false);
                        },
                        error: function() {
                            toastr.error('something went wrong');
                        },
                    });
                });


            })
        </script>
    @endsection
