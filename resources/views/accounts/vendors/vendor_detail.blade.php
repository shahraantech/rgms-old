@extends('setup.master')

@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Vendor Detail</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Vendor Detail</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ url('vendors') }}" class="btn add-btn" title="Add New Vendor"><i
                                class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            @isset($data['vendor'])
                <div class="row gutters-sm mt-3">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                        class="rounded-circle" width="150">
                                    <div class="mt-3">
                                        <h4>{{ $data['vendor']->name }}</h4>
                                        <p class="text-secondary mb-1">{{ $data['vendor']->email ? : 'Email' }}</p>
                                        <p class="text-secondary mb-1">{{ $data['vendor']->address ? : 'Address' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card mb-3" id="vendorTable">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    @if(\Illuminate\Support\Facades\Auth::user()->role=='accounts')
                                    <div class="col-sm-9 text-secondary">
                                        <div class="dropdown dropdown-action float-right">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item btn_edit_vendor" title="Edit"
                                                    data="{{ $data['vendor']->id }}">
                                                    <i class="la la-pencil"></i></a>
                                                <a href="" class="dropdown-item btn_delete_vendor" title="Delete"
                                                    data="{{ $data['vendor']->id }}">
                                                    <i class="la la-trash"></i> </a>

                                            </div>
                                        </div>
                                        {{ $data['vendor']->email ? : 'Email' }}
                                    </div>
                                        @endif
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Phone</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $data['vendor']->contact ? : 'Contact' }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $data['vendor']->address ? : 'Address' }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">City</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $data['vendor']->city ? : 'City' }}
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Balance</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        @php
                                            $balance=App\Models\Ledger::countAccountsBalance('vendors',$data['vendor']->id);
                                        @endphp
                                        {{ number_format($balance,2)}}
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">A/C History</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <a href="{{url('account-history/'.$data['vendor']->id.'/vendors')}}" class="btn-primary"> History</a>
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
            <div id="edit_vendor_modal" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Vendor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="" id="EditVendorForm" class="needs-validation"
                                enctype="multipart/form-data" novalidate>
                                <input type="hidden" name="vendor_id">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for=""> Name</label>
                                            <input type="text" name="name" class="form-control" placeholder="Vendor Name"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for=""> Email</label>
                                            <input type="text" name="email" class="form-control" placeholder="Vendor Email">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for=""> Cnic</label>
                                            <input type="number" name="cnic" class="form-control" placeholder="Vendor Cnic">
                                        </div>
                                    </div>


                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for=""> Contact</label>
                                            <input type="number" name="contact" class="form-control"
                                                placeholder="Vendor Contact">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> City</label>
                                            <input type="text" name="city" class="form-control" placeholder="Vendor City">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Open Balance</label>
                                            <input type="number" name="open_bal" class="form-control"
                                                placeholder="Open Balance">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Address</label>
                                            <textarea name="address" class="form-control" cols="30" rows="4" placeholder="Vendor Address"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Image</label>
                                            <input type="file" name="image" id="pic" class="form-control" required>
                                            <span id="store_image"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn update_vendor" type="submit">Update</button>
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
            //Edit vendor
            $('#vendorTable').on('click', '.btn_edit_vendor', function(e) {
                e.preventDefault();

                var id = $(this).attr('data');

                $('#edit_vendor_modal').modal('show');

                $.ajax({

                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('edit-vendor') }}',
                    data: {
                        id: id
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        $('input[name=vendor_id]').val(data.id);
                        $('input[name=name]').val(data.name);
                        $('input[name=email]').val(data.email);
                        $('input[name=cnic]').val(data.cnic);
                        $('input[name=contact]').val(data.contact);
                        $('input[name=city]').val(data.city);
                        $('input[name=open_bal]').val(data.open_bal);
                        $('textarea[name=address]').val(data.address);
                        $('#store_image').html(
                            '<img src="{{ asset('storage/app/public/uploads/accounts/vendor/') }}/' +
                            data.image + '" class="mt-4 ml-4" width="40px" height="50px" />');
                        $('#store_image').append('<input type="hidden" name="hidden_image" value="' + data
                            .image + '" />');
                    },

                    error: function() {

                        toastr.error('something went wrong');

                    }

                });

            });

            //update vendor
            $('.update_vendor').on('click', function(e) {
                e.preventDefault();
                $('.update_vendor').text('Updating...');

                let EditFormData = new FormData($('#EditVendorForm')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('/update-vendor') }}",
                    data: EditFormData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(response) {

                        if (response.status == 200) {
                            $("#edit_vendor_modal").modal('hide');
                            $('#EditVendorForm').find('input').val("");
                            $('.update_vendor').text('Update');
                            toastr.success(response.message);
                            window.location.reload();
                        }
                    },
                    error: function() {
                        toastr.error('something went wrong');
                        $('.update_vendor').text('Update');
                    }
                });

            });


            // script for delete data
            $('#vendorTable').on('click', '.btn_delete_vendor', function(e) {
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
                            url: "{{ url('/delete-vendor/') }}/" + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status == 200) {
                                    toastr.success('data deleted successuflly');
                                    url = "{{url("vendors")}}";
                                    window.location = url;
                                }
                            }
                        });
                    }
                });

            });
        </script>
    @endsection
