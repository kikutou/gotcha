@extends('layouts.app')

<style>
    .wrapper {
      margin-top: 80px;
      margin-bottom: 20px;
    }

    .form-signin {
      max-width: 420px;
      padding: 30px 38px 66px;
      margin: 0 auto;
      background-color: #FAFAFA;
      border: 3px dotted rgba(0, 0, 0, 0.1);
    }

    .form-signin-heading {
      text-align: center;
      margin-bottom: 30px;
    }

    .form-control {
      position: relative;
      font-size: 16px;
      height: auto;
      padding: 10px;
    }

    input[type="text"] {
      margin-bottom: 0px;
      border-bottom-left-radius: 0;
      border-bottom-right-radius: 0;
    }

    input[type="password"] {
      margin-bottom: 20px;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }

    .colorgraph {
      height: 3px;
      border-top: 0;
      background: #c4e17f;
      border-radius: 5px;
      background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
      background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
      background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
      background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
    }
  </style>
@section('content')
    @if($message)
        <div class="alert alert-primary" role="alert">
            <p>{{$message}}</p>
        </div>
    @endif
    <section class="container">
        <h3 class="mb-3 mt-6">画像一覧</h3>
        <a class="btn btn-primary btn-md pull-left mb-3" href="{{url('/picture/create')}}"> 新規登録</a>
            @if(!empty($pictures) || !is_null($pictures))

                    <table class="table table-striped custab">
                        <thead>
                            <tr class="d-flex">
                                <th class="col-1">画像ID</th>
                                <th class="col-3">⽤途</th>
                                <th class="col-2">種別</th>
                                <th class="col-4">画像</th>
                                <th class="col-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pictures as $picture)
                                <!-- TODO loops -->
                                <tr class="d-flex">
                                    <td class="col-1">{{$picture->id}}</td>
                                    <td class="col-3">{{$picture->description}}</td>
                                    <td class="col-2">{{config('const.picture_type')[$picture->type]}}</td>
                                    <td class="col-4"><img class="img-thumbnail" src="{{ asset('storage/imgs/' . $picture->url) }}" alt="{{ $picture->url }}"> </td>
                                    <td class="col-2">
                                        <a class="btn btn-danger" href="{{ route('picture.edit', ['id' => $picture->id]) }}">詳細/編集</a>
                                        <a class="btn btn-danger" href="{{ route('picture.delete', ['id' => $picture->id]) }}">削除</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            @else
            <p>該当情報がありません</p>
            @endif
        </div>
    </section>
@endsection
