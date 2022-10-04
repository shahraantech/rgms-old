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
                        <h3 class="page-title bold-heading">Banks</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Bank Trial Balance</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{url('/manage-bank')}}" class="btn add-btn" title="Banks List"><i class="fa fa-list" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{url('bank')}}" method="POST" id="bankForm" class="needs-validation" novalidate >
                        @csrf
                        @include('accounts.coa.coa-level')
                        <div class="row">

                            <div class="form-group col-sm-4">
                                <label>Date<span class="text-danger">*</span></label>
                                <input class="form-control" type="date" name="date" required>
                                <div class="invalid-feedback">
                                    Enter date.
                                </div>
                                <span id="show_error"></span>
                            </div>

                            <div class="form-group col-sm-4">
                                <label>Balance<span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="balance" required placeholder="Enter Open Balance" >
                                <div class="invalid-feedback">
                                    Please Open  Balance.
                                </div>
                                <span id="show_error"></span>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-primary submit-btn mt-4" type="submit" id="btnSubmit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
            $(document).ready(function() {



                $('#bankForm').unbind().on('submit',function(e){
                    e.preventDefault();
                    var formData= $('#bankForm').serialize();
                    $.ajax({
                        type: 'ajax',
                        method: 'post',
                        url: '{{url("bank")}}',
                        data: formData,
                        async: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $('#btnSubmit').prop('disabled',true);
                            $('#btnSubmit').text('loading...');
                        },
                        success: function(data) {

                            if(data.success) {
                                $('#bankForm')[0].reset();
                                toastr.success(data.success);
                            }
                            if(data.errors) {
                                toastr.error(data.errors);
                            }
                        },
                        complete: function() {
                            $('#btnSubmit').prop('disabled',false);
                            $('#btnSubmit').text('Save');

                        },

                        error: function() {
                            toastr.error('something went wrong');

                        }

                    });


                });

                //validation for contact
                var minLength = 14;
                var maxLength = 14;
                $('#ac_number').on('keydown keyup change', function() {
                    var char = $(this).val();
                    var charLength = $(this).val().length;
                    if (charLength < minLength) {
                        $('#show_error').html('Length is short minimum ' + minLength);
                        $('#show_error').css('color', 'red');
                    } else if (charLength > maxLength) {
                        $('#show_error').html('Length is not valid maximum ' + maxLength + ' allowed.');
                        $('#show_error').css('color', 'red');
                        $(this).val(char.substring(0, maxLength));
                    } else {
                        $('#show_error').html('');
                    }
                });

            });
        </script>
@endsection
