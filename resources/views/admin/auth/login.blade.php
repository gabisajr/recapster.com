@extends('admin.auth.layout')

@section('title')Вход в админ-панель@endsection

@section('content')

  <form method="POST" class="auth-form" action="{{ route('admin.login.submit') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
      <label for="email">E-Mail</label>
      <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus onfocus="this.value = this.value">
      @if ($errors->has('email'))
        <div class="form-control-feedback">{{ $errors->first('email') }}</div>
      @endif
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
      <label for="password">Пароль</label>
      <input id="password" type="password" class="form-control" name="password" required>
      @if ($errors->has('password'))
        <div class="form-control-feedback">{{ $errors->first('password') }}</div>
      @endif
    </div>

    <div class="form-group">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Запомнить меня
        </label>
      </div>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-primary">
        Войти
      </button>

      <a class="btn btn-link" href="{{ route('admin.password.request') }}">
        Забыли свой пароль?
      </a>
    </div>
  </form>

@endsection
