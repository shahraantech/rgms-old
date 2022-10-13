@extends('setup.master')

@section('content')
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">My Tickets</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">My Tickets</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_ticket"><i
                                class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->


            <div class="row">
                <div class="col-md-12">
                    <div class="card-group m-b-30">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">Decline Tickets</span>
                                    </div>
                                    @php
                                        $declineTickets = $data['declineTickets'] ? $data['declineTickets'] : 0;
                                        if ($data['totalTickets'] == 0) {
                                            $devidedBy = 1;
                                        } else {
                                            $devidedBy = $data['totalTickets'];
                                        }
                                        $newProgress = round(($declineTickets * 100) / $devidedBy, 2);
                                    @endphp
                                    <div>
                                        <span class="text-success">{{ $newProgress }}%</span>
                                    </div>
                                </div>
                                <h3 class="mb-3">{{ $declineTickets }}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ $newProgress }}%;" aria-valuenow="40" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">Solved Tickets</span>
                                    </div>
                                    <div>
                                        @php
                                            $completeTickets = $data['completeTickets'] ? $data['completeTickets'] : 0;
                                            $completeProgress = ($completeTickets * 100) / $devidedBy;
                                        @endphp
                                        <span class="text-success">{{ round($completeProgress, 2) }}%</span>
                                    </div>
                                </div>
                                <h3 class="mb-3">{{ $completeTickets }}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ $completeProgress }}%;" aria-valuenow="40" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">Pending Tickets</span>
                                    </div>
                                    <div>
                                        @php
                                            $pendingTickets = $data['pendingTickets'] ? $data['pendingTickets'] : 0;
                                            $pendingProgress = ($pendingTickets * 100) / $devidedBy;
                                        @endphp
                                        <span class="text-success">{{ round($pendingProgress, 2) }}%</span>
                                    </div>
                                </div>
                                <h3 class="mb-3">{{ $pendingTickets }}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ $pendingProgress }}%;" aria-valuenow="40" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">Total Tickets</span>
                                    </div>
                                    <div>
                                        <span class="text-success">{{ round($completeProgress, 2) }}%</span>
                                    </div>
                                </div>
                                <h3 class="mb-3">{{ $data['totalTickets'] ? $data['totalTickets'] : 0 }}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ $completeProgress }}%;" aria-valuenow="40" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">

                        <table class="table table-striped " id="datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ticket Id</th>
                                    <th>Ticket Subject</th>
                                    <th>Desc</th>
                                    <th>Created Date</th>
                                    <th>Priority</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>

                                </tr>
                            </thead>
                            <tbody id="ticketTable">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->


    </div>

    <!-- Add Ticket Modal -->
    <div id="add_ticket" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Ticket</h5>
                    <button type="button" class="close btn-dismiss" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="ticketForm">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Ticket Subject</label>
                                    <input class="form-control" type="text" name="subject" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Priority</label>

                                    <select class="select" name="priority" required>
                                        <option value="">Choose Priority</option>
                                        <option value="High">High</option>
                                        <option value="Low">Low</option>
                                        <option value="Medium">Medium</option>


                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="desc" required></textarea>
                                </div>


                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn btn_save_tic" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Ticket Modal -->




    <!-- Edit Ticket Modal -->
    <div id="edit_ticket_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Ticket</h5>
                    <button type="button" class="close btn-dismiss" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="EditTicketForm" class="needs-validation" novalidate>
                        <input type="hidden" name="ticket_id">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Ticket Subject</label>
                                    <input class="form-control" type="text" name="subject" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Priority</label>

                                    <select class="select" name="priority" required>
                                        <option value="">Choose Priority</option>


                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="desc" required></textarea>
                                </div>


                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn update_ticket" type="submit">Save Changes</button>
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

            $('#ticketForm').validate({

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

            getTickets();

            function getTickets() {


                $.ajax({

                    url: '{{ url('/my-ticket') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',

                    success: function(data) {

                        var html = '';
                        var i;
                        var c = 0;
                        var status_class = '';

                        for (i = 0; i < data.length; i++) {
                            (data[i].status == 'COMPLETE') ? status_class = 'bg-success': status_class =
                                'bg-danger';
                            c++;
                            html += '<tr>' +
                                '<td>' + c + '</td>' +
                                '<td>#TKT-' + data[i].id + '</td>' +
                                '<td>' + data[i].subject + '</td>' +
                                '<td>' + data[i].desc + '</td>' +
                                '<td>' + data[i].created_at + '</td>' +
                                '<td>' + data[i].periorty + '</td>' +
                                '<td><span class="badge ' + status_class + '" style="color:white"> ' +
                                data[i].status + ' </span></td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a href="#" class="dropdown-item btn_edit_ticket" data="' + data[i]
                                .id +
                                '" id="btn_edit_clients"><i class="la la-pencil" style="font-size: 20px;"></i></a>' +
                                '<a href="" class="dropdown-item btn_delete_ticket" data="' + data[i]
                                .id +
                                '" id="btn_delete_clients"><i class="la la-trash" style="font-size: 20px;"></i></a>' +
                                '</tr>';
                        }


                        $('#ticketTable').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }

            //ajax call for save Record..
            $('#ticketForm').on('submit', function(e) {
                e.preventDefault();

                var $form = $(this);
                // check if the input is valid
                if (!$form.validate().form()) return false;

                let formData = new FormData($('#ticketForm')[0]);


                $.ajax({
                    type: "POST",
                    url: '{{ url('save-ticket') }}',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.btn_save_tic').text('Saving...');
                        $(".btn_save_tic").prop("disabled", true);
                    },
                    success: function(data) {
                        if (data.errors) {
                            toastr.error('missing some fields');
                            $('.btn_save_tic').text('Save');
                            $(".btn_save_tic").prop("disabled", false);
                        }

                        if (data.success) {
                            getTickets();
                            $('#ticketForm')[0].reset();
                            $('.btn-dismiss').click();
                            toastr.success('Record save successfully');
                            $('.btn_save_tic').text('Save');
                            $(".btn_save_tic").prop("disabled", false);
                        }

                    },

                    error: function() {
                        toastr.error('something went wrong');
                        $('.btn_save_tic').text('Save');
                        $(".btn_save_tic").prop("disabled", false);
                    }

                });



            });

            //edit data
            $('#ticketTable').on('click', '.btn_edit_ticket', function() {

                $('select[name="priority"]').empty();

                var id = $(this).attr('data');

                $('#edit_ticket_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('edit-ticket') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('input[name=ticket_id]').val(data.id);
                        $('input[name=subject]').val(data.subject);

                        $('select[name="priority"]')
                            .append(
                                `<option value="HIGH" ${'HIGH' == data.periorty ? 'selected' : ''}>HIGH</option>` +
                                `<option value="LOW" ${'LOW' == data.periorty ? 'selected' : ''}>LOW</option>` +
                                `<option value="MEDIUM" ${'MEDIUM' == data.periorty ? 'selected' : ''}>MEDIUM</option>`
                            );

                        $('textarea[name=desc]').val(data.desc);



                    },

                    error: function() {

                        toastr.error('something went wrong');
                    }
                });

            });


            //update data
            $('.update_ticket').on('click', function(e) {
                e.preventDefault();
                $('.update_ticket').text('Saving...');

                let EditFormData = new FormData($('#EditTicketForm')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('/update-ticket') }}",
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(response) {

                        if (response.status == 200) {
                            $("#edit_ticket_modal").modal('hide');
                            $('#EditTicketForm').find('input').val("");
                            $('.update_ticket').text('Save Changes');
                            toastr.success(response.message);
                            getTickets();
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.update_ticket').text('Save Changes');
                    }
                });

            });

            // script for delete data
            $('#ticketTable').on('click', '.btn_delete_ticket', function(e) {
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
                            url: "{{ url('/delete-ticket/') }}/" + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {

                                toastr.success(response.message);

                                getTickets();
                            }
                        });
                    }
                })

            });

            //btnEditDept
            $('.btn-edit').on('click', function() {
                var id = $(this).attr('data');


                $.ajax({

                    url: '{{ url('/edit-grade') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(data) {

                        $('input[name=grade]').val(data.grade);
                        $('input[name=grade_cat]').val(data.grade_cat);
                        $('input[name=hidden_grade_id]').val(data.id);

                    },
                    error: function() {
                        toastr.success('Save changes successfully');
                    }

                });

            });

            //btnUpdateDept
            $('.btn-update').on('click', function() {
                var formData = $('#gradeEditForm').serialize();


                $.ajax({

                    url: '{{ url('/update-grade') }}',
                    type: 'post',
                    async: false,
                    dataType: 'json',
                    data: formData,
                    success: function(data) {

                        if (data.errors) {
                            toastr.error('missing some fileds');
                        }

                        if (data.success) {
                            getGrades();
                            $('#btnDissmissEdit').click();


                            toastr.success('Save changes successfully');
                        }

                    },
                    error: function() {
                        toastr.error('Something went wrong');
                    }

                });

            });

            //btnEditDelete
            $('.btnDelete').on('click', function() {
                var id = $(this).attr('data');

                $('.btnDeleteNow').on('click', function() {

                    $.ajax({

                        url: '{{ url('/delete-grade') }}',
                        type: 'get',
                        async: false,
                        dataType: 'json',
                        data: {
                            id: id
                        },
                        success: function(data) {

                            if (data.success) {
                                getGrades();
                                $('.btnSkip').click();
                                toastr.success('Record deleted successfully');
                            }

                        },
                        error: function() {
                            toastr.error('something went wrong');
                        }

                    });
                });

            });

            //Datatables
            $('#datatable').DataTable();
        });
    </script>
@endsection
