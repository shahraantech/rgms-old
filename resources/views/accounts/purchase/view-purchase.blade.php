@extends('setup.master')
@section('content')


    <style type="text/css">
        body {
            font-family: Arial;
            font-size: 10pt;
        }
    </style>
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Purchase Detail</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Purchase Detail</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ url('/purchase-list') }}" class="btn add-btn" title="Back"><i
                                class="fa fa-arrow-left" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="card">
                <div class="card-body">


                    <table class="table table-bordered mt-5 table-hover table-striped">
                        <thead>
                            <tr class="bold-tr">
                                <th># </th>
                                <th>Item </th>
                                <th>Qty </th>
                                <th>Price </th>
                                <th>Sale Price </th>
                                <th>Created At </th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tbody id="purchaseTable">
                        @php $grandTotal=0 @endphp
                            @isset($data['purchase'])
                                @foreach ($data['purchase'] as $key => $p)
                                    @php $grandTotal=$grandTotal + $p->pur_price; @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $p->products->item }}-{{ $p->reg_no}}</td>
                                        <td>{{ $p->qty }}</td>
                                        <td>{{number_format($p->pur_price,2)}}</td>
                                        <td>{{number_format($p->sale_price,2)}}</td>
                                        <td>{{ $p->created_at }}</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                    aria-expanded="false"><i class="fas fa-ellipsis-v ellipse_color"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item btn_edit_purchase_detail" data="{{ $p->id }}"
                                                        href="#"> Edit</a>
                                                    <a class="dropdown-item btn_delete_purchase_detail"
                                                        data="{{ $p->id }}" href="#"> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset

                            <tr>
                                <td  colspan="4">
                                    <div class="float-right"> <strong>Grand Total:{{number_format($grandTotal,2)}}</strong></div>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /Page Content -->



            <!-- Edit Vendor Modal -->
            <div id="edit_purchase_modal" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Purchase</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="" id="EditPurchaseForm" class="needs-validation"
                                enctype="multipart/form-data" novalidate>
                                <input type="hidden" name="purchase_id">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="">Items</label>
                                        <select name="item_id" id="" class="form-control" required>
                                            <option value="">Choose Items</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for=""> Qty</label>
                                            <input type="number" name="qty" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for=""> Price</label>
                                            <input type="number" name="pur_price" class="form-control">
                                        </div>
                                    </div>


                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for=""> Sale Price</label>
                                            <input type="number" name="sale_price" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn update_purchase"
                                        type="button">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Edit Vendor Modal -->

        </div>




        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <!-- CDN for Sweet Alert -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function() {


                //Edit purchase detail
                $('#purchaseTable').on('click', '.btn_edit_purchase_detail', function(e) {
                    e.preventDefault();

                    var id = $(this).attr('data');

                    $('#edit_purchase_modal').modal('show');

                    $.ajax({

                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('view-purchase-edit') }}',
                        data: {
                            id: id
                        },
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            $('input[name=purchase_id]').val(data.pur.id);

                            $.each(data.prod, function(key, prod) {

                                $('select[name="item_id"]')
                                    .append(
                                        `<option value="${prod.id}" ${prod.id == data.pur.item_id ? 'selected' : ''}>${prod.item}</option>`
                                    )
                            });

                            $('input[name=qty]').val(data.pur.qty);
                            $('input[name=pur_price]').val(data.pur.pur_price);
                            $('input[name=sale_price]').val(data.pur.sale_price);
                        },

                        error: function() {

                            toastr.error('something went wrong');

                        }

                    });

                });


                // script for delete data
                $('#purchaseTable').on('click', '.btn_delete_purchase_detail', function(e) {
                    e.preventDefault();

                    var id = $(this).attr('data');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to Delete this Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "GET",
                                url: "{{ url('/view-purchase-delete/') }}/" + id,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.success) {
                                        toastr.success(response.success);
                                        setTimeout(function() {
                                            window.location.reload(1);
                                        }, 1000);
                                    }
                                }
                            });
                        }
                    });

                });


                //update category
                $('.update_purchase').on('click', function() {

                    var formData = $('#EditPurchaseForm').serialize();

                    $.ajax({

                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('view-purchase-update') }}',
                        data: formData,
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            $('#edit_purchase_modal').modal('hide');
                            toastr.success(data.success);
                            setTimeout(function() {
                                window.location.reload(1);
                            }, 1000);
                        },

                        error: function() {
                            toastr.error('something went wrong');

                        }

                    });

                });
            });



        </script>
    @endsection
