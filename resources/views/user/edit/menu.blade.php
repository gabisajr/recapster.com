@php
  /**
   * @var string $active
   */
@endphp
<div class="panel">
  <div class="panel-body pad-vert-sm">
    <menu role="menu" class="aside-menu">
      {{--todo use routes--}}
      <a class="aside-menu-item{{ $active == 'personal' ? ' active' : '' }}" href="{{ route('user.edit.personal') }}">{{ __('Личная информация') }}</a>
      <a class="aside-menu-item{{ $active == 'contacts' ? ' active' : '' }}" href="{{ route('user.edit.contacts') }}">{{ __('Контакты') }}</a>
      <a class="aside-menu-item{{ $active == 'education' ? ' active' : '' }}" href="{{ route('user.edit.education') }}">{{ __('Образование') }}</a>
      <a class="aside-menu-item{{ $active == 'experience' ? ' active' : '' }}" href="/edit/experience">{{ __('Опыт работы') }}</a>
      <a class="aside-menu-item{{ $active == 'skills' ? ' active' : '' }}" href="/edit/skills">{{ __('Навыки и языки') }}</a>
      <a class="aside-menu-item{{ $active == 'exams' ? ' active' : '' }}" href="/edit/exams">{{ __('Тесты, экзамены и курсы') }}</a>
    </menu>
  </div>
</div>