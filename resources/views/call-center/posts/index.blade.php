
@extends('setup.master')
@section('content')

    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">

            <div class="page-header my-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title bold-heading">Posts</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add New Post</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{url('/create-post')}}" class="btn add-btn" title="Add Post"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="row staff-grid-row">
                @isset($data['posts'])
                    @foreach($data['posts'] as $post)
                        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                            <div class="profile-widget">
                                <div class="profile-img">
                                    <a href="">
                                        <img src="{{asset('storage/app/public/uploads/social-posts/').'/'.$post->image}}" class="social-media-post" alt="">
                                    </a>
                                </div>
                                <div class="dropdown profile-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">

                                        <a class="dropdown-item" href="https://www.facebook.com/sharer/sharer.php?u={{asset('storage/app/public/uploads/social-posts').'/'.$post->image}}" target="_blank" ><i class="fa fa-pencil m-r-5"></i> Facebook</a>
                                        <a class="dropdown-item btn-delete" href="#" ><i class="fa fa-trash-o m-r-5"></i>Instagram</a>
                                        <a class="dropdown-item btn-delete" href="#" ><i class="fa fa-trash-o m-r-5"></i>Whatsapp</a>
                                        <a class="dropdown-item btn-delete" href="#" ><i class="fa fa-trash-o m-r-5"></i>Twiter</a>
                                    </div>
                                </div>
                                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="{{url('profile')}}">{{$post->title}}</a></h4>
                                <div class="small text-muted">{{substr($post->desc,0,30)}}</div>
                            </div>
                        </div>
                    @endforeach
                @endisset
            </div>
        </div>
    </div>
@endsection
