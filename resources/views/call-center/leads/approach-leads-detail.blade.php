@extends('setup.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Leads Details</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Leads Details</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="card mb-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                        <a href="#">
                                            <img alt=""
                                                 src="{{ asset('storage/app/public/uploads/staff-images/user1-128x128.png') }}"></a>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0">
                                                    {{ $data['lead'] ? $data['lead']->name : '' }}
                                                </h3>
                                                <h6 class="text-muted"></h6>
                                                <small class="text-muted"></small>
                                                <div class="staff-id">Lead ID
                                                    :{{ $data['lead'] ? $data['lead']->id : '' }}
                                                </div>
                                                <div class="small doj text-muted">Date :
                                                    {{ $data['lead'] ? $data['lead']->created_at : '' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Phone:</div>
                                                    <div class="text"><a
                                                            href="">{{ $data['lead'] ? $data['lead']->contact : '' }}</a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Email:</div>
                                                    <div class="text"><a
                                                            href="">{{ $data['lead'] ? $data['lead']->email : '' }}</a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">City:</div>
                                                    <div class="text">
                                                        {{ $data['lead'] ? $data['lead']->cityname['city_name'] : '' }}
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Query:</div>
                                                    <div class="text">
                                                        {{ $data['lead'] ? $data['lead']->interest : '' }}
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content">

                <!-- Profile Info Tab -->
                <div id="emp_profile" class="pro-overview tab-pane fade show active">
                    <h4>Leads Information </h4>

                    <div class="row">
                        @isset($data['approached_leads'])
                            @foreach ($data['approached_leads'] as $leads)
                                <div class="col-md-4 d-flex">
                                    <div class="card profile-box flex-fill">
                                        <div class="card-body">
                                            <span class="card-title">
                                                     @php
                                                         $res=App\Models\QaFeedBack::where('approach_id',$leads->id)->first();

                                                     @endphp
                                                @if(!$res)
                                                    @if(Auth::user()->role=='call-center')
                                                        <div class="pro-edit float-right">
                                               <small>
                                                      <a href="#" data="{{$leads->id}}" data-toggle="modal" data-target="#add_leave" title="Give Feedback" class="btnFeedBack"><i class="fa fa-plus"></i></a>
                                               </small></div>
                                                    @endif
                                                @endif
                                                <small
                                                    class="text-secondary">{{ $leads->created_at }}</small></span>
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Approached By.</div>
                                                    <div class="text badge bg-inverse-info">{{ $leads->agent['name'] }}</div>
                                                </li>
                                                <li>
                                                    <div class="title">Temperature</div>
                                                    <div class="text">
                                                        <div class="text badge bg-inverse-warning">{{ $leads->temp['temp'] }}
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Lead Type.</div>
                                                    @php
                                                        if ($data['lead']->lead_type == 'Inbound') {
                                                        echo '
                                                        <div class="text badge bg-inverse-success">' . strtoupper($data['lead']->lead_type) . '</div>
                                                        ';
                                                        } else {
                                                        echo '
                                                        <div class="text badge bg-inverse-primary">' . strtoupper($data['lead']->lead_type) . '</div>
                                                        ';
                                                        }
                                                    @endphp
                                                </li>
                                                <li>
                                                    <div class="title">Next Followup</div>
                                                    <div class="text">
                                                        {{ date('d-M-Y', strtotime($leads->followup_date)) }}
                                                        {{ $leads->follow_time }}
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="title" style="font-weight: bold;"><i class="la la-comments-o" aria-hidden="true"></i></div>
                                                    <div class="text">{{ $leads->comments }}</div>
                                                </li>
                                                @if(!empty($leads->audio))
                                                    <li>
                                                        <div class="text">
                                                            <audio controls>
                                                                <source src="{{asset('storage/app/public/uploads/leedRecording/').'/'.$leads->audio}}" type="audio/ogg">
                                                                Your browser does not support the audio element.
                                                            </audio>
                                                        </div>
                                                    </li>
                                                @endif


                                                <div class="title" style="    font-weight: bold;"><i class="la la-phone"></i></div>

                                                @if(!empty($leads->audio_call_rec))
                                                    <li>
                                                        <div class="text">
                                                            <audio controls>
                                                                <source src="data:audio/mpeg;base64,{{  $leads->audio_call_rec}}" type="audio/ogg">
                                                                Your browser does not support the audio element.
                                                            </audio>
                                                        </div>
                                                    </li>

                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endisset
                    </div>
                </div>
                <!-- /Profile Info Tab -->
            </div>
        </div>
    </div>

    <div id="add_leave" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">QA Feedback</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="modalDismiss">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="ratingForm" action="{{url('qa-feedback')}}" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="hidden_call_id" >
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Rating <span class=""></span></label>
                                <input type="text" class="ratingEvent rating5" value="1" name="rating" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label>Remarks <span class="text-danger">*</span></label>
                                <textarea name="remarks" cols="10" rows="3" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn" type="submit" id="btnSubmit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">


        $('.btnFeedBack').on('click', function() {
            var call_id = $(this).attr('data');
            $('input[name=hidden_call_id]').val(call_id);

        });


        $('#ratingForm').unbind().on('submit', function(e) {
            e.preventDefault();
            var formData = $('#ratingForm').serialize();
            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{ url('qa-feedback') }}',
                data: formData,
                async: false,
                dataType: 'json',
                beforeSend: function() {
                    $(".btnFeedBack").prop("disabled", true);
                    $(".btnFeedBack").html("processing...");

                },
                success: function(data) {
                    if (data.success) {
                        $('.close').click();
                        toastr.success(data.success);
                    }
                    if (data.errors) {
                        toastr.error(data.errors);
                    }
                },
                complete: function(data) {
                    $(".btnFeedBack").html("<i class='fa fa-plus'></i>");
                    $(".btnFeedBack").prop("disabled", false);
                },
                error: function() {
                    toastr.error('something went wrong');
                },
            });
        });

        $(function() {
            $('.rating').rating();

            $('.ratingEvent').rating({
                rateEnd: function(v) {
                    $('#result').text(v);
                }
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
@endsection
