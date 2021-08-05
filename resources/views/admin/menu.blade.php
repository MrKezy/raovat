<div class="row menu">
    <div class="col-md-12">
        <h1>Quản trị</h1>
        <hr>
    </div>
    <div class="col-sm-12 item-menu @if(url()->current() == route('admin.show')) active-menu @endif ">
        <a href="{{route('admin.show')}}">Tổng quan</a>
    </div>
    <div class="col-sm-12 item-menu menu-list">
        <a href="#">Quản lý thành viên</a>
        <ul class="menu-child">
            <li
                class="item-child @if(url()->current() == route('admin.user')) active-menu @endif @if(isset($user) && (url()->current() == route('admin.user.show',['id' => $user->id]))) active-menu @endif">
                <a href="{{route('admin.user')}}">Danh sách thành viên</a></li>
        </ul>
    </div>
    <div class="col-sm-12 item-menu menu-list">
        <a href="#">Quản lý bài viết</a>
        <ul class="menu-child">
            <li class="item-child @if(url()->current() == route('admin.post.show')) active-menu @endif"><a
                    href="{{route('admin.post.show')}}">Danh
                    sách bài viết</a></li>
            <li class="item-child @if(url()->current() == route('admin.vips.check')) active-menu @endif"><a
                    href="{{route('admin.vips.check')}}">Bài
                    viết chờ duyệt</a></li>
            <li class="item-child @if(url()->current() == route('admin.vips.show')) active-menu @endif"><a
                    href="{{route('admin.vips.show')}}">Bài
                    viết VIP</a></li>
            <li class="item-child @if(url()->current() == route('admin.validate.show')) active-menu @endif"><a
                    href="{{route('admin.validate.show')}}">Bài
                    viết hết hạn</a></li>
            <li class="item-child @if(url()->current() == route('admin.postblock.show')) active-menu @endif"><a
                    href="{{route('admin.postblock.show')}}">Bài
                    viết bị khóa</a></li>
        </ul>
    </div>
    <div class="col-sm-12 item-menu menu-list">
        <a href="#">Quản lý danh mục</a>
        <ul class="menu-child">
            <li class="item-child @if(url()->current() == route('admin.category.list')) active-menu @endif @if(isset($category) && (url()->current() == route('admin.category.edit',['category' =>
                $category->id])))
                active-menu @endif"><a href="{{route('admin.category.list')}}">Danh sách danh mục</a>
            </li>
            <li class="item-child @if(url()->current() == route('admin.category.creat')) active-menu @endif">
                <a href="{{route('admin.category.creat')}}">Thêm danh mục</a></li>
        </ul>
    </div>
</div>