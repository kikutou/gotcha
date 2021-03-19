<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? "ガチャシステム" }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="{{ asset('/js/common.js')}}"></script>

    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="{{ asset('/css/common.css')}}" rel="stylesheet" type="text/css">

</head>
<body>
    @include('partials.header')

    <div class="container-fluid h-100">
        <div class="row">
            @if(Auth::check())
                <div class="col-sm-2 mb-0 rounded-0">
                    @include('partials.sidebar')
                </div>
            @endif

            <div class="col-sm-10"> 
                <section class="container-fluid">

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

                </section>
                @yield('content')
            </div>
        </div>
    </div> 
</body>
</html>
