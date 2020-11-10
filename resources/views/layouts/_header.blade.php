<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
  <div class="container">
      <!-- Branding Image -->
      <a class="navbar-brand " href="{{ url('/') }}">
      易新闻
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Side Of Navbar -->

      <ul class="navbar-nav mr-auto">
        <li class="nav-item {{ active_class(if_route('articles.index')) }}"><a class="nav-link" href="{{ route('articles.index') }}">全部</a></li>
        <li class="nav-item {{ category_nav_active(1) }}"><a class="nav-link" href="{{ route('categories.show', 1) }}">热点</a></li>
        <li class="nav-item {{ category_nav_active(2) }}"><a class="nav-link" href="{{ route('categories.show', 2) }}">财经</a></li>
        <li class="nav-item {{ category_nav_active(3) }}"><a class="nav-link" href="{{ route('categories.show', 3) }}">娱乐</a></li>
        <li class="nav-item {{ category_nav_active(4) }}"><a class="nav-link" href="{{ route('categories.show', 4) }}">科技</a></li>
        <li class="nav-item {{ category_nav_active(5) }}"><a class="nav-link" href="{{ route('categories.show', 5) }}">旅游</a></li>
        <li class="nav-item {{ category_nav_active(6) }}"><a class="nav-link" href="{{ route('categories.show', 6) }}">体育</a></li>
      </ul>

      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav navbar-right">
          <!-- Authentication Links -->
          @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登录</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">注册</a></li>
          @else
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="{{Auth::user()->avatar}}" class="img-responsive img-circle avatar" width="30px" height="30px">
              {{ Auth::user()->name }}
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{route('users.show',Auth::id())}}">
                <i class="far fa-user mr-2"></i>
                个人中心</a>
              <a class="dropdown-item" href="{{route('users.edit',Auth::id())}}">
                <i class="far fa-edit mr-2"></i>
                编辑资料</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" id="logout" href="#">
                  <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('您确定要退出吗？')">
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
