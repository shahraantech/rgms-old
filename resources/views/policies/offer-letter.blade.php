@extends('setup.master')

@section('content')

    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Offer Letter</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Offer Letter</li>
                        </ul>
                    </div>


                </div>
            </div>
            <!-- /Page Header -->

            <!-- Search Filter -->
            <div class="card">
                <div class="card-body">
                    <form action="" class="needs-validation" novalidate id="letterForm" method="post">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <select class="form-control selectpicker" data-container="body" data-live-search="true"
                                        name="company_id" id="company_id" required>
                                        <option value="">Choose Company</option>
                                        @isset($data['company'])
                                            @foreach ($data['company'] as $comp)
                                                <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group form-focus select-focus">
                                    <select class="select floating emp_id" id="showEmployee" name="emp_id" required>
                                        <option value="">Select Employee</option>

                                    </select>
                                    <div id="empError"></div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                {{-- <a href="" class="btn btn-primary btn-block">Print</a> --}}
                                <button class="btn btn-primary btn-block" type="submit" id="btnPrint"><i
                                        class="fa fa-print" aria-hidden="true"></i></button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <!-- Search Filter -->

        </div>
        <!-- /Page Content -->




    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type='text/javascript'>
        $(document).ready(function() {

            //company_id dependent dropdown
            $('select[name=company_id]').change(function() {

                var company_id = $('select[name=company_id]').val();

                $.ajax({

                    type: 'ajax',

                    method: 'get',

                    url: '{{ url('/getEmpByCompany') }}',

                    data: {
                        company_id: company_id
                    },

                    async: false,

                    dataType: 'json',

                    success: function(data) {

                        var html = '<option value="">Choose Employee</option>';

                        var i;
                        if (data.length > 0) {

                            for (i = 0; i < data.length; i++) {

                                html += '<option value="' + data[i].id + '">' + data[i].name +
                                    '</option>';
                            }
                        } else {
                            var html = '<option value="">Choose Employee</option>';
                            toastr.error('data not found');
                        }


                        $('#showEmployee').html(html);

                    },

                    error: function() {

                        toastr.error('db error');


                    }

                });
            });



            $('#letterForm').unbind().on('submit', function(e) {
                e.preventDefault();
                var desig_id = $('select[name=designation]').val();
                var emp_id = $('select[name=emp_id]').val();

                var r = '';

                if (desig_id == '') {
                    var span = '<span style="color:red">field must be required</span>';
                    $('#desigError').html(span);
                } else {

                    $('#desigError').hide();
                    r += '1';
                }


                if (emp_id == '') {

                    var span = '<span style="color:red">field must be required</span>';
                    $('#empError').html(span);
                } else {

                    $('#empError').hide();
                    r += '1';
                }

                if (r == 11) {

                    var url = "{{ url('/offer-letter-create') }}" + '/' + emp_id;
                    window.location.href = url;
                }


            })




        })
    </script>
@endsection
