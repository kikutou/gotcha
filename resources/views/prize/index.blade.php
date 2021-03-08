@extends('layouts.app')

@if($message)
    <div>
        <p>{{＄message}}</p>
    </div>
@endif

@section('content')
    <section class="content-header">
        <div class="mt-3 mb-3">
           <h1>景品一覧</h1>
        </div>
        <div class="mt-3 mb-3">
            <a class="btn btn-primary btn-lg active" role="button" aria-pressed="true" href="{{url('prize_create')}}">新規登録</a>
        </div>

        <div class="">
            @if(!empty($prizes) || !is_null($prizes))
                <form action="{{url('gotcha_edit')}}" method="get">
                    @csrf
                    <table class="table table-dark(thead-light)">
                        <tr>
                            <td>景品ID</td>
                            <td>景品名</td>
                            <td>種別</td>
                            <td>画像</td>
                        </tr>
                        @foreach($prizes as $prize)
                        <!-- TODO loop -->
                        <tr>
                            <td>{{$prize->id}}</td>
                            <td>{{$prize->name}}</td>
                            <td>{{$prize->type}}</td>
                            <td>{{$prize->picture_id}}</td>
                            <td>
                                <input type="submit" value="詳細/編集" id="edit">
                                <input type="hidden" name="gotcha_id" id="gotcha_id" value="{{$gotcha->id}}">
                            </td>
                            <td><input type="submit" value="削除" id="delete"></td>
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
