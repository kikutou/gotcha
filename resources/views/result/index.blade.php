@extends('layouts.app')

@section('content')
<section class="container">
    <section class="container">
        <div class="page-title justify-content-center">
            <h3 class="mb-3 mt-6 text-center">ガチャ結果一覧</h3>
        </div>
        @if(!empty($results) || !is_null($results))
            <table class="table table-striped custab">
                <thead>
                    <tr>
                        <th>ガチャID</th>
                        <th>ガチャ名</th>
                        <th>コスト名称</th>
                        <th>コスト値</th>
                        <th>利用者ID</th>
                        <th>景品ID</th>
                        <th>景品名称</th>
                        <th>ステータス</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td>{{$result->gotcha->id}}</td>
                            <td>{{$result->gotcha->name}}</td>
                            <td>{{$result->gotcha->cost_name}}</td>
                            <td>{{$result->gotcha->cost_value}}</td>
                            <td>{{$result->participant}}</td>
                            <td>{{$result->prize->id}}</td>
                            <td>{{$result->prize->name}}</td>
                            <td>{{config('const.result_status')[$result->status]}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>該当情報がありません</p>
        @endif
    </section>
    <div class="container fixed-bottom text-center">
        {{$results->links("pagination::bootstrap-4")}}
    </div>
@endsection
