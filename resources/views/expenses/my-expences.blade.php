@extends('setup.master')

@section('content')

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    </head>
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">My Expenses</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">My Expenses</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_ticket"
                            title="add expense"><i class="fa fa-plus"></i> </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">

                        <table class="table table-striped table-responsive" id="datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Expense Type</th>
                                    <th>Cost</th>
                                    <th>Bill</th>
                                    <th>Expense Period</th>

                                    <th>Description</th>
                                    <th>Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>

                                </tr>
                            </thead>
                            <tbody id="showExpense">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->


    </div>

    <!-- Add Expense Modal -->
    <div id="add_ticket" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Expenses</h5>
                    <button type="button" class="close btn-dismiss" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="expenseForm" action="" enctype="multipart/form-data">

                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Expense Type</label>

                                    <select class="form-control selectpicker" data-container="body" data-live-search="true"
                                        name="exp_type" required>
                                        <option value="">Choose Type</option>
                                        <option value="Official Travelling">Official Travelling</option>
                                        <option value="Medical">Medical</option>
                                        <option value="Food">Food</option>
                                        <option value="Others">Others</option>


                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Expense Amount</label>
                                    <input class="form-control" type="number" name="cost" required placeholder="Amount">
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Expense Period</label>
                                    <input type="text" class="form-control" required name="period"
                                        placeholder="Expense period in days">
                                </div>


                            </div>

                        </div>





                        <div class="row">

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea cols="10" rows="3" class="form-control" required name="desc"></textarea>
                                </div>


                            </div>
                        </div>


                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Bill</label>
                                    <input type="file" id="pic" class="form-control" required name="file"
                                        onchange="previewFile(this);">
                                </div>


                            </div>


                            <div class="col-sm-6" style="visibility: hidden" id="imagePreviewDiv">
                                <div class="form-group">

                                    <img id="previewImg" style="height: 150px" width="150px;" class="img img-thumbnail">
                                </div>


                            </div>

                        </div>
                        <div class="submit-section">


                            <button class="btn btn-primary btn-submit btn_save_exp" type="submit">Save</button>


                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Expense Modal -->



    <!-- Edit Expense Modal -->
    <div id="edit_expense_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Expenses</h5>
                    <button type="button" class="close btn-dismiss" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="EditExpenseForm" class="needs-validation" novalidate action=""
                        enctype="multipart/form-data">

                        <input type="hidden" name="expense_id">

                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Expense Type</label>

                                    <select class="select" name="exp_type" required>
                                        <option value="">Choose Type</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Expense Amount</label>
                                    <input class="form-control" type="number" name="cost" required
                                        placeholder="Amount">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Expense Period</label>
                                    <input type="text" class="form-control" required name="period"
                                        placeholder="Expense period in days">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea cols="10" rows="3" class="form-control" required name="desc"></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Bill</label>
                                    <input type="file" id="pic" class="form-control" required name="file">
                                    <span id="store_image"></span>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary btn-submit update_expense" type="submit">Save Changes</button>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Ticket Modal -->


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            $('#expenseForm').validate({

                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            expensesList();


            $('#expenseForm').on('submit', function(e) {
                e.preventDefault();

                var $form = $(this);
                // check if the input is valid
                if (!$form.validate().form()) return false;

                let formData = new FormData($('#expenseForm')[0]);


                $.ajax({
                    type: "POST",
                    url: '{{ url('my-expenses') }}',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.btn_save_exp').text('Saving...');
                        $(".btn_save_exp").prop("disabled", true);
                    },
                    success: function(data) {

                        if (data.errors) {
                            toastr.error(data.errors);
                            $('.btn_save_exp').text('Save');
                            $(".btn_save_exp").prop("disabled", false);
                        }

                        if (data.success) {
                            expensesList();
                            $('.close').click();
                            toastr.success(data.success);
                            $('.btn_save_exp').text('Save');
                            $(".btn_save_exp").prop("disabled", false);
                            $('#expenseForm')[0].reset();
                        }

                    },

                    error: function() {
                        toastr.error('something went wrong');
                        $('.btn_save_exp').text('Save');
                        $(".btn_save_exp").prop("disabled", false);
                    },

                });

            });


            function expensesList() {

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('getMyExpenseList') }}',
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
                                '<td>' + data[i].expense_type + '</td>' +
                                ' <td>' + data[i].expense_amount + '</td>' +
                                ' <td><img src="{{ asset('storage/app/public/uploads/expense-bills') }}/' +
                                data[i].expense_bill +
                                '" style="height:45px; width:60px" class="img img-thumbnail"></td>' +
                                '<td>' + data[i].expense_period + '</td>' +
                                '<td>' + data[i].expense_desc + '</td>' +
                                '<td>' + data[i].created_at + '</td>' +
                                '<td>' + data[i].status + '</td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a href="#" class="dropdown-item btn_edit_expense" data="' + data[i]
                                .id +
                                '" id="btn_edit_clients"><i class="la la-pencil" style="font-size: 20px;"></i></a>' +
                                '<a href="" class="dropdown-item btn_delete_expense" data="' + data[i]
                                .id +
                                '" id="btn_delete_clients"><i class="la la-trash" style="font-size: 20px;"></i></a>' +

                                '</tr>';
                        }


                        $('#showExpense').html(html);

                    },

                    error: function() {
                        toastr.error('something went wrong');

                    }

                });
            }

            //edit data
            $('#showExpense').on('click', '.btn_edit_expense', function() {


                var id = $(this).attr('data');

                $('#edit_expense_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('edit-expense') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('input[name=expense_id]').val(data.id);

                        $('select[name="exp_type"]')
                            .append(
                                `<option value="Official Travelling" ${'Official Travelling' == data.expense_type ? 'selected' : ''}>Official Travelling</option>` +
                                `<option value="Medical" ${'Medical' == data.expense_type ? 'selected' : ''}>Medical</option>` +
                                `<option value="Food" ${'Food' == data.expense_type ? 'selected' : ''}>Food</option>` +
                                `<option value="Others" ${'Others' == data.expense_type ? 'selected' : ''}>Others</option>`
                            );


                        $('input[name=cost]').val(data.expense_amount);
                        $('input[name=period]').val(data.expense_period);
                        $('textarea[name=desc]').val(data.expense_desc);
                        $('#store_image').html(
                            '<img src="{{ asset('storage/app/public/uploads/expense-bills/') }}/' +
                            data.expense_bill +
                            '" class="mt-4 ml-4" width="40px" height="70px" />');
                        $('#store_image').append(
                            '<input type="hidden" name="hidden_image" value="' + data
                            .expense_bill + '" />');

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            });

            //update expanse
            $('.update_expense').on('click', function(e) {
                e.preventDefault();
                $('.update_expense').text('Saving...');

                let EditFormData = new FormData($('#EditExpenseForm')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('/update-expense') }}",
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(response) {

                        if (response.status == 200) {
                            $("#edit_expense_modal").modal('hide');
                            $('#EditExpenseForm').find('input').val("");
                            $('.update_expense').text('Save Changes');
                            toastr.success(response.message);
                            expensesList();
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.update_expense').text('Save Changes');
                    }
                });

            });


            // script for delete data
            $('#showExpense').on('click', '.btn_delete_expense', function(e) {
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
                            url: "{{ url('/delete-expense/') }}/" + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {

                                toastr.success(response.message);

                                expensesList();
                            }
                        });
                    }
                })

            });

            //Datatables
            $('#datatable').DataTable();

        });
    </script>

    <script>
        function previewFile(input) {

            $("#imagePreviewDiv").css('visibility', 'visible');
            var file = $("input[type=file]").get(0).files[0];

            if (file) {
                var reader = new FileReader();

                reader.onload = function() {
                    $("#previewImg").attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
