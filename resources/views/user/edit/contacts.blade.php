@php
  /**
   * @var \App\Model\User $user
   * @var string     $skype
   * @var string     $twitter
   * @var string     $site
   * @var string     $instagram
   * @var array      $errors
   */
@endphp

@extends('user.edit.layout')

@section('edit-content')
  <div class="panel">
    <header class="panel-header hidden-xs">{{ __('Контакты') }}</header>

    <div class="panel-body">

      @if(session('success'))
        <div class="alert alert-success">{{ __("Ваши контакты сохранены") }}</div>
      @endif

      {{--телефон--}}
      <form method="post" class="toggle-edit-form" id="edit-tel-form" action="/edit/tel"> {{--todo route--}}
        <div class="form-group row">
          <div class="col-sm-3">{{ __('Телефон') }}</div>
          <div class="col-sm-8">
            @if ($user->tel)
              {{ protect_tel($user->tel) }}
            @else
              <em class="text-muted">{{ __('телефон не указан') }}</em>
            @endif
            <span class="toggle-edit right link" data-has="{{ !!$user->tel }}">{{ $user->tel ? __('Изменить') : __('Добавить') }}</span>
          </div>
        </div>
        <div class="form-group toggle-edit-area">
          <div class="col-sm-8 col-sm-offset-3">
            <div class="input-group input-group-sm">
              <input class="form-control" value="" autocomplete="off" name="tel" id="tel" placeholder="{{ __('Новый телефон') }}">
              <div class="input-group-btn">
                <button class="btn btn-submit btn-primary">{{ __('Сохранить') }}</button>
              </div>
            </div>
          </div>
        </div>
      </form>

      {{--email--}}
      <form class="toggle-edit-form" id="edit-email-form" method="post" action="/edit/email">
        <div class="form-group row">
          <div class="col-sm-3">{{ __('Электронная почта') }}</div>
          <div class="col-sm-8">
            <p class="form-control-static">
              @if ($user->email)
                {{ protect_email($user->email) }}
              @else
                <span class="text-muted">{{ __('почта не указана') }}</span>
              @endif
              <span class="toggle-edit right link" data-has="{{ !!$user->email }}">{{ $user->email ? __('Изменить') : __('Добавить') }}</span>
            </p>
          </div>
        </div>
        <div class="form-group toggle-edit-area">
          <div class="col-sm-8 col-sm-offset-3">
            <div class="input-group input-group-sm">
              <input class="form-control" value="" autocomplete="off" name="email" id="email" placeholder="{{ __('Новая почта') }}">
              <span class="input-group-btn">
              <button class="btn btn-submit btn-primary">{{ __('Сохранить') }}</button>
            </span>
            </div>
          </div>
        </div>
      </form>

      {{--Социальные аккаунты--}}
      <div>

        {{--ВКонтакте--}}
        <div class="form-group row">
          <div class="col-sm-3">{{ __('ВКонтакте') }}</div>
          <div class="col-sm-8">
            @if ($user->vkAccount)
              <span class="social-account">
                <a target="_blank" href="{{ $user->vkAccount->url }}">{{ $user->vkAccount->fullname }}</a>
                <button class="social-account-remove powertip remove-vk" type="button" title="{{ __('Отключить') }}"><i class="icon closeblock"></i></button>
              </span>
            @else
              <a href="/vkauth">{{ __('Подключить') }}</a>
            @endif
          </div>
        </div>

        {{--Facebook--}}
        <div class="form-group row">
          <label for="vk" class="col-sm-3 control-label">Facebook</label>
          <div class="col-sm-8">
            <p class="form-control-static">
              @if ($user->fbAccount)
                <span class="social-account">
                <a target="_blank" href="{{ $user->fbAccount->url }}">{{ $user->fbAccount->fullname }}</a>
                <button class="social-account-remove powertip remove-facebook" type="button" title="{{ __('Отключить') }}"><i class="icon closeblock"></i></button>
            </span>
              @else
                <a href="/fbauth">{{ __('Подключить') }}</a>
              @endif
            </p>
          </div>
        </div>

      </div>

      {{--прочее--}}
      <form method="post" id="edit-contacts-form" action="{{ route('user.edit.contacts') }}">

        {{ csrf_field() }}

        {{--Skype--}}
        <div class="form-group row">
          <label for="skype" class="col-sm-3 col-form-label">Skype</label>
          <div class="col-sm-8">
            <input class="form-control{{ $errors->has('skype') ? ' is-invalid' : '' }}" value="{{ old('skype', $user->skype) }}" autocomplete="off" name="skype" id="skype">
            <div class="invalid-feedback">{{ $errors->first('skype') }}</div>
          </div>
        </div>

        {{--Instagram--}}
        <div class="form-group row">
          <label for="instagram" class="col-sm-3 col-form-label">Instagram</label>
          <div class="col-sm-8">
            <input class="form-control{{ $errors->has('instagram') ? ' is-invalid' : '' }}" value="{{ old('instagram', $user->instagram) }}" autocomplete="off" name="instagram" id="instagram">
            <div class="invalid-feedback">{{ $errors->first('instagram') }}</div>
          </div>
        </div>

        {{--Twitter--}}
        <div class="form-group row">
          <label for="twitter" class="col-sm-3 col-form-label">Twitter</label>
          <div class="col-sm-8">
            <input class="form-control{{ $errors->has('twitter') ? ' is-invalid' : '' }}" value="{{ old('twitter', $user->twitter) }}" autocomplete="off" name="twitter" id="twitter">
            <div class="invalid-feedback">{{ $errors->first('twitter') }}</div>
          </div>
        </div>

        {{--Web-site--}}
        <div class="form-group row">
          <label for="site" class="col-sm-3 col-form-label">{{ __('Веб-сайт') }}</label>
          <div class="col-sm-8">
            <input class="form-control{{ $errors->has('site') ? ' is-invalid' : '' }}" value="{{ old('site', $user->site) }}" autocomplete="off" name="site" id="site" placeholder="http://">
            <div class="invalid-feedback">{{ $errors->first('site') }}</div>
          </div>
        </div>

        {{--submit--}}
        <div class="form-group row">
          <div class="col col-sm-3"></div>
          <div class="col-sm-8">
            <input type="submit" value="{{ __('Сохранить') }}" class="btn btn-primary btn-submit">
            <a href="{{ route('user.edit.contacts') }}" class="marg-lt">{{ __('Отмена') }}</a>
          </div>
        </div>

      </form>

    </div>

  </div>
@endsection

@section('page_js', 'edit/contacts')