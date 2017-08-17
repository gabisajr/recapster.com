@php
  /**
   * @var array   $errors
   * @var string  $email
   * @var boolean $employer
   * @var array   $socialInfo
   */
@endphp

<form class="panel auth-form" method="post" id="signup-form" action="{{ route('signup') }}">
  {{ csrf_field() }}
  <div class="panel-body">
    <h1 class="auth-form-title">{{ __('Регистрация') }}</h1>

    @if (count($socialInfo))

      <div class="about-user">
        <img src="{{ array_get($socialInfo, 'photo_preview', '/images/avatar.svg') }}" class="about-user-avatar">
        <div class="about-user-name">
          @php
            //икнока сторонего сервиса
            $service = array_get($socialInfo, 'service');
            switch ($service) {
              case 'vk':
                echo View::factory('svg/vk');
                break;
              case 'facebook':
                echo View::factory('svg/facebook');
                break;
            }
          @endphp
          {{ array_get($socialInfo, 'firstname') }}
          {{ array_get($socialInfo, 'lastname') }}
        </div>
        {{--todo route--}}
        <div class="about-user-cancel"><a href="/signup/reset">{{ __('Отмена') }}</a></div>
      </div>

    @else

      <p class="auth-form-subtitle">{{ __('Войдите с помощью учетной записи в других сервисах') }}</p>
      <div class="row">
        <div class="col-sm-6">
          {{--todo route--}}
          <a class="btn btn-block btn-vk btn-vk-login" href="/vkauth"><i class="fa fa-vk"></i>{{ __('Войти через ВКонтакте') }}</a>
        </div>
        <div class="col-sm-6">
          {{--todo route--}}
          <a class="btn btn-block btn-fb" href="/fbauth"><i class="fa fa-facebook"></i>{{ __('Войти через Facebook') }}</a>
        </div>
      </div>
      <div class="hr marg-vert-lg text-center">
        <hr>
        <span class="center">{{ __('или') }}</span>
      </div>

    @endif


    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
      <label hidden><input type="email" name="email" hidden></label>
      <input type="email" name="email" placeholder="{{ __('Email адрес') }}" class="form-control" autocomplete="off" value="{{ old('email', $email) }}">
      <div class="form-control-feedback">{{ $errors->first('email') }}</div>
    </div>

    <div class="form-group{{ $errors->has('password') ?  ' has-danger' : '' }}">
      <input type="password" name="password" placeholder="{{ __('Пароль') }}" class="form-control" autocomplete="off">
      <div class="form-control-feedback">{{ $errors->first('password') }}</div>
    </div>

    <div class="form-group{{ $errors->has('password_confirm') ? ' has-danger' : '' }}">
      <input type="password" name="password_confirmation" placeholder="{{ __('Повторите пароль') }}" class="form-control" autocomplete="off">
      <div class="text-danger">{{ $errors->first('password_confirm') }}</div>
    </div>

    <div class="form-group">
      <div class="row">
        <div class="col">
          <div class="form-check mb-0">
            <label class="form-check-label">
              <input class="form-check-input" type="checkbox" name="employer" {{ old('employer', $employer) ? ' checked' : '' }} id="employer">
              {{ __('Я работодатель') }}
            </label>
          </div>
        </div>
        <div class="col col-auto">
          <a href="{{ route('signin') }}">{{ __('У меня есть аккаунт') }}</a>
        </div>
      </div>
    </div>

    <div class="form-group">
      <button class="btn btn-primary btn-block">{{ __('Зарегистрироваться') }}</button>
    </div>

    <p class="text-muted text-center">{!! __("messages.signup_user_agreement", ['link' => '#']) !!}</p>
  </div>
</form>