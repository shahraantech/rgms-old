@extends('setup.master')
@section('content')



    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Property</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Property</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ url('create-property') }}" class="btn add-btn" title="Add Supplier"><i class="fa fa-plus"></i></a>
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
                            <th>Owner Name </th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Property Type</th>
                            <th>Created At </th>
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
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add Property Type</h5>
                        <button type="button" class="close btn-dismiss" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form method="post" action="{{url('category')}}" class="needs-validation" novalidate id="supplierForm">
                            @csrf
                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Property Type</label>
                                        <input class="form-control" type="text" name="type" placeholder="Property Type" required>
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


        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
            $(document).ready(function() {
                getPropertyType();
                function getPropertyType() {

                    $.ajax({

                        url: '{{url("/get-property")}}',
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
                                    '<td>' + data[i].owner_name + '</td>' +
                                    '<td>' + data[i].type + '</td>' +
                                    '<td>' + data[i].location + '</td>' +
                                    '<td>' + data[i].proptype.type + '</td>' +
                                    '<td>' + data[i].created_at + '</td>' +
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


                $('#supplierForm').unbind().on('submit', function(e) {
                    e.preventDefault();
                    var formData = $('#supplierForm').serialize();

                    $.ajax({

                        type: 'ajax',
                        method: 'post',
                        url: '{{url("store-property-type")}}',
                        data: formData,
                        async: false,
                        dataType: 'json',
                        beforeSend: function() {

                            $(".btn-submit").prop("disabled", true);
                            $(".btn-submit").html("please wait...");

                        },
                        success: function(data) {
                            if (data.success) {
                                getPropertyType();
                                $('.close').click();
                                $('#supplierForm')[0].reset();
                                toastr.success(data.success);
                            }
                            if (data.errors) {
                                toastr.error(data.errors);
                            }
                        },
                        complete : function(data){
                            $(".btn-submit").html("Save");
                            $(".btn-submit").prop("disabled", false);
                        },
                        error: function() {
                            toastr.error('something went wrong');
                        },
                    });
                });

            });
        </script>
@endsection
