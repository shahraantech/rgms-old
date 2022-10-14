@extends('setup.master')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Purchase</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Purchase</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ url('/purchase-list') }}" class="btn add-btn" title="Products List"><i
                                class="fa fa-list" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="card">
                <form action="{{ url('purchase') }}" method="post" id="purchaseForm" class="needs-validation" novalidate>
                    @csrf
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col-sm-2">
                                <label>INV# </label>
                                <input type="text" class="form-control" value="{{ $data['invNo'] }}" readonly>
                            </div>
                            <div class="form-group col-sm-3">
                                <label>Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="pur_date" required>
                            </div>

                            <div class="form-group col-sm-4">
                                <label>Vendors <span class="text-danger">*</span></label>
                                <select class="livesearch form-control p-3" name="vendor_id" required>
                                    <option value="">Choose One</option>
                                </select>
                                
                            </div>


                            <div class="form-group col-sm-3">
                                <label>Available Balance <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="balance" placeholder="Available Balance"
                                    readonly>

                            </div>

                        </div>
                        <div class="row">

                            <div class="form-group col-sm-4">
                                <label>Project <span class="text-danger">*</span></label>
                                <select name="project_id" class="selectpicker form-control" required>
                                    <option value="" selected disabled>Choose One</option>
                                    @isset($data['society'])
                                        @foreach ($data['society'] as $society)
                                            <option value="{{ $society->id }}">{{ $society->project_name }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="form-group col-sm-8">
                                <label>Remarks <span class="text-danger">*</span></label>
                                <input type="text" name="comments" placeholder="Remarks" class="form-control" required>
                                
                            </div>

                        </div>
                        {{-- @include('accounts.coa.coa-level') --}}
                        <div class="row">
                            <table class="table table-style">
                                <thead>
                                    <tr>
                                        <th>Items <span class="text-danger">*</span></th>
                                        <th>
                                            Stamp
                                        </th>
                                        <th>Reg-No<span class="text-danger">*</span></th>
                                        <th>Qty <span class="text-danger">*</span></th>
                                        <th>Pur Price <span class="text-danger">*</span></th>
                                        <th>Sale Price <span class="text-danger">*</span></th>
                                        <th>Total </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tblPurchase">
                                    <tr>
                                        <td>
                                            <select name="item_id[]" id="" class="form-control item-id" required>
                                                <option value="">Choose Item</option>
                                                @isset($data['products'])
                                                    @foreach ($data['products'] as $pro)
                                                        <option value="{{ $pro->id }}">{{ $pro->item }}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </td>
                                        <td>
                                            <select name="stamp[]" id="" class="form-control" required>
                                                <option value="">Choose Stamp</option>
                                                <option value="The A Team">The A Team</option>
                                                <option value="Fast">Fast</option>
                                                <option value="Fast">Fast</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control reg-no" placeholder="File No"
                                                name="reg_no[]" required></td>
                                        <td><input type="number" class="form-control qty" placeholder="0.00" name="qty[]"
                                                required></td>
                                        <td><input type="number" class="form-control price" placeholder="0.00"
                                                name="price[]" required></td>
                                        <td><input type="number" class="form-control sale-price" placeholder="0.00"
                                                name="sale_price[]" required></td>
                                        <td><input type="number" class="form-control total" placeholder="0.00"
                                                name="total[]" required></td>
                                        <td><button type="button" class="btn-primary" id="addNewRow"><i
                                                    class="fa fa-plus"></i></button> </td>
                                    </tr>
                                </tbody>

                                <tr>
                                    <td colspan="6">
                                        <div class="float-right">Grand Total:</div>
                                    </td>
                                    <td><input type="number" class="form-control grandTotal" placeholder="0.00"
                                            name="grand_total" readonly required></td>

                                </tr>
                            </table>
                            <div class="col-md-10"></div>
                            <div class="col-md-2"><button class="btn btn-primary btn-submit">Save</button></div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- /Page Content -->
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
        <table class="table table-bordered mt-5 table-style secondtable">
            <tr>
                <td>
                    <select name="item_id[]" id="" class="form-control item-id" required>
                        <option value="">Choose Item</option>
                        @isset($data['products'])
                            @foreach ($data['products'] as $pro)
                                <option value="{{ $pro->id }}">{{ $pro->item }}</option>
                            @endforeach
                        @endisset
                    </select>
                </td>
                <td>
                    <select name="stamp[]" id="" class="form-control" required>
                        <option value="">Choose Stamp</option>
                        <option value="The A Team">The A Team</option>
                        <option value="Fast">Fast</option>
                        <option value="Fast">Fast</option>
                    </select>
                </td>
                <td><input type="text" class="form-control reg-no" placeholder="File No" name="reg_no[]" required>
                </td>
                <td><input type="number" class="form-control qty" placeholder="0.00" name="qty[]" required></td>
                <td><input type="number" class="form-control price" placeholder="0.00" name="price[]" required></td>
                <td><input type="number" class="form-control sale-price" placeholder="0.00" name="sale_price[]"
                        required></td>
                <td><input type="number" class="form-control total" placeholder="0.00" name="total[]" required></td>
                <td style="color:red;cursor: pointer" class="delete-row" title="Remove"><i class="fa fa-trash"></i></td>
            </tr>
        </table>
    </div>
    <!--add dynamic row!-->
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
                    url: '{{ url('get-vendors-name') }}',
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
            // calculation of current table
            $('#tblPurchase').on('change', '.item-id', function() {
                var item_id = $(this).val();
                var $currentRow = $(this).closest('tr');
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('/getProductInfo') }}',
                    data: {
                        product_id: item_id,
                        mode: 1
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        if (data.cat_id == 2) {
                            $currentRow.find('.price').val(data.price);
                            $currentRow.find('.reg-no').prop('readonly', true);
                        } else {
                            $currentRow.find('.price').val(data.price);
                            $currentRow.find('.reg-no').prop('readonly', false);
                        }
                        $currentRow.find('.item-unit').val(data.unit);
                        $currentRow.find('.sale-price').val(data.price);
                        $currentRow.find('.size').val(data.size);
                    },

                    error: function() {

                        alert('Could not get Data from Database');

                    }

                });



            });

            // change qty
            $('#tblPurchase').on('keyup', '.qty', function() {
                var qty = $(this).val();

                var $currentRow = $(this).closest('tr');
                var price = $currentRow.find('.price').val();
                var total = parseFloat(price) * parseFloat(qty);
                $currentRow.find('.total').val(total);

                // call grand total for calculation
                grandTotal();


            });

            // change purchase price
            $('#tblPurchase').on('keyup', '.price', function() {
                var price = $(this).val();

                var $currentRow = $(this).closest('tr');
                var qty = $currentRow.find('.qty').val();
                var total = parseFloat(price) * parseFloat(qty);
                $currentRow.find('.total').val(total);
                // call grand total for calculation
                grandTotal();


            });

            function grandTotal() {
                var grandTotal = 0;
                $(".total").each(function() {
                    var subTotal = $(this).val();
                    (subTotal) ? grandTotal = parseFloat(grandTotal) + parseFloat(subTotal): '';

                });

                $('input[name=grand_total]').val(grandTotal);
            }

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
                    url: '{{ url('purchase') }}',
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
            $('select[name=vendor_id]').on('change', function() {
                var ac_id = $('select[name=vendor_id]').val();
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('get-account-balance') }}',
                    data: {
                        ac_id: ac_id,
                        ac_type: 'vendors'
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
            toastr.success("Purchase items save successfully");
        @endif
    </script>
@endsection
