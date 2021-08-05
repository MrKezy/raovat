@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row bg-white pt-3 pb-5">
        <div class="col-md-12">
            <div class="row">
                <div class="col-6">
                    <h1>Tạo tin rao vặt</h1>
                </div>
                <div class="col-6 text-right">
                    <a href="
                    @if(url()->previous() == url()->current())
                    {{route('userInfo')}}
                    @else
                    {{url()->previous()}}
                    @endif
                    " class="btn btn-warning"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Quay lại</a>
                </div>
            </div>
            <hr>
            @if (session('notice'))
            <div class="col-md-12">
                <div class="alert alert-{{session('status')}}" role="alert">
                    <i class="fa fa-bell" aria-hidden="true"></i> {{session('notice')}}
                </div>
            </div>
            @endif
            <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data" class="row">
                @csrf
                <div class="col-9 post-right">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title">Tiêu đề :</label>
                            <input type="text" id="title" class="form-control @error('title') is-invalid @enderror"
                                name="title" placeholder="Nhập tiêu đề của bạn" value="{{ old('title') }}">
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="content">Chi tiết :</label>
                            <textarea class="form-control ckeditor @error('content') is-invalid @enderror" rows="12"
                                id="content" name="content" placeholder="Nội dung chi tiết của bạn">
                                {{ old('content') }}
                            </textarea>
                            @error('content')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 reg-vip">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="reg_vip" value="1">Đăng ký tin
                                <b style="color:red">VIP</b> . Sau khi xem xét Admin sẽ kích hoạt cho bạn!
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-3 post-left">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="category_id">Danh mục :</label>
                            <select multiple class="form-control @error('category_id') is-invalid @enderror"
                                id="category_id" name="category_id[]">
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <h5>Chọn khu vực</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group provinces">
                            <label for="province_id">Tỉnh / Thành phố:</label>
                            <select class="form-control @error('province_id') is-invalid @enderror" id="province_id"
                                name="province_id">
                                @foreach ($provinces as $province)
                                <option value="{{$province->id}}">{{$province->name}}</option>
                                @endforeach
                            </select>
                            @error('province_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group provinces">
                            <label for="district_id">Quận / Huyện:</label>
                            <select class="form-control @error('district_id') is-invalid @enderror" id="district_id"
                                name="district_id">
                                <option value="0">Chọn Quận / Huyện</option>
                            </select>
                            @error('district_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group provinces">
                            <label for="ward_id">Phường / Xã :</label>
                            <select class="form-control @error('ward_id') is-invalid @enderror" id="ward_id"
                                name="ward_id">
                                <option value="0">Chọn Phường / Xã</option>
                            </select>
                            @error('ward_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="col-md-12">
                        <div class="form-group provinces">
                            <label for="validate">Ngày hết hạn tin</label>
                            <input class="form-control @error('validate') is-invalid @enderror" type="date"
                                name="validate" id="validate" value="{{ old('validate') }}">
                            @error('validate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> Đăng
                        tin</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function getforprovince(link,id,selecter){
        let url = link+'/'+id;
        $(selecter).html('')
        $.get(url,function(data){
            data.forEach(function(element){
             $(selecter).append(new Option(element.name, element.id));
            });
        });
    }

    const province = $('#province_id').val();
    getforprovince("{{route('getDistricts')}}",province,"#district_id");
    setTimeout(function(){
        let district = $('#district_id').val();
        getforprovince("{{route('getWards')}}",""+district+"","#ward_id");
    }, 1000);

    $('#province_id').change(function(callback){
        let province = $('#province_id').val();
        getforprovince("{{route('getDistricts')}}",province,"#district_id");
        setTimeout(function(){
        let district = $('#district_id').val();
        getforprovince("{{route('getWards')}}",""+district+"","#ward_id");
        }, 1000);
    })
    $('#district_id').change(function(){
        let district = $('#district_id').val();
        getforprovince("{{route('getWards')}}",""+district+"","#ward_id");
    })
    
</script>
@endsection