@extends('setup.master')

@section('content')



    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

    <style type="text/css">
        #social_icons ul {
            margin-top: 1rem;
            margin-bottom: 1rem;
            margin-left: 0px;
        }

        #social_icons li {
            list-style: none;
            margin-left: 5px;
            text-align: center;
            border-radius: 5px;
        }

        #social_icons li span {
            font-size: 20px;
        }

        #social_icons ul li {
            display: inline-block;
            padding: 11px 5px 5px;
        }

        #social_icons #social-links {
            float: left;
        }
        #social_icons #social-links{
            text-align: center !important;
        }
    </style>

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Jobs Portal</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Recruitment</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ url('recruitment/new/form') }}" class="btn add-btn"><i class="fa fa-plus"></i>Create
                            Job</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Search Filter -->
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('recruitment/new') }}" method="post" id="searchForm">
                        @csrf
                        <div class="row filter-row">

                            <div class="col-sm-6 col-md-3">
                                <div class="form-group form-focus">
                                    <select class="select floating" name="job_title">
                                        <option value="">-</option>
                                        @isset($data['title'])
                                            @foreach ($data['title'] as $title)
                                                <option value="{{ $title->id }}">{{ $title->desig_name }}</option>
                                            @endforeach
                                        @endisset


                                    </select>
                                    <label class="focus-label">Job Title</label>
                                </div>
                            </div>


                            <div class="col-sm-6 col-md-3">
                                <div class="form-group form-focus select-focus">
                                    <select class="select floating" name="job_type">
                                        <option value="">-</option>
                                        <option value="Part Time">Part Time</option>
                                        <option value="Full Time">Full Time</option>


                                    </select>
                                    <label class="focus-label">Job Type</label>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-3">
                                <div class="form-group form-focus select-focus">
                                    <select class="select floating" name="status">
                                        <option value="">-</option>
                                        <option value="open">OPEN</option>
                                        <option value="close">CLOSE</option>


                                    </select>
                                    <label class="focus-label">Job Status</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <!-- Search Filter -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-responsive mb-0" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>SR#</th>
                                            <th>Job Title</th>
                                            <th>Dept</th>

                                            <th class="text-center">Shift</th>
                                            <th class="d-none d-sm-table-cell">Salary</th>
                                            <th class="d-none d-sm-table-cell">Description</th>
                                            <th class="d-none d-sm-table-cell">Status</th>
                                            <th class="text-right">Actions</th>
                                            <th class="text-right">Shares To</th>
                                        </tr>
                                    </thead>
                                    <tbody id="showData">


                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /Page Content -->




        <!-- Delete Today Work Modal -->
        <div class="modal custom-modal fade" id="delete_department" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Job</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);"
                                        class="btn btn-primary continue-btn btnDeleteNow">Delete</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal"
                                        class="btn btn-primary cancel-btn btnSkip">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Today Work Modal -->

    </div>
    <!-- /Page Wrapper -->


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script type='text/javascript'>
        $(document).ready(function() {


            getNewHiring();

            function getNewHiring() {


                $.ajax({

                    url: '{{ url('/get-new/hiring') }}',
                    type: 'get',
                    async: false,
                    dataType: 'json',

                    success: function(data) {

                        var html = '';
                        var i;
                        var c = 0;
                        var status_class = '';
                        for (i = 0; i < data.length; i++) {

                            c++;

                            (data[i].status == 'OPEN') ? status_class = 'text-success': status_class =
                                'text-danger';


                            html += '<tr>' +
                                '<td>' + c + '</td>' +
                                '<td>' + data[i].desig_name + '</td>' +
                                '<td>' + data[i].departments + '</td>' +

                                '<td><h2> ' + data[i].shift + '</h2></td>' +
                                '<td><h2> ' + data[i].salary + '</h2></td>' +


                                '<td class="d-none d-sm-table-cell col-md-4">' + data[i].desc.substring(
                                    0, 100) + '</td>' +
                                '<td class="text-center">' +
                                '<div class="action-label">' +
                                '<a class="btn btn-white btn-sm btn-rounded" href="#" data-toggle="dropdown" aria-expanded="false">' +
                                '<i class="fa fa-dot-circle-o ' + status_class + '"></i>' + data[i]
                                .status + ' </a>' +
                                '</div></td>' +


                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a class="dropdown-item btnEdit" href="{{ url('edit-recruitment/') }}/' +
                                data[i].id + '"><i class="fa fa-pencil m-r-5"></i> Edit</a>' +
                                '<a class="dropdown-item btn-delete" href="#"   data="' + data[i].id +
                                '"><i class="fa fa-trash-o m-r-5"></i> Delete</a>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +

                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                // '<a class="dropdown-item" href="https://www.facebook.com/sharer.php?u=https://crm.alphabuzzco.com/job/list" target="_blank" title="share to facebook"><img src="{{ asset('public/assets/img/logo/socail-icon/fb.png') }}" /></a>' +
                                // '<a class="dropdown-item" href="https://www.twitter.com/share?text=text&url=https://crm.alphabuzzco.com/job/list" title="share to Twitter" target="_blank"><img src="{{ asset('public/assets/img/logo/socail-icon/twitter.png') }}" /></a>' +
                                // '<a class="dropdown-item " href="https://api.whatsapp.com/send?phone=&text=<?php urlencode('Testing'); ?> https://crm.alphabuzzco.comjob/list" target="_blank" title="share to Whatsapp"><img src="{{ asset('public/assets/img/logo/socail-icon/whatsapp.png') }}" /> </a>' +
                                '<div id="social_icons"  target="_blank">{!! $data['shareButtons'] !!}</div>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +

                                '</tr>';
                        }


                        $('#showData').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }



            $('#deptId').change(function() {
                var dept_id = $('select[name=dept_name]').val();

                $.ajax({

                    type: 'ajax',

                    method: 'get',

                    url: '{{ url('/getDesignations') }}',

                    data: {
                        dept_id: dept_id
                    },

                    async: false,

                    dataType: 'json',

                    success: function(data) {

                        var html = '';

                        var i;
                        if (data.length > 0) {

                            for (i = 0; i < data.length; i++) {

                                html += '<option value="' + data[i].id + '">' + data[i]
                                    .desig_name + '</option>';

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


            //ajax call for serach record

            $('#searchForm').unbind().on('submit', function(e) {
                e.preventDefault();

                var formData = $('#searchForm').serialize();


                $.ajax({

                    type: 'ajax',
                    method: 'post',
                    url: '{{ url('recruitment/new') }}',
                    data: formData,
                    async: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('.btn-submit').append(
                            "<img class='img-loader' style='height: 25px;width: 30px' src=public/assets/img/loader/loader.gif />"
                        ).button();
                    },

                    success: function(data) {

                        var html = '';
                        var i;
                        var c = 0;
                        var status_class = '';
                        for (i = 0; i < data.length; i++) {

                            c++;

                            (data[i].status == 'OPEN') ? status_class = 'text-success':
                                status_class = 'text-danger';


                            html += '<tr>' +
                                '<td>' + c + '</td>' +
                                '<td>' + data[i].desig_name + '</td>' +
                                '<td>' + data[i].departments + '</td>' +
                                '<td><h2> ' + data[i].timings + '</h2></td>' +
                                '<td><h2> ' + data[i].shift + '</h2></td>' +
                                '<td><h2> ' + data[i].salary + '</h2></td>' +


                                '<td class="d-none d-sm-table-cell col-md-4">' + data[i].desc
                                .substring(0, 100) + '</td>' +
                                '<td class="text-center">' +
                                '<div class="action-label">' +
                                '<a class="btn btn-white btn-sm btn-rounded" href="#" data-toggle="dropdown" aria-expanded="false">' +
                                '<i class="fa fa-dot-circle-o ' + status_class + '"></i>' +
                                data[i].status + ' </a>' +
                                '</div></td>' +


                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a class="dropdown-item btnEdit" href="{{ url('edit-recruitment/') }}/' +
                                data[i].id + '"><i class="fa fa-pencil m-r-5"></i> Edit</a>' +
                                '<a class="dropdown-item btn-delete" href="#" data-toggle="modal"  data="' +
                                data[i].id +
                                '"><i class="fa fa-trash-o m-r-5"></i> Delete</a>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +

                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a class="dropdown-item" href="https://www.facebook.com/sharer.php?u=https://hrm.alphabuzzco.com/job/list" target="_blank" title="share to facebook"><img src="{{ asset('public/assets/img/logo/socail-icon/fb.png') }}" /></a>' +
                                '<a class="dropdown-item" href="https://www.twitter.com/share?text=text&url=https://hrm.alphabuzzco.com/job/list" title="share to Twitter" target="_blank"><img src="{{ asset('public/assets/img/logo/socail-icon/twitter.png') }}" /></a>' +
                                '<a class="dropdown-item " href="https://api.whatsapp.com/send?phone=&text=<?php urlencode('Testing'); ?> https://hrm.alphabuzzco.comjob/list" target="_blank" title="share to Whatsapp"><img src="{{ asset('public/assets/img/logo/socail-icon/whatsapp.png') }}" /> </a>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +

                                '</tr>';
                        }


                        $('#showData').html(html);

                    },

                    error: function() {
                        toastr.error('something went wrong');

                    },

                    complete: function() {
                        $('.img-loader').remove();


                    },

                });


            });



            $('#showData').on('click', '.btn-delete', function() {

                var id = $(this).attr('data');
                $('#delete_department').modal('show');

                $('.btnDeleteNow').on('click', function() {


                    $.ajax({

                        type: 'ajax',
                        method: 'get',
                        url: '{{ url('delete/recruitment') }}',
                        data: {
                            id: id
                        },
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            if (data.success) {
                                getNewHiring();
                                toastr.success(data.success);
                                $('#delete_department').modal('hide');
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

        })
    </script>

@endsection
