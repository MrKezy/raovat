@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 bg-white pt-3 user-info">
            <h1>Thông tin</h1>
            <hr class="mt-0">
            <ul class="list-info">
                <li class="info-item">
                    <p> <i class="fa fa-star" aria-hidden="true"></i> Quyền hạn :
                        @if($user->role == 'admin')
                        <span class="badge badge-pill badge-danger">ADMIN</span>
                        @endif

                        @if($user->role == 'user')
                        <span class="badge badge-pill badge-primary">USER</span>
                        @endif

                        @if($user->role == 'block')
                        <span class="badge badge-pill badge-dark">BLOCK</span>
                        @endif
                    </p>
                </li>
                <li class="info-item">
                    <p> <i class="fa fa-user" aria-hidden="true"></i> Họ tên : {{$user->fullname}}</p>
                </li>
                <li class="info-item">
                    <p> <i class="fa fa-phone" aria-hidden="true"></i> Số điện thoại : @if($user->phone)
                        {{$user->phone}} @else Chưa cập nhập @endif</p>
                </li>
                <li class="info-item">
                    <p> <i class="fa fa-envelope-o" aria-hidden="true"></i> Email : {{$user->email}}</p>
                </li>
            </ul>
            @auth
            @if(Auth::user()->id == $user->id)
            <div class="text-center"><a href="{{route('userEdit')}}" class="btn btn-primary mb-3"><i
                        class="fa fa-pencil-square-o" aria-hidden="true"></i> Sửa thông tin</a>
            </div>
            @endif
            @endauth
        </div>
        <div class="col-md-8 bg-white pt-3 user-post-list">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="mt-1 mb-3">{{$title}}</h3>
                </div>
                <div class="col-md-6 text-right">
                    @auth
                    <a href="{{route('post.create')}}" class="btn btn-success"><i class="fa fa-plus-circle"
                            aria-hidden="true"></i> Đăng tin mới</a>
                    @endauth
                    @guest
                    <a href="{{route('login')}}" class="btn btn-success"><i class="fa fa-sign-in"
                            aria-hidden="true"></i> Đăng nhập</a>
                    @endguest
                </div>
            </div>
            <hr class="mt-0">
            <ul class="list-post">
                @foreach ($posts as $post)
                <li class="item-post">
                    @auth
                    @if (Auth::user()->can('update', $post))
                    <a href="{{route('post.edit',['post' => $post->id])}}" class='btn btn-success button-info'><i
                            class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    @endif
                    @if (Auth::user()->can('delete', $post))
                    <a class="btn btn-danger button-info" href="#" onclick="event.preventDefault();
                    document.getElementById('deletePost-{{$post->id}}').submit();"><i class="fa fa-trash-o"
                            aria-hidden="true"></i>
                    </a>
                    @endif
                    @endauth
                    <i class="fa fa-caret-right" aria-hidden="true"></i>
                    @if($post->is_vip) <span class="badge badge-pill badge-danger d-inline">VIP</span> @endif
                    <a href="{{route('post.show',['post' => $post->id])}}" class="link-post"
                        title="{{Str::title($post->title)}}">
                        <h5>{{Str::title($post->title)}}</h5>
                    </a>
                    - Ngày hết hạn :
                    @if($post->validate) <b>
                        {{ date('d-m-Y', strtotime($post->validate)) }}
                    </b> @else <b>
                        Không có </b>
                    @endif
                </li>
                <form id="deletePost-{{$post->id}}" action="{{ route('post.destroy',['post' => $post->id]) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')
                </form>
                @endforeach
            </ul>
            {{$posts}}
        </div>
    </div>
</div>
@endsection