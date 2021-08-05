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
                    <h1>Quản lý thành viên</h1>
                    <hr>
                    @if(session('notice'))
                    <div class="alert alert-{{session('status')}}">
                        <i class="fa fa-bell" aria-hidden="true"></i> {!! session('notice') !!}
                    </div>
                    @endif
                </div>
                <div class="col-12">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Quyền hạn</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td><a href="{{route('viewInfo',['id' => $user->id])}}">{{$user->fullname}}</a></td>
                                <td>{{$user->email}}</td>
                                <th>
                                    @if($user->role == 'admin')
                                    <span class="badge badge-pill badge-danger">ADMIN</span>
                                    @endif

                                    @if($user->role == 'user')
                                    <span class="badge badge-pill badge-primary">USER</span>
                                    @endif

                                    @if($user->role == 'block')
                                    <span class="badge badge-pill badge-dark">BLOCK</span>
                                    @endif

                                </th>
                                <td>
                                    <a href="{{route('admin.user.show',['id' => $user->id])}}"
                                        class="btn btn-success button-info" title="Sửa bài viết"><i
                                            class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    @if($user->role != 'block')
                                    <a href="{{route('admin.user.lock',['id' => $user->id])}}"
                                        class="btn btn-dark button-info @if(Auth::user()->id == $user->id) disabled @endif"
                                        title="Khóa thành viên"><i class="fa fa-lock" aria-hidden="true"></i></a>
                                    @else
                                    <a href="{{route('admin.user.unlock',['id' => $user->id])}}"
                                        class="btn btn-secondary button-info @if(Auth::user()->id == $user->id) disabled @endif"
                                        title="Mở khóa thành viên"> <i class="fa fa-unlock-alt"
                                            aria-hidden="true"></i></a>
                                    @endif

                                    @if($user->role != 'admin')
                                    <a href="{{route('admin.user.up',['id' => $user->id])}}"
                                        class="btn btn-danger button-info @if(Auth::user()->id == $user->id) disabled @endif"
                                        title="Nâng quyền Admin"><i class="fa fa-level-up" aria-hidden="true"></i></a>
                                    @else
                                    <a href="{{route('admin.user.down',['id' => $user->id])}}"
                                        class="btn btn-warning button-info @if(Auth::user()->id == $user->id) disabled @endif"
                                        title="Hạ quyền Admin"> <i class="fa fa-level-down" aria-hidden="true"></i></a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$users}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection