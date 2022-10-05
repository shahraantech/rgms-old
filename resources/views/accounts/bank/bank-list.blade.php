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
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Bank List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Bank List</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{url('/bank')}}" class="btn add-btn" title="Add Bank"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>

        </div>


            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-hover" id="datatable">

                        <tr>
                            <th>SR#</th>
                            <th>Bank</th>
                            <th>Balance</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        <tbody id="accountTable">
                        @php $c=0; @endphp
                        @isset($data['branches'])
                            @foreach($data['branches'] as $row)
                                @php $c++; @endphp
                                <tr>
                                    <td>{{$c}}</td>
                                    <td>
                                        @php
                                       $headName=App\Models\Ledger::getLevelHeadName($row->level_no,$row->head_id);
                                      $balance=App\Models\Ledger::countAccountsBalance('bank',$row->id);

                                            @endphp
                                        {{$headName}}
                                    </td>

                                    <td>PKR {{number_format($balance,2)}}</td>
                                    <td>{{$row->created_at}}</td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{url('account-history/'.$row->id.'/bank')}}" class="dropdown-item" title="History"><i class="la la-history"></i></a>
                                                @if(\Illuminate\Support\Facades\Auth::user()->role=='accounts')
                                                <a href="#" class="dropdown-item btn_delete_account" title="Delete"
                                                   data="{{ $row->id }}"><i class="la la-trash"></i>
                                                    </a>
                                                    @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endisset
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {

                // script for delete data
                $('#accountTable').on('click', '.btn_delete_account', function(e) {
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
                                data: {
                                    id: id
                                },
                                url: '{{ url('delete-bank') }}',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType: "json",
                                success: function(response) {
console.log(response);
                                    if (response.success) {
                                        toastr.success(response.success);
                                        window.location.reload();
                                    } else {
                                        toastr.error(response.errors);
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
@endsection
