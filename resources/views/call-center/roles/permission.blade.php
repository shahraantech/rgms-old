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
                            <h3 class="page-title bold-heading">Role Permissions</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Role Permissions</li>
                            </ul>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <form action="{{url('test-permissions')}}" method="post" id="rolePermission">
                            @csrf

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select name="role_id" class="form-control selectpicker" data-container="body" data-live-search="true">
                                            <option value="" selected >--Select--</option>
                                            @isset($data['roles'])
                                                @foreach($data['roles'] as $role)
                                                    <option value="{{ $role->id }}">{{ $role->role }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>



                            </div>

                            <table class="table table-striped table-hover data-table" >
                                <tbody id="permissionTable">


                                </tbody>

                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
        </div>

    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {

            getPermission();
            //get all permisisions in role base
            $('select[name=role_id]').change(function() {
                var role_id = $('select[name=role_id]').val();

                $.ajax({

                    url: '{{url("test-permissions")}}',
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    data:{role_id:role_id},
                    success: function(data){

                        $('#permissionTable').html(data);
                    },
                    error:function()

                    {
                        toastr.error('something went wrong');
                    }

                });

            });
            $("#permissionTable").delegate(".checkbox","click",function(){

                var role_id=$('select[name=role_id]').val();
                if(!role_id){
                    toastr.error('choose role please');
                    $(this).prop('checked',false);

                }else {
                    var sum_module_id = $(this).attr('data');

                    var status = 0;
                    ($(this).prop("checked") == true) ? status = 1 : status = 0;


                    $.ajax({

                        type: 'ajax',
                        method: 'get',
                        url: '{{url("update-role-has-permissions")}}',
                        data: {sub_module_id: sum_module_id, status: status, role_id: role_id},
                        async: false,
                        dataType: 'json',
                        beforeSend: function () {

                            // $("#btnSubmit").prop("disabled", true);
                            // $("#btnSubmit").html("loading...");

                        },
                        success: function (data) {
                            console.log(data);
                            if (data.success) {
                                toastr.success(data.success);
                            }
                            if (data.errors) {
                                toastr.error(data.errors);
                            }
                        },

                        complete: function (data) {
                            // $("#btnSubmit").html("Save");
                            // $("#btnSubmit").prop("disabled", false);
                        },
                        error: function () {
                            toastr.error('something went wrong');

                        },

                    });
                }
            });
            function  getPermission(){


                $.ajax({

                    url: '{{url("test-permissions")}}',
                    type: 'get',
                    async: false,
                    dataType: 'json',

                    success: function(data){

                        $('#permissionTable').html(data);
                    },
                    error:function()

                    {
                        toastr.error('something went wrong');
                    }

                });
            }


        });
    </script>
@endsection
