@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="page-title justify-content-center">
            <h3 class="mb-3 mt-6 text-center">景品詳細/編集</h3>
        </div>
        <div class="form-area">  
        <form action="{{url('/prize/edit')}}" method="post">
                @csrf
                <br style="clear:both">
                <label for="prize_id">景品ID：</label>{{$prize->id}}
                <input type="hidden" id="prize_id" name="prize_id" value="{{$prize->id}}">
                <div class="form-group">
                    <label for="name">景品名称</label>
                    <input 
                        type="text"
                        class="form-control"
                        placeholder="半角/全角テキスト/英数字/記号"
                        id="name"
                        name="name"
                        value="{{ old('name', $prize->name) }}"
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
                        <option value="1"
                            {{ (($prize->type == 1)
                                ||(old('type_id') && old('type_id')) == 1) ? 'selected' : '' }}
                        >ゲーム内利用</option>
                        <option value="2"
                            {{ ( ($prize->type == 2)
                                ||(old('type_id') && old('type_id')) == 2) ? 'selected' : '' }}
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
                                {{ $picture->id == $prize->picture->id
                                    || (old('picture_id') && old("picture_id") == $picture->id) ? 'selected' : '' }}
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
                    @if (is_null($prize->picture->url) || $prize->picture->type != 3)
                        <img id="preview" class="img-fluid img-responsive" src="">
                    @else
                        <img id="preview" class="img-fluid img-responsive" src="{{ asset('storage/imgs/' . $prize->picture->url) }}">
                    @endif
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6 text-left">
                        <a href="{{ route('prize') }}" class="btn btn-primary" >もどる</a>
                        <button type="submit" id="update" name="update" class="btn btn-success" >更新する</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

