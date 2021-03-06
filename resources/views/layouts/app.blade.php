<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', '易新闻') - 易新闻 一个简单便捷的自媒体新闻发布平台</title>

  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

  @yield('styles')

</head>

<body>
  <div id="app" class="{{ route_class() }}-page">

    @include('layouts._header')

    <div class="container">

      @include('shared._messages')

      @yield('content')

    </div>

    @include('layouts._footer')
  </div>

  @if (app()->isLocal())
  @include('sudosu::user-selector')
  @endif

<!-- Scripts -->

  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}"></script>
  @yield('scripts')

</body>

</html>
