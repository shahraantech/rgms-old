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


        <div class="page-header my-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title bold-heading">Expense Head List</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Expense Head List</li>
                    </ul>
                </div>


                <div class="col-auto float-right ml-auto">
                    <a href="{{url('/finance-expense')}}" class="btn add-btn" title="Add Expense Head"><i class="fa fa-plus" aria-hidden="true"></i></a>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <table class="table table-striped table-hover" id="datatable">

                    <thead>
                        <tr>
                            <th>SR#</th>
                            <th>Expense Head</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody id="expenseHeadTable">

                    </tbody>

                </table>
            </div>
        </div>

        <!-- /Page Content -->
    </div>


    <!-- Edit expense_head -->
    <div id="edit_expense_head_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Expense Head</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="" id="EditExpenseHeadForm" class="needs-validation" novalidate>
                        <input type="hidden" name="expense_head_id">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="exp_head" placeholder="exp_head" required>
                                </div>
                            </div>

                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn exp_head_update" type="button">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Expense Head -->


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            getExpenseHead();

            function getExpenseHead() {

                $.ajax({

                    url: '{{url("/expense-list")}}',
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
                                '<td>' + data[i].exp_head + '</td>' +
                                '<td>' + data[i].created_at + '</td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a class="dropdown-item btn_edit_expense_head" href="#" data-toggle="modal"  data="' + data[i].id + '"><i class="fa fa-pencil m-r-5n "></i> Edit</a>' +
                                '<a class="dropdown-item btn_delete_expense_head" href="#" " data="' + data[i].id + '"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +

                                '</tr>';
                        }


                        $('#expenseHeadTable').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }

            //Edit expense head
            $('#expenseHeadTable').on('click', '.btn_edit_expense_head', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                $('#edit_expense_head_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{url("expense-head-edit")}}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('input[name=expense_head_id]').val(data.id);
                        $('input[name=exp_head]').val(data.exp_head);
                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });

            //update expense head
            $('.exp_head_update').on('click', function() {

                var formData = $('#EditExpenseHeadForm').serialize();

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{url("expense-head-update")}}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('#edit_expense_head_modal').modal('hide');
                        toastr.success(data.success);
                        getExpenseHead();
                    },

                    error: function() {
                        toastr.error('something went wrong');

                    }

                });

            });

            // script for delete data
            $('#expenseHeadTable').on('click', '.btn_delete_expense_head', function(e) {
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
                            url: "{{ url('/expense-head-delete/') }}/" + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.success) {
                                    toastr.success(response.success);
                                    getExpenseHead();
                                }
                            }
                        });
                    }
                });

            });

            //Datatables
            $('#datatable').DataTable();

        });
    </script>

    @endsection