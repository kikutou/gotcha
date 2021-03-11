@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="page-title justify-content-center">
            <h3 class="mb-3 mt-6 text-center">ガチャ一覧</h3>
        </div>
        <div class="float-right">
        <a class="btn btn-primary btn-md pull-left mb-3" href="{{url('/gotcha/create')}}"> 新規登録</a>
        </div>
        @if(!empty($gotchas) || !is_null($gotchas))
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
                    @foreach ($gotchas as $gotcha)
                    <tr>
                        <td>{{$gotcha->id}}</td>
                        <td>{{$gotcha->name}}</td>
                        <td>{{$gotcha->cost_name}}</td>
                        <td>{{$gotcha->cost_value}}</td>
                        <td>{{$gotcha->use_numbers}}</td>
                            
                        <td class="text-center">
                            <a class='btn btn-info btn-md' href="{{ route('gotcha.edit', ['id' => $gotcha->id]) }}">詳細/編集</a> 
                            <a class="btn btn-danger btn-md" href="{{ route('gotcha.delete', ['id' => $gotcha->id]) }}">削除</a>
                        </td>
                    </tr>
                        @endforeach
                </tbody>
            </table>
        @else
            <p>該当情報がありません</p>
        @endif
    </section>
@endsection
