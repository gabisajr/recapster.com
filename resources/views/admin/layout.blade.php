<!DOCTYPE html>
<html lang="{{ Lang::locale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Lukas Pierce">
<title>{{ $title }}</title>
<link rel="stylesheet" href="{{ asset('assets-admin/css/lukas-admin.min.css') }}" type="text/css">
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
@include('admin.partials.sidebar')
<main>
  <div class="container-fluid pt-3 pb-5">
    @yield('content')
  </div>
</main>
</body>
</html>