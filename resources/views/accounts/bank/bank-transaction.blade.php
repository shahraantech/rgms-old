@extends('setup.master')
@section('content')
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
                        <h3 class="page-title bold-heading">Banks Transaction</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Bank Transaction</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{url('/bank-summary')}}" class="btn add-btn" title="Transaction Summary"><i class="fa fa-list" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form method="post" id="transForm" action="" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Date <span class="text-danger">*</span></label>
                                <input class="form-control" type="date" name="date"  value="{{date('d-m-Y')}}">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Transaction Type<span class="text-danger">*</span></label>
                                <select name="trans_type" id="" class="form-control" required>
                                    <option value="">Choose Type</option>
                                    <option value="db">(+)</option>
                                    <option value="cr"> (-)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Bank Name<span class="text-danger">*</span></label>
                                <select name="bank_id"  class="form-control selectpicker" data-container="body"
                                        data-live-search="true"  required>
                                    <option value="">Choose Bank</option>
                                    @isset($data['bank_name'])
                                        @foreach($data['bank_name'] as $bank)
                                            <option value="{{$bank->id}}">{{$bank->bank_name}}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Branch<span class="text-danger">*</span></label>
                                <select name="branch_id"  class="form-control" id="showBranch" required>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Withdraw / Deposit ID<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="trans_id" placeholder="Transaction Id" required>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Amount<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="amount" required>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Narration<span class="text-danger">*</span></label>
                                <textarea name="" id="" cols="6" rows="2" class="form-control" name="narration" required></textarea>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn" type="submit" id="btnSubmit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script type='text/javascript'>
            $(document).ready(function() {

                //company_id dependent dropdown
                $('select[name=bank_id]').change(function() {

                    var bank_id = $('select[name=bank_id]').val();


                    $.ajax({

                        type: 'ajax',

                        method: 'get',

                        url: '{{url("/getBankBranches")}}',

                        data: {
                            bank_id: bank_id
                        },

                        async: false,

                        dataType: 'json',

                        success: function(data) {


                            var html = '<option value="">Choose Branch</option>';

                            var i;
                            if (data.length > 0) {

                                for (i = 0; i < data.length; i++) {

                                    html += '<option value="' + data[i].id + '">' + data[i].branch + '</option>';
                                }
                            } else {
                                var html = '<option value="">Choose Branch</option>';
                                toastr.error('data not found');
                            }


                            $('#showBranch').html(html);

                        },

                        error: function() {

                            toastr.error('db error');


                        }

                    });
                });



                $('#transForm').unbind().on('submit',function(e){
                    e.preventDefault();

                    var formData= $('#transForm').serialize();


                    $.ajax({

                        type: 'ajax',
                        method: 'post',
                        url: '{{url("bank-transaction")}}',
                        data: formData,
                        async: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $('#btnSubmit').prop('disabled',true);
                            $('#btnSubmit').text('loading...');
                        },
                        success: function(data) {

                            if(data.success) {
                                $('#transForm')[0].reset();
                                toastr.success(data.success);
                            }
                        },
                        complete: function() {
                            $('#btnSubmit').prop('disabled',false);
                            $('#btnSubmit').text('Submit');

                        },

                        error: function() {
                            toastr.error('something went wrong');

                        }

                    });


                });

            })
        </script>
@endsection
