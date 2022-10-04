@extends('setup.master')
@section('content')



    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Customer Survey</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Customer Survey</li>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr class="font-weight-bold">
                                <th>#</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Project</th>
                                <th>Date</th>
                                <th>Size</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="taskTable">
                            @isset($cs)
                                @foreach ($cs as $key => $c)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $c->name }}</td>
                                        <td>{{ $c->contact }}</td>
                                        <td>{{ $c->project }}</td>
                                        <td>{{ $c->date }}</td>
                                        <td>{{ $c->size }} Marla</td>

                                        <td>
                                            @php


                                                if ($c->status =='not approach') {
                                                    echo '<span class="badge bg-inverse-danger">' .strtoupper( $c->status) . '</span></br>';
                                                } else {
                                                    echo '<span class="badge bg-inverse-info">'.strtoupper($c->status).'</span>';
                                                }
                                            @endphp

                                        </td>
                                        <td class="text-right">

                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                   aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="{{ url('survey-remarks/'.encrypt($c->id)) }}"
                                                       class="dropdown-item bg-inverse-primary" title="Create Survey Comment">Interested</a>

                                                    <a href="{{ url('not-intrested/'.encrypt($c->id)) }}"
                                                       class="dropdown-item bg-inverse-primary" title="Create Survey Comment">Not Interested</a>
                                                    <a href="{{ url('not-connected/'.encrypt($c->id))}}"
                                                       class="dropdown-item bg-inverse-primary" title="Create Survey Comment">Not Connected</a>



                                                </div>
                                            </div>
                                        </td>


                                    </tr>
                                @endforeach
                            @endisset

                            <tr>
                                <td colspan="12">
                                    <div class="float-right">
                                        {{ $cs->links('pagination::bootstrap-4') }}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
