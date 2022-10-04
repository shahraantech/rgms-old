@extends('setup.master')
@section('content')



    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Asset Details</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Asset Details</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ url('add-specification') }}" class="btn add-btn" title="Add Supplier"><i
                                class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="card mt-3">

                <div class="card-body">
                    <h3 class="mt-3">{{ $specs->title }}</h3>

                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Modal</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ empty($speval1->speci->model) ? '' : $speval1->speci->model }}
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Price</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ empty($speval1->speci->price) ? '' : $speval1->speci->price }}
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-3">
                            <h6 class="mb-0">Specification Value</h6>
                        </div>
                        <div class="col-md-9">

                            <div class="row">
                                <div class="col-md-6 text-secondary">
                                    @foreach ($cs as $c)
                                        {{ empty($c->specification) ? '' : $c->specification }} <br>
                                    @endforeach

                                </div>
                                <div class="col-md-6 text-secondary">
                                    @foreach ($speval as $spe)
                                        {{ empty($spe->value) ? '' : $spe->value }} <br>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <!-- /Page Content -->
        </div>

        <!-- Add Ticket Modal -->
        <div id="add_supplier" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close btn-dismiss" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title">Add Specification</h5>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ url('store-specification') }}" class="needs-validation" novalidate
                            id="specificationForm">
                            @csrf
                            <table class="table table-bordered mt-5 table-style">

                                <label for="">Assets</label>
                                <select class="form-control" name="asset_id" required>
                                    <option value="">Choose Assets</option>
                                    @isset($assets)
                                        @foreach ($assets as $asset)
                                            <option value="{{ $asset->id }}">{{ $asset->title }}</option>
                                        @endforeach
                                    @endisset
                                    <div class="invalid-feedback">
                                        Please choose source .
                                    </div>
                                </select>

                                <thead>
                                    <tr>
                                        <th>Specification <span class="text-danger">*</span></th>
                                    </tr>
                                </thead>
                                <tbody id="tblPurchase">
                                    <tr>
                                        <td>
                                            <input type="text" name="specification[]" class="form-control"
                                                placeholder="Specification" required>
                                        </td>

                                        <td class="text-center"><button type="button" class="btn-success mt-2"
                                                id="addNewRow"><i class="fa fa-plus"></i></button>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>

                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary btn-submit btn_specification">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Ticket Modal -->


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
            <table class="table table-bordered mt-5 table-style">
                <thead>
                    <tr>
                        <th>Specification <span class="text-danger">*</span></th>
                    </tr>
                </thead>
                <tbody id="tblPurchase">
                    <tr>
                        <td>
                            <input type="text" name="specification[]" class="form-control" placeholder="specification"
                                required>
                        </td>

                        <td style="color:red;cursor: pointer" class="delete-row text-center" title="Remove"><i
                                class="fa fa-trash"></i>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>



        <!-- Edit Ticket Modal -->
        <div id="edit_variation_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Specification</h5>
                        <button type="button" class="close btn-dismiss" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form method="POST" action="{{ url('update-specification') }}" class="needs-validation"
                            novalidate id="specificationEditForm">
                            <input type="hidden" name="specification_asset_id">
                            @csrf
                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Asset</label>
                                        <select name="asset_id" class="select">
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Model</label>
                                        <input class="form-control" type="text" name="model" placeholder="Model"
                                            required>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input class="form-control" type="text" name="price" placeholder="Price"
                                            required>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Specification</label>
                                        <input class="form-control" type="text" name="value"
                                            placeholder="Specification" required>
                                    </div>
                                </div>


                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary btn-submit btn_specification_update"
                                    type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Ticket Modal -->

        <script>
            $(document).ready(function() {
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

            });
        </script>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <!-- CDN for Sweet Alert -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {

                toastr.options.timeOut = 3000;
                @if (Session::has('error'))
                    toastr.error('{{ Session::get('error') }}');
                @elseif(Session::has('success'))
                    toastr.success('{{ Session::get('success') }}');
                @endif

            });


            $('.btn_specification').on('click', function() {
                $(".btn_specification").prop("disabled", true);
                $(".btn_specification").html("Please wait...");
                $('#specificationForm').submit();
            });

            $('.btn_specification_update').on('click', function() {
                $(".btn_specification_update").prop("disabled", true);
                $(".btn_specification_update").html("Please wait...");
                $('#specificationEditForm').submit();
            });
        </script>
    @endsection
