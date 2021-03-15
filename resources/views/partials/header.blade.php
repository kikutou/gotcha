    <nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-center">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link h4 mr-3
                {{ isset($title) && $title == "ガチャ-ガチャ" ? "active" : "" }}
                " href="{{url('gotcha')}}">ガチャ</a>
            </li>

            <li class="nav-item">
                <a class="nav-link h4 mr-3
                {{ isset($title) && $title == "ガチャ-景品" ? "active" : "" }}
                 " href="{{url('prize')}}">景品</a>
            </li>
            <li class="nav-item">
                <a class="nav-link h4 mr-3
                {{ isset($title) && $title == "ガチャ-画像" ? "active" : "" }}
                " href="{{url('picture')}}">画像</a>
            </li>

            <li class="nav-item">
                <a class="nav-link h4 mr-3
                {{ isset($title) && $title == "ガチャ結果一覧" ? "active" : "" }}
                " href="{{url('result')}}">ガチャ結果一覧</a>
            </li>

            <li class="nav-item">
                <a class="nav-link h4 mr-3" href="{{url('gotcha')}}">ログ</a>
            </li>
            <!-- Authentication Links -->
            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link h4 mr-3 btn-primary rounded" href="{{ route('login') }}">ログイン</a>
                    </li>
                @endif
                                
            @else
                <li class="nav-item dropdown pull-right">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle h4 mr-3 btn-primary rounded" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item" href="{{ route('get_change_password') }}">パスワード変更</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </nav>
