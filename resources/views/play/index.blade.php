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
    <script type="text/javascript">
        gotcha_id = {!! json_encode($gotcha_id) !!};
        if (gotcha_id != ""){
            $(function(){
                $("#result-" + gotcha_id).modal("toggle");
            })
        }
        function gotcha(id){
            $("#gotcha-" + id).modal("hide");
            $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            },
            url: "http://18.181.193.90/api/gotcha_result",
            type: "POST",
            dataType: "json",
            data: {
                "uid":{{$uid}},
                "api_token":"{{$api_token}}", 
                "gotcha_id": id 
            }
        })
            // Ajaxリクエストが成功した場合
            .done(function (data) {
                var html = '<button id="btn-result-close" type="button" class="btn btn-sm" onclick="resultModal(' + data.redirect_url + ')">はい</button>';
                $("#result-gotcha-img").attr("src",data.gotcha_result_img_url);
                $("#result-prize-img").attr("src",data.prize_img_url);
                $("#result-prize-name").text(data.prize_name);
                $("#btn-area").append(html);
                $("#result").modal("toggle");
                
            })
            // Ajaxリクエストが失敗した場合
            .fail(function (data) {
                $("#resultLabel").text("失敗しました");
                
            });
        }

        function resultModal(url){
            $('#result').modal('hide');
            $("#btn-result-close").remove();
            if(url == null){
                location.reload();
            }else{
                window.location.href = url;
            }
        }
    </script>
</head>

<body>



<div class="container">
    <input type="hidden" id="gotcha_id" name="gotcha_id" value="{{isset($gotcha_id) ? $gotcha_id : ''}}">
    @foreach($gotchas as $gotcha)
    
            <div class="text-center">
                <div>
                    <h2>{{ $gotcha["name"] }}</h2>
                    <div>
                        <img style="width: 50%" src="{{ $gotcha['img_url'] }}">
                    </div>
                </div>

                <div class="text-center">
                    <button class="btn btn-primary btn-lg mt-3" data-toggle="modal" data-target="#gotcha-detail-{{ $gotcha['id'] }}">内容物詳細</button>
                </div>

                <div class="text-center">

                    <h3>{{ $gotcha["cost_name"] }} {{ $tickets }}/{{ $gotcha["cost_value"] }}枚</h3>
                    @if($tickets >= $gotcha["cost_value"])
                        <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#gotcha-{{ $gotcha['id'] }}"  data-backdrop="static" data-keyboard="false">ガチャを引く</button>
                    @else
                        <p>チケットが足りないです。</p>
                    @endif
                </div>
            </div>

            <!-- 模态框（Modal） -->
            <div class="modal fade" id="gotcha-{{ $gotcha['id'] }}" tabindex="-1" role="dialog" aria-labelledby="sliverLabel-{{ $gotcha['id'] }}"
                aria-hidden="true">
                <div class="modal-dialog" style="height:800px">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h4 class="modal-title" id="sliverLabel-{{ $gotcha['id'] }}" style=" text-align:center">{{ $gotcha["name"] }}を引きますか? </h4>
                        </div>

                        <div class="modal-body text-center">
                            <div class="text-center">
                                <img style="width: 50%" src="{{ $gotcha['img_url'] }}">
                            </div>
                            <p>{{ $gotcha["cost_name"] }} 消費数 {{ $gotcha["cost_value"] }}枚</p>
                        </div>

                        <div class="text-center">
                            <div>
                            <button class="btn btn-primary" type="submit" onclick="gotcha({{$gotcha['id']}})">はい</button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">いいえ</button>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- 模态框（Modal） -->
            <div class="modal fade" id="gotcha-detail-{{ $gotcha['id'] }}" tabindex="-1" role="dialog" aria-labelledby="sliverLabel-{{ $gotcha['id'] }}"
                aria-hidden="true">
                <div class="modal-dialog" style="height:800px">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h4 class="modal-title" id="sliverLabel-{{ $gotcha['id'] }}" style=" text-align:center">景品詳細</h4>
                        </div>

                        <div class="modal-body text-center">
                            @foreach($gotcha['prizes'] as $prize)

                                <div class="row">
                                    <div class="col-4">
                                        <img class="w-75" src="{{ $prize['img_url'] }}">
                                    </div>
                                    <div class="col-8">
                                        <p>{{ $prize["name"] }}</p>
                                    </div>
                                </div>
                                @if(!$loop->last)
                                <br>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
    <br>
    @endforeach


    <div class="modal fade" id="result" tabindex="-1" role="dialog" aria-labelledby="resultLabel"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" style="height:800px">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="resultLabel" style=" text-align:center">おめでとう！ </h4>
                </div>

                <div class="modal-body text-center">
                    <div class="text-center">
                        <img id="result-gotcha-img" style="width: 50%" src="">
                    </div>
                    <p>以下の獲得しました。</p>
                    <div class="row">

                        <div class="col-4">
                            <img width="80%" id="result-prize-img" src="">
                        </div>
                        <div class="col-8">
                            <p id="result-prize-name"></p>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <div id="btn-area">
                    </div>
                </div>

            </div>

        </div>

    </div>

</body>

</html>