@extends('layouts.app')

@section('content')
<section class="container">
    <section class="container">
        <div class="page-title justify-content-center">
            <h3 class="mb-3 mt-6 text-center">チケット一覧</h3>
        </div>
        <div class="search">
            <form action="{{url('/ticket/search')}}" method="post">
                @csrf
                <div class="">
                    <label for="user_id">ユーザーID</label>
                    <input 
                        type="number"
                        class=""
                        placeholder=""
                        id="user_id"
                        name="user_id"
                        value="{{ old('user_id') }}"
                    >
                    <button type="sumbit">検索</button>
                    @if ($errors->first('user_id'))
                        <div class="text-danger">
                            <p class="validation">※{{$errors->first('user_id')}}</p>
                        </div>
                    @endif
                </div>
        <div>
        @if($get_tickets && $used_tickets && $rest_tickets)
        <div class="user_ticket_result">
            <span>チケット総取得数：{{$get_tickets}}</span>
            <span>チケット利用数：{{$used_tickets}}</span>
            <span>チケット残り数：{{$rest_tickets}}</span>
        </div>
        @endif
        <div class="table">
            <table class="table table-striped custab">
                <thead>
                    <tr>
                        <th>ユーザーID</th>
                        <th>チケット</th>
                        <th>タイプ</th>
                        <th>日付</th>
                    </tr>
                </thead>
                <tbody>
                @if(count($results) > 0)
                    @foreach ($results as $result)
                        <tr>
                            <td>{{$result->uid}}</td>
                            <td>{{$result->tickets}}</td>
                            <td>{{config('const.user_ticket_type')[$result->type]}}</td>
                            <td>{{$result->created_at}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8">該当情報がありません</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </section>
@endsection
