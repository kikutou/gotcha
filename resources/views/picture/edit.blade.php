@extends('layouts.app')
<script>
    window.onload = function(){ 
        $('#image').on('change', function (e) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#preview").attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    };
</script>
@if($message)
    <div>
        <p>{{＄message}}</p>
    </div>
@endif

@section('content')
    <section class="content-header">

        <div class="mt-3 mb-3">
            <h1>画像登録</h1>
        </div>

        <div class="">
            <form action="{{url('post_picture_edit')}}" method="post" enctype="multipart/form-data">
                @csrf
                <table class="table table-dark(thead-light)">
                    <tr>
                        <td>ガチャ画像ID</td>
                        <td><span>{{$picture->id}}</span><span>※自動設定</span></td>
                    </tr>
                    <tr>
                        <td>⽤途</td>
                        <td>{{Form::input('text','description',$picture->description,['id' => 'description'])}}</td>
                    </tr>
                    <tr>
                        <td>種別</td>
                        <td>{{Form::select('type_id', config('const.picture_type'))}}</td>
                    </tr>
                    <tr>
                        <td>画像素材</td>
                        <td>
                            <input type="file" name="image" id="image" accept="image/*"　display: none>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><img id="preview" class="img-fluid"></td>
                    </tr>
                    <tr>
                        <td><a class="btn btn-primary btn-lg active" href="{{ URL::previous() }}">戻る</a></td>
                        <td><button class="btn btn-danger" name="delete" type="submit">削除する</button></td>
                        <td><button class="btn btn-danger" name="insert" type="submit">登録する</button></td>    
                    </tr>
                </table>
            </form>
        </div>
    </section>
@endsection

