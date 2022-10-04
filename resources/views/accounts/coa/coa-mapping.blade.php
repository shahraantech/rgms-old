@extends('setup.master')
@section('content')



    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">COA Mapping</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">COA Mapping</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_supplier" title="Add Supplier"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered mt-5 table-hover table-striped">
                        <thead>
                        <tr>
                            <th># </th>
                            <th>Module</th>
                            <th>Level</th>
                            <th>Head</th>
                            <th>Created At </th>
                        </tr>
                        </thead>
                        <tbody id="supplierTable">
                        @php $c=0 @endphp
                        @isset($data['mapping'])
                            @foreach($data['mapping'] as $mapp)
                                @php $c++ @endphp
                               <tr>
                                    <td>{{$c}}</td>
                                    <td>{{ strtoupper($mapp->module)}}</td>
                                    <td>{{$mapp->level_no}}</td>
                                    <td>
                                        @php
                                            $headName=App\Models\Ledger::getLevelHeadName($mapp->level_no,$mapp->head_id);
                                            @endphp
                                        {{$headName}}
                                    </td>

                                    <td> {{$mapp->created_at}}</td>
                                    </tr>
                            @endforeach
                                @endisset

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
                        <h5 class="modal-title">COA Mapping</h5>
                        <button type="button" class="close btn-dismiss" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{url('coa-mapping')}}" class="needs-validation" novalidate id="supplierForm">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Module</label>
                                        <select name="module" id="" class="form-control">
                                            <option value="">Choose One</option>
                                            <option value="vendors"> Vendors</option>
                                            <option value="clients"> Customers</option>
                                            <option value="purchase"> Purchase</option>
                                            <option value="sale"> Sale</option>
                                            <option value="expense"> Daily Expense</option>
                                            <option value="commission">Commission</option>
{{--                                            <option value="payments"> Payments</option>--}}
{{--                                            <option value="receipts"> Receipts</option>--}}
{{--                                            <option value="bank"> Bank Trial Balance</option>--}}
                                        </select>
                                    </div>
                                </div>


                            </div>
                            @include('accounts.coa.coa-level')
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


                $('#supplierForm').unbind().on('submit', function(e) {
                    e.preventDefault();
                    var formData = $('#supplierForm').serialize();
                    $.ajax({
                        type: 'ajax',
                        method: 'post',
                        url: '{{url("coa-mapping")}}',
                        data: formData,
                        async: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $(".btn-submit").prop("disabled", true);
                            $(".btn-submit").html("please wait...");

                        },
                        success: function(data) {
                            if (data.success) {
                                $('.close').click();
                                $('#supplierForm')[0].reset();
                                toastr.success(data.success);
                                window.location.reload();
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
