<!DOCTYPE html>
<html lang="{{ Lang::locale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Lukas Pierce">
<title>@yield('title', 'Admin')</title>
<link rel="stylesheet" href="{{ asset('lib/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets-admin/css/lukas-admin.min.css') }}">
<script>
  window.app = {
    csrfToken: '{{ csrf_token() }}',
    name: '{{ config('app.name') }}'
  };
</script>
</head>
<body>
<main class="d-flex flex-column">
  @include('admin.partials.nav')
  <div class="row h-100 no-gutters flex-nowrap">
    <div class="col col-auto h-100 bg-faded">
      @include('admin.partials.sidebar')
    </div>
    <div class="col">
      <div class="container-fluid pt-3 pb-5">
        @include('admin.partials.message')
        @yield('content')
      </div>
    </div>
  </div>
  @include('admin.modal.confirm')
</main>
<script src="//cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="/lib/require.js"></script>
<script>
  require(['/assets-admin/js/common.js'], function () {
    require(['/assets-admin/js/main.js'], function () {
      var pageJs = '@yield('page_js')';
      if (pageJs) {
        require([pageJs]);
      }
    });
  });
</script>
</body>
</html>