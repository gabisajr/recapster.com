@php
  /**
   * @var \App\Model\User $curr_user
   * @var string $active
   */
@endphp
<div class="panel">
  <div class="panel-body pad-vert-sm  ">
    <menu role="menu" class="aside-menu">
      {{--todo use routes--}}
      <a class="aside-menu-item{{ $active == 'edit' ?  ' active' : '' }}" href="/edit"><i class="fa fa-fw fa-user"></i>{{ __('Редактировать профиль') }}</a>
      <a class="aside-menu-item{{ $active == 'settings' ? ' active' : '' }}" href="/settings"><i class="fa fa-fw fa-gear"></i>{{ __('Настройки') }}</a>
      <a class="aside-menu-item hidden" href="/bids"><i class="fa fa-fw fa-commenting"></i>{{ __('Отклики на вакансии') }}</a>
      <a class="aside-menu-item{{ $active == 'fave' ? ' active' : '' }}" href="/fave"><i class="fa fa-fw fa-star"></i>{{ __('Избранные вакансии') }}</a>
    </menu>
  </div>
</div>