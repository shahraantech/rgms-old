@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Payroll Items</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payroll Items</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <!-- Page Tab -->
            <div class="page-menu">
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs nav-tabs-bottom">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab_additions">Allowance</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab_overtime">Allowance Assigne</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Tab -->
            <!-- Tab Content -->
            <div class="tab-content">
                <!-- Additions Tab -->
                <div class="tab-pane show active" id="tab_additions">
                    <!-- Add Addition Button -->
                    <div class="text-right mb-4 clearfix">
                        <button class="btn btn-primary add-btn" type="button" data-toggle="modal"
                            data-target="#add_addition" title="Create Allowance"><i class="fa fa-plus"></i> </button>
                    </div>
                    <!-- /Add Addition Button -->
                    <!-- Payroll Additions Table -->
                    <div class="card">
                        <div class="card-body">
                            <div class="payroll-table">
                                <div class="table-responsive">
                                    <table class="table table-hover table-radius">
                                        <thead>
                                            <tr>
                                                <th>SR#</th>
                                                <th>Allowance</th>
                                                <th>Decription</th>
                                            </tr>
                                        </thead>
                                        <tbody id="allowanceList">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Payroll Additions Table -->
                </div>
                <!-- Additions Tab -->
                <!-- Overtime Tab -->
                <div class="tab-pane" id="tab_overtime">
                    <!-- Add Overtime Button -->
                    <div class="text-right mb-4 clearfix">
                        <button class="btn btn-primary add-btn" type="button" data-toggle="modal"
                            data-target="#add_overtime" title="assign allowance"><i class="fa fa-plus"></i></button>
                    </div>
                    <!-- /Add Overtime Button -->
                    <!-- Payroll Overtime Table -->
                    <div class="card">
                        <div class="card-body">
                            <div class="payroll-table">
                                <div class="table-responsive">
                                    <table class="table table-hover table-radius" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>SR#</th>
                                                <th>Employee Name</th>
                                                <th>Allowance List</th>
                                                <th>Allowance Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @isset($data['empAllowance'])
                                                @foreach ($data['empAllowance'] as $key => $emp_all)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $emp_all->name }}</td>
                                                        <td>
                                                            <ul style="list-style-type: none">
                                                                <li>
                                                                    @php $allow_ids=(explode(",", $emp_all->allowance_id)); @endphp
                                                                    @foreach ($allow_ids as $k => $val)
                                                                        @php $allData=App\Models\Allownce::find($val); @endphp
                                                                        @if ($allData)
                                                                            <span class="badge bg-inverse-success">
                                                                                {{ $allData->allowance }}</span>
                                                                        @endif
                                                                    @endforeach
                                                                </li>
                                                            </ul>
                                                        </td>
                                                        <td>{{ $emp_all->amount }}</td>
                                                    </tr>
                                                @endforeach
                                            @endisset
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Payroll Overtime Table -->
            </div>
            <!-- /Overtime Tab -->
        </div>
        <!-- Tab Content -->
    </div>
    <!-- /Page Content -->


    <!-- Add Allounce Modal -->
    <div id="add_addition" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Allowance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ url('payroll-items') }}" id="allowanceForm">
                        <div class="form-group">
                            <label>Allowance <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="allowance" placeholder="Allowance" required>
                        </div>
                        <div class="form-group">
                            <label class="d-block">Description</label>
                            <textarea name="desc" cols="10" rows="3" class="form-control" placeholder="Description" required></textarea>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn btn_add_alunce" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Allounce Modal -->


    <!-- Edit Allounce Modal -->
    <div id="edit_allounce_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Allowance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="" id="EditAllounceForm" class="needs-validation">
                        <input type="hidden" name="allownce_id">
                        @csrf
                        <div class="form-group">
                            <label>Allowance <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="allowance" required>
                        </div>
                        <div class="form-group">
                            <label class="d-block">Description</label>
                            <textarea name="desc" cols="10" rows="3" class="form-control" required></textarea>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn update_allowance" type="button">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Allounce Modal -->



    <!-- Edit Addition Modal -->
    <div id="edit_addition" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Addition</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text">
                        </div>
                        <div class="form-group">
                            <label>Category <span class="text-danger">*</span></label>
                            <select class="select">
                                <option>Select a category</option>
                                <option>Monthly remuneration</option>
                                <option>Additional remuneration</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="d-block">Unit calculation</label>
                            <div class="status-toggle">
                                <input type="checkbox" id="edit_unit_calculation" class="check">
                                <label for="edit_unit_calculation" class="checktoggle">checkbox</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Unit Amount</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="d-block">Assignee</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_addition_assignee"
                                    id="edit_addition_no_emp" value="option1" checked>
                                <label class="form-check-label" for="edit_addition_no_emp">
                                    No assignee
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_addition_assignee"
                                    id="edit_addition_all_emp" value="option2">
                                <label class="form-check-label" for="edit_addition_all_emp">
                                    All employees
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_addition_assignee"
                                    id="edit_addition_single_emp" value="option3">
                                <label class="form-check-label" for="edit_addition_single_emp">
                                    Select Employee
                                </label>
                            </div>
                            <div class="form-group">
                                <select class="select">
                                    <option>-</option>
                                    <option>Select All</option>
                                    <option>John Doe</option>
                                    <option>Richard Miles</option>
                                </select>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Addition Modal -->
    <!-- Delete Addition Modal -->
    <div class="modal custom-modal fade" id="delete_addition" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Addition</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" data-dismiss="modal"
                                    class="btn btn-primary cancel-btn">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Addition Modal -->
    <!-- Add Overtime Modal -->
    <div id="add_overtime" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Allowance to Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ url('payroll-items') }}" id="empAllowanceForms"
                        class="needs-validation">
                        <input type="hidden" name="empAllowanceForm" value="1">
                        <div class="form-group">
                            <label>Employee <span class="text-danger">*</span></label>

                            <select name="emp_id" class="form-control selectpicker" data-container="body"
                                data-live-search="true" title="Choose  Employee" required>

                                @isset($data)
                                    @foreach ($data['employee'] as $emp)
                                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Allowance <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm select2" multiple="multiple"
                                name="allowance_id[]" required>
                                <option></option>
                                @isset($data)
                                    @foreach ($data['allowance'] as $all)
                                        <option value="{{ $all->id }}">{{ $all->allowance }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Allowance <span class="text-danger">*</span></label>
                            <input type="number" name="allowance_percent" placeholder="Allowance in amount"
                                class="form-control" required>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn btn_asin">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Overtime Modal -->
    <!-- Edit Overtime Modal -->
    <div id="edit_overtime" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Overtime</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text">
                        </div>
                        <div class="form-group">
                            <label>Rate Type <span class="text-danger">*</span></label>
                            <select class="select">
                                <option>-</option>
                                <option>Daily Rate</option>
                                <option>Hourly Rate</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Rate <span class="text-danger">*</span></label>
                            <input class="form-control" type="text">
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Overtime Modal -->
    <!-- Delete Overtime Modal -->
    <div class="modal custom-modal fade" id="delete_overtime" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Overtime</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" data-dismiss="modal"
                                    class="btn btn-primary cancel-btn">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Overtime Modal -->
    <!-- Add Deduction Modal -->
    <div id="add_deduction" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Deduction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text">
                        </div>
                        <div class="form-group">
                            <label class="d-block">Unit calculation</label>
                            <div class="status-toggle">
                                <input type="checkbox" id="unit_calculation_deduction" class="check">
                                <label for="unit_calculation_deduction" class="checktoggle">checkbox</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Unit Amount</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="d-block">Assignee</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="deduction_assignee"
                                    id="deduction_no_emp" value="option1" checked>
                                <label class="form-check-label" for="deduction_no_emp">
                                    No assignee
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="deduction_assignee"
                                    id="deduction_all_emp" value="option2">
                                <label class="form-check-label" for="deduction_all_emp">
                                    All employees
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="deduction_assignee"
                                    id="deduction_single_emp" value="option3">
                                <label class="form-check-label" for="deduction_single_emp">
                                    Select Employee
                                </label>
                            </div>
                            <div class="form-group">
                                <select class="select">
                                    <option>-</option>
                                    <option>Select All</option>
                                    <option>John Doe</option>
                                    <option>Richard Miles</option>
                                </select>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Deduction Modal -->
    <!-- Edit Deduction Modal -->
    <div id="edit_deduction" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Deduction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text">
                        </div>
                        <div class="form-group">
                            <label class="d-block">Unit calculation</label>
                            <div class="status-toggle">
                                <input type="checkbox" id="edit_unit_calculation_deduction" class="check">
                                <label for="edit_unit_calculation_deduction" class="checktoggle">checkbox</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Unit Amount</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="d-block">Assignee</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_deduction_assignee"
                                    id="edit_deduction_no_emp" value="option1" checked>
                                <label class="form-check-label" for="edit_deduction_no_emp">
                                    No assignee
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_deduction_assignee"
                                    id="edit_deduction_all_emp" value="option2">
                                <label class="form-check-label" for="edit_deduction_all_emp">
                                    All employees
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_deduction_assignee"
                                    id="edit_deduction_single_emp" value="option3">
                                <label class="form-check-label" for="edit_deduction_single_emp">
                                    Select Employee
                                </label>
                            </div>
                            <div class="form-group">
                                <select class="select">
                                    <option>-</option>
                                    <option>Select All</option>
                                    <option>John Doe</option>
                                    <option>Richard Miles</option>
                                </select>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Addition Modal -->
    <!-- Delete Deduction Modal -->
    <div class="modal custom-modal fade" id="delete_deduction" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Deduction</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" data-dismiss="modal"
                                    class="btn btn-primary cancel-btn">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Deduction Modal -->
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {


            $('#allowanceForm').validate({

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

            $('#empAllowanceForms').validate({

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



            $('.select2').select2({
                placeholder: "Please select here",
                width: "100%"
            });
            getAllowanceList();

            function getAllowanceList() {

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('payroll-items') }}',
                    data: {
                        getAllowanceList: 1
                    },
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
                                '<td>' + data[i].allowance + '</td>' +
                                '<td>' + data[i].description + '</td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a class="dropdown-item btn_edit_allowance" href="#" data-toggle="modal"  data="' +
                                data[i].id +
                                '"><i class="la la-pencil" style="font-size: 20px;"></i></a>' +
                                '<a class="dropdown-item btn_delete_allowance" href="#" " data="' +
                                data[i].id +
                                '"><i class="la la-trash" style="font-size: 20px;"></i></a>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +
                                '<tr>';

                        }

                        $('#allowanceList').html(html);

                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });


            };

            //Add Allowance
            $('#allowanceForm').on('submit', function(e) {
                e.preventDefault();
                var $form = $(this);
                // check if the input is valid
                if (!$form.validate().form()) return false;

                let formData = new FormData($('#allowanceForm')[0]);

                $.ajax({
                    type: "POST",
                    url: '{{ url('payroll-items') }}',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.btn_add_alunce').text('Saving...');
                        $(".btn_add_alunce").prop("disabled", true);
                    },
                    success: function(data) {


                        if (data.success) {
                            getAllowanceList();
                            $('#allowanceForm')[0].reset();
                            $('.close').click();
                            toastr.success(data.success);
                            $('.btn_add_alunce').text('Save');
                            $(".btn_add_alunce").prop("disabled", false);
                            window.location.reload();
                        }

                    },

                    error: function() {
                        toastr.error('something went wrong');
                        $('.btn_add_alunce').text('Save');
                        $(".btn_add_alunce").prop("disabled", false);
                    }

                });

            });

            //Edit Allowance
            $('#allowanceList').on('click', '.btn_edit_allowance', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                $('#edit_allounce_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('edit-allowance') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('input[name=allownce_id]').val(data.id);
                        $('input[name=allowance]').val(data.allowance);
                        $('textarea[name=desc]').val(data.description);
                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });

            //update category
            $('.update_allowance').on('click', function() {

                var formData = $('#EditAllounceForm').serialize();

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('update-allowance') }}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('#edit_allounce_modal').modal('hide');
                        toastr.success(data.success);
                        getAllowanceList();
                    },

                    error: function() {
                        toastr.error('something went wrong');

                    }

                });

            });

            // script for delete data
            $('#allowanceList').on('click', '.btn_delete_allowance', function(e) {
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
                            url: "{{ url('/delete-allowance/') }}/" + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status == 200) {
                                    toastr.success(response.message);
                                    getAllowanceList();
                                }
                            }
                        });
                    }
                });

            });



            $('#empAllowanceForms').on('submit', function(e) {
                e.preventDefault();
                var $form = $(this);
                // check if the input is valid
                if (!$form.validate().form()) return false;

                let formData = new FormData($('#empAllowanceForms')[0]);

                $.ajax({

                    type: "POST",
                    url: '{{ url('payroll-items') }}',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.btn_asin').text('Saving...');
                        $(".btn_asin").prop("disabled", true);
                    },
                    success: function(data) {
                        if (data.success) {
                            getAllowanceList();
                            $('#empAllowanceForms')[0].reset();
                            $('.close').click();
                            toastr.success(data.success);
                            $('.btn_asin').text('Save');
                            $(".btn_asin").prop("disabled", false);
                            window.location.reload();
                        }
                    },

                    error: function() {
                        toastr.error('something went wrong');
                        $('.btn_asin').text('Save');
                        $(".btn_asin").prop("disabled", false);
                    }

                });

            });


            //Datatables
            $('#datatable').DataTable();
        });
    </script>




@endsection
