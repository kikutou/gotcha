<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'system_name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-input-file-text.js') }}"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'system_name') }}
                </a>
                <!--
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                -->

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <nav class="navbar navbar-expand-sm bg-danger navbar-dark justify-content-center" >
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('gotcha_list')}}">ガチャ一覧</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">景品種別別挙動</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('picture_list')}}">画像一覧(ガチャ/結果)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('prize_list')}}">景品一覧</a>
                            </li>  
                        </ul>
                    </nav>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                                </li>
                            @endif
                            
                        <!--
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        -->
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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

        <div class="container row">
            <div class="col-md-8">
                @yield('content')
            </div>
        </div>

        
    </div>
</body>
</html>
