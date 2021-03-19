@extends('layouts.app')

@section('content')

    <div class="col-sm-8"> 
        <section>
            <div class="page-title justify-content-center">
                <h3 class="mb-3 mt-6">景品テーブル登録</h3>
            </div>
            <form action="{{url('/gotcha/prize')}}" method="post" enctype="multipart/form-data">
                @csrf
                <br style="clear:both">
                <label for="id">ガチャID：</label>{{$id}}
                <input type="hidden" id="id" name="id" value="{{$id}}">
                <table id="prize_data" class="table-bordered w-100">
                    <thead>
                        <tr>
                            <th class="w-25">景品名</th>
                            <th class="w-25">重み</th>
                            <th class="w-25">参考出現率(%)</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="hidden">
                            <td>
                                <select id="clone_option" name="prize_id[]" class="optionSelect">
                                    <option value="" selected>
                                        景品を選択してください
                                    </option>
                                    @foreach ($prizes as $prize)
                                        <option value="{{$prize->id}}">{{$prize->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @for($row = 0; $row < 10; $row++)
                        <tr>
                            <td>
                                <select id="id_{{$row}}" name="prize_id[]" class="optionSelect">
                                    <option value="" selected>
                                        景品を選択してください
                                    </option>
                                    @foreach ($prizes as $prize)
                                        <option value="{{$prize->id}}"

                                                @if(isset($records[$row]) and $records[$row]["prize_id"] == $prize->id)
                                                    selected
                                                @endif

                                        >{{$prize->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" class="frequency form-control" id="frequency_{{$row}}" name="frequency[]" value="@if(isset($records[$row])){{ $records[$row]["frequency"] }}@endif">
                            </td>
                            <td>
                                <p id="occurrence_rate_{{$row}}">
                                    @if(isset($records[$row]))
                                        {{ $records[$row]["chance"] }}
                                    @endif
                                </p>
                            </td>
                        </tr>

                        @endfor
                    </tbody>
                </table>

                <div class="row mt-3">
                    <div class="col-xs-6 col-md-6 text-left">
                        <button type="submit" id="insert" name="insert" class="btn btn-success" >登録する</button>
                    </div>
                </div> 
            </form>
        </section>
    </div>
    <div class="col-sm-1">
        <div class="scroll-top">
            <a class="btn btn-dark btn-circle" href="javascript:add();">+</a>
        </div>
    </div>
@endsection