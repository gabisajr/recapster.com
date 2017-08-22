@php
  /**
   * @var array  $errors
   * @var string $email
   */
@endphp
<form class="panel auth-form" method="post" id="signin-form" action="{{ route('signin') }}">
  {{ csrf_field() }}
  <div class="panel-body">
    <h1 class="auth-form-title">{{ __('Вход') }}</h1>
    <p class="auth-form-subtitle">{{ __('Войдите с помощью учетной записи в других сервисах') }}</p>

    <div class="social-btns">
      <div class="row">
        <div class="col col-sm-6">
          {{--todo route--}}
          <a class="btn btn-block btn-vk btn-vk-login" href="/vkauth"><i class="fa fa-vk"></i> {{ __('Войти через ВКонтакте') }}</a>
        </div>
        <div class="col col-sm-6">
          {{--todo route--}}
          <a class="btn btn-block btn-fb" href="/fbauth"><i class="fa fa-facebook"></i> {{ __('Войти через Facebook') }}</a>
        </div>
      </div>
    </div>

    <div class="hr marg-vert-lg text-center">
      <hr>
      <span class="center">{{ __('или') }}</span>
    </div>

    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
      <input type="email" name="email" placeholder="{{ __('Email адрес') }}" class="form-control" autocomplete="off" value="{{ old('email') }}">
      <div class="form-control-feedback">{{ $errors->first('email') }}</div>
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
      <input type="password" name="password" placeholder="{{ __('Пароль') }}" class="form-control" autocomplete="off">
      <div class="form-control-feedback">{{ $errors->first('password') }}</div>
    </div>

    <div class="form-group">
      <button class="btn btn-primary btn-block">{{ __('Войти') }}</button>
    </div>

    <div class="text-muted">
      <a href="{{ route('restore') }}">{{ __('Забыли пароль?') }}</a>
      <a href="{{ route('signup') }}" class="pull-right">{{ __('Регистрация') }}</a>
    </div>

  </div>
</form>