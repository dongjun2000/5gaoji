<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ active_class(if_route('home')) }}">
                    <a class="nav-link" href="{{ route('home') }}">首页 <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item {{ category_nav_active(1) }}">
                    <a class="nav-link" href="{{ route('categories.show', 1) }}">分享</a>
                </li>
                <li class="nav-item {{ category_nav_active(2) }}">
                    <a class="nav-link" href="{{ route('categories.show', 2) }}">教程</a>
                </li>
                <li class="nav-item {{ category_nav_active(3) }}">
                    <a class="nav-link" href="{{ route('categories.show', 3) }}">问答</a>
                </li>
                <li class="nav-item {{ category_nav_active(4) }}">
                    <a class="nav-link" href="{{ route('categories.show', 4) }}">公告</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbar-more" data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">更多</a>
                    <div class="dropdown-menu mt-0" aria-labelledby="navbar-more">
                        <a class="dropdown-item" href="#">Action 1</a>
                        <a class="dropdown-item" href="#">Action 2</a>
                    </div>
                </li>
            </ul>

            <ul class="navbar-nav navbar-right">
                @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">登录</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link">注册</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('topics.create') }}" class="nav-link mt-1 mr-3 font-weight-bold">
                            <i class="fa fa-plus"></i>
                        </a>
                    </li>

                    <li class="nav-item notification-badge">
                        <a href="{{ route('notifications.index') }}" class="nav-link mr-3 badge badge-pill badge-{{ Auth::user()->notification_count > 0 ? 'hint' : 'secondary' }} text-white">
                            {{ Auth::user()->notification_count }}
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{ route('users.show', Auth::user()) }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ Auth::user()->avatar }}" class="img-responsive img-circle mr-1" width="30px" height="30px">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu mt-0" aria-labelledby="navbarDropdown">

                            @can('manage_contents')
                                <a class="dropdown-item" href="{{ url(config('administrator.uri')) }}">
                                    <i class="fas fa-tachometer-alt"></i>
                                    管理后台
                                </a>
                                <div class="dropdown-divider"></div>
                            @endcan

                            <a class="dropdown-item" href="{{ route('users.show', Auth::user()) }}">
                                <i class="far fa-user"></i>
                                个人中心
                            </a>
                            <a class="dropdown-item" href="{{ route('users.edit', Auth::user()) }}">
                                <i class="far fa-edit"></i>
                                编辑资料
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" id="logout" href="#">
                                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('您确定要退出码？')">
                                    {{ csrf_field() }}
                                    <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                                </form>
                            </a>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>