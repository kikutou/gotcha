
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu list-unstyled">
            <li class="nav-item">
                <a class="nav-link h4
                {{ isset($title) && $title == "ガチャ-ガチャ" ? "active" : "" }}
                " href="{{url('gotcha')}}">ガチャ</a>
            </li>

            <li class="nav-item">
                <a class="nav-link h4
                {{ isset($title) && $title == "ガチャ-景品" ? "active" : "" }}
                " href="{{url('prize')}}">景品</a>
            </li>
            <li class="nav-item">
                <a class="nav-link h4
                {{ isset($title) && $title == "ガチャ-画像" ? "active" : "" }}
                " href="{{url('picture')}}">画像</a>
            </li>

            <li class="nav-item">
                <a class="nav-link h4
                {{ isset($title) && $title == "ログ一覧" ? "active" : "" }}
                " href="{{url('log')}}">ログ一覧</a>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </div>