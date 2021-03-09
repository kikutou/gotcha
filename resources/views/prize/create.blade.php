@extends('layouts.app')
<script>
    window.onload = function(){ 
        $('#myImage').on('change', function (e) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#preview").attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    };
</script>

@section('content')
    <section class="container">
        <div class="page-title justify-content-center">
            <h3 class="mb-3 mt-6 text-center">景品登録</h3>
        </div>

        <form action="{{url('prize_create')}}" method="post">
            @csrf
                <table class="table table-dark(thead-light)">
                    <tr>
                        <td>景品名称</td>
                        <td><input type="text" id="gotcha_name" value=""></td>
                    </tr>
                    <tr>
                        <td>景品種別</td>
                        <td><input type="text" id="cost_name" value=""></td>
                    </tr>
                    <tr>
                        <td>画像素材</td>
                        <td>
                            <input type="file" id="myImage" accept="image/*"　display: none>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><img id="preview" class="img-fluid"></td>
                    </tr>
                </table>
                <div class="btn">
                    <div class="btn">
                        <button type="submit">もどる</button>
                    </div>
                    <div class="btn">
                        <button type="submit">削除</button>
                    </div>
                    <div class="btn">
                        <button type="submit">登録する</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

