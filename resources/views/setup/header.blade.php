<!-- Header -->
<div class="header">

    <div class="header-left">
        <a href="{{url('/')}}" class="logo">
            <div class="page-title-box">
                    <h3>RGMS</h3>

            </div>

        </a>
    </div>
    <!-- /Logo -->
    <a id="toggle_btn" href="javascript:void(0);">
   <span class="bar-icon">
   <span></span>
   <span></span>
   <span></span>
   </span>
    </a>


    <!-- /Header Title -->
    <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
    <!-- Header Menu -->
    <ul class="nav user-menu">

        <!-- /Flag -->
        <!-- Notifications -->
        <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <i class="fa fa-bell"></i> <span class="badge badge-danger countNotification"></span>
            </a>

            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Notifications</span>
                    <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                </div>

                <div class="noti-content">
                    <ul class="notification-list" id="notifyTable">

                    </ul>
                </div>


                <div class="topnav-dropdown-footer">
                    <a href="#">View all Notifications</a>
                </div>
            </div>
        </li>
        <!-- /Notifications -->


        <li class="nav-item dropdown">
            <a href="{{url('chat')}}" class="" data-toggle="">
                <i class="fab fa-facebook-messenger"></i>
                <span class="badge badge-danger countMessage"></span>
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Messages</span>
                    <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                </div>

                <div class="noti-content">
                    <ul class="notification-list" id="messageTable">

                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="{{url('chat')}}">View all Messages</a>
                </div>
            </div>
        </li>
        <!-- /Message Notifications -->
        <!-- Message Notifications -->
        <!-- /Message Notifications -->
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                @if(auth())
                    @php
                        $id=auth()->user()->account_id;
                        $res= App\Models\Employee::find($id);
                        if($res){
                        $image=$res->image;
                        }else{
                        $image='user1-128x128.png';
                        }
                    @endphp
                @endif
                <span class="user-img"><img src="{{asset('storage/app/public/uploads/staff-images/').'/'.$image}}" >
         <span class="status online"></span></span>
                <span>    @if(auth()) {{auth()->user()->name}} @endif </span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{url('my-profile')}}">My Profile</a>
                <a class="dropdown-item" href="{{url('logout')}}">Logout</a>
            </div>
        </li>
    </ul>
    <!-- /Header Menu -->
    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{url('my-profile')}}">My Profile</a>
            <a class="dropdown-item" href="{{url('logout')}}">Logout</a>
        </div>
    </div>
    <!-- /Mobile Menu -->
</div>



<script>
    $(function() {

        //
        // setInterval(function() {
        //     $.load(countNotification(),countMessage())
        //
        // }, 1000);


        countNotification();
        countMessage();

        function countNotification() {

            $.ajax({

                url: '{{url("countNotification")}}',
                type: 'get',
                success: function(response) {

                   $('.countNotification').html(response['notification'].length);

                    var html = '';
                    var i;
                    var c = 0;

                    for (i = 0; i < response['notification'].length; i++) {

                        c++;

                        html += '<li class="notification-message">'+
                            '<a href="#">'+
                            '<div class="media">'+
                            '<span class="">'+
                            '<img alt="" src="storage/app/public/uploads/staff-images/' + response['notification'][i].image + '" class="target-img">'+
                            '</span>'+
                            '<div class="media-body">'+
                            '<p class="noti-details"><span class="noti-title">'+response['notification'][i].name+'</span> added new  ' +
                            '<span class="noti-title">'+response['notification'][i].message+'</span></p>'+
                            ' <p class="noti-time"><span class="notification-time">'+response['notification'][i].time+'</span></p>'+
                            '</div>'+
                            '</div>'+
                            '</a>'+
                            '</li>';
                    }


                    $('#notifyTable').html(html);
                },

            });
        };


        function countMessage() {

            $.ajax({

                url: '{{url("countMessage")}}',
                type: 'get',
                success: function(response) {


                    $('.countMessage').html(response['message'].length);

                    var html = '';
                    var i;
                    var c = 0;

                    for (i = 0; i < response['message'].length; i++) {

                        c++;


                        html += '<li class="notification-message">'+
                            '<a href="chat.html">'+
                            '<div class="list-item">'+
                            '<div class="list-left">'+
                            '<span class="">'+
                            '<img alt="" src="storage/app/public/uploads/staff-images/' + response['message'][i].image + '" class="target-img">'+
                            '</span>'+
                            '</div>'+
                            '<div class="list-body">'+
                            '<span class="message-author">'+response['message'][i].name+'</span>'+
                            '<span class="message-time">'+response['message'][i].time+'</span>'+
                            '<div class="clearfix"></div>'+
                            '<span class="message-content">'+response['message'][i].message+'</span>'+
                        '</div>'+
                        '</div>'+
                        '</a>'+
                        '</li>';
                    }


                    $('#messageTable').html(html);
                },

            });
        };


    });

</script>
