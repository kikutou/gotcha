<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? "ガチャシステム" }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- JS -->
    <script src="{{ asset('/js/jquery.min-3.2.1.js')}}"></script>
    <script src="{{ asset('/js/popper.min.js')}}"></script>
    <script src="{{ asset('/js/bootstrap.min-twitter-4.3.1.js')}}"></script>
    <script src="{{ asset('/js/bootstrap.min-3.3.0.js')}}"></script>
    <!-- <script src="{{ asset('/js/jquery-1.11.1.min.js')}}"></script> -->
    <script src="{{ asset('/js/common.js')}}"></script>

    <!-- CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css"> -->
    <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
    <link href="{{ asset('/css/common.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/css/style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/css/startmin.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">

</head>
<body>
    
        @if(Auth::check())
            <div class="dashboard-main-wrapper">
                @include('partials.header')
                @include('partials.sidebar')
                <div class="dashboard-wrapper">
                    <div class="dashboard-ecommerce">
                        <div class="container-fluid dashboard-content ">
                            <!-- フラッシュメッセージ -->
                            @if (session('message'))
                                <div class="alert alert-primary message" role="alert">
                                    {{ session('message') }}
                                </div>
                            @endif

                            <!-- フラッシュメッセージ -->
                            @if (session('error'))
                                <div class="alert alert-danger error" role="alert">
                                    {!! nl2br(session('error')) !!}
                                </div>
                            @endif
                        @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        @else
            @yield('content')
        @endif
    
</body>
</html>
