<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script type="text/javascript" rel="script" src="{{asset('js/app.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <script src="https://use.fontawesome.com/55461975e7.js"></script>

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <a class="nav-link" href="{{ route('home') }}"><i class="fa fa-home" aria-hidden="true"></i>
                        Trang chủ</a> |
                    <a class="nav-link" href="{{ route('category.index') }}"><i class="fa fa-folder"
                            aria-hidden="true"></i> Danh mục</a> |
                    <a class="nav-link" href="{{ route('search') }}"><i class="fa fa-search" aria-hidden="true"></i> Tìm
                        kiếm</a>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <a href="{{route('post.create')}}" class="btn btn-success"><i class="fa fa-plus-circle"
                                aria-hidden="true"></i> Đăng tin mới</a>
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item" style="border-right:1px solid rgb(206, 204, 204)">
                            <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-sign-in"
                                    aria-hidden="true"></i>
                                {{ __('auth.Login') }}</a>
                        </li>
                        @endif
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}"><i class="fa fa-registered"
                                    aria-hidden="true"></i> {{ __('auth.Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-heart" aria-hidden="true"></i> {{ Auth::user()->fullname }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('admin.show')}}"><i class="fa fa-street-view"
                                        aria-hidden="true"></i> AdminCP</a>
                                <a class="dropdown-item" href="{{route('userInfo')}}"><i class="fa fa-info-circle"
                                        aria-hidden="true"></i> Thông tin cá nhân</a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                                        class="fa fa-sign-out" aria-hidden="true"></i>
                                    {{ __('auth.Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    CKEDITOR.replace('content', {
        filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>

</html>