@extends('layouts.app')

@section('content')
<section class="container">
    <section class="container">
        <div class="page-title justify-content-center">
            <h3 class="mb-3 mt-6 text-center">ログ一覧</h3>
        </div>
        <div class="table">
            <table class="table table-striped custab">
                <thead>
                    <tr>
                        <th>ログ内容</th>
                        <th>日付</th>
                    </tr>
                </thead>
                <tbody>
                @if($logs->total() > 0)
                    @foreach ($logs as $log)
                        <tr>
                            <td>{{$log->log}}</td>
                            <td>{{$log->created_at}}</td>
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
    <div class="d-flex justify-content-center">
        {!! $logs->links('vendor.pagination.bootstrap-4') !!}
    </div>

@endsection
