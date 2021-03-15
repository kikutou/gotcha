@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="page-title justify-content-center">
            <h3 class="mb-3 mt-6 text-center">景品登録</h3>
        </div>
        <div class="form-area">  
            <form action="{{url('prize/create')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">景品名称</label>
                    <input 
                        type="text"
                        class="form-control"
                        placeholder="半角/全角テキスト/英数字/記号"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                    >
                    @if ($errors->first('name'))   <!-- ここ追加 -->
                        <div class="text-danger mt-3">
                            <p class="validation">※{{$errors->first('name')}}</p>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="type">景品種別</label>
                    <select name="type_id">
                        <option value="2"
                            @if(old('type_id') && old("type_id") == 2)
                                selected
                            @endif
                        >発送物</option>
                    </select>
                    @if ($errors->first('type_id'))   <!-- ここ追加 -->
                        <div class="text-danger mt-3">
                            <p class="validation">※{{$errors->first('type_id')}}</p>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="picture_id">画像素材</label>
                    <select name="picture_id">
                        <option value="">
                            画像選択してください
                        </option>
                        @foreach ($pictures as $picture)
                            <option value="{{$picture->id}}"
                                @if(old('picture_id') && old("picture_id") == 1)
                                    selected
                                @endif
                            >{{$picture->description}}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->first('picture_id'))   <!-- ここ追加 -->
                        <div class="text-danger mt-3">
                            <p class="validation">※{{$errors->first('picture_id')}}</p>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <img id="preview" class="img-fluid img-responsive">
                </div>

                <div class="form-group">
                    <label for="url">発送物</label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="URL"
                        id="url"
                        name="url"
                        value="{{ old('url') }}"
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
                        <button type="submit" id="insert" name="insert" class="btn btn-success" >登録する</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

