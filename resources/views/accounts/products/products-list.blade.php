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
            <!-- Page Header -->
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Items</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Items List</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{url('/products')}}" class="btn add-btn" title="Add Product"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="card">
                <div class="card-body">


                    <table class="table table-striped table-hover" id="datatable">
                        <thead>
                        <tr class="bold-tr">
                            <th># </th>
                            <th>Category </th>
                            <th>Items </th>
                            <th>Unit </th>
                            <th>Qty-Unit </th>
{{--                            <th> Price </th>--}}
                            <th> Created At </th>
                            <th>Action </th>
                        </tr>
                        </thead>
                        <tbody id="productTable">



                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /Page Content -->
        </div>




        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <!-- CDN for Sweet Alert -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {
                getProducts();

                function getProducts() {

                    $.ajax({

                        url: '{{url("/showProductsList")}}',
                        type: 'get',
                        async: false,
                        dataType: 'json',

                        success: function(data) {

                            console.log(data);
                            var html = '';
                            var i;
                            var c = 0;

                            for (i = 0; i < data.length; i++) {

                                c++;
                                html += '<tr>' +
                                    '<td>' + c + '</td>' +
                                    '<td>' + data[i].getcatname.name + '</td>' +
                                    '<td>' + data[i].item + '</td>' +
                                    '<td>' + data[i].unit + '</td>' +
                                    '<td>' + data[i].qty_in_unit + '</td>' +
                                    // '<td>' + data[i].price + '</td>' +
                                    '<td>' + data[i].created_at + '</td>' +
                                    '<td class="text-right">' +
                                    '<div class="dropdown dropdown-action">' +
                                    '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item btnEditDept" href="edit-products/' + data[i].id + '"><i class="fa fa-pencil m-r-5n "></i> Edit</a>' +
                                    '<a class="dropdown-item btn_delete_product" href="#" data-toggle="modal" data-target="#delete_department" data="' + data[i].id + '"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>' +
                                    '</div>' +
                                    '</div>' +
                                    '</td>' +
                                    '</tr>';
                            }

                            $('#productTable').html(html);

                        },
                        error: function() {
                            toastr.error('something went wrong');
                        }

                    });
                }


                // script for delete data
                $('#productTable').on('click', '.btn_delete_product', function(e) {
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
                                url: "{{ url('/delete-products/') }}/" + id,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType: "json",
                                success: function(response) {

                                    toastr.success(response.message);

                                    getProducts();
                                }
                            });
                        }
                    })

                });

                //Datatables
                $('#datatable').DataTable();

            });
        </script>
@endsection
