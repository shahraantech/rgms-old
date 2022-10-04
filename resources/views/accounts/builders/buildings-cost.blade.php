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
                        <h3 class="page-title bold-heading">Builders</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Buildings Managements</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{url('/products-list')}}" class="btn add-btn" title="Products List"><i class="fa fa-list" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{url('buildings-cost')}}" method="post" class="needs-validation" novalidate>
                        @csrf
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <label for="" class="mr-2">Buildings</label>
                                    <span class="text-danger">*</span>
                                    <select class="livesearch form-control p-3" name="building_id" required>
                                        <option value="">Choose Ones</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please choose client.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex flex-row">
                                    <label for="" class="mr-2"> Comments</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control ml-5" placeholder="Comments" name="comments">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <!-- tabel start -->
                            <table class="table table-bordered mt-5 table-style">
                                <thead>
                                <tr>
                                    <th>Items <span class="text-danger">*</span></th>
                                    <th>Unit <span class="text-danger">*</span></th>
                                    <th>Price <span class="text-danger">*</span></th>
                                    <th>Qty <span class="text-danger">*</span></th>
                                    <th>Total <span class="text-danger">*</span></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="tblPurchase">
                                <tr>
                                    <td>
                                        <select name="item_id[]"  class="form-control item-id" required>
                                            <option value="">Choose Item</option>
                                            @isset($data['items'])
                                                @foreach($data['items'] as $item)
                                                    <option value="{{$item->products['id']}}">{{$item->products['item']}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control item-unit" placeholder="unit" name="item_unit[]" required readonly></td>
                                    <td><input type="number" class="form-control price" placeholder="0.00" name="price[]" required readonly></td>
                                    <td><input type="number" class="form-control qty" placeholder="0.00" name="qty[]" required></td>
                                    <td><input type="number" class="form-control total" placeholder="0.00" name="total[]" required></td>
                                    <td><button type="button" class="btn-success" id="addNewRow"><i class="fa fa-plus"></i></button> </td>
                                </tr>
                                </tbody>

                                <tr>
                                    <td  colspan="5">
                                        <div class="float-right">Grand Total% :</div>
                                    </td>
                                    <td><input type="number" class="form-control" placeholder="0.00" name="grand_total"></td>
                                    <td></td>
                                </tr>
                            </table>
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    <!-- tabel end -->
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
    <script type="text/javascript">
        $(function () {
            $('#addNewRow').on('click', function () {
                var tr = $("#dvOrders").find("Table").find("TR:has(td)").clone();
                console.log(tr);
                $("#tblPurchase").append(tr);
            });
        });
    </script>
    <div id="dvOrders" style="display:none">
        <table class="table table-bordered mt-5 table-style secondtable " >
            <tr>
                <td>
                    <select name="item_id[]" id="" class="form-control item-id" required>
                        <option value="">Choose Item</option>
                        @isset($data['items'])
                            @foreach($data['items'] as $item)
                                <option value="{{$item->products['id']}}">{{$item->products['item']}}</option>
                            @endforeach
                        @endisset
                    </select>
                </td>
                <td><input type="text" class="form-control item-unit" placeholder="unit" name="item_unit[]" required readonly></td>
                <td><input type="number" class="form-control price" placeholder="0.00" name="price[]" required readonly></td>
                <td><input type="number" class="form-control qty" placeholder="0.00" name="qty[]" required></td>
                <td><input type="number" class="form-control total" placeholder="0.00" name="total[]" required></td>
                <td style="color:red;cursor: pointer" class="delete-row" title="Remove"><i class="fa fa-trash"></i></td>
            </tr>
        </table>
    </div>
    <script>
        $(document).ready(function () {

            var rowIdx = 0;


            $('#tblPurchase').on('click', '.delete-row', function () {

                // Getting all the rows next to the row
                // containing the clicked button
                var child = $(this).closest('tr').nextAll();

                // Iterating across all the rows
                // obtained to change the index
                child.each(function () {

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
                    url: '{{url("buildings-list")}}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {

                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.title,
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
    <script type='text/javascript'>
        $(document).ready(function (){



            // calculation of current table

            $('#tblPurchase').on('change','.item-id', function() {
                var item_id=$(this).val();
                var $currentRow = $(this).closest('tr');


                $.ajax({

                    type: 'ajax',

                    method: 'get',

                    url: '{{url("/getProductInfo")}}',

                    data: {product_id: item_id},

                    async: false,

                    dataType: 'json',

                    success: function(data) {
                        $currentRow.find('.item-unit').val(data.unit);
                        $currentRow.find('.price').val(data.price);
                    },

                    error: function() {

                        toastr.error('data not found');

                    }

                });



            });


            $('#tblPurchase').on('keyup','.qty', function() {
                var qty=$(this).val();

                var $currentRow = $(this).closest('tr');
                var price = $currentRow.find('.price').val();
                var total = parseFloat(price) * parseFloat(qty);
                $currentRow.find('.total').val(total);
                grandTotal();


            });

            function  grandTotal(){
                var grandTotal=0;
                $(".total").each(function() {
                    var subTotal=$(this).val();
                    (subTotal)? grandTotal=parseFloat(grandTotal) + parseFloat(subTotal):'';

                });

                $('input[name=grand_total]').val(grandTotal);
            }

        })
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script>
        @if(count($errors) > 0)

        @foreach($errors->all() as $error)

        toastr.error("{{ $error }}");
        @endforeach
        @endif


        @if(Session::has('success'))
        toastr.success("Sale invoice generated successfully");

        @endif

    </script>
@endsection
