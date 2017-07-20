@extends('admin.auth.layout')

@section('content')
  @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif

  <form class="auth-form" method="post" action="{{ route('admin.password.reset.post') }}">
    {{ csrf_field() }}

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
      <label for="email">Ваш E-mail</label>
      <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required>

      @if ($errors->has('email'))
        <div class="form-control-feedback">{{ $errors->first('email') }}</div>
      @endif
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
      <label for="password">Придумайте пароль</label>
      <input id="password" type="password" class="form-control" name="password" required>
      <div class="form-control-feedback">{{ $errors->first('password') }}</div>
    </div>

    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
      <label for="password-confirm">Повторите пароль</label>
      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
      <div class="form-control-feedback">{{ $errors->first('password_confirmation') }}</div>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-primary btn-block">
        Изменить пароль
      </button>
    </div>
  </form>
@endsection