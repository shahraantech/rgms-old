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




    <div class="main-wrapper">
        <!-- /Sidebar -->
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <div class="page-header my-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title bold-heading">{{ $data['view'] }} Targets</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">{{ $data['view'] }} Targets</li>
                            </ul>
                        </div>

                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped mb-0 target-table" id="datatable">
                            <thead>
                                <tr>
                                    <th style="width: 30px;">#</th>
                                    <th>Team Member</th>
                                    <th>Target</th>
                                    <th>Number</th>
                                    <th>From </th>
                                    <th>To </th>
                                    <th>Progress </th>
                                    <th>Created At</th>
                                    <th>Action </th>

                                </tr>
                            </thead>


                            <tbody>
                                @php $c=0; @endphp
                                @isset($data['teamTarget'])
                                    @foreach ($data['teamTarget'] as $target)
                                        @php $c++; @endphp
                                        <tr>
                                            <td>{{ $c }}</td>
                                            <td>{{ $target->name }}</td>
                                            <td>{{ $target->target_in_numbers }} {{ strtoupper($target->target_type) }}'s
                                            </td>
                                            <td>{{ $target->target_in_numbers }}</td>
                                            <td>{{ $target->from }}</td>
                                            <td>{{ $target->to }}</td>
                                            <td>0%</td>
                                            <td>{{ $target->created_at }}</td>

                                            <td>
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                        aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a title="Edit" href="#"
                                                            class="dropdown-item bg-inverse-primary btn_edit_tar" data="{{ $target->id }}">Edit</a>
                                                            <a title="Edit" href="#"
                                                            class="dropdown-item bg-inverse-primary btn_delete_tar" data="{{ $target->id }}">Delete</a>
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
            </div>
            <!-- /Page Content -->
        </div>
    </div>


    {{-- Edit Target Start --}}
    <div id="edit_target_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Team Target</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="editTeamTargetForm" class="needs-validation" novalidate>
                        <input type="hidden" name="team_target_id">
                        {{-- @csrf --}}

                        <div class="row">
                            <div class="form-group col-sm-12">
                                <input class="form-control" type="number" name="target_number" placeholder="Number of Sale or Meetings">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label>From <span class="text-danger">*</span></label>
                                <div class="cal-">
                                    <input type="date" class="form-control" name="from_date" required>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>To <span class="text-danger">*</span></label>
                                <div class="cal-">
                                    <input type="date" class="form-control" name="to_date" required>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn update-team-target" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Edit Target End --}}



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            //Edit Team Target
            $('.target-table').on('click', '.btn_edit_tar', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                $('#edit_target_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('edit-team-target') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('input[name=team_target_id]').val(data.team_target.id);
                        $('input[name=target_number]').val(data.team_target.target_in_numbers);
                        $('input[name=from_date]').val(data.team_target.from);
                        $('input[name=to_date]').val(data.team_target.to);
                        },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });

             //Update Team Target
             $('.update-team-target').on('click', function(e) {
                e.preventDefault();

                let EditFormData = new FormData($('#editTeamTargetForm')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('update-team-target') }}",
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('.update-team-target').text('Updating...');
                        $(".update-team-target").prop("disabled", true);
                    },
                    success: function(response) {

                        if (response.status == 200) {
                            $('#edit_target_modal').modal('hide');
                            $('#editTeamTargetForm').find('input').val("");
                            $('.update-team-target').text('Update');
                            $(".update-team-target").prop("disabled", false);
                            toastr.success(response.message);
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.update-team-target').text('Update');
                        $(".update-team-target").prop("disabled", false);
                    }
                });

            });

            // Delete Level 3
            $('.target-table').on('click', '.btn_delete_tar', function(e) {
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
                            url: "{{ url('delete-team-target') }}",
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
