@extends('layouts.app')

@section('content')
    <section>
        <h3 class="mb-3 mt-6">画像詳細/編集</h3>
        <div class="form-area">
            <form action="{{url('picture/edit')}}" method="post" enctype="multipart/form-data">
                @csrf
                <br style="clear:both">
                <label for="picture_id">画像ID：</label>{{$picture->id}}
                <input type="hidden" id="picture_id" name="picture_id" value="{{$picture->id}}">
                <div class="form-group">
                    <label for="description">画像名</label>
                    <input
                            type="text"
                            class="form-control"
                            placeholder="半角/全角テキスト/英数字/記号"
                            id="description"
                            name="description"
                            value="{{ old('description', $picture->description) }}"
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
                            {{ (($picture->type == 1)
                                || (old('type_id') && old("type_id") == 1)) ? 'selected' : '' }}
                        >ガチャ画像</option>
                        <option value="2"
                            {{ (($picture->type == 2)
                                || (old('type_id') && old("type_id") == 2)) ? 'selected' : '' }}
                        >結果画像</option>
                        <option value="3"
                            {{ (($picture->type == 3)
                                || (old('type_id') && old("type_id") == 3)) ? 'selected' : '' }}
                        >景品画像</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="btn btn-primary" for="image">画像選択</label>
                    <input id="image" type="file" multiple="multiple" name="image" accept="image/*" style="display:none;">
                </div>
                <div class="form-group">
                    <img id="preview" class="img-fluid img-responsive" src="{{ asset('storage/imgs/' . $picture->url) }}">
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6 text-left">
                        <a href="{{ route('picture') }}" class="btn btn-primary" >もどる</a>
                        <button type="submit" id="update" name="update" class="btn btn-success" >更新する</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

