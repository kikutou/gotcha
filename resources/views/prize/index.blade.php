@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="page-title justify-content-center">
            <h3 class="mb-3 mt-6 text-center">景品一覧</h3>
        </div>

        <div class="float-right">
            <a class="btn btn-primary btn-md pull-left mb-3" href="{{url('/prize/create')}}"> 新規登録</a>
        </div>

        @if(!empty($prizes) || !is_null($prizes))
            <table class="table table-striped custab">
                <thead>
                    <tr class="d-flex">
                        <th class="col-1">景品ID</th>
                        <th class="col-3">景品名</th>
                        <th class="col-2">種別</th>
                        <th class="col-4">画像</th>
                        <th class="col-2"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($prizes as $prize)
                    <tr class="d-flex">
                        <td class="col-1">{{$prize->id}}</td>
                        <td class="col-3">{{$prize->name}}</td>
                        <td class="col-2">{{config('const.prize_type')[$prize->type]}}</td>
                        <td class="col-4">
                            @if (is_null($prize->picture->url) || $prize->picture->type != 3)
                                <p>画像が存在しない</p>
                            @else
                                <img class="img-thumbnail" src="{{ asset('storage/imgs/'.$prize->picture->url) }}" style="height:130px; width:150px" alt="{{$prize->picture->url}}">
                            @endif
                        </td>
                        <td class="col-2">
                            <a class="btn btn-info btn-md" href="{{ route('prize.edit', ['id' => $prize->id]) }}">詳細/編集</a>
                            <a class="btn btn-danger btn-md" onclick="return confirm('この内容を削除しますか︖')" href="{{ route('prize.delete', ['id' => $prize->id]) }}">削除</a>
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
