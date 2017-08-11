@extends('auth.layout')

@section('content')
  <form class="panel auth-form" method="post" action="{{ route('password.reset.post') }}">
    {{ csrf_field() }}
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="panel-body">
      <h1 class="auth-form-title">{{ __('Создать новый пароль') }}</h1>
      <p class="auth-form-subtitle">{{ __('Используйте заглавные буквы и спецсимволы') }}</p>

      <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
        <label for="email">Ваш E-mail</label>
        <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required>

        @if ($errors->has('email'))
          <div class="form-control-feedback">{{ $errors->first('email') }}</div>
        @endif
      </div>

      <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
        <input type="password" name="password" placeholder="{{ __('Новый пароль') }}" class="form-control" autocomplete="off">
        <div class="form-control-feedback">{{ $errors->first('password') }}</div>
      </div>

      <div class="form-group">
        <input type="password" name="password_confirmation" placeholder="{{ __('Повторите новый пароль') }}" class="form-control" autocomplete="off">
      </div>

      <div class="form-group">
        <button class="btn btn-primary btn-block">{{ __('Изменить пароль') }}</button>
      </div>
    </div>
  </form>
@endsection