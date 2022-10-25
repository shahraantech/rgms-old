@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Week Off Day</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Week Off Day</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_off_day"
                            title="Give Feedback"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->



            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">

                                <table class="table table-striped mb-0 " id="datatable">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px;">#</th>
                                            <th>Company </th>
                                            <th>Employee </th>
                                            <th>Day </th>
                                            <th>Action </th>
                                        </tr>
                                    </thead>
                                    <tbody id="trainerTable">
                                        @foreach ($emps as $key => $emp)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $emp->company->name }}</td>
                                                <td>{{ $emp->empoyee->name }}</td>
                                                <td>{{ $emp->day_off }}</td>
                                                <td class="text-right">
                                                    <div class="dropdown dropdown-action"><a href="#"
                                                            class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                            aria-expanded="false"><i
                                                                class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right"><a
                                                                class="dropdown-item btn_edit_week_of" href="#"
                                                                data-toggle="modal" data="{{ $emp->id }}"><i
                                                                    class="fa fa-pencil m-r-5n "></i> Edit</a><a
                                                                class="dropdown-item btn_delete_week_of" href="#"
                                                                data="{{ $emp->id }}"><i
                                                                    class="fa fa-trash-o m-r-5 "></i>
                                                                Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <!-- /Page Content -->
    </div>


    <!-- Add Modal -->
    <div class="modal fade" id="add_off_day" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Add Week Off Day</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="{{ url('off-week-store') }}" method="POST" style="margin: 15px"
                            id="week_off_day_form">
                            @csrf
                            <table class="table table-bordered mt-5 table-style">

                                <label for="">Company</label>
                                <select name="company_id" class="form-control company_id" required>
                                    <option value="" selected disabled>Choose Company</option>
                                    @foreach ($company as $comp)
                                        <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please Choose Company.
                                </div>
                                @error('company_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                                <thead>
                                    <tr>
                                        <th>Employee <span class="text-danger">*</span></th>
                                        <th>Days <span class="text-danger">*</span></th>
                                    </tr>
                                </thead>
                                <tbody id="tblPurchase">

                                    <tr>

                                        <td>
                                            <select name="emp_id[]" class="form-control emp_id" required>
                                                <option value="">Choose employee</option>

                                            </select>
                                            <div class="invalid-feedback">
                                                Please Choose employee.
                                            </div>
                                        </td>
                                        <td>
                                            <select name="day_off[]" class="form-control item-id" required>
                                                <option value="" selected disabled>Choose day</option>
                                                <option value="Monday">Monday</option>
                                                <option value="Tuesday">Tuesday</option>
                                                <option value="Wednesday">Wednesday</option>
                                                <option value="Thursday">Thursday</option>
                                                <option value="Friday">Friday</option>
                                                <option value="Saturday">Saturday</option>
                                                <option value="Sunday">Sunday</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please Choose days.
                                            </div>
                                        </td>

                                        <td><button type="button" class="btn-success" id="addNewRow"><i
                                                    class="fa fa-plus"></i></button> </td>
                                    </tr>
                                </tbody>

                            </table>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary week_save">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Modal -->


    <!-- Edit Modal -->
    <div class="modal fade" id="edit_off_day" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Edit Week Off Day</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="{{ url('update-off-week') }}" method="POST" class="needs-validation" novalidate
                            id="update_week_off_day_form">
                            <input type="hidden" name="week_id">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Company</label>
                                    <select name="company_id1" class="form-control" required>
                                        <option value="" selected disabled>Choose Company</option>
                                    </select>
                                    <select name="emp_id" class="form-control mt-3" required>
                                        <option value="">Choose employee</option>

                                    </select>

                                    <select name="day_off" class="form-control mt-3" required>
                                        <option value="" selected disabled>Choose day</option>
                                    </select>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary week_update mt-3">Update</button>
                                    </div>
                                </div>



                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->


    <label for="">Company</label>
    <select name="company_id" class="form-control company_id" required>
        <option value="" selected disabled>Choose Company</option>
        @foreach ($company as $comp)
            <option value="{{ $comp->id }}">{{ $comp->name }}</option>
        @endforeach
    </select>

    <!-- /Page Content -->
    <script type="text/javascript">
        $(function() {
            $('#addNewRow').on('click', function() {
                var tr = $("#dvOrders").find("Table").find("TR:has(td)").clone();
                console.log(tr);
                $("#tblPurchase").append(tr);
            });
        });
    </script>

    <div id="dvOrders" style="display:none">

        <table class="table table-bordered mt-5 table-style secondtable ">
            <tr>
                <td>
                    <select name="emp_id[]" class="form-control emp_id" required>
                        <option value="">Choose employee</option>

                    </select>
                    <div class="invalid-feedback">
                        Please Choose employee.
                    </div>
                </td>
                <td>
                    <select name="day_off[]" class="form-control item-id" required>
                        <option value="" selected disabled>Choose day</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                    <div class="invalid-feedback">
                        Please Choose days.
                    </div>
                </td>
                <td style="color:red;cursor: pointer" class="delete-row" title="Remove"><i class="fa fa-trash"></i>
                </td>
            </tr>
        </table>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {


            $('#week_off_day_form').validate({

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

            toastr.options.timeOut = 4000;
            @if (Session::has('error'))
                toastr.error('{{ Session::get('error') }}');
            @elseif (Session::has('success'))
                toastr.success('{{ Session::get('success') }}');
            @endif

            // Denotes total number of rows
            var rowIdx = 0;
            // jQuery button click event to remove a row.
            $('#tblPurchase').on('click', '.delete-row', function() {

                // Getting all the rows next to the row
                // containing the clicked button
                var child = $(this).closest('tr').nextAll();

                // Iterating across all the rows
                // obtained to change the index
                child.each(function() {

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


            //get employee company base
            $('.company_id').change(function() {

                var company_id = $(this).val();

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('get-empoyee-company-base') }}',
                    data: {
                        company_id: company_id,
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        var html = '<option value="">Choose employee</option>';

                        var i;
                        if (data.length > 0) {

                            for (i = 0; i < data.length; i++) {

                                html += '<option value="' + data[i].id + '">' + data[i]
                                    .name + '</option>';
                            }
                        } else {
                            var html = '<option value="">Choose employee</option>';
                            toastr.error('data not found');
                        }


                        $('.emp_id').html(html);

                    },

                    error: function() {

                        toastr.error('db error');


                    }

                });
            });
        });


        //Edit
        $('#trainerTable').on('click', '.btn_edit_week_of', function(e) {
            e.preventDefault();

            var id = $(this).attr('data');

            $('#edit_off_day').modal('show');

            $.ajax({

                type: 'ajax',
                method: 'get',
                url: '{{ url('edit-off-week') }}',
                data: {
                    id: id
                },
                async: false,
                dataType: 'json',
                success: function(data) {

                    $('input[name=week_id]').val(data.emp_week.id);

                    $.each(data.employee, function(key, employee) {

                        $('select[name="emp_id"]')
                            .append(
                                `<option value="${employee.id}" ${employee.id == data.emp_week.emp_id ? 'selected' : ''}>${employee.name}</option>`
                            );
                    });

                    $.each(data.company, function(key, company) {

                        $('select[name="company_id1"]')
                            .append(
                                `<option value="${company.id}" ${company.id == data.emp_week.company_id ? 'selected' : ''}>${company.name}</option>`
                            );
                    });

                    $('select[name="day_off"]')
                        .append(
                            `<option value="Monday" ${'Monday' == data.emp_week.day_off ? 'selected' : ''}>Monday</option>`,
                            `<option value="Tuesday" ${'Tuesday' == data.emp_week.day_off ? 'selected' : ''}>Tuesday</option>`,
                            `<option value="Wednesday" ${'Wednesday' == data.emp_week.day_off ? 'selected' : ''}>Wednesday</option>`,
                            `<option value="Thursday" ${'Thursday' == data.emp_week.day_off ? 'selected' : ''}>Thursday</option>`,
                            `<option value="Friday" ${'Friday' == data.emp_week.day_off ? 'selected' : ''}>Friday</option>`,
                            `<option value="Saturday" ${'Saturday' == data.emp_week.day_off ? 'selected' : ''}>Saturday</option>`,
                            `<option value="Sunday" ${'Sunday' == data.emp_week.day_off ? 'selected' : ''}>Sunday</option>`,
                        );
                },

                error: function() {

                    toastr.error('something went wrong');

                }

            });

        });

        // Delete
        $('#trainerTable').on('click', '.btn_delete_week_of', function(e) {
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
                        url: "{{ url('delete-off-week') }}",
                        data: {
                            id: id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                        success: function(response) {

                            toastr.success(response.message);
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        }
                    });
                }
            })

        });


        $('.week_update').on('click', function() {
            $(".week_update").prop("disabled", true);
            $(".week_update").html("Updating...");
            $('#update_week_off_day_form').submit();
        });
    </script>
@endsection
