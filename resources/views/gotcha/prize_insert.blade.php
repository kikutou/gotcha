@extends('layouts.app')

@section('content')
    <div class="row">
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
                            <tr class="d-none">
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
        <div class="col-sm-4">
            <div class="scroll-top">
                <a class="text-dark" href="javascript:add();">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
@endsection