<aside>
  <div class="aside-menu">

    {{--todo routes--}}

    <?/*{{ route('admin.post.tree') }} todo */?>
    <a href="#" class="aside-menu-item{{ $sidebarActive == 'post' ? ' active' : '' }}">
      <i class="fa fa-fw fa-newspaper-o"></i> {{ __('Все посты') }}
    </a>

    <a href="{{ route('admin.company.list') }}" class="aside-menu-item{{ $sidebarActive == 'company' ? ' active' : '' }}">
      <i class="fa fa-fw fa-building"></i> {{ __('Компании') }}
    </a>

    <?/*
    <li class="<? if ($sidebarActive == 'activity') echo ' active' ?>">
      <a href="/admin/activity/list"><i class="fa fa-briefcase" aria-hidden="true"></i> <?=__('Активность')?></a>
    </li>

    <li class="<? if ($sidebarActive == 'salary') echo ' active' ?>">
      <a href="/admin/salary/list"><i class="fa fa-fw fa-money" aria-hidden="true"></i> <?=__('Зарплаты')?></a>
    </li>

    <li class="<? if ($sidebarActive == 'interview') echo ' active' ?>">
      <a href="/admin/interview/list"><i class="fa fa-fw fa-exchange" aria-hidden="true"></i> <?=__('Собеседования')?></a>
    </li>

    <li class="<? if ($sidebarActive == 'job') echo ' active' ?>">
      <a href="/admin/job/list"><i class="fa fa-fw fa-shopping-bag" aria-hidden="true"></i> <?=__('Вакансии')?></a>
    </li>

    <li class="<? if ($sidebarActive == 'claim') echo ' active' ?>">
      <a href="/admin/claim/list"><i class="fa fa-fw fa-flag-o" aria-hidden="true"></i> <?=__('Жалобы')?></a>
    </li>

    <li class="<? if ($sidebarActive == 'ceo') echo ' active' ?>">
      <a href="/admin/ceo/list"><i class="fa fa-fw fa-user" aria-hidden="true"></i> <?=__('CEO')?></a>
    </li>

    <li class="<? if ($sidebarActive == 'user') echo 'active' ?>">
      <a href="/admin/user/list"><i class="fa fa-fw fa-users" aria-hidden="true"></i> <?=__('Пользователи')?></a>
    </li>

    <li class="<? if ($sidebarActive == 'vocabulary') echo 'active' ?>">
      <a href="/admin/vocabulary"><i class="fa fa-fw fa-book" aria-hidden="true"></i> <?=__('Словари')?></a>
    </li>

    <li class="<? if ($sidebarActive == 'delivery') echo 'active' ?>">
      <a href="/admin/delivery"><i class="fa fa-fw fa-envelope" aria-hidden="true"></i> <?=__('Email-рассылка')?></a>
    </li>

    <li class="<? if ($sidebarActive == 'utils') echo 'active' ?>">
      <a href="/admin/utils"><i class="fa fa-fw fa-wrench" aria-hidden="true"></i> <?=__('Утилиты')?></a>
    </li>
    */?>

  </div>
</aside>