@extends('layouts.app')

@section('content')
<div class="container">
    <div class="wrapper">
        <form method="POST" class="form-signin" action="{{ route('login') }}">
            @csrf
            <h3 class="form-signin-heading">ログイン</h3>
            <hr class="colorgraph">
            <br>
            <label for="email" class="col-md-4 col-form-label text-md-left">{{ __('ID') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            <label for="password" class="col-md-4 col-form-label text-md-left">{{ __('パスワード') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            <button class="btn btn-lg btn-info btn-block" name="Submit" value="Login" type="Submit">Login</button>
        </form>
    </div>
</div>
@endsection
