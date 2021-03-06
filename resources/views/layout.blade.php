<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
<script>
  window.app = {
    username: '{{ Auth::check() ? Auth::getUser()->username : "" }}',
    csrfToken: '{{ csrf_token() }}',
    name: '{{ config('app.name') }}'
  }
</script>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="language" content="Russian">
<link rel="shortcut icon" href="{{ asset('/favicon.ico?v=3') }}"/>
<title>{{ $title }}</title>
<meta name="title" content="{{ $title }}">
<meta name="msapplication-tap-highlight" content="no"/>
@yield('page_meta')
<?
//  # bootstrap select
//  echo HTML::style('/vendor/bootstrap/bootstrap-select/css/bootstrap-select.min.css') . PHP_EOL;
//
//  # other styles
//  if (isset($styles) && is_array($styles)) foreach ($styles as $style) echo HTML::style($style) . PHP_EOL;

?>
<link rel="stylesheet" href="{{ asset('/css/app.min.css') }}">
</head>
<body class="@yield('body_class')" data-logged="{{ Auth::check() }}">

<main>
  @include('partials.header')
  <div id="page-wrapper">
    @yield('tip')
    @yield('header_banner')
    <div class="page-content">
      @yield('content')
    </div>
  </div>

  @php /* if (isset($join_socials)) echo $join_socials; */ @endphp
  @include('partials.footer')
</main>

<script src="/dist/js/common.bundle.js"></script>
@yield('scripts')

@if(config('app.env') == 'production')
  {{--todo replace by google tag manager--}}
  @include('partials.yandex-metrika')
@endif
</body>
</html>