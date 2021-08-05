@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pt-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Danh mục : {{$category->name}} </h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('category.index')}}" class="btn btn-warning"><i
                                    class="fa fa-chevron-circle-left" aria-hidden="true"></i> Danh sách danh mục</a>
                        </div>
                    </div>
                </div>

                <ul class="list-post mt-3">
                    @foreach ($posts as $post)
                    <li class="item-post">
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
                    @endforeach
                </ul>
                {{$posts}}

            </div>
        </div>
    </div>
    @endsection