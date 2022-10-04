@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">{{ $pageTitle ?: '' }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ $subTitle ?: '' }}</li>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- /Page Header -->
            <div class="card mt-4">
                <div class="card-body">

                    {{-- search filter --}}
                    @if ($pageTitle == 'Seller')
                        <form action="{{ url('get-seller') }}" method="POST" id="searchAtt">
                            @csrf
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" name="owner_name" placeholder="Name">
                                </div>
                                <div class="col-md-2">
                                    <label for="">Location</label>
                                    <input type="text" class="form-control" name="location" placeholder="Location">
                                </div>
                                <div class="col-md-2">
                                    <label for="">Contact</label>
                                    <input type="text" class="form-control" name="owner_contact" placeholder="Contact">
                                </div>
                                <div class="col-md-2">
                                    <label for="">Property Type</label>
                                    <select name="property_type_id" class="select">
                                        <option value="" selected disabled>Choose property type</option>
                                        @foreach ($prop_typs as $prop_typ)
                                            <option value="{{ $prop_typ->id }}">{{ $prop_typ->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Status</label>
                                    <select name="status" class="select">
                                        <option value="" selected disabled>Choose status</option>
                                        <option value="1">Available</option>
                                        <option value="0">Not Available</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-search" style="margin-top: 32px;">
                                            <i class="fa fa-search"></i> </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <form action="{{ url('get-buyer') }}" method="POST" id="searchAtt">
                            @csrf
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" name="owner_name" placeholder="Name">
                                </div>
                                <div class="col-md-2">
                                    <label for="">Location</label>
                                    <input type="text" class="form-control" name="location" placeholder="Location">
                                </div>
                                <div class="col-md-2">
                                    <label for="">Contact</label>
                                    <input type="text" class="form-control" name="owner_contact" placeholder="Contact">
                                </div>
                                <div class="col-md-2">
                                    <label for="">Property Type</label>
                                    <select name="property_type_id" class="select">
                                        <option value="" selected disabled>Choose property type</option>
                                        @foreach ($prop_typs as $prop_typ)
                                            <option value="{{ $prop_typ->id }}">{{ $prop_typ->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Status</label>
                                    <select name="status" class="select">
                                        <option value="" selected disabled>Choose status</option>
                                        <option value="1">Available</option>
                                        <option value="0">Not Available</option>
                                    </select>

                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-search" style="margin-top: 32px;">
                                            <i class="fa fa-search"></i> </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                    {{-- search filter --}}

                    <table class="table table-bordered mt-3 table-hover table-striped">
                        <thead>
                            <tr class="bold-tr">
                                <th># </th>
                                <th>Name </th>
                                <th>Type </th>
                                <th>Project </th>
                                <th>Property Category </th>
                                <th>Location </th>
                                <th>Contact </th>
                                <th>Poperty Type </th>
                                <th>Poperty For </th>
                                <th>Status </th>
                                <th>Created At </th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tbody id="sellderTable">

                            @foreach ($sellers as $key => $seller)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $seller->owner_name }}</td>
                                    <td>{{ $seller->type }}</td>
                                    <td>{{ $seller->propertyproject->name }}</td>
                                    <td>{{ $seller->property_category }}</td>
                                    <td>{{ $seller->location }}</td>
                                    <td>{{ $seller->owner_contact }}</td>
                                    <td>{{ $seller->proptype->type }}</td>
                                    <td>{{ $seller->property_for }}</td>
                                    <td>
                                        @if ($seller->status == 0)
                                            <span class="badge badge-pill badge-danger">Not Available</span>
                                        @else
                                            <span class="badge badge-pill badge-success">Available</span>
                                        @endif
                                    </td>
                                    <td>{{ $seller->created_at }}</td>

                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a href="#" class="action-icon" data-toggle="dropdown"
                                                aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right" style="">
                                                <a class="dropdown-item btn_view_data" href="javascript:void(0)"
                                                    data="{{ $seller->id }}"><i class="fa fa-pencil"></i> View</a>
                                                <a class="dropdown-item btn_status" href="javascript:void(0)"
                                                    data="{{ $seller->id }}"><i class="fa fa-pencil"></i>
                                                    Status Change</a>
                                                <a class="dropdown-item btn_edit_property" href="javascript:void(0)"
                                                    data="{{ $seller->id }}"><i class="fa fa-pencil"></i>
                                                    Edit</a>
                                                <a class="dropdown-item btn_delete_property" href="javascript:void(0)"
                                                    data="{{ $seller->id }}"><i class="fa fa-pencil"></i>
                                                    Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
            <!-- /Page Content -->
        </div>

        <!-- Add Ticket Modal -->
        <div id="add_supplier" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add Property Type</h5>
                        <button type="button" class="close btn-dismiss" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form method="post" action="{{ url('category') }}" class="needs-validation" novalidate
                            id="supplierForm">
                            @csrf
                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Property Type</label>
                                        <input class="form-control" type="text" name="type"
                                            placeholder="Property Type" required>
                                    </div>
                                </div>


                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary btn-submit" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Ticket Modal -->

        <!-- Product Detail -->
        <div id="property_detail" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close btn-dismiss" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <table class="table table-bordered mt-5 table-hover table-striped">
                            <thead>
                                <tr class="bold-tr">
                                    <th># </th>
                                    <th>Variations </th>
                                    <th>Value </th>
                                </tr>
                            </thead>
                            <tbody id="featureTable">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Product Detail -->


        <!-- Edit Seller & Buyer Modal -->
        <div id="edit_seller_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Edit Property
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="" id="EditPropertyForm" class="needs-validation"
                            enctype="multipart/form-data" novalidate>
                            <input type="hidden" name="property_id">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for=""> Name</label>
                                        <input type="text" name="owner_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for=""> Location</label>
                                        <input type="text" name="location" class="form-control">
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <label for="">Property Type</label>
                                    <select name="property_type_id" class="select" required>
                                        <option value="">Choose property type</option>
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for=""> Contact</label>
                                        <input type="number" name="owner_contact" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for=""> Property For</label>
                                        <select name="property_for" class="select">
                                            <option value="" selected disabled>Choose Property For</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for=""> Property Project</label>
                                        <select name="project_id" class="select">
                                            <option value="" selected disabled>Choose property project</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for=""> Property Category</label>
                                        <select name="property_category" class="select">
                                            <option value="" selected disabled>Choose property category</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn update_property" type="button">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Seller & Buyer Modal -->


        <!-- CDN for Sweet Alert -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            //view detail
            $('#sellderTable').on('click', '.btn_view_data', function() {

                var property_id = $(this).attr('data');

                $('#property_detail').modal('show');

                $.ajax({
                    url: '{{ url('/get-seller-buyer-detail') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    data: {
                        property_id: property_id
                    },
                    success: function(data) {

                        var html = '';
                        var i;
                        var c = 0;
                        for (i = 0; i < data.length; i++) {
                            c++;
                            html += '<tr>' +
                                '<td>' + c + '</td>' +
                                '<td>' + data[i].provaration['variation'] + '</td>' +
                                '<td>' + data[i].value + '</td>' +
                                '</tr>';
                        }
                        $('#featureTable').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });

            });

            //status update
            $('#sellderTable').on('click', '.btn_status', function() {

                var id = $(this).attr('data');

                $.ajax({
                    url: '{{ url('/status-update') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            toastr.success(response.message);
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });

            });


            //Edit purchase detail
            $('#sellderTable').on('click', '.btn_edit_property', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                $('#edit_seller_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('property-edit') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('input[name=property_id]').val(data.prop.id);

                        $.each(data.prop_type, function(key, prop_type) {

                            $('select[name="property_type_id"]')
                                .append(
                                    `<option value="${prop_type.id}" ${prop_type.id == data.prop.property_type_id ? 'selected' : ''}>${prop_type.type}</option>`
                                )
                        });

                        $('select[name="property_for"]')
                            .append(
                                `<option value="Sell" ${'Sell' == data.prop.property_for ? 'selected' : ''}>Sell</option>`,
                                `<option value="Purchase" ${'Purchase' == data.prop.property_for ? 'selected' : ''}>Purchase</option>`,
                                `<option value="Rent" ${'Rent' == data.prop.property_for ? 'selected' : ''}>Rent</option>`,
                            )

                        $('input[name=owner_name]').val(data.prop.owner_name);
                        $('input[name=location]').val(data.prop.location);
                        $('input[name=owner_contact]').val(data.prop.owner_contact);
                        $('input[name=property_for]').val(data.prop.property_for);

                        $.each(data.proj, function(key, proj) {

                            $('select[name="project_id"]')
                                .append(
                                    `<option value="${proj.id}" ${proj.id == data.prop.project_id ? 'selected' : ''}>${proj.name}</option>`
                                )
                        });

                        $('select[name="property_category"]')
                            .append(
                                `<option value="Residential" ${'Residential' == data.prop.property_category ? 'selected' : ''}>Residential</option>`,
                                `<option value="Commercial" ${'Commercial' == data.prop.property_category ? 'selected' : ''}>Commercial</option>`,
                            )
                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });

            //Update property
            $('.update_property').on('click', function(e) {
                e.preventDefault();

                let EditFormData = new FormData($('#EditPropertyForm')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('property-update') }}",
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('.update_property').text('Updating...');
                        $(".update_property").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            $('#edit_seller_modal').modal('hide');
                            $('#EditPropertyForm').find('input').val("");
                            $('.update_property').text('Update');
                            $(".update_property").prop("disabled", false);
                            toastr.success(response.message);
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.update_property').text('Update');
                        $(".update_property").prop("disabled", false);
                    }
                });

            });

            // Delete Level 5
            $('#sellderTable').on('click', '.btn_delete_property', function(e) {
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
                            url: "{{ url('property-delete') }}",
                            data: {
                                id: id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {

                                toastr.success(response.message);
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2000);
                            }
                        });
                    }
                })

            });

            $('.btn-search').on('click', function() {
                $(".btn-search").prop("disabled", true);
                $(".btn-search").html("Searching...");
                $('#searchAtt').submit();
            });
        </script>
    @endsection
