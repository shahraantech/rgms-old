@extends('setup.master')
@section('content')
    <style type="text/css">
        body {
            font-family: Arial;
            font-size: 10pt;
        }

        table {
            border: 1px solid #ccc;
            border-collapse: collapse;
        }

        table th {
            background-color: #F7F7F7;
            color: #333;
            font-weight: bold;
        }

        table th,
        table td {
            padding: 5px;
            border: 1px solid #ccc;
        }
    </style>
    <div class="main-wrapper">

        <!-- /Sidebar -->
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
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
                        <div class="col-md-3 mt-2">
                            <div class="form-group">
                                <a class="btn btn-primary" data-toggle="modal" data-target="#import_leads" title="Import"><i
                                        class="fa fa-upload"></i></a>
                            </div>
                        </div>
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>

                                <th>SR#</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Project</th>
                                <th>Size</th>
                                <th>Date</th>
                                <th>Assigned To</th>
                                <th>Approached</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="leadsTable">
                            @php $c=0; @endphp
                            @isset($data['survey'])
                                @foreach ($data['survey'] as $leed)
                                    @php $c++ @endphp
                                    <tr>
                                        <td>{{$c}}</td>
                                        <td>{{ $leed->name }}</td>
                                        <td>{{ $leed->contact }}</td>
                                        <td>{{ $leed->project }}</td>
                                        <td>{{ $leed->size }}</td>
                                        <td>{{ $leed->date }}</td>

                                        <td>
                                            @php
                                            if($leed->agent_id > 0){
                                                    $emp = App\Models\Employee::find($leed->agent_id);
                                                    echo '<span class="badge bg-inverse-primary">' . $emp->name. '</span>';
                                                    } else {
                                                    echo '<span class="badge bg-inverse-danger">Open</span>';
                                                    }
                                            @endphp
                                        </td>
                                        <td>
                                            @php
                                                if($leed->status > 0){

                                                        echo '<span class="badge bg-inverse-success">Yes</span>';
                                                        } else {
                                                        echo '<span class="badge bg-inverse-danger">No</span>';
                                                        }
                                            @endphp
                                        </td>
                                        <td>
                                            @if($leed->status ==1)
                                            <a href="{{url('view-survey-remarks').'/'.encrypt($leed->id)}}"> <i class="fa fa-eye"></i></a>
                                                @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset

                            <tr>
                                <td colspan="12">
                                    <div class="float-right">
                                        {{ $data['survey']->links('pagination::bootstrap-4') }}
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
        <!-- /Add Department Modal -->
        <div id="import_leads" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import Survey Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                id="modalDismiss">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form action="{{ route('import-customer-survey') }}" method="POST" enctype="multipart/form-data"
                              class="needs-validation" novalidate id="ImportExcelForm">
                            @csrf
                            <div class="form-group">
                                <label>File <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" name="file" required id="csvFile">
                                <div class="invalid-feedback">
                                    Please enter excel file.
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary" type="submit" id="btnImportLeads">Upload</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    <script>


        $('#btnImportLeads').on('click', function() {

            if ($('#csvFile').val()) {
                $("#btnImportLeads").prop("disabled", true);
                $("#btnImportLeads").html("Please wait...");
                $('#ImportExcelForm').submit();
            } else {
                toastr.error('Excel file missing');
            }

        });

        @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
        toastr.error("{{ $error }}");
        @endforeach
        @endif


        @if (Session::has('success'))
        toastr.success("Data imported successfully!");
        @endif
    </script>

    @include('call-center.general.dont-copy');
@endsection
