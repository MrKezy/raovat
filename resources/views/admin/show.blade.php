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
                    <h1>Thống kê trang web</h1>
                    <hr>
                </div>
                @if($vips_reg > 0)
                <div class="col-12">
                    <div class="alert alert-warning">
                        <strong>Lưu ý !</strong> Bạn đang có <b class="alert-link">{{$vips_reg}}</b> bài viết chờ duyệt
                        VIP.
                    </div>
                </div>
                @endif
                <div class="col-12">
                    <div class="card-columns">
                        <div class="card bg-primary">
                            <div class="card-body text-center">
                                <h3 class="card-text">Có : <b class="text-white">{{$posts}}</b> bài viết thường</h3>
                            </div>
                        </div>
                        <div class="card bg-warning">
                            <div class="card-body text-center">
                                <h3 class="card-text">Có : <b class="text-success">{{$vips}}</b> bài viết được
                                    duyệt <span class="text-danger">VIP</span></h3>
                            </div>
                        </div>
                        <div class="card bg-success">
                            <div class="card-body text-center">
                                <h3 class="card-text">Có : <b class="text-white">{{$postvalidate}}</b> bài viết hết
                                    hạn</h3>
                            </div>
                        </div>
                        <div class="card bg-danger">
                            <div class="card-body text-center">
                                <h3 class="card-text">Có : <b class="text-white">{{$postblock}}</b> bài viết bị khóa
                                </h3>
                            </div>
                        </div>
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h3 class="card-text">Có : <b class="text-danger">{{$userblock}}</b> thành viên bị khóa
                            </div>
                        </div>
                        <div class="card bg-info">
                            <div class="card-body text-center">
                                <h3 class="card-text">Có : <b class="text-white">{{$users}}</b> thành viên hoạt động
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection