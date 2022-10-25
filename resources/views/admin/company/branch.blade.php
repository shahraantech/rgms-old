@extends('setup.master')

@section('content')
    <div class="page-wrapper">


        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Company Branch</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Company Branch</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ url('add-company-branch') }}" class="btn add-btn" title="Add New Company"><i
                                class="fa fa-plus"></i></a>
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
                                            <th>Company </th>
                                            <th>Location</th>
                                            <th>F-Person</th>
                                            <th>Contact</th>
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

    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {


            toastr.options.timeOut = 3000;
            @if (Session::has('error'))
                toastr.error('{{ Session::get('error') }}');
            @elseif(Session::has('success'))
                toastr.success('{{ Session::get('success') }}');
            @endif


            companyList();

            function companyList() {

                $.ajax({

                    url: '{{ url('/get-company-branches') }}',
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
                                '<td>' + data[i].companyname.name + '</td>' +

                                '<td>' + data[i].branch_name + '</td>' +
                                '<td>' + data[i].focal_person + '</td>' +
                                '<td>' + data[i].contact + '</td>' +
                                '<td>' + data[i].address + '</td>' +
                                '<td>' + data[i].created_at + '</td>' +
                                '<td class="text-right">' +
                                '<div class="dropdown dropdown-action">' +
                                '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right">' +
                                '<a href="edit-company-branches/' + data[i].id +
                                '" class="dropdown-item btn_edit_clients" id="btn_edit_clients"><i class="la la-pencil" style="font-size:20px;"></i></a>' +
                                '<a href="#" class="dropdown-item btn_delete_company" data="' + data[i]
                                .id +
                                '" id="btn_delete_clients"><i class="la la-trash" style="font-size:20px;"></i></a>' +
                                '</tr>';
                        }

                        $('#companyTable').html(html);

                    },
                    error: function() {
                        toastr.error('something went wrong');
                    }

                });
            }


            // Delete Level 3
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
                            url: "{{ url('delete-company-branches') }}",
                            data: {
                                id: id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {

                                if (response.status == 200) {
                                    toastr.success(response.message);
                                    companyList();
                                }
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



    <script
        src="https://maps.google.com/maps/api/js?key=AIzaSyAB6y4kRx41p5krahkuc_dT2n5HJJwQP7w&amp;libraries=places&amp;callback=initAutocomplete"
        type="text/javascript"></script>




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
