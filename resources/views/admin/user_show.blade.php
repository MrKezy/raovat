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
                    <h1>Sửa thông tin cá nhân của {{$user->fullname}}</h1>
                    <hr>
                    @if(session('notice'))
                    <div class="alert alert-success">
                        <i class="fa fa-bell" aria-hidden="true"></i> {!! session('notice') !!}
                    </div>
                    @endif
                </div>
                <div class="col-12">
                    <form action="{{ route('admin.user.store',['id' => $user->id]) }}" method="POST" class="row">
                        @csrf
                        <input type="hidden" id="id" name="id" value="{{$user->id}}">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fullname">Họ tên :</label>
                                <input type="text" id="fullname"
                                    class="form-control @error('fullname') is-invalid @enderror" name="fullname"
                                    value="{{$user->fullname}}">
                                @error('fullname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Tên đăng nhập :</label>
                                <input type="text" id="username" class="form-control " name="username"
                                    value="{{$user->username}}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email :</label>
                                <input type="text" id="email" class="form-control" name="email" value="{{$user->email}}"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Số điện thoại :</label>
                                <input type="text" id="phone" class="form-control" name="phone" value="{{$user->phone}}"
                                    @if($user->phone != null)disabled @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="google">Google Account :</label>
                                <input type="text" id="google" class="form-control" name="google_id"
                                    value="@if($user->google_id != null){{$user->google_id}} @else Chưa kết nối @endif"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="google">Facebook Account :</label>
                                <input type="text" id="Facebook" class="form-control" name="facebook_id"
                                    value="@if($user->facebook_id != null){{$user->google_id}} @else Chưa kết nối @endif"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Mật khẩu :</label>
                                <input type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password-confirm">Nhập lại mật khẩu :</label>
                                <input id="password-confirm" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="col-md-12 text-center mb-3">
                            <a href="{{route('admin.user')}}" class="btn btn-warning"><i
                                    class="fa fa-chevron-circle-left" aria-hidden="true"></i> Quay lại</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i>
                                Cập nhập thông tin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection