@extends('layouts.app')

@section('content')
    <section>
        <div class="page-title justify-content-center">
            <h3 class="mb-3 mt-6">ガチャ登録</h3>
        </div>
        <div class="form-area">  
            <form action="{{url('gotcha/create')}}" method="post" enctype="multipart/form-data">
                @csrf
                <br style="clear:both">           
                <div class="form-group">
                    <label for="name">ガチャ名称</label>
                    <input type="text" class="form-control" placeholder="半角/全角テキスト/英数字/記号" id="name" name="name" value="{{ old('name') }}">
                    @if ($errors->first('name'))   <!-- ここ追加 -->
                        <div class="text-danger mt-3">
                            <p class="validation">※{{$errors->first('name')}}</p>
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-xs-8 col-md-8 form-group">
                        <label for="cost_name">必要コスト名(表示用)</label>
                        <input type="text" class="form-control" placeholder="半角/全角テキスト/英数字/記号" id="cost_name" name="cost_name" value="{{ old('cost_name') }}">
                        @if ($errors->first('cost_name'))   <!-- ここ追加 -->
                            <div class="text-danger mt-3">
                                <p class="validation">※{{$errors->first('cost_name')}}</p>
                            </div>
                        @endif
                    </div>
                               
                    <div class="col-xs-4 col-md-4 form-group">
                        <label for="cost_value">必要コスト量</label>
                        <input type="number" class="form-control" placeholder="半角数字のみ" id="cost_value" name="cost_value" value="{{ old('cost_value') }}">
                        @if ($errors->first('cost_value'))   <!-- ここ追加 -->
                            <div class="text-danger mt-3">
                                <p class="validation">※{{$errors->first('cost_value')}}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="id_img_disp">画像ID(ガチャ)</label>
                    <select name="id_img_disp">
                        <option value="">
                            画像選択してください
                        </option>
                        @foreach ($gotcha_disp_imgs as $disp_img)
                            <option value="{{$disp_img->id}}"
                                @if(old('id_img_disp') && old("id_img_disp") == 1)
                                    selected
                                @endif
                            >{{$disp_img->description}}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->first('id_img_disp'))   <!-- ここ追加 -->
                        <div class="text-danger mt-3">
                            <p class="validation">※{{$errors->first('id_img_disp')}}</p>
                        </div>
                    @endif
                    <div class="form-group">
                        <img id="preview" class="img-fluid img-responsive">
                    </div>
                </div>
                                             
                <div class="form-group">
                    <label for="id_img_result">画像ID(結果)</label>
                    <select name="id_img_result">
                        <option value="">
                            画像選択してください
                        </option>
                        @foreach ($gotcha_result_imgs as $result_img)
                            <option value="{{$result_img->id}}"
                                @if(old('id_img_result') && old("id_img_result") == 1)
                                    selected
                                @endif
                            >{{$result_img->description}}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->first('id_img_result'))   <!-- ここ追加 -->
                        <div class="text-danger mt-3">
                            <p class="validation">※{{$errors->first('id_img_result')}}</p>
                        </div>
                    @endif
                    <div class="form-group">
                        <img id="preview_result" class="img-fluid img-responsive">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6 text-left">
                        <a href="{{ route('gotcha') }}" class="btn btn-primary" >もどる</a>
                        <button type="submit" id="insert" name="insert" class="btn btn-success" >登録する</button>
                    </div>
                </div> 
            </form>
        </div>  
@endsection