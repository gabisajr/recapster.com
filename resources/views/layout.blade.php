<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
<script>
  window.app = {
    username: '{{ Auth::check() ? Auth::getUser()->username : "" }}'
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

# fancybox
//  echo HTML::style('/vendor/fancybox/source/jquery.fancybox.css') . PHP_EOL;
//
//  # jquery ui
//  echo HTML::style('/vendor/jquery-ui-1.11.4/jquery-ui.css') . PHP_EOL;
//
//  # fontawesome
//  echo HTML::style('/vendor/font-awesome-4.5.0/css/font-awesome.min.css') . PHP_EOL;
//
//  # jquery.powertip-1.2.0
//  echo HTML::style('/vendor/jquery.powertip-1.2.0/jquery.powertip.min.css') . PHP_EOL;
    ?>

{{--<link rel="stylesheet" href="{{ asset('lib/bootstrap/bootstrap.min.css') }}">--}}

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


<script src="/lib/require.js"></script>
<script>requirejs(['/js/common.js'], function () { require(['/js/main.js', '@yield('page_js')']) })</script>

@if(config('app.env') == 'production')
  {{--todo replace by google tag manager--}}
  @include('partials.yandex-metrika')
@endif
</body>
</html>