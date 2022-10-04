@extends('setup.master')
@section('content')



    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Servay Remarks</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Servay Remarks</li>
                        </ul>
                    </div>
                    
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                   <form action="{{ url('store-servay-remarks') }}" method="POST" id="remarksForm" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="servey_id" value="{{ $srmarks->id }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Age</label>
                                <input type="text" name="age" class="form-control" placeholder="Age" required>
                                <div class="invalid-feedback">
                                    Please Enter Age.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Address" required>
                                <div class="invalid-feedback">
                                    Please Enter Address.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Marital Status</label>
                                <select name="is_married" class="select" required>
                                    <option value="" selected disabled>Choose One</option>
                                    <option value="0">Married</option>
                                    <option value="1">Un Married</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please Select One.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Profession</label>
                                <input type="text" name="profession" class="form-control" placeholder="Profession" required>
                                <div class="invalid-feedback">
                                    Please Enter Profession.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Intrest</label>
                                <input type="text" name="intrest" class="form-control" placeholder="Intrest" required>
                                <div class="invalid-feedback">
                                    Please Enter Intrest.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Dependent</label>
                                <select name="is_dependent" class="select" required>
                                    <option value="" selected disabled>Choose One</option>
                                    <option value="0">Yes</option>
                                    <option value="1">No</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please Select One.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Remarks</label>
                                <input type="text" name="remarks" class="form-control" placeholder="Remarks" required>
                                <div class="invalid-feedback">
                                    Please Enter Remarks.
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary btn-submit">Save</button>
                    </div>

                   </form>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
    </div>


    <script>

        $(document).ready(function () {
            
            toastr.options.timeOut = 3000;
                @if (Session::has('error'))
                    toastr.error('{{ Session::get('error') }}');
                @elseif(Session::has('success'))
                    toastr.success('{{ Session::get('success') }}');
                @endif

        });

        $('.save_remarks').on('click', function() {
        $(".save_remarks").prop("disabled", true);
        $(".save_remarks").html("Please wait...");
        $('#remarksForm').submit();
    });

    </script>


@endsection
