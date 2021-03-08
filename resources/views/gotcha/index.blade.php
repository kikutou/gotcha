@extends('layouts.app')

@if($message)
    <div>
        <p>{{＄message}}</p>
    </div>
@endif

@section('content')
    <section class="content-header">

        <div class="mt-3 mb-3">
            <a class="btn btn-primary btn-lg active" role="button" aria-pressed="true" href="{{url('gotcha_create')}}">新規登録</a>
        </div>

        <div class="">
            @if(!empty($gotchas) || !is_null($gotchas))
                <form action="{{url('gotcha_edit')}}" method="get">
                    @csrf
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
