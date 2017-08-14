@php
  /**
   * @var \Illuminate\Support\Collection $users
   * @var string                         $search - Поисковая фраза
   */
@endphp

@extends('admin.layout')

@section('content')

  <h4 class="page-header">
    {{ $title }}
    <small>{{ users_count($users->total()) }}</small>
  </h4>

  <nav class="breadcrumb">
    <span class="breadcrumb-item active">{{ __('Пользователи') }}</span>
  </nav>

  <div class="row">
    <div class="col col-12 col-lg-4">
      <form role="form" id="search-users-form">
        <div class="form-group">
          <div class="input-group">
            <input name="search" value="{{ $search }}" type="search" class="form-control"
                   placeholder="{{ __('Поиск пользователей: id, Email, Имя, Фамилия') }}" autocomplete="off">
            <div class="input-group-btn">
              <button class="btn btn-primary" type="submit">{{ __('Найти') }}</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-hover" id="users-list">
      <thead>
      <tr>
        <th>id</th>
        <th>{{ __('Аватар') }}</th>
        <th>{{ __('Аккаунт') }}</th>
        <th>{{ __('Возраст') }}</th>
        <th>{{ __('Профиль') }}</th>
        <th>{{ __('Подтвержден') }}</th>
        <th>{{ __('Соцсети') }}</th>
        <th>{{ __('Активность') }}</th>
        <th>{{ __('Подписки') }}</th>
        <th>{{ __('Последний вход') }}</th>
        <th>{{ __('Зарегистрирован') }}</th>
        <th></th>
      </tr>
      </thead>
      <tbody>
      @foreach ($users as $user)
        <tr data-id="{{ $user->id }}">

          <!--//<editor-fold desc="id">-->
          <td class="search-cell">
            <small><samp>{{ $user->id }}</samp></small>
          </td>
          <!--//</editor-fold>-->

          <!-- //<editor-fold desc="аватар">-->
          <td>
            <img src="{{ avatar($user) }}" width="50" height="50">
          </td>
          <!--//</editor-fold>-->

          <!--//<editor-fold desc="аккаунт">-->
          <td class="search-cell">

            {{--имя фамилия--}}
            <small class="text-muted">
              <a class="title" href="{{ route('admin.user.accounts', $user) }}">
                @if ($fullname = $user->fullname())
                  {{ $fullname }}
                @else
                  <em>({{ __('Без имени') }})</em>
                @endif
              </a>
            </small>
            <br>

            {{--login--}}
            <code>{{ $user->username }}</code><br>

            {{--Email--}}
            <small><samp>{{ $user->email ? $user->email : '(нет почты)' }}</samp></small>
          </td>
          <!--//</editor-fold>-->

          <!--//<editor-fold desc="Возраст">-->
          <td class="small text-nowrap">
            @if ($age = $user->age())
              {{ age($age) }}
            @else
              <em class='text-muted'>({{ __('не указан') }})</em>
            @endif
          </td>
          <!--//</editor-fold>-->

          <!--//<editor-fold desc="ссылка на профиль и статус">-->
          <td>
            <small>
              @if ($profile_url = $user->url())
                <a target="_blank" href="{{ $profile_url }}">{{ $profile_url }}</a>
              @else
                <em class="text-muted">({{ __('нет') }})</em>
              @endif
            </small>
            <br>
            <em class="small">{{ $user->status_title }}</em>
          </td>
          <!--//</editor-fold>--!>

          <!--//<editor-fold desc="аккаунт подтвержден">-->
          <td>
            @if($user->confirmed)
              <i class="fa fa-check text-success"></i> {{ __("да") }}
            @else
              <i class="fa fa-warning text-warning"></i> {{ __("нет") }}
            @endif
          </td>
          <!--//</editor-fold>-->

          <!--//<editor-fold desc="Аккаунты соцсетей">-->
          <td>
            @if ($user->fbAccount || $user->vkAccount
            //|| $user->ok_account->loaded()
            //|| $user->google_account->loaded()
            )
              <ul class="list-unstyled search-cell">

                {{--facebook--}}
                @if ($user->fbAccount->loaded())
                  <li><a href="{{ $user->fbAccount->url }}" target="_blank" class="btn btn-xs btn-social btn-fb">
                      <i class="fa fa-fw fa-facebook"></i> <strong>{{ $user->fbAccount->fullname }}</strong></a></li>
                @endif

                {{--ВКонтакте--}}
                @if ($user->vkAccount->loaded())
                  <li><a href="{{ $user->vkAccount->url }}" target="_blank" class="btn btn-xs btn-social btn-vk">
                      <i class="fa fa-fw fa-vk"></i> <strong>{{ $user->vkAccount->fullname }}</strong></a></li>
                @endif

                @php /* todo одноклассники
                      @if ($user->ok_account->loaded())
                        <li><a href="#" class="btn btn-xs btn-social btn-odnoklassniki">
                          <i class="fa fa-fw fa-odnoklassniki"></i> <strong>Имя Фамилия</strong></a></li>
                      @endif */ @endphp

                @php /* todo google_account
                      @if ($user->google_account->loaded())
                        <li><a href="#" class="btn btn-xs btn-social btn-google-plus">
                          <i class="fa fa-fw fa-google-plus"></i> <strong>Имя Фамилия</strong></a><li>
                      @endif */ @endphp

              </ul>
            @else
              <small class="text-muted"><em>({{ __('Нет подключенных аккаунтов') }})</em></small>
            @endif
          </td>
          <!--//</editor-fold>-->

          <!--//<editor-fold desc="Активность пользователя (contributions)">-->
          <td>

            @php
              $reviews_count = $user->reviews_count;
              $interviews_count = $user->interviews_count;
              $salaries_count = $user->salaries_count;
              $images_count = $user->images_count;
            @endphp

            @if ($reviews_count || $interviews_count || $salaries_count || $images_count)

              @if ($reviews_count)
                {{--todo route, camelCase, counters--}}
                <a href="/admin/user/reviews/{{ $user->id }}" class="btn btn-xs btn-default">{{ reviews_count($reviews_count) }}</a>
              @endif

              @if ($interviews_count)
                {{--todo route--}}
                <a href="/admin/user/interviews/{{ $user->id }}" class="btn btn-xs btn-default">{{ interviews_count($interviews_count) }}</a>
              @endif

              @if ($salaries_count)
                {{--todo route--}}
                <a href="/admin/user/salaries/{{ $user->id }}" class="btn btn-xs btn-default">{{ salaries_count($salaries_count) }}</a>
              @endif

              @if ($images_count)
                {{--todo route--}}
                <a href="/admin/user/images/{{ $user->id }}" class="btn btn-xs btn-default">{{ images_count($images_count) }}</a>
              @endif

            @else
              <small class="text-muted"><em>({{ __('нет') }})</em></small>
            @endif
          </td>
          <!--//</editor-fold>-->

          <!--//<editor-fold desc="Подписки пользователя">-->
          <td class="small">
            @if ($user->subscriptions_count)
              <a href='/admin/user/subscriptions/{$user->id}' class='text-nowrap'>{{ subscriptions_count($user->subscriptions_count) }}</a>
            @endif
          </td>
          <!--//</editor-fold>-->

          <!--//<editor-fold desc="зарегистрирован">-->
          <td class="small">
            {{--todo carbon--}}
            <samp>{{ date('d.m.Y (H:i)', strtotime($user->created_at)) }}</samp><br>
            {{--todo add registered_by field--}}
            <em class='text-muted'>({{ \App\RegisteredBy::getAcrossCaption($user->registered_by) }})</em>
          </td>
          <!--//</editor-fold>-->

          <!--//<editor-fold desc="кнопочки">-->
          <td class="text-nowrap">
            {{--todo route--}}
            <a href="/admin/user/item/{{ $user->id }}" class="text-muted" title="{{ __('Правка') }}"><i class="fa fa-fw fa-pencil"></i></a>
            <button class="btn btn-sm btn-secondary" name="remove" type="button" title="{{ __('удалить') }}"><i class="fa fa-trash"></i></button>
          </td>
          <!--//</editor-fold>-->

        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  {!! $users->links() !!}


@endsection

@section('page_js', 'user/list')