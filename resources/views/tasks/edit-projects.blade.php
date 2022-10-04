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
                    <h3 class="page-title">Edit Project</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Project</li>
                    </ul>
                </div>

                <div class="col-auto float-right ml-auto">
                    <a href="{{ url('projects') }}" class="btn add-btn"><i class="fa fa-plus"></i> Back</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

       <div class="container">
       <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{url('update-projects/'.$pro->id)}}" class="needs-validation" novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Project Name</label>
                                <input class="form-control" type="text" value="{{ $pro->title }}" name="project_name" placeholder="Project Name" required>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <div class="cal-iconssss">
                                    <input class="form-control" value="{{ $pro->start_date }}" type="date" name="start_date" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>End Date</label>
                                <div class="cal-iconss">
                                    <input class="form-control" value="{{ $pro->end_date }}" type="date" name="end_date" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Budget</label>
                                <input placeholder="Price/Budget" class="form-control" value="{{ $pro->price }}" type="number" name="price" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Priority</label>
                                <select class="select form-control" name="priority" required>
                                    <option value="High"
                                    @if($pro->priorty == 'High') selected @endif
                                    >High</option>
                                    <option value="Medium"
                                    @if($pro->priorty == 'Medium') selected @endif
                                    >Medium</option>
                                    <option value="Low"
                                    @if($pro->priorty == 'Low') selected @endif
                                    >Low</option>
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
                                   
                                    @foreach($manager as $manage)
                                    <option value="{{$manage->id}}"
                                    @if($pro->manager_id == $manage->id) selected @endif
                                    >{{$manage->name}}</option>
                                    @endforeach
                                   

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
                        <textarea rows="4" class="form-control summernote" placeholder="Enter your message here" name="des" required>{{ $pro->desc }}</textarea>
                    </div>

                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
       </div>

    </div>
    <!-- /Page Content -->



</div>
<!-- /Page Wrapper -->


<script type="text/javascript">
    CKEDITOR.replace('des', {
        filebrowserUploadUrl: "{{url('ckeditor.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>



<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {

        // save designation




        $('select[name=manager_id]').on('change', function() {

            var manager_id = $('select[name=manager_id]').val();


            $.ajax({

                type: 'ajax',
                method: 'get',
                url: '{{url("get-manager-data")}}',
                data: {
                    manager_id: manager_id
                },
                async: false,
                dataType: 'json',
                success: function(data) {

                    console.log(data.image);

                    $('#memberImage').append('<a href="#" data-toggle="tooltip" title="Jeffery Lalor" class="avatar"><img src="{{asset("public/assets/img/profiles/avatar-16.jpg")}}" alt="" style="height:40px;width:50px"> </a>');

                },

                error: function() {
                    toastr.error('something went wrong');

                }

            });


        });



    })
</script>

<script>
    @if(count($errors) > 0)

    @foreach($errors-> all() as $error)

    toastr.error("{{ $error }}");
    @endforeach
    @endif


    @if(Session::has('success'))
    toastr.success("Record save successfully!");

    @endif
</script>
@endsection