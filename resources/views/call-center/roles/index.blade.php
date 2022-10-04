@extends('setup.master')
@section('content')
    <div class="main-wrapper">
        <!-- /Sidebar -->
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <div class="page-header my-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title bold-heading">Roles</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Roles List</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn"  data-toggle="modal" data-target="#add_department" title="Add New Leads Temperature"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">

                        <table class="table table-striped table-hover data-table" >
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Role</th>
                                <th>Date</th>

                            </tr>
                            </thead>
                            <tbody id="leadsTable">

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
                        <h5 class="modal-title">Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{url('roles')}}" id="LeadForm" class="needs-validation" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label> Role Name <span class="text-danger">*</span></label>
                                        <input type="text" name="role" class="form-control" placeholder="Role Name">
                                        <div class="invalid-feedback">
                                            Please enter role .
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary" type="submit" id="btnSubmit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Department Modal -->



    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function() {
            getRoles();

            $('#LeadForm').unbind().on('submit', function(e) {
                e.preventDefault();
                var formData = $('#LeadForm').serialize();
                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{url("roles")}}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {

                        $("#btnSubmit").prop("disabled", true);
                        $("#btnSubmit").html("loading...");

                    },
                    success: function(data) {

                        if (data.success) {
                            getRoles();
                            $('.close').click();
                            $('#LeadForm')[0].reset();
                            toastr.success(data.success);

                        }
                        if (data.errors) {
                            toastr.error(data.errors);
                        }
                    },

                    complete : function(data){
                        $("#btnSubmit").html("Save");
                        $("#btnSubmit").prop("disabled", false);
                    },
                    error: function() {
                        toastr.error('something went wrong');

                    },

                });


            });


            function getRoles() {

                $.ajax({

                    url: '{{url("/roles-list")}}',
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

                            html += '<tr>'+

                                '<td>'+c+'</td>' +
                                '<td>'+data[i].role+'</td>' +
                                '<td>'+data[i].created_at+'</td>' +


                                '</tr>';
                        }


                        $('#leadsTable').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }


        });
    </script>


@endsection
