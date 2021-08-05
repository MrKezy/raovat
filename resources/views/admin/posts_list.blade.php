@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row bg-white">
        <div class="col-3 user-info pt-3">
            @include('admin.menu')
        </div>
        <div class="col-9 pt-3">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            <h1>Quản lý bài viết</h1>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{route('post.create')}}" class="btn btn-success"><i class="fa fa-plus-circle"
                                    aria-hidden="true"></i> Đăng tin
                                mới</a>
                        </div>
                    </div>
                    <hr class="m-2">
                    @if(session('notice'))
                    <div class="alert alert-success">
                        {!! session('notice') !!}
                    </div>
                    @endif
                </div>
                <div class="col-12">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Ngày hết hạn</th>
                                <th>Trạng Thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                            <tr>
                                <td>{{$post->id}}</td>
                                <td>
                                    <a href="{{route('viewInfo',['id' => $post->users->id])}}" target="_blank"><span
                                            class="badge badge-pill badge-warning">{{$post->users->fullname}}</span></a>
                                    <a href="{{route('post.show',['post' => $post->id])}}" title="{{$post->title}}">
                                        {{Str::substr($post->title,0,40)}}
                                        @if(Str::length($post->title) > 40)
                                        ...
                                        @endif
                                    </a></td>
                                <td>

                                    @if($post->validate == null)

                                    Không có

                                    @elseif($post->validate < now()) <b class="text-danger">Đã hết hạn </b>

                                        @else

                                        <b>{{ date('d-m-Y', strtotime($post->validate)) }}</b>

                                        @endif

                                </td>
                                <td>
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
                                </td>
                                <td>
                                    <a href="{{route('post.edit',['post' => $post->id])}}"
                                        class="btn btn-success button-info"><i class="fa fa-pencil-square-o"
                                            aria-hidden="true"></i></a>
                                    @if($post->is_vip)
                                    <a href="{{route('admin.post.check',['id' => $post->id])}}"
                                        class="btn btn-warning button-info" title="Hạ Vip"> <i class="fa fa-level-down"
                                            aria-hidden="true"></i></a>
                                    @else
                                    <a href="{{route('admin.post.check',['id' => $post->id])}}"
                                        class="btn btn-danger button-info @if($post->users->role == 'block') disabled @elseif($post->validate < now() && $post->validate != null) disabled @endif"
                                        title="Nâng Vip"> <i class="fa fa-level-up" aria-hidden="true"></i></a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$posts}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection