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
                        <h3 class="page-title bold-heading">Accounts List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Accounts List</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ url('/accounts') }}" class="btn add-btn" title="Add new Account"><i class="fa fa-plus"
                                                                                                        aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-hover" id="payments-list">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>A/C Head</th>
                            <th>Balance</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="accountTable">
                        @php $c=0; @endphp
                        @isset($data['accounts'])
                            @foreach ($data['accounts'] as $account)
                                @php $c++; @endphp
                                <tr>
                                    <td>{{ $c }}</td>
                                    <td>
                                        @php
                                            $headName = App\Models\Ledger::getLevelHeadName($account->level_no, $account->ac_head_id);
                                        @endphp
                                        {{ $headName }}
                                    </td>
                                    @php
                                        $balance=App\Models\Ledger::countAccountsBalance('company-account',$account->id);
                                        @endphp
                                    <td>PKR {{ number_format($balance,2) }}</td>
                                    <td>{{ $account->date }}</td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                               aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{ url('account-history/' . $account->id . '/company-account') }}"
                                                   class="dropdown-item"><i class="fa fa-pencil m-r-5n "></i> History</a>
                                                <a href="#" class="dropdown-item btn_edit_account "
                                                   data="{{ $account->id }}"><i class="fa fa-pencil m-r-5n "></i> Edit</a>
                                                <a href="#" class="dropdown-item btn_delete_account "
                                                   data="{{ $account->id }}"><i class="fa fa-trash-o m-r-5 "></i>
                                                    Delete</a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endisset
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- /Page Content -->
        </div>

        <!--Edit Training Modal -->
        <div id="edit_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        <form method="POST" action="{{ url('update-accounts') }}" id="editAccounts"
                              class="needs-validation" novalidate>

                            @csrf
                            <input type="hidden" name="account_hidden_id">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">A/C Head</label>
                                        <select class="select" name="account_head" required>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">A/C Holder Name</label>
                                        <input class="form-control" type="text" name="ac_holder_name" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Email</label>
                                        <input class="form-control" type="email" placeholder="Training Cost"
                                               name="email">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Contact <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" placeholder="Training Cost"
                                               name="contact" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>CNIC <span class="text-danger">*</span></label>
                                        <div class=""><input class="form-control " name="cnic" type="number">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Balance <span class="text-danger">*</span></label>
                                        <div class=""><input class="form-control " name="balance" type="text"
                                                             required></div>
                                    </div>
                                </div>

                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary btn-update" type="button">Update</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!--Edit Training Modal -->





        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <!-- CDN for Sweet Alert -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script type='text/javascript'>
            $(document).ready(function() {



                //Edit Data with ajax call
                $('#accountTable').on('click', '.btn_edit_account', function(e) {
                    e.preventDefault();
                    var id = $(this).attr('data');
                    $('#edit_modal').modal('show');

                    $.ajax({

                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('edit-accounts') }}',
                        data: {
                            id: id
                        },
                        async: false,
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);

                            $('input[name=account_hidden_id]').val(data.accounts.id);
                            $('input[name=ac_holder_name]').val(data.accounts.ac_holder_name);
                            $('input[name=email]').val(data.accounts.email);
                            $('input[name=contact]').val(data.accounts.contact);
                            $('input[name=cnic]').val(data.accounts.cnic);
                            $('input[name=balance]').val(data.accounts.balance);

                            //select dropdown in edit modal
                            $.each(data.achead, function(key, value) {
                                $('select[name="account_head"]')
                                    .append(
                                        `<option value="${value.id}" ${value.id == data['accounts'].ac_head_id ? 'selected' : ''}>${value.ac_head}</option>`
                                    )

                            });
                        },

                        error: function() {
                            toastr.error('something went wrong');
                        }

                    });

                });



                // script for delete data
                $('#accountTable').on('click', '.btn_delete_account', function(e) {
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
                                data: {
                                    id: id
                                },
                                url: '{{ url('delete-account') }}',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType: "json",
                                success: function(response) {

                                    if (response.success) {
                                        toastr.success(response.success);
                                        window.location.reload();
                                    } else {
                                        toastr.error(response.errors);
                                    }


                                }
                            });
                        }
                    })

                });

                //updates accounts
                $('.btn-update').on('click', function() {
                    var formData = $('#editAccounts').serialize();


                    $.ajax({

                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('update-accounts') }}',
                        data: formData,
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            if (data.success) {
                                toastr.success(data.success);
                                window.location.reload();

                            }

                        },

                        error: function() {
                            toastr.error('something went wrong');

                        }

                    });

                });


            });
        </script>
@endsection
