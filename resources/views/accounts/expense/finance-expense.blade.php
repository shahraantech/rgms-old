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
                    <h3 class="page-title bold-heading">Expense</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Expense</li>
                    </ul>
                </div>



                <div class="col-auto float-right ml-auto">
                    <a href="{{url('/expense-list')}}" class="btn add-btn" title="Banks List"><i class="fa fa-list" aria-hidden="true"></i></a>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="post" id="addExpenseHeadForm" action="" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm-2"></div>
                        <div class="form-group col-sm-8">
                            <label>Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="exp_head" required placeholder="Expense Name">

                        </div>
                        <div class="form-group col-sm-2">

                        </div>

                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn" type="submit" id="btnSubmit">Submit</button>
                    </div>


                </form>
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

