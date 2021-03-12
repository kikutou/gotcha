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

    <h3>景品詳細</h3>

    @foreach($gotcha->prizes as $prize)

        <div class="row">
            <div class="col-4">
                <img class="w-75" src="{{ asset('storage/imgs/'.$prize->picture->url) }}">
            </div>
            <div class="col-8">
                <p>{{ $prize->name }}</p>
            </div>
        </div>

    @endforeach



</div>


</body>

</html>