@extends('layouts.app')

@if($message)
    <div>
        <p>{{＄message}}</p>
    </div>
@endif

@section('content')
    <section class="content-header">
        <div class="mt-3 mb-3">
           <h1>画像一覧</h1>
        </div>
        <div class="mt-3 mb-3">
            <a class="btn btn-primary btn-lg active" role="button" aria-pressed="true" href="{{url('picture_create')}}">新規登録</a>
        </div>

        <div class="">
            @if(!empty($pictures) || !is_null($pictures))
                <form action="{{url('picture_edit')}}" method="post">
                    @csrf
                    <table class="table table-dark(thead-light)">
                        <tr class="d-flex">
                            <td class="col-3">画像ID</td>
                            <td class="col-3">⽤途</td>
                            <td class="col-3">種別</td>
                            <td class="col-6">画像</td>
                        </tr>
                        @foreach($pictures as $picture)
                        <!-- TODO loop -->
                        <tr class="d-flex">
                            <td class="col-3">{{$picture->id}}</td>
                            <td class="col-3">{{$picture->description}}</td>
                            <td class="col-3">{{config('const.picture_type')[$picture->type]}}</td>
                            <td class="col-8"><img src="{{ asset('image/' . $picture->url) }}" alt="{{ $picture->url }}"> </td>
                            <td class="col-2">
                                <button class="btn btn-danger" name="edit" type="submit">詳細/編集</button> 
                            </td>
                            <td class="col-2">
                                <button class="btn btn-danger" name="delete" type="submit">削除</button>
                                <input type="hidden" n  ame="picture_id_{{$picture->id}}" id="picture_id_{{$picture->id}}" value="{{$picture->id}}">
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </form>
            @else
            <p>該当情報がありません</p>
            @endif
        </div>
    </section>
@endsection
