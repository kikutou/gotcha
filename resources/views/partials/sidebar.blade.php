
    <div class="nav-left-sidebar sidebar-dark">
        <div class="menu-list">
            <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link h4
                            {{ isset($title) && $title == "ガチャ-ガチャ" ? "active" : "" }}
                            " href="{{url('gotcha')}}">ガチャ一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link h4
                            {{ isset($title) && $title == "ガチャ-景品" ? "active" : "" }}
                            " href="{{url('prize')}}">景品一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link h4
                            {{ isset($title) && $title == "ガチャ-画像" ? "active" : "" }}
                            " href="{{url('picture')}}">画像一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link h4
                            {{ isset($title) && $title == "ログ一覧" ? "active" : "" }}
                            " href="{{url('log')}}">ログ一覧</a>
                        </li>
                    </ul>
            </nav>
        </div>
    </div>