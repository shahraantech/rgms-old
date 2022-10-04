@extends('setup.master')
@section('content')
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
    <style>
        .MultiCheckBox {
            border: 1px solid #e2e2e2;
            padding: 5px;
            border-radius: 4px;
            cursor: pointer;
        }

        .MultiCheckBox .k-icon {
            font-size: 15px;
            float: right;
            font-weight: bolder;
            margin-top: -7px;
            height: 10px;
            width: 14px;
            color: #787878;
        }

        .MultiCheckBoxDetail {
            display: none;
            position: absolute;
            border: 1px solid #e2e2e2;
            overflow-y: hidden;
        }

        .MultiCheckBoxDetailBody {
            overflow-y: scroll;
        }

        .MultiCheckBoxDetail .cont {
            clear: both;
            overflow: hidden;
            padding: 2px;
        }

        .MultiCheckBoxDetail .cont:hover {
            background-color: #cfcfcf;
        }

        .MultiCheckBoxDetailBody>div>div {
            float: left;
        }

        .MultiCheckBoxDetail>div>div:nth-child(1) {}

        .MultiCheckBoxDetailHeader {
            overflow: hidden;
            position: relative;
            height: 28px;
            background-color: #3d3d3d;
        }

        .MultiCheckBoxDetailHeader>input {
            position: absolute;
            top: 4px;
            left: 3px;
        }

        .MultiCheckBoxDetailHeader>div {
            position: absolute;
            top: 5px;
            left: 24px;
            color: #fff;
        }
    </style>
    <script>
        $(document).ready(function() {
            $("#test").CreateMultiCheckBox({
                width: '230px',
                defaultText: 'Select Below',
                height: '250px'
            });
        });
    </script>
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Campaign</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Email Campaign</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- search filter --}}
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('email') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <select name="city_id" class="form-control">
                                    <option value="" selected disabled>Choose one</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- search filter --}}

            <!-- /Page Header -->
            <form method="POST" action="{{ url('email-send') }}" id="emailSendForm">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="text" placeholder="Subject" class="form-control" name="subject"
                                        required>
                                </div>
                                <div class="form-group">
                                    <textarea rows="4" class="form-control" placeholder="Enter your message here" name="text_body" required></textarea>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="text-center">
                                        <button class="btn btn-primary" type="submit" title="Send Mail">
                                            <i class="fa fa-send m-l-5"></i></button>
                                    </div>
                                </div>
                                {{-- <div class="form-group">
                                    <label for="" class="font-weight-bold">All</label>
                                    <input type="checkbox" class="get_all_city" id="get_all_city">
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50px"><input type="checkbox" id="master"></th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>City</th>
                                        </tr>
                                    </thead>
                                    <tbody id="leadTabble">
                                        @isset($leads)
                                            @foreach ($leads as $lead)
                                                <tr>
                                                    <td><input type="checkbox" class="sub_chk" data-id="{{ $lead->id }}"
                                                            name="lead_id[]" value="{{ $lead->id }}"></td>
                                                    <td>{{ $lead->name }}</td>
                                                    <td>{{ $lead->email }}</td>
                                                    <td>{{ $lead->cityname->city_name }}</td>
                                                </tr>
                                              
                                            @endforeach
                                            <input type="hidden" class="cities_id" data5="{{ $lead->city_id }}" name="cities_id[]"
                                            value="{{ $lead->city_id }}">
                                        @endisset
                                    </tbody>
                                </table>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                        {{ $leads->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /Page Content -->
    </div>
    <script type="text/javascript">
        CKEDITOR.replace('text_body', {
            filebrowserUploadUrl: "{{ url('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {

            //chek all boxes
            // $('#master').on('click', function(e) {
            //     if ($(this).is(':checked', true)) {
            //         $(".sub_chk").prop('checked', true);
            //     } else {
            //         $(".sub_chk").prop('checked', false);
            //     }
            // });



            // $('.send-mail125').on('click', function(e) {

            //     var allVals = [];
            //     $(".sub_chk:checked").each(function() {
            //         allVals.push($(this).attr('data-id'));
            //     });


            //     if (allVals.length <= 0) {
            //         toastr.error("Please select row.");
            //     } else {
            //         var subject = $('select[name=subject]').val();
            //         var text_body = $('select[name=text_body]').val();

            //         $.ajax({
            //             url: '{{ url('/email') }}',
            //             type: 'GET',
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //             },
            //             data: {
            //                 ids: allVals,
            //                 subject: subject,
            //                 text_body: text_body
            //             },
            //             beforeSend: function() {
            //                 $(".btn-save-assign-leads").prop("disabled", true);
            //                 $(".btn-save-assign-leads").html("saving...");

            //             },
            //             success: function(data) {

            //                 console.log(data);
            //                 if (data.success) {
            //                     toastr.success(data.success);
            //                     $(".sub_chk:checked").each(function() {
            //                         $(this).parents("tr").remove();
            //                     });

            //                 } else {
            //                     toastr.error('something went wrong');
            //                 }
            //             },
            //             complete: function(data) {
            //                 $('.close').click();
            //                 $(".btn-save-assign-leads").html("Save");
            //                 $(".btn-save-assign-leads").prop("disabled", false);
            //             },
            //             error: function(data) {
            //                 toastr.error(data.responseText);
            //             }
            //         });


            //         $.each(allVals, function(index, value) {
            //             $('table tr').filter("[data-row-id='" + value + "']").remove();
            //         });

            //     }
            // });


            // $('#get_all_city').on('change', function() {

            //     if ($(this).is(':checked', true)) {
            //         $(".cities_id").prop('checked', true);
            //         $(".cities_id").each(function() {

            //             // var cities_id = $(this).val();
            //             var cities_id = $(this).attr('data5');
            //             console.log(cities_id);

            //             $('.send_mail_to_city').click(function() {

            //                 var subject = $('input[name=subject]').val();
            //                 console.log(subject);
                            
            //                 console.log(cities_id);

            //                 $.ajax({
            //                     url: '{{ url('/email-send') }}',
            //                     type: 'POST',
            //                     data: {
            //                         cities_id: cities_id,
            //                         // address: subject,
            //                     },
            //                     headers: {
            //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
            //                             .attr('content')
            //                     },
            //                     success: function(data) {

            //                         // console.log(data);
            //                         if (data.success) {
            //                             toastr.success(data.success);

            //                         } else {
            //                             toastr.error(data.error);
            //                         }
            //                     },
            //                     error: function(data) {
            //                         toastr.error('Something wrong');
            //                     }
            //                 });

            //             });

            //         });


            //     } else {
            //         $(".cities_id").prop('checked', false);
            //     }

            // });


        });
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    <script>
        @if (count($errors) > 0)

            @foreach ($errors->all() as $error)

                toastr.error("{{ $error }}");
            @endforeach
        @endif


        @if (Session::has('success'))
            toastr.success("Leads import successfully!");
        @endif
    </script>
@endsection
