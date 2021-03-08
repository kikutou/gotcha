@extends('layouts.app')

@if($message)
    <div>
        <p>{{＄message}}</p>
    </div>
@endif

@section('content')
    <section class="content-header">

        <div class="">
            <h1>ガチャ詳細</h1>
        </div>

        <div class="">
            <form action="" method="get">
                @csrf
                <table class="table table-dark(thead-light)">
                    <tr>
                        <td>ガチャID</td>
                        <td><span>001</span><span>※自動設定</span></td>
                    </tr>
                    <tr>
                        <td>ガチャ名称</td>
                        <td><input type="text" id="gotcha_name" value=""></td>
                    </tr>
                    <tr>
                        <td>必要コスト名(表示用)</td>
                        <td><input type="text" id="cost_name" value=""></td>
                        <td>必要コスト量</td>
                        <td><input type="text" id="cost_value" value=""></td>
                    </tr>
                    <tr>
                        <td>画像ID(ガチャ)</td>
                        <td><input type="text" id="gotcha_picture_id" value=""></td>
                    </tr>
                    <tr>
                        <td>画像ID(結果)</td>
                        <td><input type="text" id="gotcha_result_picture_id" value=""></td>
                    </tr>
                </table>

                <table id="gotcha_js">
                    <th>ガチャテーブル</th>
                    <tr>
                        <td>tableID</td>
                        <td>景品ID</td>
                        <td>景品名(自動表示)</td>
                        <td>重み</td>
                        <td>参考出現率</td>
                    </tr>
                    <!-- TODO loop -->
                </table>
                <div class="btn">
                    <div class="btn">
                        <button type="submit" onclick="addRow();return false;">行追加
                    </div>
                    <div class="btn">
                        <button type="submit">もどる
                    </div>
                    <div class="btn">
                        <button type="submit">削除
                    </div>
                    <div class="btn">
                        <button type="submit">登録
                    </div>
                </div>
            </form>
        </div>
    </section>
<script>
    function addRow(){
        // table要素を取得
        var tableElem = document.getElementById('gotcha_js');
        
        // tbody要素にtr要素（行）を最後に追加
        var trElem = tableElem.tBodies[0].insertRow(-1);
        
        // td要素を追加
        var cellElem = trElem.insertCell(0);
        
        // td要素にテキストを追加
        cellElem.appendChild(document.createTextNode('セル'));
    }
</script>
@endsection

