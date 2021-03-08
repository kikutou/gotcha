@extends('layouts.app')

@section('content')
    <section class="content-header">

        <div class="">
            @if(!empty($gotchas) || !is_null($gotchas))
                <table class="table table-dark(thead-light)">
                    <tr>
                        <td>ID</td>
                        <td>名称</td>
                        <td>コスト</td>
                        <td>必要数</td>
                        <td>利⽤回数</td>
                    </tr>
                    @foreach($gotchas as $gotcha)
                    <!-- TODO loop -->
                    <tr>
                        <td>{{$gotcha->id}}</td>
                        <td>{{$gotcha->name}}</td>
                        <td>{{$gotcha->cost_name}}</td>
                        <td>{{$gotcha->cost_value}}</td>
                        <td>{{$gotcha->use_numbers}}</td>
                        <form action="" method="get">
                            @csrf
                            <td><input type="submit" value="詳細/編集" id="edit"></td>
                            <input type="hidden" value="{{$gotcha->id}}">
                        </form>
                        <form action="" method="post">
                            @csrf
                            <td><input type="submit" value="削除" id="delete"></td>
                            <input type="hidden" value="{{$gotcha->id}}">
                        </form>
                    </tr>
                    @endforeach
                </table>
            @else
            <p>該当情報がありません</p>
            @endif
        </div>
    </section>
@endsection
