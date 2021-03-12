@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="page-title justify-content-center">
            <h3 class="mb-3 mt-6 text-center">ガチャ景品登録</h3>
        </div>
        <form action="{{url('gotcha/edit')}}" method="post" enctype="multipart/form-data">
            @csrf
            <table id="prize_data" class="fixed_headers table-bordered">
                <thead>
                    <tr class="">
                        <th class="">景品ID</th>
                        <th class="">景品名(自動表示)</th>
                        <th class="">重み</th>
                        <th class="">参考出現率(%)</th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="">
                        <td class="">
                            <select id="id_0" name="prize_id[]" class="optionSelect">
                                <option value="" selected>
                                    景品を選択してください
                                </option>
                                @foreach ($prizes as $prize)
                                    <option value="{{$prize->id}}">{{$prize->id}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class=""><input type="text" class="form-control" id="prize_name" name="prize_name[0]" value="{{ old('prize_name') }}" readonly></td>
                        <td class=""><input type="number" class="frequency form-control" id="frequency" name="frequency[0]" value="{{ old('frequency') }}" readonly></td>
                        <td class=""><input type="text" class="form-control" id="occurrence_rate" name="occurrence_rate[0]" value="{{ old('occurrence_rate') }}" readonly></td>
                    </tr>
                </tbody>
            </table>

            <div class="row mt-3">
                <div class="col-xs-6 col-md-6 text-left">
                    <a class="btn btn-primary" id="add" name="add" onclick="return false;">行追加</a>
                    <a href="{{ route('gotcha') }}" class="btn btn-primary" >もどる</a>
                    <button type="submit" id="insert" name="insert" class="btn btn-success" >登録する</button>
                </div>
            </div> 
        </form>
    </section>
@endsection