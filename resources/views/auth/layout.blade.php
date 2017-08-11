@php
  /**
   * @var string $title
   * @var string $bot_text
   */
@endphp
    <!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="shortcut icon" href="{{ asset('/favicon.ico?v=3') }}"/>
<title>{{ $title }}</title>
{{--<link rel="stylesheet" href="{{ asset('lib/bootstrap/bootstrap.min.css') }}">--}}
<link rel="stylesheet" href="{{ asset('/css/app.min.css') }}">
@php
  # other styles
  if (isset($styles) && is_array($styles)) foreach ($styles as $style) echo HTML::style($style) . PHP_EOL;
@endphp
</head>
<body>
<div class="container no-pad-xs">
  <div class="row justify-content-center">
    <div class="col col-auto">
      <div class="auth">
        <a href="{{ route('home') }}" class="hidden-xs"><img src="{{ asset('images/logo-black.png') }}" class="auth-logo"></a>
        @yield('content')
        @if (isset($bot_text) && $bot_text)
          <div class="auth-bot-text text-center marg-top">{{ $bot_text }}</div>
        @endif
        <footer class="auth-footer">© {{ date('Y') }} {{ config('app.name') }}</footer>
      </div>
    </div>
  </div>
</div>
@if (isset($main_js))
  <script src="{{ asset('/lib/require.js') }}"></script>
  <script>requirejs(['/js/common.js'], function () { requirejs(['{{ $main_js }}']) })</script>
@endif
</body>
</html>