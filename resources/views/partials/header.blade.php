    <nav class="navbar navbar-expand-sm bg-dark mb-0 rounded-0 navbar-dark flex-row-reverse">
        <ul class="navbar-nav">
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
                        アドミン
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
