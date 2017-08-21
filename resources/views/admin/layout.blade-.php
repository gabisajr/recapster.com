<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="language" content="Russian">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="recapster.kz - Отзывы о компаниях">
  <meta name="author" content="Lukas Pierce">
  <title>@yield('title')</title>
  <?

//  # jQuery UI
//  echo HTML::style('/vendor/jquery-ui-1.11.4/jquery-ui.css');
//
//  # fontawesome
//  echo HTML::style('/vendor/font-awesome-4.5.0/css/font-awesome.min.css');
//
//  # Bootstrap
//  echo HTML::style('/vendor/bootstrap/bootstrap.min.css') . PHP_EOL;
//  echo HTML::style('/vendor/bootstrap/bootstrap-switch.min.css') . PHP_EOL;
//  echo HTML::style('/vendor/bootstrap/bootstrap-select/css/bootstrap-select.min.css') . PHP_EOL;
//
//  # Fancytree
//  echo HTML::style('/vendor/fancytree/skin-win8/ui.fancytree.min.css') . PHP_EOL;
//
//  # Tag Editor
//  echo HTML::style('/vendor/jquery-tag-editor/jquery.tag-editor.css') . PHP_EOL;
//
  ?>
  {{--Custom CSS--}}
  <link rel="stylesheet" href="{{ asset('lib/sb-admin.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin-assets/css/upsell-admin.css') }}">
</head>
<body>
<div id="wrapper">
  @include('admin.partials.navigation')
  <div id="page-wrapper">
    @include('admin.partials.message')
    @yield('content')
  </div>
</div>
<script src="/lib/require.js"></script>
<script>requirejs(['/admin-assets/js/common.js'], function () { requirejs(['/admin-assets/js/main.js', '@yield('page_js')']) })</script>
</body>
</html>