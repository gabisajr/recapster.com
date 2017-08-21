@php
  /**
   * @var \App\Model\User $currUser
   */
@endphp
<header id="header" class="page-header hidden-print">
  <div class="container no-pad-xs">
    <div class="row align-items-center page-header-row">
      <div class="col col-3">
        <a href="{{ route('home') }}" class="page-header-logo hover_opacity"></a>
      </div>
      <div class="col col-auto">
        <nav>
          <a class="-item hidden-xs hidden-sm" href="{{ route('jobs') }}">{{ __('Вакансии') }}</a>
          <a class="-item hidden-xs hidden-sm" href="{{ route('companies') }}">{{ __('Компании') }}</a>
          <a class="-item hidden-xs hidden-sm" href="/search?type=reviews">{{ __('Отзывы') }}</a>
          @php /*<a class="-item" href="/contest/table">{{ __('Конкурс') }} <i class="dot">•</i></a>*/ @endphp
          @if (Auth::check() && isset($currUser) && $currUser)
            <a class="-item visible-xs nowrap" href="/search"><i class="fa fa-search" aria-hidden="true"></i> {{ __('Поиск') }}</a>
          @endif
        </nav>
      </div>

      @if (isset($showHeaderSearch) && $showHeaderSearch)
        <div class="col col-auto page-header-col hidden-xs">
          <div class="header-search ui-front">
            <input type="search" placeholder="{{ __('Поиск') }}" name="q" class="q form-control input-sm" autocomplete="off">
          </div>
        </div>
      @endif

      <div class="col">

        @if (Auth::check() && isset($currUser) && $currUser)

          <div class="dropdown pull-right">

            <div class="header-user dropdown-toggle" id="dropdown-header-user-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <img src="{{ avatar($currUser, 30) }}" class="header-user-avatar">
              <span class="hidden-xs">
                  <strong>{{ $currUser->firstname ? $currUser->firstname : $currUser->username }}</strong>
                  <span class="caret"></span>
                </span>
            </div>
            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-header-user-menu">
              <li><a class="dropdown-menu-item" href="{{ $currUser->url() }}">{{ __('Мой профиль') }}</a></li>
              <li><a class="dropdown-menu-item" href="{{ $currUser->url('activity') }}">{{ __('Моя активность') }}</a></li>
              {{--todo routes--}}
              <li><a class="dropdown-menu-item" href="/fave">{{ __('Избранное') }}</a></li>
              <li><a class="dropdown-menu-item" href="/edit">{{ __('Редактировать') }}</a></li>
              <li><a class="dropdown-menu-item" href="/settings">{{ __('Настройки') }}</a></li>
              <li role="separator" class="divider"></li>
              <li>
                <form action="{{ route('signout') }}" method="post">{{ csrf_field() }}<input class="dropdown-menu-item" type="submit" value="{{ __('Выйти') }}"></form>
              </li>
            </ul>
          </div>

        @else
          <nav class="page-header-nav pull-right">
            {{--todo routes--}}
            <a class="-item" href="/signin">{{ __('Вход') }}</a>
            <div class="-item signup"><a href="{{ route('signup') }}" class="btn btn-success btn-sm btn-signup open-signup-modal">{{ __('Регистрация') }}</a></div>
          </nav>
        @endif


      </div>
    </div>
  </div>
</header>