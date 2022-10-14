@extends('setup.master')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
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
                        <h3 class="page-title bold-heading">Sale</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Sale</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ url('/sale-report') }}" class="btn add-btn" title="Sale List"><i class="fa fa-list"
                                aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="card">
                <form action="{{ url('sale') }}" method="post" id="purchaseForm" class="needs-validation" novalidate>
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-sm-2">
                                <input type="text" class="form-control"
                                    value="INV-{{ empty($data['inv_no']) ? 1 : $data['inv_no'] }}" readonly>
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="sale_date" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <select name="client_id" class="form-control selectpicker" data-container="body"
                                    data-live-search="true" title="Choose Client" required>
                                    <option value="" selected disabled>Choose Ones</option>
                                    @isset($data['clients'])
                                        @foreach ($data['clients'] as $client)
                                            <option value="{{ $client->id }}"
                                                @isset($data['client_id'])
                                                    @if ($data['client_id'] == $client->id)
                                                    selected
                                                @endif
                                                @endisset>
                                                {{ $client->name }}-{{ $client->contact }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>


                            <div class="col-md-2 balance-section">
                                <input type="text" class="form-control" name="balance" placeholder="Available Balance"
                                    readonly>
                            </div>

                            <div class="col-md-4">
                                <select name="inventory_type" class="form-control selectpicker" data-container="body"
                                    data-live-search="true" title="Choose Client" required>
                                    <option value="" selected disabled>Choose Ones</option>
                                    <option value="3" selected>All</option>
                                    <option value="1">Fresh</option>
                                    <option value="2">Buying Sale</option>
                                </select>

                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Remarks" name="comments" required>
                            </div>

                        </div>


                        <div class="row">
                            <!-- tabel start -->
                            <table class="table table-bordered mt-5 table-style">
                                <thead>
                                    <tr>
                                        <th>Items <span class="text-danger">*</span></th>
                                        <th>Price <span class="text-danger">*</span></th>
                                        <th>Qty <span class="text-danger">*</span></th>
                                        <th>Gross <span class="text-danger"></span></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tblPurchase">
                                    <tr>
                                        <td>
                                            <select name="item_id[]" class="form-control  item-id inventory"
                                                title="Choose Client" required>
                                                <option value="">Choose Item</option>
                                            </select>
                                        </td>

                                        <td><input type="number" class="form-control price" placeholder="0.00"
                                                name="price[]" required readonly></td>
                                        <td>
                                            <input type="number" class="form-control qty" placeholder="0.00" name="qty[]"
                                                required>
                                            <div class="qty-error"></div>
                                        </td>

                                        <td><input type="number" class="form-control total" placeholder="0.00"
                                                name="total[]" required readonly></td>
                                        <td><button type="button" class="btn-primary" id="addNewRow"><i
                                                    class="fa fa-plus"></i></button> </td>
                                    </tr>
                                </tbody>

                                <tbody id="footerSection">
                                    <tr>
                                        <td colspan="3">
                                            <div class="float-right">Discount : &nbsp;
                                                % <input type="radio" name="discount" value="perc"> &nbsp;
                                                Amount <input type="radio" name="discount" value="amount">
                                            </div>
                                        </td>
                                        <td>
                                            <input type="hidden" class="form-control disc_amount" name="disc_amount"
                                                placeholder="Enter Discount Amount">
                                            <input type="hidden" class="form-control disc_perc" name="disc_perc"
                                                placeholder="Enter Discount %">
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td colspan="3">
                                            <div class="float-right">Net Total :</div>
                                        </td>
                                        <td><input type="number" class="form-control" placeholder="0.00"
                                                name="grand_total"></td>

                                    </tr>
                                </tbody>
                            </table>
                            <div class="col-md-10"></div>
                            <div class="col-md-2">
                                <button class="btn btn-primary pull-right btn-submit" id="btnSubmit">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Page Content -->
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
                    <select name="item_id[]" id="" class="form-control item-id inventory" required>
                        <option value="">Choose Item</option>
                    </select>
                </td>
                <td><input type="number" class="form-control price" placeholder="0.00" name="price[]" required
                        readonly></td>
                <td>
                    <input type="number" class="form-control qty" placeholder="0.00" name="qty[]" required>
                    <div class="qty-error"></div>
                </td>
                <td><input type="number" class="form-control total" placeholder="0.00" name="total[]" required></td>
                <td style="color:red;cursor: pointer" class="delete-row" title="Remove"><i class="fa fa-trash"></i></td>
            </tr>
        </table>
    </div>
    <script>
        $(document).ready(function() {

            $("input[type='radio']").click(function() {
                var radioValue = $("input[name='discount']:checked").val();
                if (radioValue == 'perc') {
                    $("input[name=disc_perc]").prop("type", "number");
                    $("input[name=disc_amount]").prop("type", "hidden");

                } else {
                    $("input[name=disc_perc]").prop("type", "hidden");
                    $("input[name=disc_amount]").prop("type", "number");
                }
            });

            //getting inventroy stock
            var inventory_type = $('select[name=inventory_type]').val();
            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{ url('/getInventoryOntheBaseOfDealerGroup') }}',
                data: {
                    inventory_type: inventory_type,
                    sale_type: 'dealer-sale'
                },
                async: false,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    var html = '<option value="">Choose Item</option>';
                    var i;
                    if (data.length > 0) {
                        for (i = 0; i < data.length; i++) {
                            html += '<option value="' + data[i].id + '">' + data[i].products['item'] +
                                '-' + data[i].reg_no + '</option>';
                        }
                    } else {
                        var html = '<option value="">Choose Item</option>';
                        toastr.error('data not found');
                    }
                    $('.inventory').html(html);

                },
                error: function() {}

            });

            //buying sale
            $('select[name=inventory_type]').change(function() {
                var inventory_type = $('select[name=inventory_type]').val();

                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('/getInventoryOntheBaseOfDealerGroup') }}',
                    data: {
                        inventory_type: inventory_type,
                        sale_type: 'dealer-sale'
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        var html = '<option value="">Choose Item</option>';
                        var i;
                        if (data.length > 0) {
                            for (i = 0; i < data.length; i++) {
                                html += '<option value="' + data[i].id + '">' + data[i]
                                    .products['item'] + '-' + data[i].reg_no + '</option>';
                            }
                        } else {
                            var html = '<option value="">Choose Item</option>';
                            toastr.error('data not found');
                        }
                        $('.inventory').html(html);

                    },
                    error: function() {}

                });
            });

        });
    </script>

    <script>
        $(document).ready(function() {
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
            $('.livesearch').select2({

                ajax: {
                    url: '{{ url('get-clients-name') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {

                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script type='text/javascript'>
        $(document).ready(function() {

            $('#purchaseForm').validate({

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

            $('select[name=client_id]').change(function() {
                var client_id = $('select[name=client_id]').val();
                $("#client-info-section").css("display", "block");
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('/getClientInfo') }}',
                    data: {
                        client_id: client_id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        $('#cnic').html(data.cnic);
                        $('#contact').html(data.contact);
                        $('#address').html(data.address);
                    },
                    error: function() {

                    }

                });
            });


            getClientData();

            function getClientData() {
                var client_id = $('select[name=client_id]').val();
                $("#client-info-section").css("display", "block");

                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('/getClientInfo') }}',
                    data: {
                        client_id: client_id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        $('#cnic').html(data.cnic);
                        $('#contact').html(data.contact);
                        $('#address').html(data.address);
                    },

                    error: function() {

                    }

                });
            }
            // calculation of current table
            $('#tblPurchase').on('change', '.item-id', function() {

                var purchase_id = $(this).val();
                var $currentRow = $(this).closest('tr');
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('/getProductPriceAndInfo') }}',
                    data: {
                        purchase_id: purchase_id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        $currentRow.find('.item-unit').val(data.products['unit']);
                        $currentRow.find('.price').val(data.sale_price);
                    },
                    error: function() {
                        toastr.error('Could not get Data from Database');
                    }
                });
            });

            // chek available qty
            $('#tblPurchase').on('keyup', '.qty', function() {
                var qty = $(this).val();
                var $currentRow = $(this).closest('tr');
                var purchase_id = $currentRow.find('.item-id').val();
                var inventory_type = $('select[name=inventory_type]').val();

                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('/getAvailStock') }}',
                    data: {
                        purchase_id: purchase_id,
                        inventory_type: inventory_type
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        if (qty > data.avl_qty) {
                            $("#btnSubmit").prop("disabled", true);
                            var p = '<span style="color:red">stock not exist</span>';
                            $currentRow.find('.qty-error').html(p);
                        } else {
                            $("#btnSubmit").prop("disabled", false);
                            var p = '';
                            $currentRow.find('.qty-error').html(p);
                        }

                    },

                    error: function() {

                        toastr.error('Could not get Data from Database');

                    }

                });



            });
            $('#tblPurchase').on('keyup', '.qty', function() {
                var qty = $(this).val();

                var $currentRow = $(this).closest('tr');
                var price = $currentRow.find('.price').val();
                var total = parseFloat(price) * parseFloat(qty);
                $currentRow.find('.total').val(total);
                $currentRow.find('.net').val(total);
                grandTotal();


            });

            $('#tblPurchase').on('keyup', '.discount', function() {
                var discount = $(this).val();
                var $currentRow = $(this).closest('tr');
                var total = $currentRow.find('.total').val();
                var net = parseFloat(total) - parseFloat(discount);

                $currentRow.find('.net').val(net);
                grandTotal();


            });
            $('#footerSection').on('keyup', '.disc_amount', function() {

                var discount = $(this).val();
                var grandTotal = 0;
                $(".total").each(function() {
                    var subTotal = $(this).val();
                    (subTotal) ? grandTotal = parseFloat(grandTotal) + parseFloat(subTotal): '';

                });

                var total = $('input[name=grand_total]').val();
                if (discount > 0) {
                    var net = parseFloat(grandTotal) - parseFloat(discount);
                    $('input[name=grand_total]').val(net);
                } else {
                    $('input[name=grand_total]').val(grandTotal);
                }
            });

            //discount perc
            $('#footerSection').on('keyup', '.disc_perc', function() {

                var discount_perc = $(this).val();

                var grandTotal = 0;
                $(".total").each(function() {
                    var subTotal = $(this).val();
                    (subTotal) ? grandTotal = parseFloat(grandTotal) + parseFloat(subTotal): '';

                });

                if (discount_perc > 0) {
                    var amount = (parseFloat(discount_perc) / parseFloat(100)) * parseFloat(grandTotal)
                    var net = parseFloat(grandTotal) - parseFloat(amount);

                    $('input[name=grand_total]').val(net);
                } else {
                    $('input[name=grand_total]').val(grandTotal);
                }
            });
            //footerSection
            function grandTotal() {
                var grandTotal = 0;
                $(".total").each(function() {
                    var subTotal = $(this).val();
                    (subTotal) ? grandTotal = parseFloat(grandTotal) + parseFloat(subTotal): '';

                });

                $('input[name=grand_total]').val(grandTotal);
            }
            //save sale
            //purchase form submit
            $('#purchaseForm').unbind().on('submit', function(e) {
                e.preventDefault();
                var $form = $(this);
                // check if the input is valid
                if (!$form.validate().form()) return false;
                var formData = $('#purchaseForm').serialize();
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ url('sale') }}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $(".btn-submit").prop("disabled", true);
                        $(".btn-submit").html("please wait...");
                    },
                    success: function(data) {
                        if (data.success) {
                            $('#purchaseForm')[0].reset();
                            toastr.success(data.success);
                        }
                        if (data.errors) {
                            toastr.error(data.errors);
                        }
                    },
                    complete: function(data) {
                        $(".btn-submit").html("Save");
                        $(".btn-submit").prop("disabled", false);
                    },
                    error: function() {
                        toastr.error('something went wrong');
                    },
                });
            });

            // fetch account balance
            $('select[name=client_id]').on('change', function() {
                var ac_id = $('select[name=client_id]').val();
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('get-account-balance') }}',
                    data: {
                        ac_id: ac_id,
                        ac_type: 'clients'
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

        })
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script>
        @if (count($errors) > 0)

            @foreach ($errors->all() as $error)

                toastr.error("{{ $error }}");
            @endforeach
        @endif


        @if (Session::has('success'))
            toastr.success("Sale invoice generated successfully");
        @endif
    </script>
@endsection
