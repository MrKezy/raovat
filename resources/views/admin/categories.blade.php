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
                            <h1>Danh sách danh mục</h1>
                        </div>
                        <div class="col-6 text-right"><a href="{{route('admin.category.creat')}}"
                                class="btn btn-success"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tạo danh
                                mục mới</a></div>
                    </div>

                    <hr class="m-2">
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
                                <th>Name</th>
                                <th>Số tin rao vặt</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{$category->id}}</td>
                                <td><a href="{{route('category.show',['category' => $category->id])}}"
                                        target="_blank">{{$category->name}}</a>
                                    @if($category->id == 1) (Mặc định) @endif
                                </td>
                                <td>
                                    {{
                                        count($category->posts()->whereHas('users', function ($query) {
                                            $query->where('role', '!=', 'block');
                                        })->get());
                                        }}
                                </td>
                                <td>
                                    <a href="{{route('admin.category.edit',['category' => $category->id])}}"
                                        class="btn btn-success button-info" title="Sửa danh mục"><i
                                            class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <a class="btn btn-danger button-info @if($category->id == 1) disabled @endif"
                                        href="#" title="Xóa danh mục" onclick="event.preventDefault();
                                            document.getElementById('deleteCategory-{{ $category->id }}').submit();"><i
                                            class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            <form id="deleteCategory-{{ $category->id }}"
                                action="{{ route('admin.category.destroy',['category' => $category->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                            @endforeach
                        </tbody>
                    </table>
                    <p>*Lưu ý : Các bài viết của danh mục bị xóa nếu không có trong danh mục khác sẽ chuyển về danh mục
                        mặc định</p>
                    {{$categories}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection