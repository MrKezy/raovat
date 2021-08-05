@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row bg-white pt-3">
        @if (session('notice'))
        <div class="col-md-12">
            <div class="alert alert-{{session('status')}}" role="alert">
                <i class="fa fa-bell" aria-hidden="true"></i> {{session('notice')}}
            </div>
        </div>
        @endif
        <div class="col-md-8 post-right">
            <div class="col-md-12">
                <h1>{{Str::title($post->title)}}</h1>
                <hr>
            </div>
            <div class="col-md-12 content-post">
                {!! $post->content !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-6">
                        <h1>Chi tiết</h1>
                    </div>
                    <div class="col-6 text-right">
                        <a href="
                        @if(url()->current() == url()->previous())
                        {{ route('home')}}
                        @else
                        {{url()->previous()}}
                        @endif
                        " class="btn btn-warning"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Quay
                            lại</a>
                    </div>
                </div>
                <hr>
            </div>
            <div class="col-md-12">
                <ul class="list-info">
                    <li class="info-item">
                        <p> <i class="fa fa-star" aria-hidden="true"></i> Quyền hạn :
                            @if($post->users->role == 'admin')
                            <span class="badge badge-pill badge-danger">ADMIN</span>
                            @endif

                            @if($post->users->role == 'user')
                            <span class="badge badge-pill badge-primary">USER</span>
                            @endif

                            @if($post->users->role == 'block')
                            <span class="badge badge-pill badge-dark">BLOCK</span>
                            @endif
                        </p>
                    </li>
                    <li class="info-item">
                        <p> <i class="fa fa-user" aria-hidden="true"></i> Người đăng : <b><a
                                    href="{{route('viewInfo',['id' => $post->user_id])}}">{{$post->users->fullname}}</a></b>
                        </p>
                    </li>
                    <li class="info-item">
                        <p> <i class="fa fa-phone" aria-hidden="true"></i> Số điện thoại : @if($post->users->phone)
                            <b>{{$post->users->phone}}</b> @else <b>Chưa cập nhập</b> @endif</p>
                    </li>
                    <li class="info-item">
                        <p> <i class="fa fa-envelope-o" aria-hidden="true"></i> Email : <b>{{$post->users->email}}</b>
                        </p>
                    </li>
                </ul>
                <hr>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-6">
                        <h1>Chi tiết</h1>
                    </div>
                    <div class="col-6 text-right">
                        @auth
                        @if (Auth::user()->can('update', $post))
                        <a href="{{route('post.edit',['post' => $post->id])}}" class='btn btn-success'><i
                                class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        @endif
                        @if (Auth::user()->can('delete', $post))
                        <a class="btn btn-danger" href="#" onclick="event.preventDefault();
                        document.getElementById('deletePost').submit();"><i class="fa fa-trash-o"
                                aria-hidden="true"></i>
                        </a>
                        <form id="deletePost" action="{{ route('post.destroy',['post' => $post->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                        @endif
                        @endauth
                    </div>
                </div>
                <hr>
                <ul class="list-info">
                    <li class="info-item">
                        <i class="fa fa-caret-right" aria-hidden="true"></i> Chuyên mục :
                        @foreach($post->categories as $category)
                        <a href="{{route('category.show',['category'=> $category->id])}}" class="category_tag"><b
                                class="category">{{$category->name}}</b></a>
                        @endforeach
                    </li>
                    <hr>
                    <li class="info-item">
                        <i class="fa fa-caret-right" aria-hidden="true"></i> Tỉnh / Thành phố :
                        <b>{{$post->provinces->name}}</b></b>
                    </li>
                    <li class="info-item">
                        <i class="fa fa-caret-right" aria-hidden="true"></i> Quận / Huyện :
                        <b>{{$post->districts->name}}</b></b>
                    </li>
                    <li class="info-item">
                        <i class="fa fa-caret-right" aria-hidden="true"></i> Phường / Xã :
                        <b>{{$post->wards->name}}</b></b>
                    </li>
                    <hr>
                    <li class="info-item">
                        <i class="fa fa-caret-right" aria-hidden="true"></i> Loại tin :

                        @if($post->users->role != 'block')
                        @if($post->is_vip == 1)
                        <span class="badge badge-pill badge-danger">VIP</span>
                        @endif

                        @if(($post->is_vip == 0) && ($post->reg_vip) == 1)
                        <span class="badge badge-pill badge-success">Chờ duyệt VIP</span>
                        @endif


                        @if($post->reg_vip == 0)
                        <span class="badge badge-pill badge-primary">Thường</span>
                        @endif

                        @else
                        <span class="badge badge-pill badge-dark">Bị khóa</span>
                        @endif

                    </li>
                    <li class="info-item">
                        <i class="fa fa-caret-right" aria-hidden="true"></i> Ngày hết hạn :

                        @if($post->validate == null)

                        <b>Không có</b>

                        @elseif($post->validate < now()) <b class="text-danger">Đã hết hạn </b>

                            @else

                            <b>{{ date('d-m-Y', strtotime($post->validate)) }}</b>

                            @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @endsection