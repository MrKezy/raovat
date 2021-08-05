@extends('layouts.app')
@section('content')
<div class="container mb-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{route('search')}}" method="get">
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <select class="custom-select mr-sm-2" id="province_id" name="province_id"
                                class="form-control @error('province_id') is-invalid @enderror">
                                <option value="">Tất cả tỉnh / thành phố</option>
                                @foreach($provinces as $province)
                                <option value='{{$province->id}}' @if(old('province_id')==$province->id) selected
                                    @endif @if(Request::get('province_id')==$province->id) selected
                                    @endif>
                                    {{$province->name}}
                                </option>
                                @endforeach
                            </select>
                            @error('province_id')
                            <script>
                                $('select[name="province_id"]').addClass('is-invalid');
                            </script>
                            <span class="invalid-feedback" style="display:block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <select class="custom-select mr-sm-2" id="category_id" name="category_id"
                                class="form-control @error('category_id') is-invalid @enderror">
                                <option value="">Tất cả danh mục</option>
                                @foreach($categories as $category)
                                <option value='{{$category->id}}' @if(old('category_id')==$category->id) selected
                                    @endif @if(Request::get('category_id')==$category->id) selected
                                    @endif>
                                    {{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <script>
                                $('select[name="category_id"]').addClass('is-invalid');
                            </script>
                            <span class="invalid-feedback" style="display:block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Nhập tối thiểu 5 từ khóa ...."
                                name="text_search" class="form-control" @if(old('text_search'))
                                value='{{old('text_search')}}' @else value='{{Request::get('text_search')}}' @endif>
                            @error('text_search')
                            <script>
                                $('input[name="text_search"]').addClass('is-invalid');
                            </script>
                            <span class="invalid-feedback" style="display:block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"
                                aria-hidden="true"></i> Tìm kiếm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pt-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>{{$title}}</h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('home')}}" class="btn btn-warning"><i class="fa fa-chevron-circle-left"
                                    aria-hidden="true"></i> Trang chủ</a>
                        </div>
                    </div>
                </div>

                <ul class="list-post mt-3">
                    @foreach ($posts as $post)
                    <li class="item-post">
                        <i class="fa fa-caret-right" aria-hidden="true"></i>
                        @if($post->is_vip) <b style="color:red">[ VIP ]</b> @endif
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
                    @endforeach
                </ul>
                {{$posts->withQueryString()->links()}}

            </div>
        </div>
    </div>
    @endsection