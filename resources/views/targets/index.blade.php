@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <style>
            /* Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            /* Firefox */
            input[type=number] {
                -moz-appearance: textfield;
            }

            /* .target-img{
                width: 35px;
                height: 35px;
                border-radius: 50%;
                } */
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Targets</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Targets</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_leave"
                            title="Add New Target"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 target-table" id="datatable">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px;">#</th>
                                            <th>Name</th>
                                            <th></th>
                                            <th>Target</th>
                                            <th>From </th>
                                            <th>To </th>
                                            <th>Action </th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        @php $c=0; @endphp
                                        @isset($data['targets'])
                                            @foreach ($data['targets'] as $target)
                                                @php $c++; @endphp
                                                <tr>

                                                    <td>{{ $c }}</td>
                                                    <td>
                                                        @php($target->agent_id)?$account_id=$target->agent_id:$account_id=$target->manager_id;
                                                        ($target->agent_id)
                                                        ?$type='Source':$type='Manager';
                                                        $emp = App\Models\Employee::find($account_id);

                                                        if ($emp) {
                                                        echo '<span class="badge bg-inverse-success">' . $emp->name. '</span>';
                                                        }

                                                        @endphp
                                                    </td>
                                                    <td>{{ $type }}</td>
                                                    <td>{{ $target->target_in_numbers }}
                                                        {{ strtoupper($target->target_type) }}'s</td>
                                                    <td>{{ $target->from }}</td>
                                                    <td>{{ $target->to }}</td>
                                                    <td class="text-right">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false"><i
                                                                    class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a href="#" class="dropdown-item btn_edit_target"
                                                                    data="{{ $target->id }}"><i class="la la-pencil"
                                                                        style="font-size: 20px;"></i></a>
                                                                <a href="#" class="dropdown-item btn_delete_target"
                                                                    data="{{ $target->id }}"><i class="la la-trash"
                                                                        style="font-size: 20px;"></i></a>
                                                    </td>
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
        </div>



        <!-- /Page Content -->
        <div id="add_leave" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Target</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="targetForm" action="{{ url('targets') }}" class="needs-validation"
                            novalidate>
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <select name="to_allocate" class="form-control selectpicker" data-container="body"
                                        data-live-search="true">
                                        <option value="">Choose One</option>
                                        <option value="1">Manager</option>
                                        <option value="2">Source</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6 manager_section" style="display: none">
                                    <select name="manager_id" class="form-control selectpicker" data-container="body"
                                        data-live-search="true">
                                        <option value="">Choose Manager</option>
                                        @isset($data)
                                            @foreach ($data['manager'] as $manager)
                                                <option value="{{ $manager->leader_id }}">{{ $manager->name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                    <div class="invalid-feedback">
                                        Please choose agent.
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 csr_section" style="display: none">
                                    <select name="agent_id" class="form-control selectpicker" data-container="body"
                                        data-live-search="true">
                                        <option value="">Choose Agent</option>
                                        @isset($data)
                                            @foreach ($data['employee'] as $emp)
                                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                    <div class="invalid-feedback">
                                        Please choose agent.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <select name="target_type" class="form-control ">
                                        <option value="">Target Type</option>
                                        <option value="sale">Sale</option>
                                        <option value="meeting">Meetings</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <input class="form-control" type="number" name="target_number"
                                        placeholder="Number of Sale or Meetings">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label>From <span class="text-danger">*</span></label>
                                    <div class="cal-">
                                        <input type="date" class="form-control" name="from_date" required>
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>To <span class="text-danger">*</span></label>
                                    <div class="cal-">
                                        <input type="date" class="form-control" name="to_date" required>
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Duration <span class="text-danger">*</span></label>
                                    <div class="cal-">
                                        <input type="text" class="form-control" name="duration" readonly required>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn" type="submit" id="btnSubmit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        {{-- Edit Target Start --}}
        <div id="edit_target_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Target</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" id="editTargetForm" class="needs-validation" novalidate>
                            <input type="hidden" name="target_id">
                            {{-- @csrf --}}

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <select name="target_type" class="form-control">
                                        <option value="" selected disabled>Target Type</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <input class="form-control" type="number" name="target_number"
                                        placeholder="Number of Sale or Meetings">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>From <span class="text-danger">*</span></label>
                                    <div class="cal-">
                                        <input type="date" class="form-control" name="from_date" required>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>To <span class="text-danger">*</span></label>
                                    <div class="cal-">
                                        <input type="date" class="form-control" name="to_date" required>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn update-target" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Edit Target End --}}




    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type='text/javascript'>
        $(document).ready(function() {


            $('input[name=to_date]').change(function() {

                var fromDate = $('input[name=from_date]').val();
                var toDate = $('input[name=to_date]').val();
                //var Difference_In_Time = toDate.getTime() - fromDate.getTime();

                var date1 = new Date(fromDate);
                var date2 = new Date(toDate);
                var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24), 10);

                if (diffDays < 1) {
                    $('input[name=duration]').val(diffDays + ' ' + 'Days');
                    $('#btnSubmit').prop('disabled', true);
                } else {
                    $('input[name=duration]').val(diffDays + ' ' + 'Days');
                    $('#btnSubmit').prop('disabled', false);
                }

            });

            //company_id dependent dropdown for all employees
            $('select[name=to_allocate]').change(function() {
                var to_allocate = $('select[name=to_allocate]').val();

                if (to_allocate == 1) {

                    $(".manager_section").css("display", "block");
                    $(".csr_section").css("display", "none");
                } else {
                    $(".manager_section").css("display", "none");
                    $(".csr_section").css("display", "block");
                }

            });



            $('#targetForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData($('#targetForm')[0]);

                $.ajax({
                    type: "POST",
                    url: '{{ url('targets') }}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            $('#targetForm')[0].reset();
                            toastr.success(data.success);
                            window.location.reload();
                        }
                    },

                    error: function() {
                        toastr.error('something went wrong');
                    }
                });
            });

            //Edit Target
            $('.target-table').on('click', '.btn_edit_target', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                $('#edit_target_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('edit-targets') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('input[name=target_id]').val(data.target.id);
                        $('input[name=target_number]').val(data.target.target_in_numbers);
                        $('input[name=from_date]').val(data.target.from);
                        $('input[name=to_date]').val(data.target.to);

                        $.each(data, function(key, target) {

                            $('select[name="target_type"]')
                                .append(
                                    `<option value="sale" ${data.target.target_type == 'sale' ? 'selected' : ''}>Sale</option>`,
                                    `<option value="meeting" ${data.target.target_type == 'meeting' ? 'selected' : ''}>Meeting</option>`,
                                )
                        });
                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });

            //Update Target
            $('.update-target').on('click', function(e) {
                e.preventDefault();

                let EditFormData = new FormData($('#editTargetForm')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('update-targets') }}",
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('.update-target').text('Updating...');
                        $(".update-target").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            $('#edit_target_modal').modal('hide');
                            $('#editTargetForm').find('input').val("");
                            $('.update-target').text('Update');
                            $(".update-target").prop("disabled", false);
                            toastr.success(response.message);
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.update-target').text('Update');
                        $(".update-target").prop("disabled", false);
                    }
                });

            });


            // Delete Level 3
            $('.target-table').on('click', '.btn_delete_target', function(e) {
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
                            url: "{{ url('delete-targets') }}",
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
                                }, 1000);
                            }
                        });
                    }
                })

            });

        });
    </script>
@endsection
