<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <?/*
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
      */?>
    </ul>
    <ul class="navbar-nav navbar-right">
      <li class="nav-item dropdown">
        <div role="button" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->email }}</div>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="javascript:document.getElementById('logout-form').submit()">Выйти</a>
          <form hidden method="post" id="logout-form" action="{{ route('admin.logout') }}">{{ csrf_field() }}</form>
        </div>
      </li>
    </ul>
    {{--<span class="navbar-text">--}}
      {{--"kosha.industry@gmail.com"--}}
    {{--</span>--}}
  </div>
</nav>