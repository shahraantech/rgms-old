@extends('setup.master')

@section('content')

<div class="page-wrapper">


    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Company</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Company</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{url('add-company')}}" class="btn add-btn" title="Add New Company"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->


        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 30px;">#</th>
                                        <th> Name </th>
{{--                                        <th>Monthly Holidays </th>--}}
{{--                                        <th>Working Days </th>--}}
{{--                                        <th>Favicon</th>--}}
{{--                                        <th>Logo</th>--}}
                                        <th>Address</th>
                                        <th>Date</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody id="companyTable">


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Page Content -->

    <!-- Add Department Modal -->
    <div id="add_department" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Company Settings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalDismiss">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="" id="companyForm" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Company Name<span class="text-danger">*</span></label>

                                    <input class="form-control" type="text" name="company_name" placeholder="Company Name" required>
                                    <div class="invalid-feedback">
                                        Please Enter Company Name.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Working Hrs<span class="text-danger">*</span></label>

                                    <input class="form-control" type="number" name="working_days" placeholder="Working Hrs" required>
                                    <div class="invalid-feedback">
                                        Please Enter Working Hrs.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Monthly Leaves<span class="text-danger">*</span></label>

                                    <input class="form-control" type="number" name="allow_holidays" placeholder="Monthly Leaves" required>
                                    <div class="invalid-feedback">
                                        Please Enter Monthly Leaves.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Company Favicon <span class="text-danger">*</span></label>
                                    <input class="form-control" type="file" name="favicon" id="favicon" required onchange="favPriviewFunction();">
                                    <div class="invalid-feedback">
                                        Please Enter Company Favicon.
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Company Logo <span class="text-danger">*</span></label>
                                    <input class="form-control" type="file" name="file" id="logo" required onchange="previewFile(this);">
                                    <div class="invalid-feedback">
                                        Please Enter Comapny Logo.
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-6 col-md-6" style="display: none" id="favDiv">
                                        <div class="form-group">

                                            <img id="favPreview" style="height: 150px" width="150px;" class="img img-thumbnail">
                                        </div>


                                    </div>
                                    <div class="col-sm-6 col-md-6" style="display: none" id="logDiv">
                                        <div class="form-group">

                                            <img id="previewLogo" style="height: 150px" width="150px;" class="img img-thumbnail">
                                        </div>


                                    </div>

                                </div>

                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn " type="submit">Submit Now</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Department Modal -->


</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- CDN for Sweet Alert -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        companyList();

        function companyList() {


            $.ajax({

                url: '{{url("/company")}}',
                type: 'get',
                async: false,
                dataType: 'json',
                success: function(data) {

                    var html = '';
                    var i;
                    var c = 0;

                    for (i = 0; i < data.length; i++) {

                        c++;
                        html += '<tr>' +
                            '<td>' + c + '</td>' +
                            '<td>' + data[i].name + '</td>' +
                            // '<td>' + data[i].allow_holidays + ' days</td>' +
                            // '<td>' + data[i].working_days + ' days</td>' +
                            {{--' <td><img src="{{asset("storage/app/public/uploads/company-assets")}}/' + data[i].favicon + '" style="height:45px; width:50px" class="img img-thumbnail"></td>' +--}}
                            {{--' <td><img src="{{asset("storage/app/public/uploads/company-assets")}}/' + data[i].logo + '" style="height:45px; width:50px" class="img img-thumbnail"></td>' +--}}
                            '<td>' + data[i].address + '</td>' +
                            '<td>' + data[i].created_at + '</td>' +
                            '<td class="text-right">' +
                            '<div class="dropdown dropdown-action">' +
                            '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a href="edit-company/' + data[i].id + '" class="dropdown-item btn_edit_clients" id="btn_edit_clients"><i class="la la-pencil" style="font-size:20px;"></i></a>' +
                            '<a href="" class="dropdown-item btn_delete_company" data="' + data[i].id + '" id="btn_delete_clients"><i class="la la-trash" style="font-size:20px;"></i></a>' +
                            '</tr>';
                    }


                    $('#companyTable').html(html);

                },
                error: function() {
                    toastr.error('something went wrong');
                }

            });
        }


        // script for delete data
        $('#companyTable').on('click', '.btn_delete_company', function(e) {
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
                        url: "{{ url('/delete-company/') }}/" + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                        success: function(response) {

                            toastr.success(response.message);

                            companyList();
                        }
                    });
                }
            })

        });

        //Datatables
        $('#datatable').DataTable();

    });
</script>


<script>
    function favPriviewFunction() {

        $("#favDiv").css("display", "block");
        var file = $("input[name=favicon]").get(0).files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                $("#favPreview").attr("src", reader.result);
            }
            reader.readAsDataURL(file);

        }
    }

    function previewFile(input) {

        $("#logDiv").css("display", "block");
        var file = $("input[name=file]").get(0).files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                $("#previewLogo").attr("src", reader.result);
            }
            reader.readAsDataURL(file);

        }
    }
</script>



<script src="https://maps.google.com/maps/api/js?key=AIzaSyAB6y4kRx41p5krahkuc_dT2n5HJJwQP7w&amp;libraries=places&amp;callback=initAutocomplete" type="text/javascript"></script>




<script>
    google.maps.event.addDomListener(window, 'load', initialize);

    function initialize() {
        var input = document.getElementById('autocomplete');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            $('#latitude').val(place.geometry['location'].lat());
            $('#longitude').val(place.geometry['location'].lng());
            // --------- show lat and long ---------------
            $("#lat_area").removeClass("d-none");
            $("#long_area").removeClass("d-none");
        });
    }
</script>


@endsection
