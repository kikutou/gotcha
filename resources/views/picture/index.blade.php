@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="page-title justify-content-center">
            <h3 class="mb-3 mt-6 text-center">画像一覧</h3>
        </div class="pull-left">
        <div class="float-right">
            <a class="btn btn-primary btn-md pull-left mb-3" href="{{url('/picture/create')}}"> 新規登録</a>
        </div>
        @if(!empty($pictures) || !is_null($pictures))

            <table class="table table-striped custab">
                <thead>
                    <tr class="d-flex">
                        <th class="col-1">画像ID</th>
                        <th class="col-3">⽤途</th>
                        <th class="col-2">種別</th>
                        <th class="col-4">画像</th>
                        <th class="col-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pictures as $picture)
                        <tr class="d-flex">
                            <td class="col-1">{{$picture->id}}</td>
                            <td class="col-3">{{$picture->description}}</td>
                            <td class="col-2">{{config('const.picture_type')[$picture->type]}}</td>
                            <td class="col-4"><img class="img-thumbnail" src="{{ asset('storage/imgs/' . $picture->url) }}" style="height:130px; width:150px" alt="{{ $picture->url }}"> </td>
                            <td class="col-2">
                                <a class="btn btn-info btn-md" href="{{ route('picture.edit', ['id' => $picture->id]) }}">詳細/編集</a>
                                <a class="btn btn-danger btn-md" onclick="return confirm('この内容を削除しますか︖')" href="{{ route('picture.delete', ['id' => $picture->id]) }}">削除</a>
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
