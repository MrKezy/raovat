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
                            <h1>Thêm danh mục</h1>
                        </div>
                        <div class="col-6 text-right"><a href="{{ route('admin.category.list') }}"
                                class="btn btn-warning"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                                Danh sách danh mục</a>
                        </div>
                    </div>
                    <hr class="m-2">
                    @if(session('notice'))
                    <div class="alert alert-{{session('status')}}">
                        <i class="fa fa-bell" aria-hidden="true"></i> {!! session('notice') !!}
                    </div>
                    @endif
                </div>
                <div class="col-12">
                    <form method="post" action="{{route('admin.category.store')}}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    placeholder="Nhập tên danh mục" name="name" value='{{old('name')}}'>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"
                                        aria-hidden="true"></i> Thêm danh mục</button>
                            </div>
                        </div>
                    </form>
                    <ul class="mt-2">
                        <li>Tên danh mục phải có ít nhất 3 kí tự!</li>
                        <li>Tên danh mục không được trùng lặp với các danh mục khác</li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection