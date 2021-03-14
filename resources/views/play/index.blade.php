<!DOCTYPE html>
<html>
<head>
    <title>チケットガチャ</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <style>

        body {
            padding-top: 20px
        }


    </style>

</head>

<body>



<div class="container">

    @foreach($gotchas as $gotcha)

    <div class="text-center">

        <div>
            <h2>{{ $gotcha->name }}</h2>
            <div>
                <img style="width: 50%" src="{{ asset('storage/imgs/'.$gotcha->picture->url) }}">
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('get_play_list', ['id' => $gotcha->id]) }}?sid={{ $sid }}">内容物詳細</a>
        </div>

        <div class="text-center">

            <h3>{{ $gotcha->cost_name }} {{ $tickets }}/{{ $gotcha->cost_value }}枚</h3>
            @if($tickets >= $gotcha->cost_value)
            <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#gotcha-{{ $gotcha->id }}"  data-backdrop="static" data-keyboard="false">ガチャを引く</button>
            @else
                <p>チケットが足りないです。</p>
            @endif
        </div>
    </div>


    <!-- 模态框（Modal） -->
    <div class="modal fade" id="gotcha-{{ $gotcha->id }}" tabindex="-1" role="dialog" aria-labelledby="sliverLabel-{{ $gotcha->id }}"
         aria-hidden="true">
        <div class="modal-dialog" style="height:800px">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="sliverLabel-{{ $gotcha->id }}" style=" text-align:center">{{ $gotcha->name }}を引きますか? </h4>
                </div>

                <div class="modal-body text-center">
                    <div class="text-center">
                        <img style="width: 50%" src="{{ asset('storage/imgs/'.$gotcha->picture->url) }}">
                    </div>
                    <p>{{ $gotcha->cost_name }} 消費数 {{ $gotcha->cost_value }}枚</p>
                </div>

                <div class="text-center">
                    <div>
                        <a href="{{ route('get_play_result', ['id' => $gotcha->id]) }}?sid={{ $sid }}">はい</a>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm" data-dismiss="modal">いいえ</button>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- 模态框（Modal） -->
    <div class="modal fade" id="result-{{ $gotcha->id }}" tabindex="-1" role="dialog" aria-labelledby="resultLabel-{{ $gotcha->id }}"
         aria-hidden="true">
        <div class="modal-dialog" style="height:800px">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="resultLabel-{{ $gotcha->id }}" style=" text-align:center">シおめでとう！ </h4>
                </div>

                <div class="modal-body text-center">
                    <div class="text-center">
                        <img style="width: 50%" src="{{ asset('storage/imgs/'.$gotcha->picture->url) }}">
                    </div>
                    <p>以下の獲得しました。</p>
                    <div class="row">

                        <div class="col-4">
                            <img width="80%" src="https://gacha-lab.tech/data/img/products/pipit/slider02.jpg">
                        </div>
                        <div class="col-8">
                            <p>景品名</p>
                        </div>



                    </div>
                </div>

                <div class="text-center">
                    <div>
                        <button class="btn btn-primary text-align: center">はい</button>
                    </div>

                </div>

            </div>

        </div>

    </div>
        <hr>

    @endforeach


</div>


</body>

</html>