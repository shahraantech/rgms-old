@extends('setup.master')

@section('content')

<div class="page-wrapper">

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->

        <div class="page-header my-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Items</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Items</li>
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


                <form method="post" id="productForm" action="{{url('products')}}" class="needs-validation" novalidate>
                    @csrf

                    <div class="row">

                        <div class="form-group col-sm-4">
                            <label>Item Type <span class="text-danger">*</span></label>
                            <select name="item_type_id" id="" class="form-control">

                                <option value="1">Finishing Item</option>
                                <option value="2">Raw Material</option>

                            </select>

                        </div>


                        <div class="form-group col-sm-4">
                            <label>Category <span class="text-danger">*</span></label>
                            <select name="cat_id" id="" class="form-control">
                                <option value="">Choose One</option>

                                @isset($data['categories'])
                                    @foreach($data['categories'] as $cat)
                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                    @endforeach
                                @endisset
                            </select>

                        </div>

                        <div class="form-group col-sm-4">
                            <label>Items <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="item_name" placeholder="Item Name" required>
                        </div>
                    </div>
                    <div class="row">


                        <div class="form-group col-sm-6">
                            <label>Unit <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="unit" required placeholder="Item Unit" value="FILE">

                        </div>
                        <div class="form-group col-sm-6">
                            <label>Qty-Unit <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" name="qty_unit" placeholder="Qty in Unit" required value="1">
                        </div>

                        {{-- <div class="form-group col-sm-4">
                            <label>Unit Price <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" name="unit_price" placeholder="Unit Price" required>
                        </div> --}}
                    </div>


                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn" type="submit" id="btnSubmit">Save</button>
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

                            setTimeout(function() {
                                window.location = '{{url("products-list")}}';
                            }, 2000);
                        }
                        if(data.errors){
                            toastr.error(data.errors);
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
