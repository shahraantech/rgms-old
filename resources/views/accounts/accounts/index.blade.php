@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Trial Balance</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Trial Balance</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{url('/accounts-list')}}" class="btn add-btn" title="Banks List"><i class="fa fa-list" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{url('accounts')}}" method="POST" id="accountsForm" class="needs-validation" novalidate >
                        @csrf
                            @include('accounts.coa.coa-level')
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Date</label>
                                        <input type="date" name="date" class="form-control">

                                    </div>
                                </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Open Balance</label>
                                    <input type="number" name="open_bal" class="form-control" placeholder="Opening Balance" required>
                                    <div class="invalid-feedback">
                                        Please Enter Open Balance.
                                    </div>
                                </div>
                            </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary submit-btn add_vendor mt-4" id="btnSubmit">Save</button>

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



                $('#accountsForm').unbind().on('submit',function(e){
                    e.preventDefault();

                    var formData= $('#accountsForm').serialize();

                    $.ajax({

                        type: 'ajax',
                        method: 'post',
                        url: '{{url("accounts")}}',
                        data: formData,
                        async: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $('#btnSubmit').prop('disabled',true);
                            $('#btnSubmit').text('loading...');
                        },
                        success: function(data) {

                            if(data.success) {
                                $('#accountsForm')[0].reset();
                                toastr.success(data.success);

                                setTimeout(function() {
                                    window.location = '{{url("accounts-list")}}';
                                }, 2000);
                            }
                            if(data.errors){
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
