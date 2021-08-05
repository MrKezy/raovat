@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pt-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Danh mục rao vặt </h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('home')}}" class="btn btn-warning"><i class="fa fa-chevron-circle-left"
                                    aria-hidden="true"></i> Trang chủ</a>
                        </div>
                    </div>
                </div>
                <ul class="list-post mt-3">
                    @foreach ($categories as $category)
                    <li class="item-post">
                        <i class="fa fa-folder-open" aria-hidden="true"></i>
                        <a href="{{route('category.show',['category' => $category->id])}}" class="link-post"
                            title="{{Str::title($category->name)}}">
                            <h5>{{Str::title($category->name)}}</h5>
                        </a>
                        - Số tin rao vặt :
                        {{
                        count($category->posts()->whereHas('users', function ($query) {
                            $query->where('role', '!=', 'block');
                        })->get());
                        }}
                    </li>
                    @endforeach
                </ul>
                {{$categories}}
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pt-3">
                    <h4>Tin rao vặt <b style="color:red">VIP</b></h4>
                </div>
                <ul class="list-post mt-3">
                    @foreach ($vips as $vip)
                    <li class="item-post">
                        <i class="fa fa-caret-right" aria-hidden="true"></i>
                        <span class="badge badge-pill badge-danger d-inline">VIP</span>
                        <a href="{{route('post.show',['post' => $vip->id])}}" class="link-post"
                            title="{{Str::title($vip->title)}}">
                            <h5>{{Str::title($vip->title)}}</h5>
                        </a>
                        - Ngày hết hạn :
                        @if($vip->validate) <b>
                            {{ date('d-m-Y', strtotime($vip->validate)) }}
                        </b> @else <b>
                            Không có </b>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection