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
                        <h3 class="page-title bold-heading">Add Expense</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Expense </li>
                        </ul>
                    </div>

                    <div class="col-auto float-right ml-auto">
                        <a href="{{ url('/expense-summary') }}" class="btn add-btn" title="Expense Summary"><i
                                class="fa fa-list" aria-hidden="true"></i></a>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form method="post" id="expenseForm" action="{{ url('manage-expense') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" name="exp_date" required>
                                    <span class="balance-error"></span>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Payment Mode</label>
                                    <select class="select" name="trans_mode" required>
                                        <option value="">Payment Mode</option>
                                        <option value="cash">Cash</option>
                                        <option value="bank">Bank</option>
                                    </select>
                                    
                                </div>
                            </div>

                            <div class="col-md-3 cash-section" style="display: none">
                                <div class="form-group">
                                    <label for="">Account</label>
                                    <select name="company_account_id" id="" class="form-control ac-bank inpCash">
                                        <option value="">Pay To Account</option>
                                        @isset($data['accounts'])
                                            @foreach ($data['accounts'] as $accounts)
                                                @php
                                                    $headName = App\Models\Ledger::getLevelHeadName($accounts->level_no, $accounts->ac_head_id);
                                                @endphp
                                                <option value="{{ $accounts->id }}">{{ $headName }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                    
                                </div>
                            </div>

                            <div class="col-sm-3 bank_section" style="display:none">
                                <div class="form-group">
                                    <option value="">Banks</option>
                                    <select name="bank_id" id="" class="form-control ac-bank inpBank">
                                        <option value="">Choose Bank</option>
                                        @isset($data['banks'])
                                            @foreach ($data['banks'] as $bank)
                                                @php
                                                    $headName = App\Models\Ledger::getLevelHeadName($bank->level_no, $bank->head_id);
                                                @endphp
                                                <option value="{{ $bank->id }}" data-bank-id="{{ $bank->id }}">
                                                    {{ $headName }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 balance-section" style="display: none">
                                <div class="form-group">
                                    <label for="">Avail Balance</label>
                                    <input type="text" class="form-control" name="balance" readonly>

                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Attachment</label>
                                    <input type="file" class="form-control" name="file" id="pic" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- tabel start -->
                            <table class="table table-bordered mt-5 table-style">
                                <thead>
                                    <tr>
                                        <th>Exp Head <span class="text-danger">*</span></th>
                                        <th>Remarks <span class="text-danger">*</span></th>
                                        <th>Amount <span class="text-danger">*</span></th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tblPurchase">
                                    <tr>
                                        <td>

                                            <select name="exp_head_id[]" class="form-control selectpicker"
                                                data-container="body" data-live-search="true" required>
                                                <option value="">Choose Head</option>
                                                @isset($data['level4'])
                                                    @foreach ($data['level4'] as $head)
                                                        <option value="{{ $head->id }}">{{ $head->level_head }}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control qty" placeholder="Remarks"
                                                name="remarks[]" required>
                                            <div class="qty-error"></div>
                                        </td>
                                        <td><input type="number" class="form-control amount" placeholder="0.00"
                                                name="amount[]" required></td>

                                        <td><button type="button" class="btn-primary" id="addNewRow"><i
                                                    class="fa fa-plus"></i></button> </td>
                                    </tr>
                                </tbody>
                                <tbody id="footerSection">
                                    <tr>
                                        <td colspan="2">
                                            <div class="float-right">Grand Total :</div>
                                        </td>
                                        <td><input type="number" class="form-control" placeholder="0.00"
                                                name="grand_total" readonly></td>

                                    </tr>
                                </tbody>
                            </table>
                            <div class="col-md-10"></div>
                            <div class="col-md-2">
                                <button class="btn btn-primary pull-right" id="btnSubmit">Save</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>


        <script type="text/javascript">
            $(function() {
                $('#addNewRow').on('click', function() {
                    var tr = $("#dvOrders").find("Table").find("TR:has(td)").clone();
                    console.log(tr);
                    $("#tblPurchase").append(tr);
                });
            });
        </script>
        <div id="dvOrders" style="display:none">
            <table class="table table-bordered mt-5 table-style secondtable ">
                <tr>
                    <td>
                        <select name="exp_head_id[]" class="form-control " data-container="body" data-live-search="true"
                            required>
                            <option value="">Choose Head</option>
                            @isset($data['level4'])
                                @foreach ($data['level4'] as $head)
                                    <option value="{{ $head->id }}">{{ $head->level_head }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control qty" placeholder="Remarks" name="remarks[]" required>
                        <div class="qty-error"></div>
                    </td>
                    <td><input type="number" class="form-control amount" placeholder="0.00" name="amount[]" required>
                    </td>
                    <td style="color:red;cursor: pointer" class="delete-row" title="Remove"><i class="fa fa-trash"></i>
                    </td>
                </tr>
            </table>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
        <script>
            $(document).ready(function() {

                $('#expenseForm').validate({

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

                $('#expenseForm').unbind().on('submit', function(e) {
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
                        url: '{{ url('manage-expense') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: formData,
                        async: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $('#btnSubmit').prop('disabled', true);
                            $('#btnSubmit').text('loading...');
                        },
                        success: function(data) {
                            console.log(data);
                            if (data.success) {
                                toastr.success('Expense added successfully');
                                $('#expenseForm')[0].reset();
                            }

                            if (data.errors) {
                                toastr.error('missing some fields');
                            }
                        },
                        complete: function() {
                            $('#btnSubmit').prop('disabled', false);
                            $('#btnSubmit').text('Save');

                        },
                        error: function() {
                            toastr.error('something went wrong');

                        }
                    });

                });
                // Denotes total number of rows
                var rowIdx = 0;
                // jQuery button click event to remove a row.
                $('#tblPurchase').on('click', '.delete-row', function() {

                    // Getting all the rows next to the row
                    // containing the clicked button
                    var child = $(this).closest('tr').nextAll();

                    // Iterating across all the rows
                    // obtained to change the index
                    child.each(function() {

                        // Getting <tr> id.
                        var id = $(this).attr('id');

                        // Getting the <p> inside the .row-index class.
                        var idx = $(this).children('.row-index').children('p');

                        // Gets the row number from <tr> id.
                        var dig = parseInt(id.substring(1));

                        // Modifying row index.
                        idx.html(`Row ${dig - 1}`);

                        // Modifying row id.
                        $(this).attr('id', `R${dig - 1}`);
                    });

                    // Removing the current row.
                    $(this).closest('tr').remove();

                    // Decreasing total number of rows by 1.
                    rowIdx--;
                });
                //count ttoal Amount
                $('#tblPurchase').on('keyup', '.amount', function() {
                    grandTotal();

                    var availBalance = $('input[name=balance]').val();
                    var grandTotalAmount = $('input[name=grand_total]').val();

                    if (parseFloat(availBalance) < parseFloat(grandTotalAmount)) {
                        $("#btnSubmit").prop("disabled", true);
                        toastr.error('Insufficent balance');
                    } else {
                        $("#btnSubmit").prop("disabled", false);
                    }

                });

                function grandTotal() {
                    var grandTotal = 0;
                    $(".amount").each(function() {
                        var amount = $(this).val();
                        (amount) ? grandTotal = parseFloat(grandTotal) + parseFloat(amount): '';
                        $('input[name=grand_total]').val(grandTotal);
                    });
                }
                // fetch account balance
                $('.ac-bank').on('change', function() {
                    var trans_mode = $('select[name=trans_mode]').val();

                    if (trans_mode == 'cash') {
                        var acType = 'company-account';
                        var ac_id = $('select[name=company_account_id]').val();
                    }
                    if (trans_mode == 'bank') {
                        var acType = 'bank';
                        var ac_id = $('select[name=bank_id]').val();
                    }

                    $.ajax({
                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('get-account-balance') }}',
                        data: {
                            ac_id: ac_id,
                            ac_type: acType
                        },
                        async: false,
                        dataType: 'json',
                        success: function(data) {
                            $(".balance-section").css("display", "block");
                            $('input[name=balance]').val(data);
                        },
                        error: function() {
                            toastr.error('something went wrong');
                        }
                    });
                });
                // payment mode
                $('select[name=trans_mode]').change(function() {
                    var trans_mode = $('select[name=trans_mode]').val();

                    if (trans_mode == 'bank') {
                        $(".bank_section").css("display", "block");
                        $(".cash-section").css("display", "none");
                        $(".inpBank").prop('required', true);
                        $(".inpCash").prop('required', false);
                    }
                    if (trans_mode == 'cash') {
                        $(".bank_section").css("display", "none");
                        $(".cash-section").css("display", "block");
                        $(".inpBank").prop('required', false);
                        $(".inpCash").prop('required', true);
                    }

                });
            });
        </script>
    @endsection
