@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Assign Targets</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Assign Targets</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container mt-1">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Target</label>
                        <input type="text" class="form-control" readonly value="{{$data['target']->target_in_numbers}}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Assign</label>
                        <input type="text" class="form-control" value="{{$data['assignTarget']}}" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Pending</label>
                        <input type="text" class="form-control pending" name="pendingTarget" value="{{$data['target']->target_in_numbers - $data['assignTarget']}}" readonly>
                    </div>
                </div>
            </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <form action="{{url('save-assign-target')}}" id="AssignTarget" method="post" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <input type="hidden" name="hidden_target_id" value="{{$data['target']->id}}">
                            <table class="table table-bordered table-style">
                                <tbody id="tblPurchase">
                                <tr>
                                    <td>
                                        <select name="member_id[]" class="form-control">
                                            <option value="">Choose Member</option>
                                            @isset($data['member'] )
                                                @foreach($data['member'] as $member)
                                                    <option value="{{$member['id']}}">{{$member['name']}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control numberOf" placeholder="Number of Sales/Meetings" name="numberOf[]" required>
                                        <div class="numberOfErrors"></div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="{{ strtoupper($data['target']->target_type)}}'s" name="sales" readonly>
                                    </td>
                                    <td><button type="button" class="btn-success" id="addNewRow"><i class="fa fa-plus"></i></button> </td>
                                </tr>

                                </tbody>



                                   <input type="hidden" class="form-control" name="grand_total" >


                            </table>
                            <button class="btn btn-primary" id="btnSubmit" type="submit">Save</button>
                        </div>
                    </form>
                    <!-- tabel end -->
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
    <script type="text/javascript">
        $(function () {
            $('#addNewRow').on('click', function () {
                var tr = $("#dvOrders").find("Table").find("TR:has(td)").clone();
                console.log(tr);
                $("#tblPurchase").append(tr);
            });
        });
    </script>
    <div id="dvOrders" style="display:none">
        <table class="table table-bordered mt-5 table-style secondtable " >
            <tr>
                <td>
                    <select name="member_id[]" class="form-control"required>
                        <option value="">Choose Item</option>
                        @isset($data['member'] )
                            @foreach($data['member'] as $member)
                                <option value="{{$member['id']}}">{{$member['name']}}</option>
                            @endforeach
                        @endisset
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control numberOf" placeholder="Number of Sales/Meetings" name="numberOf[]" required>
                    <div class="numberOfErrors"></div>
                </td>
                <td>
                    <input type="text" class="form-control" value="{{ strtoupper($data['target']->target_type)}}'s" name="sales" readonly>
                </td>
                <td style="color:red;cursor: pointer" class="delete-row" title="Remove"><i class="fa fa-trash"></i></td>
            </tr>

        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {

            // Denotes total number of rows
            var rowIdx = 0;
            // jQuery button click event to remove a row.
            $('#tblPurchase').on('click', '.delete-row', function () {

                // Getting all the rows next to the row
                // containing the clicked button
                var child = $(this).closest('tr').nextAll();

                // Iterating across all the rows
                // obtained to change the index
                child.each(function () {

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



            $('#AssignTarget').unbind().on('submit', function(e) {
                e.preventDefault();

                var formData = $('#AssignTarget').serialize();

                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{url("save-assign-target")}}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {

                        $(".btnSubmit").prop("disabled", true);
                        $(".btnSubmit").html("loading...");

                    },
                    success: function(data) {

                        if (data.success) {

                            $('#AssignTarget')[0].reset();
                            toastr.success(data.success);
                            window.location.reload();
                        }
                        if (data.errors) {

                            toastr.error(data.errors);
                            //toastr.error('missing some fileds');

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


            $('#tblPurchase').on('keyup','.numberOf', function() {
                grandTotal();
                var pendingTarget=$('input[name=pendingTarget]').val();
                var total=$('input[name=grand_total]').val();

               if(parseFloat(total) > parseFloat(pendingTarget)){
                   $("#btnSubmit").prop("disabled", true);
                   var p='<span style="color:red">Please enter less then pending targets</span>';
                   var $currentRow = $(this).closest('tr');
                   $currentRow.find('.numberOfErrors').html(p);

               }
               else{
                   $("#btnSubmit").prop("disabled", false);
                   var p='';
                   $('.numberOfErrors').html(p);

               }


            });



            function  grandTotal(){

                var grandTotal=0;
                $(".numberOf").each(function() {
                    var subTotal=$(this).val();
                    (subTotal)? grandTotal=parseFloat(grandTotal) + parseFloat(subTotal):'';

                });

                $('input[name=grand_total]').val(grandTotal);
            }

        });
    </script>
@endsection
