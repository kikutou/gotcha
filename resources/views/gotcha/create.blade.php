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
            <form action="{{url('post_picture_create')}}" method="post" enctype="multipart/form-data">
                @csrf
                <br style="clear:both">
                <p style="margin-bottom: 25px; text-align: left;">ガチャID：003</p>
                            
                <div class="form-group">
                    <label for="name">ガチャ名称</label>
                    <input type="text" class="form-control" placeholder="半角/全角テキスト/英数字/記号" id="name" name="name" >
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
                    <label for="id_img">画像ID(ガチャ)</label>
                    <input type="text" class="form-control" id="id_img" name="id_img" >
                </div>
                                             
                <div class="form-group">
                    <label for="id_img">画像ID(結果)</label>
                    <input type="text" class="form-control" id="id_img" name="id_img" >
                </div>
            </form>
        </div>

        <table class="fixed_headers table-bordered mb-3" id="gotcha_js">
            <thead>
                <tr>
                    <th>tableID</th>
                    <th>景品ID</th>
                    <th>景品名(自動表示)</th>
                    <th>重み</th>
                    <th>参考出現率</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>0001</td>
                    <td>001</td>
                    <td>[⻤滅の刃]炭治郎ぬいぐるみ</td>
                    <td>500</td>
                    <td>62.9</td>
                </tr>
                <tr>
                    <td>0001</td>
                    <td>001</td>
                    <td>[⻤滅の刃]炭治郎ぬいぐるみ</td>
                    <td>500</td>
                    <td>62.9</td>
                </tr>
            </tbody>
        </table>
        <div class="row"> 
            <div class="col-xs-6 col-md-6 ">
                <button type="button" id="submit" name="submit" onclick="addRow();return false;" class="btn btn-primary pull-right">行を増やす</button>
            </div>

            <div class="col-xs-6 col-md-6 text-right">
                <button type="button" id="submit" name="submit" class="btn btn-primary" >もどる</button>               
                <button type="button" id="submit" name="submit" class="btn btn-danger" >削除する</button>               
                <button type="button" id="submit" name="submit" class="btn btn-success" >登録する</button>
            </div>
        </div> 
    </section>
<script>
    function addRow(){
        // table要素を取得
        var tableElem = document.getElementById('gotcha_js');
        
        // tbody要素にtr要素（行）を最後に追加
        var trElem = tableElem.tBodies[0].insertRow(-1);
        
        // td要素を追加
        for (var i=0;i<5;i++){
            var cellElem = trElem.insertCell(i);
        }    
        // td要素にテキストを追加
        cellElem.appendChild(document.createTextNode('test'));
    }
</script>
@endsection

