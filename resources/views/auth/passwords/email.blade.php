@php /** @var boolean $useRecaptcha */ @endphp

@extends('auth.layout')

@section('content')

  @if (session('status'))
    <div class="alert alert-success">
      {!! session('status') !!}
    </div>
  @else
    <form class="panel auth-form" id="restore-form" method="post" role="form" action="{{ route('restore') }}">
      {{ csrf_field() }}
      <div class="panel-body">
        <h1 class="auth-form-title">{{ __('Восстановление пароля') }}</h1>
        <p class="auth-form-subtitle">{{ __('Введите Email адрес, указанный при регистрации. На эту почту будет отправлено письмо для восстановления пароля.') }}</p>


        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
          <input type="email" name="email" placeholder="{{ __('Email, указанный при регистрации') }}" class="form-control" autocomplete="off" value="{{ old('email') }}">
          <div class="form-control-feedback">{{ $errors->first('email') }}</div>
        </div>

        @if ($useRecaptcha)
          <div class="form-group">
            <div class="text-danger">{{ $errors->first('g-recaptcha-response') }}</div>
            <div class="g-recaptcha" data-sitekey="{{ config('google-recaptcha.sitekey') }}"></div>
          </div>
        @endif

        <div class="form-group">
          <button class="btn btn-primary btn-block" type="submit">{{ __('Восстановить') }}</button>
        </div>
      </div>
    </form>
  @endif

@endsection