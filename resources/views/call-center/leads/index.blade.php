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
    <div class="main-wrapper">

        <!-- /Sidebar -->
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <div class="page-header my-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title bold-heading">Leads</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Leads</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_department"
                                title="Add New Leads"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Search Filter -->
                <div class="card mt-3">
                    <div class="card-body">
                        <form action="{{ url('leads') }}" method="POST" id="searchForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="text" name="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Contact</label>
                                        <input type="text" name="contact" class="form-control"
                                            placeholder="92-333-4636416">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Search</label>
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-search">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Search Filter -->
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-3 mt-2">
                            <div class="form-group">
                                <a class="btn btn-primary" data-toggle="modal" data-target="#import_leads" title="Import"><i
                                        class="fa fa-upload"></i></a>
                            </div>
                        </div>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>

                                    <th>SR#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>City</th>
                                    <th>Source</th>
                                    <th>Address</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="leadsTable">
                            @php $c=0; @endphp
                                @isset($data['leedMarketing'])
                                    @foreach ($data['leedMarketing'] as $leed)
                                        @php $c++ @endphp
                                        <tr>
                                            <td>{{$c}}</td>
                                            <td>{{ $leed->name }}</td>
                                            <td>{{ $leed->email }}</td>
                                            <td>{{ $leed->contact }}</td>
                                            <td>{{ $leed->cityname->city_name }}</td>
                                            <td>{{ $leed->platformname->platform }}</td>
                                            <td>{{ $leed->address }}</td>
                                            <td>{{ $leed->date }}</td>
                                        </tr>
                                    @endforeach
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
        <!-- Add Department Modal -->
        <div id="add_department" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Lead</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form method="post" action="{{ url('leads') }}" id="LeadForm" class="needs-validation"
                            novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" placeholder=" Name"
                                            required>
                                        <div class="invalid-feedback">
                                            Please enter name.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email <span class="text-danger"></span></label>
                                        <input class="form-control" type="text" name="email" placeholder="Email">
                                        <div class="invalid-feedback">
                                            Please enter email.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="contact"
                                            placeholder="92-333-4636416" required>
                                        <div class="invalid-feedback">
                                            Please enter contact.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City <span class="text-danger">*</span></label>
                                        <select class=" selectpicker" name="city_id" required>
                                            <option value="">Choose City</option>
                                            @isset($data)
                                                @foreach ($data['city'] as $city)
                                                    <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <div class="invalid-feedback">
                                            Please choose city.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Lead Type<span class="text-danger">*</span></label>
                                        <select class="select" name="lead_type" required>
                                            <option value="outbound">Outbound</option>
                                            <option value="Inbound">Inbound</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please enter Source.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Source<span class="text-danger">*</span></label>
                                        <select class="select" name="source_id" required>
                                            <option value="">Choose Source</option>
                                            @isset($data)
                                                @foreach ($data['platforms'] as $platforms)
                                                    <option value="{{ $platforms->id }}">{{ $platforms->platform }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <div class="invalid-feedback">
                                            Please enter Source.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Interest<span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="interest" id="" cols="6" rows="2"
                                            placeholder="Enter Interested Project/Query" required></textarea>

                                        <div class="invalid-feedback">
                                            Please Interest .
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="address" placeholder="Address"
                                            required>
                                        <div class="invalid-feedback">
                                            Please enter Address.
                                        </div>
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
        <!-- /Add Department Modal -->
        <div id="import_leads" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import Leads</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form action="{{ route('import-leads') }}" method="POST" enctype="multipart/form-data"
                            class="needs-validation" novalidate id="ImportExcelForm">
                            @csrf
                            <div class="form-group">
                                <label>File <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" name="file" required id="csvFile">
                                <div class="invalid-feedback">
                                    Please enter excel file.
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary" type="submit" id="btnImportLeads">Upload</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js">
    </script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            $('.btn-search').on('click', function() {
                $(".btn-search").prop("disabled", true);
                $(".btn-search").html("Searching...");
                $('#searchForm').submit();
            });
            $('#LeadForm').unbind().on('submit', function(e) {
                e.preventDefault();
                var formData = $('#LeadForm').serialize();
                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{ url('store-leads') }}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {

                        $(".btn-submit").prop("disabled", true);
                        $(".btn-submit").html("saving...");

                    },
                    success: function(data) {

                        if (data.success) {
                            $('.close').click();
                            $('#LeadForm')[0].reset();
                            toastr.success(data.success);
                            setInterval(() => {
                                window.location.reload();
                            }, 1000);
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
            //chek all boxes
            $('#master').on('click', function(e) {
                if ($(this).is(':checked', true)) {
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked', false);
                }
            });
            // delte bulk
            $('.delete_all').on('click', function(e) {


                var allVals = [];
                $(".sub_chk:checked").each(function() {
                    allVals.push($(this).attr('data-id'));
                });


                if (allVals.length <= 0) {
                    alert("Please select row.");
                } else {


                    var check = confirm("Are you sure you want to delete this row?");
                    if (check == true) {


                        var join_selected_values = allVals.join(",");



                        $.ajax({
                            url: '{{ url('/deleteLeads') }}',
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: 'ids=' + join_selected_values,
                            success: function(data) {
                                getLeads();
                                if (data.success) {
                                    toastr.success(data.success);
                                    window.location.reload();
                                    $(".sub_chk:checked").each(function() {
                                        $(this).parents("tr").remove();
                                    });

                                } else {
                                    toastr.error('something went wrong');
                                }
                            },
                            error: function(data) {
                                toastr.error(data.responseText);
                            }
                        });


                        $.each(allVals, function(index, value) {
                            $('table tr').filter("[data-row-id='" + value + "']").remove();
                        });
                    }
                }
            });
            $('#btnImportLeads').on('click', function() {

                if ($('#csvFile').val()) {
                    $("#btnImportLeads").prop("disabled", true);
                    $("#btnImportLeads").html("uploading...");
                    $('#ImportExcelForm').submit();
                } else {
                    toastr.error('Excel file missing');
                }

            });
        });
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
            toastr.success("Leads import successfully!");
        @endif
    </script>

    @include('call-center.general.dont-copy');
@endsection
