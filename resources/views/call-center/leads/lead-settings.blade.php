@extends('setup.master')
@section('content')

    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: darkred;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: darkgreen;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
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
                            <h3 class="page-title bold-heading">Leads Settings</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Leads Settings</li>
                            </ul>
                        </div>

                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        @php  $status='';   @endphp
                        @isset($data['status'])
                            @php     ($data['status']->lead_mode==1)?$status='checked':$status=''; @endphp
                        @endisset
                            <center>
                            <div class="form-group" style="display: inline-flex">
                                <lable class="mr-1"> <strong> Auto Save </strong></lable>
                                <label class="switch">
                                    <input type="checkbox" {{$status}} class="radio-button" name="auto_save">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            </center>


                    </div>
                </div>

            </div>
            <!-- /Page Content -->
        </div>




    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {


            $('.radio-button').on('change', function() {


                var status=0;
                if($('.radio-button').is(':checked'))
                {
                    status=1;
                }else{
                    status=0;
                }

                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{url("update-leads-settings")}}',
                    data: {status:status},
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        toastr.success(data.success);

                    },
                    error: function() {
                        toastr.error('something went wrong');

                    },

                });


            });





        });
    </script>


@endsection
