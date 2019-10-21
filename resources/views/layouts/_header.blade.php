<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">首页 <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbar-more" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">更多</a>
                    <div class="dropdown-menu" aria-labelledby="navbar-more">
                        <a class="dropdown-item" href="#">Action 1</a>
                        <a class="dropdown-item" href="#">Action 2</a>
                    </div>
                </li>
            </ul>

            <ul class="navbar-nav navbar-right">
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">登录</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="nav-link">注册</a>
                </li>
            </ul>
        </div>
    </div>
</nav>