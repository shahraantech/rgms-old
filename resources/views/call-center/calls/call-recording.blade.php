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
                            <h3 class="page-title bold-heading">Call Recording</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Call Recording</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_department"
                               title="Add Inbound Leads"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover data-table" >
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Phone</th>
                                <th>Rec</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody id="leadsTable">
                            @php $c=0 @endphp
                            @isset($data)
                                @foreach($data['callRecording'] as $key => $row)
                                    @php $c++ @endphp
                                    <tr>
                                       <td>{{$c}}</td>
                                       <td>{{$row->phone}}</td>
                                       <td>
                                           <audio controls>
                                               <source src="{{asset('storage/app/public/uploads/call-recordings/').'/'.$row->audio_file}}" type="audio/ogg">
                                               Your browser does not support the audio element.
                                           </audio>

                                           </td>
                                       <td>{{$row->created_at}}</td>

                                    </tr>
                                @endforeach
                            @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
        </div>


    </div>

    <div id="add_department" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Lead</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ url('call-recording') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="phone" placeholder="Phone" required>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Rec File <span class="text-danger"></span></label>
                                    <input class="form-control" type="file" name="file">

                                </div>
                            </div>

                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary" type="submit" id="btnSubmit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
