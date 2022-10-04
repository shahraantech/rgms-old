@extends('setup.master')

@section('content')


<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->


        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Edit Targets</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Targets</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{url('targets')}}" class="btn add-btn"><i class="fa fa-plus"></i> Back</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->




        <div class="row">
            <div class="col-md-12">
                <form method="POST" id="targetForm" action="{{url('update-targets/'.$target->id)}}" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <select class="form-control selectpicker" data-container="body" data-live-search="true" name="dept_id" id="deptId" required>
                                <option value="">Choose Dept</option>

                                @foreach($depart as $dept)
                                <option value="{{$dept->id}}">{{$dept->departments}}</option>
                                @endforeach

                            </select>
                        </div>


                        <div class="form-group col-sm-4">
                            <select class="select" id="showDesig" name="designation" required>
                                <option value="">Choose Designation</option>
                            </select>
                            <div id="desigError"></div>
                        </div>



                        <div class="form-group col-sm-4">


                            <div class="form-group form-focus select-focus">
                                <select class="select floating emp_id" id="showEmployee" name="emp_id" required>
                                    <option value="">Select Employee</option>
                                </select>
                                <div id="empError"></div>
                            </div>

                        </div>
                    </div>

                    <div class="row">


                        <div class="form-group col-sm-12">
                            <label>Task <span class="text-danger">*</span></label>

                            <textarea name="task" cols="10" rows="3" class="form-control" required>{{ $target->task }}</textarea>
                        </div>


                        <div class="form-group col-sm-12">
                            <label>Amount <span class="">(optional)</span></label>
                            <input class="form-control" type="number" name="amount" value="{{ $target->target_amount }}" placeholder="Target Amount">
                        </div>
                    </div>



                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label>From <span class="text-danger">*</span></label>
                            <div class="cal-">
                                <input type="date" class="form-control" value="{{ $target->from }}" name="from" required>
                            </div>
                        </div>

                        <div class="form-group col-sm-4">
                            <label>To <span class="text-danger">*</span></label>
                            <div class="cal-">
                                <input type="date" class="form-control" value="{{ $target->to }}" name="to" required>
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
                        <button class="btn btn-primary submit-btn" type="submit" id="btnSubmit">Update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- /Page Content -->



</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type='text/javascript'>
    $(document).ready(function() {

        getTargetList();


        $('input[name=to]').change(function() {

            var fromDate = $('input[name=from]').val();
            var toDate = $('input[name=to]').val();
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


        $('#deptId').change(function() {
            var dept_id = $('select[name=dept_id]').val();

            $.ajax({

                type: 'ajax',

                method: 'get',

                url: '{{url("/getDesignations")}}',

                data: {
                    dept_id: dept_id
                },

                async: false,

                dataType: 'json',

                success: function(data) {

                    var html = '<option>Choose Designation</option>';

                    var i;
                    if (data.length > 0) {

                        for (i = 0; i < data.length; i++) {

                            html += '<option value="' + data[i].id + '">' + data[i].desig_name + '</option>';

                        }
                    } else {
                        var html = '<option value="">Choose Designation</option>';
                        toastr.error('data not found');
                    }


                    $('#showDesig').html(html);

                },

                error: function() {

                    alert('Could not get Data from Database');

                }

            });
        });



        $('#showDesig').change(function() {
            var desig_id = $('select[name=designation]').val();

            $.ajax({

                type: 'ajax',

                method: 'get',

                url: '{{url("/getEmployeeBaseDesignation")}}',

                data: {
                    desig_id: desig_id
                },

                async: false,

                dataType: 'json',

                success: function(data) {

                    var html = '';

                    var i;
                    if (data.length > 0) {

                        for (i = 0; i < data.length; i++) {

                            html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';

                        }
                    } else {
                        var html = '<option value="">Choose Employee</option>';
                        toastr.error('data not found');
                    }


                    $('#showEmployee').html(html);

                },

                error: function() {

                    alert('Could not get Data from Database');

                }

            });
        });


        function getTargetList() {


            $.ajax({

                url: '{{url("/targetList")}}',
                type: 'get',
                async: false,
                dataType: 'json',

                success: function(data) {

                    var html = '';
                    var i;
                    var c = 0;
                    var amount = '-';
                    var progress = 0;



                    for (i = 0; i < data.length; i++) {


                        if (data[i].target_amount > 0) {
                            amount = data[i].target_amount;

                            if (data[i].achievementsAmount) {
                                progress = (data[i].achievementsAmount * 100) / data[i].target_amount;

                            } else {
                                var progress = 0;
                            }

                        } else {
                            amount = '-';
                        }

                        if (data[i].status == 'COMPLETE') {
                            progress = 100;

                        }
                        c++;

                        html += '<tr>' +
                            '<td>' + c + '</td>' +
                            ' <td>' +
                            ' <h2 class="table-avatar">' +
                            '  <a href="profile.html" class="avatar"><img alt="" src="storage/app/public/uploads/staff-images/' + data[i].image + '"></a>' +
                            '   <a href="#">' + data[i].name + ' <span>' + data[i].desig_name + '</span></a>' +
                            ' </h2>' +
                            ' </td>' +
                            ' <td>' + data[i].task + '</td>' +
                            ' <td>' + amount + '</td>' +
                            ' <td>' + data[i].from + ' </td>' +
                            ' <td>' + data[i].to + '</td>' +
                            ' <td>' +
                            ' <div class=" action-label">' +
                            '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">' +
                            '  <i class="fa fa-dot-circle-o text-success"></i> ' + data[i].status + '  </a>' +

                            ' </div>' +
                            ' </td>' +
                            '<td><p class="mb-1"> ' + progress + '%</p><div class="progress" style="height:5px">' +
                            '<div class="progress-bar bg-success progress-sm" style="width: ' + progress + '%;height:10px;"></div></div></td>' +
                            '<td class="text-right">' +
                            '<div class="dropdown dropdown-action">' +
                            '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a href="#" class="dropdown-item btn_edit_target" data="' + data[i].id + '" id="btn_edit_clients"><i class="fa fa-pencil m-r-5n "></i> Edit</a>' +
                            '<a href="#" class="dropdown-item btn_delete_target" data="' + data[i].id + '" id="btn_delete_clients"><i class="fa fa-trash-o m-r-5 "></i> Delete</a>' +

                            '</tr>' +
                            '</tr>';
                    }


                    $('#targetTable').html(html);

                },
                error: function() {
                    toastr.error('something went wrong');
                }

            });
        }


        //Edit target
        $('#targetTable').on('click', '.btn_edit_target', function(e) {
            e.preventDefault();

            var id = $(this).attr('data');

            $('#edit_target_form').modal('show');

            $.ajax({

                type: 'ajax',
                method: 'get',
                url: '{{url("edit-target")}}',
                data: {
                    id: id
                },
                async: false,
                dataType: 'json',
                success: function(data) {

                    $('input[name=target_id]').val(data.id);
                    $('select[name=designation]').val(data.trainer);
                    $('select[name=emp_id]').val(data.emp_id);
                    $('textarea[name=task]').val(data.task);
                    $('input[name=amount]').val(data.target_amount);
                    $('input[name=from]').val(data.from);
                    $('input[name=to]').val(data.to);
                    $('input[name=duration]').val(data.status);
                },

                error: function() {

                    toastr.error('something went wrong');

                }

            });

        });


    });
</script>


@endsection