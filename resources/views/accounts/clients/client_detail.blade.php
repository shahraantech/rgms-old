@extends('setup.master')

@section('content')
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->

            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Client Detail</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Client Detail</li>
                        </ul>
                    </div>
                    {{-- <div class="col-auto float-right ml-auto">
                        <a href="{{ url('clients') }}" class="btn add-btn" title="Add New Client"><i
                                class="fa fa-plus"></i></a>
                    </div> --}}
                </div>
            </div>
            <!-- /Page Header -->




            @isset($data['clients'])
                <div class="row gutters-sm mt-3">
                    <div class="col-md-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                        class="rounded-circle" width="150">
                                    <div class="mt-3">
                                        <h4>{{ $data['clients']->name }}</h4>
                                        <p class="text-secondary mb-1">{{ $data['clients']->email ?: 'Email' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card mb-3" id="clientTable">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <div class="dropdown dropdown-action float-right">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item btn_edit_client"
                                                    data="{{ $data['clients']->id }}">
                                                    <i class="fa fa-pencil m-r-5n "></i> Edit</a>
                                                <a href="" class="dropdown-item btn_delete_client"
                                                    data="{{ $data['clients']->id }}">
                                                    <i class="fa fa-trash-o m-r-5 "></i> Delete</a>

                                            </div>
                                        </div>
                                        {{ $data['clients']->email ?: 'Email' }}
                                    </div>
                                </div>
                                <hr>

                                @if ($data['clients']->f_name)
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Father Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            {{ $data['clients']->f_name }}
                                        </div>
                                    </div>
                                    <hr>
                                @endif

                                @if ($data['clients']->lead_id)
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Lead ID</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            {{ $data['clients']->lead_id }}
                                        </div>
                                    </div>
                                    <hr>
                                @endif

                                @if ($data['clients']->processing_fee)
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Processing Fee</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            {{ $data['clients']->processing_fee }}
                                        </div>
                                    </div>
                                    <hr>
                                @endif

                                @if ($data['clients']->address)
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Address</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            {{ $data['clients']->address }}
                                        </div>
                                    </div>
                                    <hr>
                                @endif

                                @if ($data['clients']->profession)
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Profession</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            {{ $data['clients']->profession }}
                                        </div>
                                    </div>
                                    <hr>
                                @endif

                                @if ($data['clients']->age)
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Age</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            {{ $data['clients']->age }}
                                        </div>
                                    </div>
                                    <hr>
                                @endif

                                @if ($data['clients']->cnic)
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Cnic</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            {{ $data['clients']->cnic }}
                                        </div>
                                    </div>
                                    <hr>
                                @endif

                                @if ($data['clients']->city)
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">City</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            {{ $data['clients']->city }}
                                        </div>
                                    </div>
                                    <hr>
                                @endif

                                @if ($data['clients']->open_bal)
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Balance</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            {{ $data['clients']->open_bal }}
                                        </div>
                                    </div>
                                    <hr>
                                @endif

                                @if ($data['clients']->sale_price)
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Sale Price</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            {{ $data['clients']->sale_price }}
                                        </div>
                                    </div>
                                    <hr>
                                @endif

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">A/C History</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <a href="{{ url('account-history/' . $data['clients']->id . '/clients') }}"
                                            class="btn-primary"> History</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endisset

        </div>
        <!-- /Page Content -->


        <!-- Edit Vendor Modal -->
        <div id="edit_client_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Vendor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="" id="EditClientForm" class="needs-validation"
                            enctype="multipart/form-data" novalidate>
                            <input type="hidden" name="client_id">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for=""> Name</label>
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for=""> Email</label>
                                        <input type="text" name="email" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for=""> Cnic</label>
                                        <input type="number" name="cnic" class="form-control">
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for=""> Contact</label>
                                        <input type="number" name="contact" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for=""> City</label>
                                        <input type="text" name="city" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Open Balance</label>
                                        <input type="number" name="open_bal" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <textarea name="address" class="form-control" cols="30" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Image</label>
                                        <input type="file" name="image" id="pic" class="form-control">
                                        <span id="store_image"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn update_client" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Vendor Modal -->


    </div>






    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- CDN for Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            //Edit vendor
            $('#clientTable').on('click', '.btn_edit_client', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                $('#edit_client_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('edit-client') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('input[name=client_id]').val(data.id);
                        $('input[name=name]').val(data.name);
                        $('input[name=email]').val(data.email);
                        $('input[name=cnic]').val(data.cnic);
                        $('input[name=contact]').val(data.contact);
                        $('input[name=city]').val(data.city);
                        $('input[name=open_bal]').val(data.open_bal);
                        $('textarea[name=address]').val(data.address);
                        $('#store_image').html(
                            '<img src="{{ asset('storage/app/public/uploads/accounts/clients/') }}/' +
                            data.image + '" class="mt-4 ml-4" width="40px" height="50px" />'
                        );
                        $('#store_image').append(
                            '<input type="hidden" name="hidden_image" value="' + data
                            .image + '" />');
                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });

            //update vendor
            $('.update_client').on('click', function(e) {
                e.preventDefault();
                $('.update_client').text('Updating...');

                let EditFormData = new FormData($('#EditClientForm')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('/update-client') }}",
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(response) {

                        if (response.status == 200) {
                            $("#edit_client_modal").modal('hide');
                            $('#EditClientForm').find('input').val("");
                            $('.update_client').text('Update');
                            toastr.success(response.message);
                            window.location.reload();
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.update_client').text('Update');
                    }
                });

            });

            // script for delete data
            $('#clientTable').on('click', '.btn_delete_client', function(e) {
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
                            url: "{{ url('/delete-client/') }}/" + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status == 200) {
                                    toastr.success(response.message);
                                    setTimeout(function() {
                                        window.location.reload(1);
                                    }, 1000);
                                }
                            }
                        });
                    }
                });

            });
        });
    </script>
@endsection
