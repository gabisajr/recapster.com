@extends('admin.auth.layout')

@section('title')Восстановить доступ в админку@endsection

@section('content')

  @if (session('status'))
    <div class="alert alert-success">
      {!! session('status') !!}
    </div>
  @else
    <form method="post" class="auth-form" action="{{ route('admin.password.email') }}">
      <h1 class="h5 mb-3">
        Восстановление пароля
      </h1>

      {{ csrf_field() }}
      <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
        <input type="email" name="email" placeholder="fake" hidden>
        <input type="email" name="email" required class="form-control" placeholder="Введите ваш e-mail"
               autocomplete="off" value="{{ old('email') }}">
        <div class="form-control-feedback">{{ $errors->first('email') }}</div>
      </div>
      <button type="submit" class="btn btn-primary btn-block">Сбросить пароль</button>
      <div class="text-center mt-3">
        <a href="{{ route('admin.login') }}">Я помню пароль</a>
      </div>
    </form>
  @endif
@endsection