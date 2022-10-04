@extends('setup.master')
@section('content')
    <div class="main-wrapper">
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Chat Main Row -->
            <div class="chat-main-row">
                <!-- Chat Main Wrapper -->
                <div class="chat-main-wrapper">
                    <div class="col-lg-9 message-view task-view">

                    </div>
                    <!-- Chat Right Sidebar -->
                    <div class="col-lg-3 message-view chat-profile-view chat-sidebar" id="task_window">
                        <div class="chat-window video-window">
                            <div class="fixed-header">
                                <ul class="nav nav-tabs nav-tabs-bottom">
                                    <li class="nav-item"><a class="nav-link" href="#calls_tab" data-toggle="tab">People</a></li>
                                </ul>
                            </div>
                            <div class="tab-content chat-contents">
                                <div class="sidebar-menu">
                                    <ul>
                                        @isset($data['users'])
                                        @foreach($data['users'] as $user)
                                        <li>
                                            <a href="{{url('public/messenger/').'/'.$user['id']}}" target="_blank">
                              <span class="chat-avatar-sm user-img">
                              <img class="avatar av-l upload-avatar-preview" alt="" src="{{asset('public/storage/users-avatar/').'/'.$user['avatar']}}">
                              <span class="status away"></span>
                              </span>
                                                <span class="chat-user">{{$user['name']}}
                                                    @if($user['countMessage'] > 0)
                                                    <small class="badge badge-danger ">{{$user['countMessage']}}</small>
                                                        @endif
                                                </span>
                                            </a>
                                        </li>

                                            @endforeach
                                        @endisset
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Chat Right Sidebar -->
                </div>
                <!-- /Chat Main Wrapper -->
            </div>
            <!-- /Chat Main Row -->
        </div>
        <!-- /Page Wrapper -->
    </div>
@endsection
