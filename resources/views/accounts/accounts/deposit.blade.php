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
            <!-- Page Header -->
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Add Deposit</h3>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <h3 class="page-title bold-heading">Balance Sheet</h3>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <!-- /Page Content -->
            <div class="card" id="mainCard">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <form action="{{url('deposit')}}" method="POST" id="depositForm" class="needs-validation" novalidate >
@csrf

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for=""> Account</label>
                                                <select name="ac_id" id="" class="form-control">
                                                    <option value="">Choose Account</option>
                                                    @isset($data['accounts'])
                                                        @foreach($data['accounts'] as $account)
                                                            <option value="{{$account->id}}">{{$account->achead['ac_head']}}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                <div class="invalid-feedback">
                                                    please choose account.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for=""> Date</label>
                                                <input type="date" name="date" class="form-control"  required>
                                                <div class="invalid-feedback">
                                                    enter date.
                                                </div>
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


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Amount</label>
                                                <input type="number" name="amount" class="form-control" placeholder="amount" required>
                                                <div class="invalid-feedback">
                                                    enter amount
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12 ">
                                            <div class="submit-section">
                                                <button type="submit" class="btn btn-primary submit-btn add_vendor" id="btnSubmit">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-6 col-md-6" id="right_side">


                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>SR#</th>
                                        <th>Ac Holder</th>
                                        <th>Account</th>
                                        <th>Balance</th>
                                    </tr>
                                    </thead>
                                    <tbody id="accountsTable">


                                    </tbody>

                                    <tr>
                                        <td>
                                            <div class="float-right"> <strong>Total:</strong></div>
                                        </td>
                                        <td colspan="2">

                                        </td>
                                        <td> <strong>PKR <span id="total"></span></strong></td>

                                    </tr>
                                </table>
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

            getAccountsList();
            $('#depositForm').unbind().on('submit',function(e){
                e.preventDefault();

                var formData= $('#depositForm').serialize();

                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{url("deposit")}}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btnSubmit').prop('disabled',true);
                        $('#btnSubmit').text('loading...');
                    },
                    success: function(data) {

                        if(data.success) {
                            getAccountsList();
                            $('#depositForm')[0].reset();
                            toastr.success(data.success);
                        }
                        if(data.error){
                            toastr.error(data.error);
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

            function getAccountsList() {

                $.ajax({

                    url: '{{url("/balance-sheet")}}',
                    type: 'get',
                    async: false,
                    dataType: 'json',

                    success: function(data) {

                        var html = '';
                        var i;
                        var c = 0;
                        var total=0;

                        for (i = 0; i < data.length; i++) {
                            total=parseFloat(total)+ parseFloat(data[i].balance);
                            c++;
                            html += '<tr>' +
                                '<td>' + c + '</td>' +
                                '<td>' + data[i].ac_holder_name + '</td>' +
                                '<td>' + data[i].achead.ac_head + '</td>' +
                                '<td> PKR ' +data[i].balance + '</td>' +

                                '</tr>';
                        }

                        $('#total').html(total);
                        $('#accountsTable').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }

        });
    </script>

@endsection
