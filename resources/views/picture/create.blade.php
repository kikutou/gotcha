@extends('layouts.app')
<style>

    .red{
        color:red;
        }
    .form-area{
        background-color: #FAFAFA;
        padding: 5px 20px 10px;
        margin: 5px 0px 30px;
        border: 1px solid GREY;
        }
    .fixed_headers {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
    }
    .fixed_headers th {
        text-decoration: underline;
    }
    .fixed_headers th,
    .fixed_headers td {
        padding: 5px;
        text-align: center;
    }
    .fixed_headers td:nth-child(1),
    .fixed_headers th:nth-child(1) {
        min-width: 100px;
    }
    .fixed_headers td:nth-child(2),
    .fixed_headers th:nth-child(2) {
        min-width: 100px;
    }
    .fixed_headers td:nth-child(3),
    .fixed_headers th:nth-child(3) {
        min-width: 600px;
    }
    .fixed_headers td:nth-child(4),
    .fixed_headers th:nth-child(4) {
        min-width: 200px;
    }
    .fixed_headers td:nth-child(5),
    .fixed_headers th:nth-child(5) {
        width: 200px;
    }
    .fixed_headers thead {
        background-color: #333;
        color: #FAFAFA;
    }
    .fixed_headers thead tr {
        display: block;
        position: relative;
    }
    .fixed_headers tbody {
        display: block;
        overflow: auto;
        width: 100%;
        height: 300px;
    }
    .fixed_headers tbody tr:nth-child(even) {
        background-color: #DDD;
    }    

</style>

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
    <section class="container">
        <h3 class="mb-3 mt-6">画像登録</h3>
        <div class="form-area">  
            <form action="{{url('picture/create')}}" method="post" enctype="multipart/form-data">
                @csrf
                <br style="clear:both">
                <p style="margin-bottom: 25px; text-align: left;">ガチャ画像ID：003<span class="ml-3">※自動設定</span></p>
                <div class="form-group">
                    <label for="description">⽤途</label>
                    <input type="text" class="form-control" placeholder="半角/全角テキスト/英数字/記号" id="description" name="description" >
                </div>
                <div class="form-group">
                    <label for="type_id">種別</label>
                    {{Form::select('type_id', config('const.picture_type'))}}
                </div>
                <div class="form-group">
                    <label for="image">画像素材</label>
                    <input type="file" name="image" id="image" accept="image/*"　display: none>
                </div>
                <div class="form-group">
                    <img id="preview" class="img-fluid">
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6 text-left">
                        <a href="{{ url()->previous() }}" class="btn btn-primary" >もどる</a>
                        <button type="submit" id="insert" name="insert" class="btn btn-success" >登録する</button>
                    </div>
                </div> 
            </form>

        </div>
    </section>
@endsection

