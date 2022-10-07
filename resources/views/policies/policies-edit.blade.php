
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
                        <h3 class="page-title">Edit Policies</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Policies</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{url('policies')}}" class="btn add-btn" >Policies List</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            <form method="post" id="newHiringForm" action="{{url('update-polciy')}}">
                                @csrf

                                @isset($data['policy'])
                                <div class="form-group">
                                    <label for="">Company</label>
                                    <select name="company_id" class="form-control selectpicker" data-container="body" data-live-search="true">
                                        <option value="" selected disabled>choose company</option>
                                        @isset($data)
                                            @foreach($data['company'] as $com)
                                                <option value="{{ $com->id }}"
                                                {{ $data['policy']->company_id == $com->id ? "selected" : "" }}
                                                >{{ $com->name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="hidden" name="hidden_policy_id" value="{!! $data['policy']->id !!}">
                                    <label>Company Policies <span class="text-danger">*</span></label>
                                    <textarea rows="4" class="form-control" name="policy" >{!! $data['policy']->policies !!}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Rules & Regulation <span class="text-danger">*</span></label>
                                    <textarea rows="4" class="form-control" name="rules">{!! $data['policy']->rules !!}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Confidential Information <span class="text-danger">*</span></label>
                                    <textarea rows="4" class="form-control" name="confidentail_info">{!! $data['policy']->confidentional_info !!}</textarea>
                                </div>
                                @endisset


                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn btn_update_polieces" type="submit" id="btnSubmit">Save Changes</button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /Page Content -->



    </div>
    <!-- /Page Wrapper -->


    <script type="text/javascript">


        CKEDITOR.replace('policy', {
            filebrowserUploadUrl: "{{url('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('confidentail_info', {
            filebrowserUploadUrl: "{{url('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });

        CKEDITOR.replace('rules', {
            filebrowserUploadUrl: "{{url('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });






    </script>





    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    <script>
        @if(count($errors) > 0)

        @foreach($errors->all() as $error)

        toastr.error("{{ $error }}");
        @endforeach
        @endif


        @if(Session::has('success'))

        toastr.success("Record updated successfully!");
        window.location.href=url;
        var url = "{{ url('/policies')}}";
        window.location.href=url;

        @endif



        $('.btn_update_polieces').on('click', function() {
        $(".btn_update_polieces").prop("disabled", true);
        $(".btn_update_polieces").html("Please wait...");
        $('#newHiringForm').submit();
        });

    </script>


@endsection

