    
    <div class="dashboard-header">
        <nav class="navbar navbar-expand-lg sidebar-dark fixed-top">
            <ul class="navbar-nav ml-auto navbar-right-top">
                <!-- Authentication Links -->
                <!-- @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link h4 mr-3 btn-primary rounded" href="{{ route('login') }}">ログイン</a>
                        </li>
                    @endif
                                        
                @else -->
                    <li class="nav-divider dropdown">
                        <a class="dropdown-toggle nav-link h5 pt-0 pb-0 mt-1 btn-primary nounderline" data-toggle="dropdown" href="#">
                            アドミン
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="{{ route('get_change_password') }}"><i class="fa fa-user fa-fw"></i>パスワード変更</a>
                            </li>
                            <li><a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out fa-fw"></i>{{ __('Logout') }}</a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </li>
                <!-- @endguest -->
            </ul>
        </nav>
    </div>
