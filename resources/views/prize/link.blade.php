@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="page-title justify-content-center">
            <h3 class="mb-3 mt-6 text-center">景品種別挙動</h3>
        </div>
        <div class="form-area">  
        <form action="{{url('/prize/link')}}" method="post">
                @csrf
                <br style="clear:both">
                <label for="prize_id">景品ID：</label>{{$prize->id}}
                <input type="hidden" id="prize_id" name="prize_id" value="{{$prize->id}}">
                <div class="form-group">
                    <label for="name">景品名称</label>{{$prize->name}}
                </div>
                <div class="form-group">
                    <label for="url">発送物</label>
                    <input 
                        type="text"
                        class="form-control"
                        placeholder="URL"
                        id="url"
                        name="url"
                        value="{{ old('url', (isset($url) ? $url:'' ))}}"
                    >
                    @if ($errors->first('url'))   <!-- ここ追加 -->
                        <div class="text-danger mt-3">
                            <p class="validation">※{{$errors->first('url')}}</p>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6 text-left">
                        <a href="{{ route('prize') }}" class="btn btn-primary" >もどる</a>
                        <button type="submit" id="insert" name="insert" class="btn btn-success" >{{ isset($url) ? '更新する' : '登録する' }}</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

