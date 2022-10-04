@extends('setup.master')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
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
                    <h3 class="page-title bold-heading">Commission Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Commission Report</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">

            <div class="card-body">


                <table class="table table-striped table-hover" id="payments-list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>INV#</th>
                            <th>Sales Person</th>
                            <th>Commission</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $total=0;
                        @endphp
                        @isset($data['commission'])
                        @foreach($data['commission'] as $key=>$val)
                            @php $total=$total+$val['commission'] @endphp
                           {{($val['status']=='Paid')?$className='success': $className='danger'}}
                               <tr>
                       <td>{{$key+1}}</td>
                       <td>{{$val['inv']}}</td>
                       <td>{{$val['sp_name']}}</td>
                       <td>{{number_format($val['commission'],2)}}</td>
                                   <td>{{$val['date']}}</td>
                                   <td><span class="badge bg-inverse-{{$className}}">{{$val['status']}}</span> </td>

                           </tr>
                       @endforeach
                       @endisset

                       <tr>
                           <td>
                               <div class="float-right"> <strong>Total:</strong></div>
                           </td>
                           <td colspan="3">
                               <div class="float-right"> <strong>PKR:{{number_format($total,2)}}</strong></div>
                               </td>
                       </tr>
                   </tbody>
               </table>
           </div>

       </div>
   </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type='text/javascript'>
   $(document).ready(function() {

       $('select[name=ac_type]').change(function() {

           var ac_type = $('select[name=ac_type]').val();

           $.ajax({

               type: 'ajax',
               method: 'get',

               url: '{{url("/getAccountsName")}}',

               data: {
                   ac_type: ac_type
               },

               async: false,

               dataType: 'json',

               success: function(response) {

                   var html = '<option value="">Choose One</option>';

                   var i;
                   if (response.length > 0) {

                       for (i = 0; i < response.length; i++) {

                           html += '<option value="' + response[i].id + '">' + response[i].name + '</option>';

                       }
                   } else {
                       var html = '<option value="">Choose One</option>';
                       toastr.error('data not found');
                   }


                   $('#showAccounts').html(html);

               },

               error: function() {

                   toastr.error('data not found');

               }

           });
       });

       //Datatables
       $('#payments-list').DataTable();
   });
</script>
@endsection
