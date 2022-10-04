@extends('setup.master')

@section('content')


<style type="text/css">
    body {
        font-family: Arial;
        font-size: 10pt;
    }

    table {
        /* border: 1px solid #ccc; */
        /* border-collapse: collapse; */
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

    #sheet {
        background-color: grey;
        padding: 5px;
    }
    .bor{
        border: 1px solid #ccc;
    }
</style>
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">


        <div class="page-header my-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title text-center">CHART OF ACCOUNTS</h3>
                </div>

            </div>
        </div>



        <div class="card">
            <div class="card-body">
                <div class="row">
                    
                    <div class="col-md-6">
                    <div class="bor">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <h4 class="text-center" id="sheet">BALANCE SHEET</h4>
                                </tr>
                                <tr>
                                    <h6 class="text-center font-weight-bold">Assets</h6>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Current <br> Assets</td>
                                    <td>
                                        <p>Bank 1(main banking account)</p>
                                        <p>Bank 2(Account Sheet)</p>
                                        <p>Pety Cash</p>
                                        <p>Accounts Receivable</p>
                                        <p>Inventor</p>
                                        <p>Bank 1(main banking account)</p>
                                    </td>
                                    <td>4001</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">No Current <br> Assets</td>
                                    <td>
                                        <p>Bank 1(main banking account)</p>
                                        <p>Bank 2(Account Sheet)</p>
                                        <p>Pety Cash</p>
                                        <p>Accounts Receivable</p>
                                        <p>Inventor</p>
                                        <p>Bank 1(main banking account)</p>
                                    </td>
                                    <td>4001</td>

                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Fixed <br> Assets</td>
                                    <td>
                                        <p>Bank 1(main banking account)</p>
                                        <p>Bank 2(Account Sheet)</p>
                                        <p>Pety Cash</p>
                                        <p>Accounts Receivable</p>
                                        <p>Inventor</p>
                                        <p>Bank 1(main banking account)</p>
                                    </td>
                                    <td>4001</td>

                                </tr>

                            </tbody>
                        </table>
                        
                        <table class="table">
                            <tbody>
                                <tr>
                                    <h5 class="text-center font-weight-bold" id="asset">Liablities</h5>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Current <br> Liablities</td>
                                    <td>
                                        <p>Bank 1(main banking account)</p>
                                        <p>Bank 2(Account Sheet)</p>
                                        <p>Pety Cash</p>
                                        <p>Accounts Receivable</p>
                                        <p>Inventor</p>
                                        <p>Bank 1(main banking account)</p>
                                    </td>
                                    <td>4001</td>

                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Non Current <br> Liablities</td>
                                    <td>
                                        <p>Bank 1(main banking account)</p>
                                        <p>Bank 2(Account Sheet)</p>
                                        <p>Pety Cash</p>
                                        <p>Accounts Receivable</p>
                                        <p>Inventor</p>
                                        <p>Bank 1(main banking account)</p>
                                    </td>
                                    <td>4001</td>
                                </tr>

                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="bor">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <h4 class="text-center" id="sheet">INCOME STATEMENT</h4>
                                </tr>
                                <tr>
                                    <h6 class="text-center font-weight-bold">Assets</h6>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Income</td>
                                    <td>
                                        <p>Bank 1(main banking account)</p>
                                        <p>Bank 2(Account Sheet)</p>
                                        <p>Pety Cash</p>
                                        <p>Accounts Receivable</p>
                                        <p>Inventor</p>
                                        <p>Bank 1(main banking account)</p>
                                    </td>
                                    <td>4001</td>

                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Ohter <br> Income</td>
                                    <td>
                                        <p>Bank 1(main banking account)</p>
                                        <p>Bank 2(Account Sheet)</p>
                                        <p>Pety Cash</p>
                                        <p>Accounts Receivable</p>
                                        <p>Inventor</p>
                                        <p>Bank 1(main banking account)</p>
                                    </td>
                                    <td>4001</td>

                                </tr>

                            </tbody>
                        </table>

                        <table class="table">
                            <tbody>
                                <tr>
                                    <h5 class="text-center font-weight-bold" id="asset"></h5>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Cost of <br> Sales I <br> Goods <br> Sold</td>
                                    <td>
                                        <p>Bank 1(main banking account)</p>
                                        <p>Bank 2(Account Sheet)</p>
                                        <p>Pety Cash</p>
                                        <p>Accounts Receivable</p>
                                        <p>Inventor</p>
                                        <p>Bank 1(main banking account)</p>
                                    </td>
                                    <td>4001</td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
                
            </div>
        </div>


        <!-- /Page Content -->
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function() {

            // save category
            $('#addExpenseHeadForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $('#addExpenseHeadForm').serialize();

                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{url("finance-expense")}}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        if (data.success) {
                            $('#addExpenseHeadForm')[0].reset();
                            toastr.success(data.success);
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    },

                    error: function() {
                        toastr.error('something went wrong');

                    }

                });
            });

        });
    </script>

    @endsection