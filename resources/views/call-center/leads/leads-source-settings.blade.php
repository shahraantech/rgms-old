@extends('setup.master')
@section('content')
    <div class="main-wrapper">
        <!-- /Sidebar -->
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <div class="page-header my-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title bold-heading">Source Leads Settings</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Source Leads Settings</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Auto Save</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $c=0 @endphp
                                @if ($data['csrs']->count() > 0)
                                    @foreach ($data['csrs'] as $csr)
                                        @php $c++ @endphp
                                        <tr>
                                            <td>{{ $c }}</td>
                                            <td>
                                                {{ $csr->name }}
                                            </td>
                                            @php
                                                $status='';
                                                $res = \App\Models\SourceLeadsSettings::where('agent_id', $csr->id)->first();
                                                
                                                if ($res && $res->auto_save == 1) {
                                                    $status="checked";
                                                }
                                            @endphp
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" {{ $status }} class="radio-button"
                                                        name="auto_save" data="{{ $csr->id }}">
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
        <!-- /Add Department Modal -->
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {


            $('.radio-button').on('change', function() {



                var csr_id = $(this).attr('data');
                var status = 0;
                ($(this).is(':checked')) ? status = 1: status = 0;

                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ url('update-source-leads-settings') }}',
                    data: {
                        csr_id: csr_id,
                        status: status
                    },
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
