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
                    <h3 class="page-title bold-heading">Expense Summary</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Expense Summary</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{url('/manage-expense')}}" class="btn add-btn" title="Manage Expense"><i class="fa fa-plus" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ url('expense-summary') }}" class="needs-validation" novalidate id="SearchForm">
                    @csrf
                    <div class="row">


                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">From</label>
                                <input type="date" class="form-control" name="from_date" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">To</label>
                                <input type="date" class="form-control" name="to_date" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-search" style="margin-top:28px" title="Search"><i class="fa fa-search"></i></button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        @if($data['exp']->count() > 0)
        <div class="card">
            <div class="card-body">
                @isset($data['exp'])
                    @foreach($data['exp'] as $key => $exp)
                        @php
                        $res=App\Models\Ledger::where('transaction_id',$exp->id)->where('ac_type','company-account')->first();
                        $account_id=$res->account_id;
                        @endphp
                @endforeach
                @endisset
                    <div class="form-group" style="float: right">
                        <a href="{{url('print-expense-summary').'/'.$data['from_date'].'/'.$data['to_date'].'/'.$account_id}}" style="margin-top:28px" title="Print"><i class="fa fa-print"></i></a>

                </div>
                <table class="table table-striped table-hover" id="datatable">
                    <thead>
                        <tr>
                            <th>SR#</th>
                            <th>Exp Head</th>
                            <th>Amount</th>
                            <th>Remarks</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="summaryTable">
                    @php $total=0; @endphp
                        @isset($data['exp'])
                        @foreach($data['exp'] as $key => $exp)

                            @php $total=$total + $exp->amount; @endphp
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>
                                @php
                                    $headName=App\Models\Ledger::getLevelHeadName($exp->coa_level,$exp->coa_head_id);
                                    @endphp
                                {{$headName}}
                            </td>

                            <td>{{number_format($exp->amount,2)}}</td>
                            <td>{{$exp->desc}}</td>
                            <td>{{date('d-M-Y',strtotime($exp->date))}}</td>

                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item btn-edit" href="#" data="{{$exp->id }}" data-toggle="modal" data-target="#edit_expense_summary_modal"><i class="fa fa-edit" aria-hidden="true"></i></a>

                                    </div>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                        @endisset

                    </tbody>

                    <tr>

                        <td  colspan="2">
                            <div class="float-right"> <strong>Total:</strong></div>
                        </td>
                        <td > <strong>PKR {{number_format($total,2)}}</strong></td>
                        <td></td>
                        <td></td>
                        <td></td>

                    </tr>
                </table>
            </div>
        </div>
        @else
        <div class="alert alert-danger">Record not exist</div>
            @endif
    </div>


    <!-- Edit Expense summary -->
    <div id="edit_expense_summary_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{url('update-expense-summary')}}" id="EditSummaryForm" class="needs-validation" novalidate enctype="multipart/form-data">
                        <input type="hidden" name="hidden_trans_id">
                        @csrf
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                            <select name="edit_exp_head_id" class="form-control">
                                <option value="">Choose Head</option>
                            </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                           <div class="form-group">
                               <input type="date" class="form-control" placeholder="date" name="edit_date">
                           </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Amount" name="edit_amount">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Remarks" name="edit_remarks">
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Attachment</label>
                                    <input type="file" class="form-control" name="file" id="pic">
                                    <div class="invalid-feedback">
                                        please choose account.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary btn-save-changes" type="submit">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Expense summary -->


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            //Edit expense summary
            $('#summaryTable').on('click', '.btn-edit', function(e) {
                e.preventDefault();
                var id = $(this).attr('data');
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{url("edit-expense-summary")}}',
                    data: {id:id},
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('input[name=hidden_trans_id]').val(data.exp.id);
                        $('input[name=edit_amount]').val(data.exp.amount);
                        $('input[name=edit_remarks]').val(data.exp.desc);
                        $('input[name=edit_date]').val(data.exp.date);

                        //edit dropdown in ajax
                        $.each(data.exp_head, function(key, exp_head) {
                            $('select[name="edit_exp_head_id"]')
                                .append(`<option value="${exp_head.id}" ${exp_head.id == data.exp.coa_head_id ? 'selected' : ''}>${exp_head.level_four_head}</option>`)
                        });
                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }
                });
            });
            // script for delete data
            $('#summaryTable').on('click', '.btn_delete_summary', function(e) {
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
                            url: "{{ url('/expense-summary-delete') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                id: id
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.success) {
                                    toastr.success(response.success);
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 1000);
                                }
                            }
                        });
                    }
                });

            });

            $('#EditSummaryForm').unbind().on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                let file = $('#pic')[0];
                formData.append('file', file.files[0]);

                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{url("update-expense-summary")}}',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    async: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $(".btn-save-changes").prop("disabled", true);
                        $(".btn-save-changes").html("please wait...");

                    },
                    success: function(data) {
                        if (data.success) {
                            toastr.success(data.success);
                            window.location.reload()
                        }
                    },
                    complete: function(data) {
                        $(".btn-save-changes").html("Save Changes");
                        $(".btn-save-changes").prop("disabled", false);
                    },
                    error: function() {
                        toastr.error('something went wrong');

                    }
                });

            });
        });
    </script>

    @endsection
