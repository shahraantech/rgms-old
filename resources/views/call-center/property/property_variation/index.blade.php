@extends('setup.master')
@section('content')



    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Property Variation</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Property Variation</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_supplier"
                            title="Add Supplier"><i class="fa fa-plus"></i></a>
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
                                <th>Property Type</th>
                                <th>Variation</th>
                                <th>Created At </th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tbody id="supplierTable">
                        </tbody>
                    </table>

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
                        <h5 class="modal-title">Add Variation</h5>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ url('property-variation') }}" class="needs-validation" novalidate
                            id="brandFeatureForm">
                            @csrf
                            <table class="table table-bordered mt-5 table-style">

                                <label for="">Property Type</label>
                                <select class="select" name="type_id" required>
                                    <option value="">Choose property type</option>
                                    @isset($data)
                                        @foreach ($data['property_heads'] as $property_head)
                                            <option value="{{ $property_head->id }}">{{ $property_head->type }}</option>
                                        @endforeach
                                    @endisset
                                </select>

                                <thead>
                                    <tr>
                                        <th>Property Variation <span class="text-danger">*</span></th>
                                    </tr>
                                </thead>
                                <tbody id="tblPurchase">
                                    <tr>
                                        <td>
                                            <input type="text" name="variation[]" class="form-control"
                                                placeholder="Variation" required>
                                        </td>

                                        <td class="text-center"><button type="button" class="btn-success mt-2"
                                                id="addNewRow"><i class="fa fa-plus"></i></button>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>

                            <div class="submit-section">
                                <button class="btn btn-primary btn-submit" type="submit">Save</button>
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
                        <th>Property Variation <span class="text-danger">*</span></th>
                    </tr>
                </thead>
                <tbody id="tblPurchase">
                    <tr>
                        <td>
                            <input type="text" name="variation[]" class="form-control" placeholder="Variation" required>
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
                        <h5 class="modal-title">Edit Property Variation</h5>
                        <button type="button" class="close btn-dismiss" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form method="POST" action="" class="needs-validation" novalidate id="edit_varidation_form">
                            <input type="hidden" name="variation_id">
                            @csrf
                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Property Type</label>
                                        <select name="type_id" class="select">
                                            <option value="" selected disabled>Choose type</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Property Variation</label>
                                        <input class="form-control" type="text" name="variation"
                                            placeholder="Property Type" required>
                                    </div>
                                </div>


                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary btn-submit update_property_variation"
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


                getSupplierList();

                function getSupplierList() {

                    $.ajax({

                        url: '{{ url('/get-property-variation') }}',
                        type: 'get',
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            var html = '';
                            var i;
                            var c = 0;
                            for (i = 0; i < data.length; i++) {
                                c++;
                                html += '<tr>' +
                                    '<td>' + c + '</td>' +
                                    '<td>' + data[i].type.type + '</td>' +
                                    '<td>' + data[i].variation + '</td>' +
                                    '<td>' + data[i].created_at + '</td>' +
                                    '</td>' +
                                    '</td>' +
                                    '<td class="text-right"> ' +
                                    '<div class="dropdown">' +
                                    '<a href="#" class="action-icon" data-toggle="dropdown"aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                    '<div class="dropdown-menu dropdown-menu-right" style="">' +
                                    '<a class="dropdown-item btn_edit_property_variation" href="javascript:void(0)" data="' +
                                    data[i].id + '"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item btn_delete_property_variation" href="javascript:void(0)" data="' +
                                    data[i].id + '"><i class="fa fa-pencil"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>' +
                                    '</td>' +
                                    '</tr>';
                            }
                            $('#supplierTable').html(html);
                        },
                        error: function() {
                            toastr.error('something went wrong');
                        }

                    });
                }

                //Edit Level 1
                $('#supplierTable').on('click', '.btn_edit_property_variation', function(e) {
                    e.preventDefault();

                    var id = $(this).attr('data');

                    $('#edit_variation_modal').modal('show');

                    $.ajax({

                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('edit-property-variation') }}',
                        data: {
                            id: id
                        },
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            $('input[name=variation_id]').val(data.prop_var.id);
                            $('input[name=variation]').val(data.prop_var.variation);
                            $.each(data.type, function(key, type) {

                                $('select[name="type_id"]')
                                    .append(
                                        `<option value="${type.id}" ${type.id == data.prop_var.type_id ? 'selected' : ''}>${type.type}</option>`
                                    )
                            });
                        },

                        error: function() {

                            toastr.error('something went wrong');

                        }

                    });

                });


                //Update Level 3
                $('.update_property_variation').on('click', function(e) {
                    e.preventDefault();

                    let EditFormData = new FormData($('#edit_varidation_form')[0]);

                    $.ajax({
                        type: "POST",
                        url: "{{ url('update-property-variation') }}",
                        data: EditFormData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        beforeSend: function() {
                            $('.update_property_variation').text('Updating...');
                            $(".update_property_variation").prop("disabled", true);
                        },
                        success: function(response) {

                            if (response.status == 200) {
                                $('#edit_variation_modal').modal('hide');
                                $('#edit_varidation_form').find('input').val("");
                                $('.update_property_variation').text('Update');
                                $(".update_property_variation").prop("disabled", false);
                                toastr.success(response.message);
                                getSupplierList();
                            }
                        },
                        error: function() {
                            toastr.error('something went wrong');
                            $('.update_property_variation').text('Update');
                            $(".update_property_variation").prop("disabled", false);
                        }
                    });

                });


                // Delete Level 3
                $('#supplierTable').on('click', '.btn_delete_property_variation', function(e) {
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
                                url: "{{ url('delete-property-variation') }}",
                                data: {
                                    id: id
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType: "json",
                                success: function(response) {

                                    toastr.success(response.message);
                                    getSupplierList();
                                }
                            });
                        }
                    })

                });

            });
        </script>
    @endsection
