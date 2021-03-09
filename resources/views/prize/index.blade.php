@extends('layouts.app')

@section('content')
    <section class="container">
        <h3 class="mb-3 mt-6">景品一覧</h3>
        <a class="btn btn-primary btn-md pull-left mb-3" href="{{url('/prize/create')}}"> 新規登録</a>
        @if(!empty($prizes) || !is_null($prizes))
            <form action="{{url('get_gotcha_edit')}}" method="get">
                @csrf
                <table class="table table-striped custab">
                    <thead>
                        <tr>
                            <th>景品ID</th>
                            <th>景品名</th>
                            <th>種別</th>
                            <th>画像</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($prizes as $prize)
                        <!-- TODO loop -->
                        <tr>
                            <td>{{$prize->id}}</td>
                            <td>{{$prize->name}}</td>
                            <td>{{$prize->type}}</td>
                            <td>{{$prize->picture_id}}</td>
                            <td>
                                <button class="btn btn-info btn-xs" type="submit" value="詳細/編集" id="edit">
                                <button class="btn btn-danger btn-xs" type="submit" value="削除" id="delete">
                                <input type="hidden" name="prize_id" id="prize_id" value="{{$prize->id}}">
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
