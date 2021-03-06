<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', '风雪之隅') - 风雪之隅</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        风雪之隅
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li id="nav-home" _class="active"><a href="{{route('index')}}">首页</a></li>
                        <li id="nav-php-internal"><a href="{{route('phpInternal')}}">PHP源码分析</a></li>
                        <li id="nav-php"><a href="{{route('php')}}">PHP应用</a></li>
                        <li id="nav-jscss"><a href="{{route('jscss')}}">JS/CSS</a></li>
                        <li id="nav-notes"><a href="{{route('notes')}}">随笔</a></li>
                        <li id="nav-licence"><a href="{{route('licence')}}">博客声明</a></li>
                    </ul>
                    <!-- Right Side Of Navbar -->
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <footer>
        <div class="footer-bottom">
            <p class="text-center">Copyright 2015 - 2018 LaraCMS All Rights Reserved</p>
            <p class="text-center"><a href="http://www.miitbeian.gov.cn/" target="_blank">京ICP备15019058号-1</a></p>
        </div>

    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
