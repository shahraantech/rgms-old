@extends('setup.master')

@section('content')


    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Projects</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Projects</li>
                        </ul>
                    </div>

                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#create_project"
                            title=" Create Project"><i class="fa fa-plus"></i></a>

                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Search Filter -->
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating">
                        <label class="focus-label">Project Name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating">
                        <label class="focus-label">Employee Name</label>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <a href="#" class="btn btn-primary"><i class="fa fa-search"></i></a>
                </div>
            </div>
            <!-- Search Filter -->

            <div class="row">
                @isset($data)
                    @foreach ($data['projects'] as $project)
                        <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown dropdown-action profile-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ url('edit-projects/' . $project->id) }}"><i
                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item btn_project_delete" href="#"
                                                data="{{ $project->id }}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                    <h4 class="project-title"><a href="#">{{ $project->title }}</a></h4>
                                    <small class="block text-ellipsis m-b-15">

                                        @php
                                            $open = App\Models\Tasks::where('project_id', $project->id)
                                                ->where('status', 2)
                                                ->count();
                                            $pending = App\Models\Tasks::where('project_id', $project->id)
                                                ->where('status', 0)
                                                ->count();
                                            $complete = App\Models\Tasks::where('project_id', $project->id)
                                                ->where('status', 1)
                                                ->count();
                                        @endphp

                                        <span class="text-xs"> <strong>{{ $open }} </strong> </span> <span
                                            class="badge-primary">open </span>
                                        <span class="text-xs"> <strong>{{ $pending }} </strong></span> <span
                                            class="badge-danger"> pending</span>
                                        <span class="text-xs"> <strong>{{ $complete }} </strong></span> <span
                                            class="badge-success"> completed</span>

                                    </small>
                                    <p class="text-muted">
                                        {!! Str::limit($project->desc, 200) !!}
                                    </p>
                                    <div class="pro-deadline m-b-15">
                                        <div class="sub-title">
                                            Deadline:
                                        </div>
                                        <div class="text-muted">
                                            {{ date('d M Y', strtotime($project->end_date)) }}
                                        </div>
                                    </div>
                                    <div class="project-members m-b-15">
                                        <div>Project Leader :</div>
                                        <ul class="team-members">
                                            <li>
                                                <a href="#" data-toggle="tooltip" title="{{ $project->name }}">

                                                    <img alt=""
                                                        src="{{ asset('storage/app/public/uploads/staff-images/') . '/' . $project->image }}">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    @php
                                        $totalTask = APP\Models\Project::join('tasks', 'tasks.project_id', '=', 'projects.id')
                                            ->where('tasks.project_id', $project->id)
                                            ->get();
                                        $doneTask = APP\Models\Project::join('tasks', 'tasks.project_id', '=', 'projects.id')
                                            ->where('tasks.project_id', $project->id)
                                            ->where('tasks.status', 1)
                                            ->get();
                                        if ($totalTask->count() > 0) {
                                            $progress = ($doneTask->count() * 100) / $totalTask->count();
                                        } else {
                                            $progress = 0;
                                        }
                                        
                                    @endphp
                                    @if ($project->status == 1)
                                        <p class="m-b-5">Progress <span class="text-success float-right">100%</span></p>
                                        <div class="progress progress-xs mb-0">
                                            <div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip"
                                                title="Progress" style="width:100%"></div>
                                        </div>
                                    @else
                                        <p class="m-b-5">Progress <span class="text-success float-right">
                                                {{ round($progress) }}%</span></p>
                                        <div class="progress progress-xs mb-0">
                                            <div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip"
                                                title="Progress" style="width:{{ round($progress) }}%"></div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endisset
            </div>

            <div class="float-right mt-3">
                {{ $data['projects']->links('pagination::bootstrap-4') }}
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Create Project Modal -->
        <div id="create_project" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Project</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ url('projects') }}" enctype="multipart/form-data"
                            id="ProjectForm">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Project Name</label>
                                        <input class="form-control" type="text" name="project_name"
                                            placeholder="Project Name" required>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <div class="cal-iconssss">
                                            <input class="form-control " type="date" name="start_date" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <div class="cal-iconss">
                                            <input class="form-control " type="date" name="end_date" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Budget</label>
                                        <input placeholder="Price/Budget" class="form-control" type="number"
                                            name="price" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Priority</label>
                                        <select class="select form-control" name="priority" required>
                                            <option value="High">High</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Add Project Manager</label>
                                        <select class="select" name="manager_id" required>
                                            <option value="">Choose Manager</option>
                                            @isset($data)
                                                @foreach ($data['manager'] as $manage)
                                                    <option value="{{ $manage->id }}">{{ $manage->name }}</option>
                                                @endforeach
                                            @endisset

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Team Leader</label>
                                        <div class="project-members" id="memberImage">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea rows="4" class="form-control summernote" placeholder="Enter your message here" name="des"
                                    required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Attachments</label>
                                <input class="form-control" type="file" name="file">
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary btn-submit ">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Create Project Modal -->


    </div>
    <!-- /Page Wrapper -->


    <script type="text/javascript">
        CKEDITOR.replace('des', {
            filebrowserUploadUrl: "{{ url('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            $('#ProjectForm').validate({

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

            // save designation
            $('select[name=manager_id]').on('change', function() {
                var manager_id = $('select[name=manager_id]').val();
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('get-manager-data') }}',
                    data: {
                        manager_id: manager_id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        $('#memberImage').append(
                            '<a href="#" data-toggle="tooltip" title="Jeffery Lalor" class="avatar"><img src="{{ asset('public/assets/img/profiles/avatar-16. jpg') }}" alt="" style="height:40px;width:50px"> </a>'
                        );
                    },

                    error: function() {
                        toastr.error('something went wrong');

                    }

                });


            });


            // script for delete data
            $('.card').on('click', '.btn_project_delete', function(e) {
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
                            url: "{{ url('/delete-projects/') }}/" + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 2000
                                })

                                window.location.reload();
                            }
                        });
                    }
                })

            });



        });
    </script>

    <script>
        @if (count($errors) > 0)

            @foreach ($errors->all() as $error)

                toastr.error("{{ $error }}");
            @endforeach
        @endif
        @if (Session::has('success'))
            toastr.success("Record save successfully!");
        @endif
    </script>
@endsection
