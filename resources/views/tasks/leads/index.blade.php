@extends('setup.master')

@section('content')


<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Team Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Team</li>
                    </ul>
                </div>

                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#create_project"><i class="fa fa-plus"></i> Create Team</a>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped mb-0" id="datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Manager</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Team Members</th>

                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php $i=0; @endphp
                            @isset($data)
                            @foreach($data['leads'] as $lead)
                            @php $i++; @endphp
                            <tr>
                                <td>{{ $i;}}</td>


                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#">
                                            <img alt="" class="target-img" src="{{asset('storage/app/public/uploads/staff-images/').'/'.$lead->image}}"></a>
                                        <a>{{$lead->name}}</a>
                                    </h2>
                                </td>
                                <td>{{$lead->email}}</td>
                                <td>{{$lead->contact}}</td>

                                <td>
                                    <ul class="team-members">
                                        <?php
                                        $member_ids = (explode(",", $lead->member_id));
                                        $c = 0;
                                        foreach ($member_ids as $k => $val) {
                                            $c++;
                                            $empData = App\Models\Employee::find($val);
                                        }


                                        ?>

                                            @if($empData)

                                        <li>

                                            <a href="#" title="{{$empData->name}}" data-toggle="tooltip">
                                                <img class="target-img" alt="" src="{{asset('storage/app/public/uploads/staff-images/').'/'.$empData->image}}"></a>

                                        </li>

                                        <li class="dropdown avatar-dropdown">
                                            <a href="#" class="all-users dropdown-toggle" data-toggle="dropdown" aria-expanded="false">+{{$c}}</a>
                                            <div class="dropdown-menu dropdown-menu-right">

                                                <div class="avatar-group">
                                                    @foreach($member_ids as $k=>$val)

                                                    @php $empData=App\Models\Employee::find($val); @endphp
                                                    <a class="avatar avatar-xs" href="#">
                                                        <img class="target-img" title="{{$empData->name}}" alt="" src="{{asset('storage/app/public/uploads/staff-images/').'/'.$empData->image}}">
                                                    </a>

                                                    @endforeach
                                                </div>

                                            </div>
                                        </li>

                                            @endif
                                    </ul>
                                </td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right"><a href="{{ url('edit-leeds/'.$lead->id) }}" class="dropdown-item btn_edit_trainer" data="1" id="btn_edit_clients">
                                                <i class="fa fa-pencil m-r-5n "></i> Edit</a>
{{--                                            <a href="" class="dropdown-item btn_delete_trainer" data="1" id="btn_delete_clients">--}}
{{--                                                <i class="fa fa-trash-o m-r-5 "></i> Delete</a></div>--}}
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
    </div>
    <!-- /Page Content -->

</div>


<div id="create_project" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Leads</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{url('leads')}}" class="needs-validation" id="leadsForm">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Add Project Manager</label>
                                <select class="select select2" name="manager_id" required>
                                    <option value="">Choose Manager</option>
                                    @isset($data)
                                    @foreach($data['employee'] as $emp)
                                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                                    @endforeach
                                    @endisset

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Team Member</label>

                                <select class="form-control form-control-sm select2" multiple="multiple" name="team_id[]" required>
                                    <option></option>

                                    @isset($data)
                                    @foreach($data['employee'] as $emp)
                                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                                    @endforeach
                                    @endisset


                                </select>

                            </div>
                        </div>
                    </div>


                    <div class="submit-section">
                        <button class="btn btn-primary " type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {

        $('.select2').select2({
            placeholder: "Please select here",
            width: "100%"
        });



        $('#leadsForm').unbind().on('submit', function(e) {
            e.preventDefault();

            var formData = $('#leadsForm').serialize();


            $.ajax({

                type: 'ajax',
                method: 'post',
                url: '{{url("team")}}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                async: false,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    if (data.success) {
                        toastr.success(data.success);
                        $('.close').click();
                        window.location.reload();
                    }
                    if (data.error) {
                        toastr.error(data.error)
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
