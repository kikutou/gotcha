@extends('layouts.app')
<style>

.custab{
  border: 1px solid #ccc;
  padding: 5px;
  margin: 3% 0;
}
.custab:hover{
  box-shadow: 3px 3px 0px transparent;
  transition: 0.5s;
}

</style>

@section('content')
    <section class="container">
        <h3 class="mb-3 mt-6">ガチャ一覧</h3>
        <a class="btn btn-primary btn-md pull-left mb-3" href="{{url('/gotcha/create')}}"> 新規登録</a>
        @if(!empty($gotchas) || !is_null($gotchas))
            <form action="{{url('get_gotcha_edit')}}" method="get">
                @csrf
                <table class="table table-striped custab">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>名称</th>
                            <th>コスト</th>
                            <th>必要数</th>
                            <th>利用回数</th>
                            <th class="text-center">編集</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>News</td>
                            <td>News Cate</td>
                            <td>News Cate</td>
                            <td>News Cate</td>
                            
                            <td class="text-center">
                                <a class='btn btn-info btn-md' href="#"><span class="glyphicon glyphicon-edit"></span> 詳細/編集</a> 
                                <a class="btn btn-danger btn-md" href="#"><span class="glyphicon glyphicon-remove"></span> 削除</a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>News</td>
                            <td>News Cate</td>
                            <td>News Cate</td>
                            <td>News Cate</td>
                            
                            <td class="text-center">
                                <a class='btn btn-info btn-md' href="#"><span class="glyphicon glyphicon-edit"></span> 詳細/編集</a> 
                                <a class="btn btn-danger btn-md" href="#"><span class="glyphicon glyphicon-remove"></span> 削除</a>
                            </td>
                        </tr>
                    @foreach($gotchas as $gotcha)
                        <!-- TODO loop -->
                        <tr>
                            <td>{{$gotcha->id}}</td>
                            <td>{{$gotcha->name}}</td>
                            <td>{{$gotcha->cost_name}}</td>
                            <td>{{$gotcha->cost_value}}</td>
                            <td>{{$gotcha->use_numbers}}</td>
                            <td>
                                <!-- <a class='btn btn-info btn-xs' href="#"><span class="glyphicon glyphicon-edit"></span> 詳細/編集</a>  -->
                                <button class="btn btn-info btn-xs" type="submit" value="詳細/編集" id="edit">
                                <!-- <a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> 削除</a> -->
                                <button class="btn btn-danger btn-xs" type="submit" value="削除" id="delete">
                                <input type="hidden" name="gotcha_id" id="gotcha_id" value="{{$gotcha->id}}">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </form>
        @else
            <p>該当情報がありません</p>
        @endif
    </section>
@endsection
