@extends('layouts.app')

@section('content')
    <section>
        <div class="page-title justify-content-center">
            <h3 class="mb-3 mt-6">パスワード変更</h3>
        </div>
        <div class="form-area w-75">  
            <form action="{{ route("post_change_password") }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="description">新しいパスワード</label>
                    <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                    >
                    @if ($errors->first('password'))   <!-- ここ追加 -->
                        <div class="text-danger mt-3">
                            <p class="validation">※{{$errors->first('password')}}</p>
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="description">新しいパスワード確認</label>
                    <input
                            type="password"
                            class="form-control"
                            id="password_confirm"
                            name="password_confirm"
                    >
                @if ($errors->first('password_confirm'))   <!-- ここ追加 -->
                    <div class="text-danger mt-3">
                        <p class="validation">※{{$errors->first('password_confirm')}}</p>
                    </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-xs-6 col-md-6 text-left">
                        <button type="submit" id="insert" name="insert" class="btn btn-success" >登録する</button>
                    </div>
                </div> 
            </form>

        </div>
    </section>
@endsection

