@extends('setup.master')

@section('content')


    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Edit Leads</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Leads</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ url('update-leeds/' . $lead->id) }}" class="needs-validation"
                        id="leadsForm">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Add Project Manager</label>
                                    <select class="select select2" name="manager_id" required>
                                        <option value="">Choose Manager</option>
                                        @isset($employee)
                                            @foreach ($employee as $emp)
                                                <option value="{{ $emp->id }}"
                                                    @if ($lead->leader_id == $emp->id) selected @endif>{{ $emp->name }}
                                                </option>
                                            @endforeach
                                        @endisset

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Team Leader</label>

                                    <select class="form-control form-control-sm select2" multiple="multiple"
                                        name="team_id[]" required>
                                        <option></option>

                                        @isset($employee)
                                            @foreach ($employee as $emp)
                                                <option value="{{ $emp->id }}"
                                                    @if (in_array($emp->id, $SelectedMonths)) selected @endif>{{ $emp->name }}
                                                </option>
                                            @endforeach
                                        @endisset


                                    </select>

                                </div>
                            </div>
                        </div>


                        <div class="submit-section">
                            <button class="btn btn-primary btn-submit" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
        <!-- /Page Content -->

    </div>






    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {

            $('.select2').select2({
                placeholder: "Please select here",
                width: "100%"
            });

        })
    </script>


@endsection
