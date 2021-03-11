@extends('layouts.app')

@section('content')
    <section class="container">
        <h3 class="mb-3 mt-6">画像登録</h3>
        <div class="form-area">  
            <form action="{{url('picture/create')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="description">⽤途</label>
                    <input
                            type="text"
                            class="form-control"
                            placeholder="半角/全角テキスト/英数字/記号"
                            id="description"
                            name="description"
                            value="{{ old('description') }}"
                    >
                    @if ($errors->first('description'))   <!-- ここ追加 -->
                        <div class="text-danger mt-3">
                            <p class="validation">※{{$errors->first('description')}}</p>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="type_id">種別</label>
                    <select name="type_id">
                        <option value="1"
                            @if(old('type_id') && old("type_id") == 1)
                                selected
                            @endif
                        >ガチャ画像</option>
                        <option value="2"
                                @if(old('type_id') && old("type_id") == 2)
                                selected
                                @endif
                        >結果画像</option>
                        <option value="3"
                                @if(old('type_id') && old("type_id") == 3)
                                selected
                                @endif
                        >景品画像</option>
                    </select>
                    @if ($errors->first('type_id'))   <!-- ここ追加 -->
                        <div class="alert alert-danger alert-dismissible fade show">
                            <p class="validation">※{{$errors->first('type_id')}}</p>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="btn btn-primary" for="image">画像選択</label>
                    <input id="image" type="file" multiple="multiple" name="image" accept="image/*" style="display:none;">
                    @if ($errors->first('image'))   <!-- ここ追加 -->
                        <div class="text-danger mt-3">
                            <p class="validation">※{{$errors->first('image')}}</p>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <img id="preview" class="img-fluid img-responsive">
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6 text-left">
                        <a href="{{ route('picture') }}" class="btn btn-primary" >もどる</a>
                        <button type="submit" id="insert" name="insert" class="btn btn-success" >登録する</button>
                    </div>
                </div> 
            </form>

        </div>
    </section>
@endsection

