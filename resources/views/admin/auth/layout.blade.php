<!DOCTYPE html>
<html lang="ru">
<meta charset="utf-8">
<link rel="shortcut icon" href="/favicon.ico?v=2" type="image/x-icon">
<title>@yield('title')</title>
<link rel="stylesheet" href="{{ asset('admin-assets/css/lukas-admin.min.css') }}" type="text/css">
</html>
<body>
<main class="d-flex h-100 flex-column">
  <div id="page-wrapper" class="d-flex flex-column align-items-center justify-content-center pt-5 pb-5">

    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col col-auto">
          @yield('content')
        </div>
      </div>
    </div>

  </div>
</main>
</body>