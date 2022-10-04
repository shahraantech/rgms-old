@extends('setup.master')

@section('content')

<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->

        <div class="page-header my-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Edit Products</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Products</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{url('/products-list')}}" class="btn add-btn" title="Products List"><i class="fa fa-list" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="card">
            <div class="card-body">


                <form method="post" id="EditProductForm" action="{{ url('update-products/'.$pro->id) }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Category <span class="text-danger">*</span></label>
                            <select name="cat_id" id="" class="form-control">

                                @foreach($categ as $cat)
                                <option value="{{$cat->id}}" @if($pro->cat_id == $cat->id) selected @endif
                                    >{{$cat->name}}</option>
                                @endforeach

                            </select>

                        </div>
                        <div class="form-group col-sm-6">
                            <label>Items <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" value="{{ $pro->item }}" name="item_name" placeholder="Item Name" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Unit <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" value="{{ $pro->unit }}" name="unit" required placeholder="Item Unit">

                        </div>
                        <div class="form-group col-sm-6">
                            <label>Qty-Unit <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" value="{{ $pro->qty_in_unit }}" name="qty_unit" placeholder="Qty in Unit" required>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label> Price <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" value="{{ $pro->price }}" name="price" placeholder="Price" required>
                        </div>
                    </div>

                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn update_products" type="submit" id="btnSubmit">Update</button>
                    </div>

                </form>
            </div>
        </div>

        <!-- /Page Content -->



    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {

            // save product
            $('#productForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $('#productForm').serialize();

                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{url("products")}}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        if (data.success) {
                            toastr.success(data.success);
                            var url = '{{url("products-list")}}';
                            window.location.href = url;
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