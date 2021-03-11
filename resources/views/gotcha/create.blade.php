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

@section('content')
    <section class="container">
        <h3 class="mb-3 mt-6">ガチャ登録</h3>

        <div class="form-area">  
            <form action="{{url('post.picture.create')}}" method="post" enctype="multipart/form-data">
                @csrf
                <br style="clear:both">           
                <div class="form-group">
                    <label for="name">ガチャ名称</label>
                    <input type="text" class="form-control" placeholder="半角/全角テキスト/英数字/記号" id="name" name="name" value="{{ old('name') }}">
                </div>

                <div class="row">
                    <div class="col-xs-8 col-md-8 form-group">
                        <label for="cosuto">必要コスト名(表示用)</label>
                        <input type="text" class="form-control" placeholder="半角/全角テキスト/英数字/記号" id="cosuto" name="cosuto" >
                    </div>
                               
                    <div class="col-xs-4 col-md-4 form-group">
                        <label for="amount">必要コスト量</label>
                        <input type="text" class="form-control" placeholder="半角数字のみ" id="amount" name="amount" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="id_img_disp">画像ID(ガチャ)</label>
                    <input type="number" class="form-control" id="id_img_disp" name="id_img_disp">
                </div>
                                             
                <div class="form-group">
                    <label for="id_img_result">画像ID(結果)</label>
                    <input type="number" class="form-control" id="id_img_result" name="id_img_result" >
                </div>
            </form>
        </div>  
@endsection

<script>
    window.onload = function(){ 
        //セレクトボックスが切り替わったら発動
        $('#id_img_disp').change(function() {
            var id = $('#id_img_disp').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('picture.get') }}",
                type: 'POST',
                dataType:"json",
                data: { 'id': id, 'type':'disp' }
            })
            // Ajaxリクエストが成功した場合
            .done(function(data) {
                console.log(data.url);
                if(data.url==''){
                    console.log("失敗しました")
                }else{
                    console.log("成功しました")
                }
            })
            // Ajaxリクエストが失敗した場合
            .fail(function(data) {
                console.log("失敗しました")
            });
        });

        //セレクトボックスが切り替わったら発動
        $('#id_img_result').change(function() {
            var id = $('#id_img_result').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('picture.get') }}",
                type: 'POST',
                dataType:"json",
                data: { 'id': id, 'type':'disp' }
            })
            // Ajaxリクエストが成功した場合
            .done(function(data) {
                console.log(data.url);
                if(data.url==''){
                    console.log("失敗しました")
                }else{
                    console.log("成功しました")
                }
            })
            // Ajaxリクエストが失敗した場合
            .fail(function(data) {
                console.log("失敗しました")
            });
        });
    };
</script>