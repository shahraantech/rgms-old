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
    </style>

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->


        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Trainings</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Trainings</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_leave" title="Add New "><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->


        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive ">


                            <table class="table table-striped table-responsive mb-0" id="datatable">
                                <thead>
                                    <tr>
                                        <th style="width: 30px;">#</th>
                                        <th>Training Type</th>
                                        <th>Trainer</th>
                                        <th>Employee</th>
                                        <th>Time Duration</th>
                                        <th>Description </th>
                                        <th>Cost </th>
                                        <th>Status </th>
                                        <th>Action </th>
                                    </tr>
                                </thead>
                                <tbody id="trainingTable">

                                    @php $c=0; @endphp
                                    @isset($data['training'])
                                    @foreach($data['training'] as $train)
                                    @php $c++; @endphp
                                    <tr>
                                        <td>{{$c}}</td>
                                        <td>{{$train->training_type}}</td>

                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="#">
                                                    <img alt="" class="target-img" src="{{asset('storage/app/public/uploads/staff-images/user1-128x128.png')}}"></a>
                                                <a href="#">{{$train->trainer}} </a>
                                            </h2>
                                        </td>

                                        <td>
                                            <ul class="team-members">
                                                @php
                                                $res=App\Models\Training::join('employees', 'employees.id','=','trainings.emp_id')
                                                ->select('employees.name','employees.image')
                                                ->where([['trainings.training_type',$train->training_type],['trainings.from',$train->from],['trainings.to',$train->to]])
                                                ->get();

                                                @endphp
                                                <li>
                                                    <a href="#" title="{{$train->name}}" data-toggle="tooltip">
                                                        <img alt="" class="target-img" src="{{asset('storage/app/public/uploads/staff-images/').'/'.$train->image}}">
                                                    </a>
                                                </li>

                                                @if($res->count() >1)

                                                <li class="dropdown avatar-dropdown">
                                                    <a href="#" class="all-users dropdown-toggle" data-toggle="dropdown" aria-expanded="false">+ {{$res->count()}}</a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <div class="avatar-group">

                                                            @foreach($res as $row)
                                                            <a class="avatar avatar-xs" href="#">
                                                                <img alt="" src="{{asset('storage/app/public/uploads/staff-images/').'/'.$row->image}}" title="{{$row->name}}">
                                                            </a>
                                                            @endforeach
                                                        </div>
                                                        <div class="avatar-pagination">
                                                            <ul class="pagination">
                                                                <li class="page-item">
                                                                    <a class="page-link" href="#" aria-label="Previous">
                                                                        <span aria-hidden="true">«</span>
                                                                        <span class="sr-only">Previous</span>
                                                                    </a>
                                                                </li>
                                                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                                <li class="page-item">
                                                                    <a class="page-link" href="#" aria-label="Next">
                                                                        <span aria-hidden="true">»</span>
                                                                        <span class="sr-only">Next</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>

                                                @endif
                                            </ul>
                                        </td>
                                        <td>{{ date("d M Y", strtotime($train->from))}} - {{ date("d M Y", strtotime($train->to))}}</td>
                                        <td>{{$train->desc}}</td>
                                        <td>{{$train->cost}}</td>


                                        <td>
                                            <div class="dropdown action-label">
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-dot-circle-o text-success"></i> {{$train->status}}
                                                </a>

                                            </div>
                                        </td>

                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item btn_edit_training" data="{{ $train->id }}" id="btn_edit_clients"><i class="fa fa-pencil m-r-5n "></i> Edit</a>
                                                    <a href="#" class="dropdown-item btn_delete_training" data="{{ $train->id }}" id="btn_delete_clients"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>

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
                    <h5 class="modal-title">Add New Trainings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <form method="post" action="{{url('trainings')}}" id="trainingForm" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Training Type</label>
                                    <select class="select" name="training_type" required>
                                        <option value="Skill Improvement">Skill Improvement</option>
                                        <option value="Resource learning and development">Resource learning and development</option>
                                        <option value="Professional Growth">Professional Growth</option>
                                        <option value="Achieve target goals">Achieve target goals</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Trainer</label>


                                    <select class="select" name="trainer_name" required>

                                        <option value="">Choose Trainer</option>
                                        @isset($data['trainer'])
                                        @foreach($data['trainer'] as $trainer)
                                        <option value="{{$trainer->id}}">{{$trainer->f_name}}</option>
                                        @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Employees</label>

                                    <select class="select" name="emp_id" required>

                                        <option value="">Choose Employee</option>
                                        @isset($data['employee'])
                                        @foreach($data['employee'] as $emp)
                                        <option value="{{$emp->id}}">{{$emp->name}}</option>
                                        @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Training Cost <span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" placeholder="Training Cost" name="cost" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Start Date <span class="text-danger">*</span></label>
                                    <div class=""><input class="form-control " name="from" type="date" required></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>End Date <span class="text-danger">*</span></label>
                                    <div class=""><input class="form-control " name="to" type="date" required></div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="4" name="desc" required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Status</label>
                                    <select class="select" name="status" required>
                                        <option value="Active" selected>Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <center>
                            <img id="loader" class="center" height="60px" width="90px" src=public/assets/img/loader/loader.gif style="display: none" />
                        </center>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn" type="submit" id="btnSubmit">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



    <!--Edit Training Modal -->
    <div id="edit_training_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Trainings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <form method="POST" action="" id="EditTrainingForm" class="needs-validation" novalidate>
                        <input type="hidden" name="training_id">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Training Type</label>
                                    <select class="select" name="training_type" required>
                                        <option value="0" selected disabled>Choose option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Trainer</label>
                                    <select class="select" name="trainer_name" required>
                                        <option value="">Choose Trainer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Employees</label>
                                    <select class="select" name="emp_id" required>
                                        <option value="">Choose Employee</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Training Cost <span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" placeholder="Training Cost" name="cost" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Start Date <span class="text-danger">*</span></label>
                                    <div class=""><input class="form-control " name="from" type="date" required></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>End Date <span class="text-danger">*</span></label>
                                    <div class=""><input class="form-control " name="to" type="date" required></div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="4" name="desc" required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Status</label>
                                    <select class="select" name="status" required>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <center>
                            <img id="loader" class="center" height="60px" width="90px" src=public/assets/img/loader/loader.gif style="display: none" />
                        </center>
                        <div class="submit-section">
                            <button class="btn btn-primary btn-update" type="button">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!--Edit Training Modal -->






</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- CDN for Sweet Alert -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type='text/javascript'>
    $(document).ready(function() {


        $('#trainingForm').unbind().on('submit', function(e) {
            e.preventDefault();
            $("#btnSubmit").attr("disabled", true);
            $('#btnSubmit').text('Saving...');

            var formData = $('#trainingForm').serialize();

            $.ajax({

                type: 'ajax',
                method: 'post',
                url: '{{url("trainings")}}',
                data: formData,
                async: false,
                dataType: 'json',
                success: function(data) {


                    if (data.success) {

                        $('#trainingForm')[0].reset();
                        $('.close').click();
                        toastr.success('Record save successfully');
                        window.location.reload();
                        $('#btnSubmit').text('Save');
                    }


                },

                error: function() {
                    toastr.error('something went wrong');
                    $('#btnSubmit').text('Save');
                },
                complete: function() {
                    $("#btnSubmit").attr("disabled", false);
                    $('#btnSubmit').text('Save');
                },

            });


        });


        //Edit Data with ajax call
        $('#trainingTable').on('click', '.btn_edit_training', function(e) {
            e.preventDefault();


            var id = $(this).attr('data');
            $('#edit_training_modal').modal('show');

            $.ajax({

                type: 'ajax',
                method: 'get',
                url: '{{url("edit-trainings")}}',
                data: {
                    id: id
                },
                async: false,
                dataType: 'json',
                success: function(data) {

                    $('input[name=training_id]').val(data.training.id);
                    $('select[name="training_type"]')
                        .append(`<option value="Skill Improvement" ${'Skill Improvement' == data['training'].training_type ? 'selected' : ''}>Skill Improvement</option>` +
                            `<option value="Resource learning and development" ${'Resource learning and development' == data['training'].training_type ? 'selected' : ''}>Resource learning and development</option>` +
                            `<option value="Professional Growth" ${'Professional Growth' == data['training'].training_type ? 'selected' : ''}>Professional Growth</option>` +
                            `<option value="Achieve target goals" ${'Achieve target goals' == data['training'].training_type ? 'selected' : ''}>Achieve target goals</option>`
                        );

                    //select dropdown in edit modal
                    $.each(data.tran, function(key, value) {
                        $('select[name="trainer_name"]')
                            .append(`<option value="${value.id}" ${value.id == data['training'].trainer ? 'selected' : ''}>${value.f_name}</option>`)

                    });
                    //select dropdown in edit modal
                    $.each(data.employee, function(key, emp) {
                        $('select[name="emp_id"]')
                            .append(`<option value="${emp.id}" ${emp.id == data['training'].emp_id ? 'selected' : ''}>${emp.name}</option>`)

                    });
                    $('input[name=cost]').val(data['training'].cost);
                    $('input[name=from]').val(data['training'].from);
                    $('input[name=to]').val(data['training'].to);
                    $('textarea[name=desc]').val(data['training'].desc);
                    $('select[name="status"]')
                        .append(`<option value="Active" ${'Active' == data['training'].status ? 'selected' : ''}>Active</option>` +
                            `<option value="Inactive" ${'Inactive' == data['training'].status ? 'selected' : ''}>Inactive</option>`
                        );
                },

                error: function() {

                    toastr.error('something went wrong');

                }

            });

        });



        // script for delete data
        $('#trainingTable').on('click', '.btn_delete_training', function(e) {
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
                        url: "{{ url('/delete-trainings/') }}/" + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                        success: function(response) {
                            toastr.success(response.message);
                            setTimeout(function() {
                                window.location.reload(1);
                            }, 1000);
                        }
                    });
                }
            })

        });

        $('.btn-update').on('click', function() {

            $('.btn-update').text('Updating...');
            var formData = $('#EditTrainingForm').serialize();


            $.ajax({

                type: 'ajax',
                method: 'get',
                url: '{{url("update-trainings")}}',
                data: formData,
                async: false,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {

                        $('#EditTrainingForm').find('input').val("");
                        $('.btn-update').text('Update');
                        toastr.success(data.success);
                        $("#edit_training_modal").modal('hide');
                        window.location.reload();

                    }
                },

                error: function() {
                    toastr.error('something went wrong');

                }

            });

        });


        //Datatables
        $('#datatable').DataTable();
    });
</script>
@endsection
