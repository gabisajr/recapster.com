@php
  /**
   * @var string               $title
   * @var int                  $total
   * @var \App\Model\Company[] $companies
   * @var Pagination           $pagination
   */
@endphp

@extends('admin.layout')

@section('title', $title)

@section('content')
  <h1 class="h5 mb-4">{{ $title }}
    <small>
      @if ($total)
        {{ __('Найдено :total :companies', [
          ':total'     => $total,
          ':companies' => Text::getNumEnding($total, [__('компания'), __('компании'), __('компаний')]),
        ]) }}
      @else
        {{ __('Пока нет компаний') }}
      @endif
    </small>
  </h1>

  <div class="row">
    <div class="col col-auto">
      <form role="form" id="search-form">
        <div class="form-group">
          <div class="input-group">
            <input name="q" value="{{ array_get($_GET, 'q') }}" type="search" class="form-control" placeholder="{{ __('Поиск компании') }}" autocomplete="off">
            <div class="input-group-btn">
              <button class="btn btn-primary" type="submit">{{ __('Найти') }}</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="col">
      <a class="btn btn-success" href="{{ route('admin.company.create') }}">{{ __('Добавить компанию') }}</a>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-4">
      <nav>
        <ul class="nav nav-tabs">
          {{--todo routes--}}
          <li class="nav-item {{ $activeTab == 'all' ? ' active' : '' }} {{ !isset($_GET['noactive']) && !isset($_GET['noconfirmed']) ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('admin.companies') }}">{{ __('Все компании') }}</a>
          </li>
          <li class="nav-item {{ $activeTab == 'new' ? ' active' : '' }} {{ isset($_GET['noactive']) ? ' active' : '' }}">
            <a class="nav-link" href="{{ "/admin/company/list?noactive" }}">{{ __('Новые') }}</a>
          </li>
          <li class="nav-item {{ $activeTab == 'unconfirmed' ? ' active' : '' }} {{ isset($_GET['noconfirmed']) ? ' active' : '' }}">
            <a class="nav-link" href="{{ "/admin/company/list?noconfirmed" }}">{{ __('Не подтвержденные') }}</a>
          </li>
        </ul>
      </nav>
    </div>
  </div>

  <div class="row top-buffer">
    <div class="col-lg-12">
      @if (count($companies))
        <div class="table-responsive">
          <table class="table table-hover" id="companies-list">
            <thead>
            <tr>
              <th><samp>id</samp></th>
              <th>{{ __('Логотип') }}</th>
              <th colspan="3">{{ __('Название') }}</th>
              <th>{{ __('Активность') }}</th>
              <th>{{ __('Рейтинг') }}</th>
              <th>{{ __('Вид деятельности') }}</th>
              <th>{{ __('Представители') }}</th>
              <th>{{ __('Добавлена') }}</th>
              <th>{{ __('Изменения') }}</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @php /** @var \App\Model\Company $company */ @endphp
            @foreach ($companies as $company)
              <tr data-id="{{ $company->id }}">
                <td><samp>{{ $company->id }}</samp></td>

                <td>
                  <img class="logo" width="50" height="50" src="{{ logo($company) }}" alt="{{ $company->title }}">
                </td>

                <td class="title-cell">
                  <a href="{{ route('admin.company.edit', $company) }}">
                    <small class="title">{{ str_limit($company->title, 50) }}</small>
                  </a>
                  <br>
                  <a class="company-site" href="{{ $company->site }}" target="_blank">{{ $company->site_title }}</a><br>
                  <small><a href="{{ $company->url() }}" target="_blank">{{ __('Открыть профиль') }}
                      <i class="fa fa-external-link"></i></a></small>
                </td>
                <td class="text-center">
                  <small>
                    @if ($company->active)
                      <i class="fa fa-circle" style="color: #5cb85c" title="{{ __('Активирована') }}"></i>
                    @else
                      <i class="fa fa-circle-thin" style="color: #ccc" title="{{ __('Неактивирована') }}"></i>
                    @endif
                  </small>
                </td>
                <td class="text-center">
                  @if ($company->confirmed)
                    <img src="/images/icon/check23.png" title="{{ __('Подтвержденый профиль') }}">
                  @endif
                </td>
                <td>


                  @if ($company->total_reviews_count
                    || $company->total_images_count
                    || $company->total_salaries_count
                    || $company->total_interviews_count
                    || $company->total_jobs_count
                    //|| $company->total_benefits_count
                  )

                    <?
                    # отзывы
                    if ($company->pending_reviews_count) {
                      echo " <a href='/admin/review/list?status=pending&company={$company->id}' class='btn btn-sm btn-danger'>" . __('Отзывы') . " + {$company->pending_reviews_count}</a>";
                    } elseif ($company->total_reviews_count) {
                      echo " <a href='/admin/review/list?company={$company->id}' class='btn btn-sm btn-secondary'>" . __('Отзывы') . " <small class='text-muted'>{$company->total_reviews_count}</small></a>";
                    }

                    # зарплаты
                    if ($company->pending_salaries_count) {
                      echo " <a href='/admin/salary/list?status=pending&company={$company->id}' class='btn btn-sm btn-danger'>" . __('Зарплаты') . " + {$company->pending_salaries_count}</a>";
                    } elseif ($company->total_salaries_count) {
                      echo " <a href='/admin/salary/list?company={$company->id}' class='btn btn-sm btn-secondary'>" . __('Зарплаты') . " <small class='text-muted'>{$company->total_salaries_count}</small></a>";
                    }

                    # собеседования
                    if ($company->pending_interviews_count) {
                      echo " <a href='/admin/interview/list?status=pending&company={$company->id}' class='btn btn-sm btn-danger'>" . __('Собеседования') . " + {$company->pending_interviews_count}</a>";
                    } elseif ($company->total_interviews_count) {
                      echo " <a href='/admin/interview/list?company={$company->id}' class='btn btn-sm btn-secondary'>" . __('Собеседования') . " <small class='text-muted'>{$company->total_interviews_count}</small></a>";
                    }

                    # фотографии
                    if ($company->pending_images_count) {
                      echo " <a href='/admin/company/images/{$company->id}' class='btn btn-sm btn-danger'>" . __('Фотографии') . " + {$company->pending_images_count}</a>";
                    } elseif ($company->total_images_count) {
                      echo " <a href='/admin/company/images/{$company->id}' class='btn btn-sm btn-secondary'>" . __('Фотографии') . " <small class='text-muted'>{$company->total_images_count}</small></a>";
                    }

                    # вакансии
                    if ($company->pending_jobs_count) {
                      echo " <a href='/admin/job/list?status=pending&company={$company->id}' class='btn btn-sm btn-danger'>" . __('Вакансии') . " + {$company->pending_jobs_count}</a>";
                    } elseif ($company->total_jobs_count) {
                      echo " <a href='/admin/job/list?company={$company->id}' class='btn btn-sm btn-secondary'>" . __('Вакансии') . " <small class='text-muted'>{$company->total_jobs_count}</small></a>";
                    }

                    //todo benefits
                    ?>

                  @else
                    <small><em>({{ __('нет') }})</em></small>
                  @endif
                </td>
                <td class="text-center">
                  <small>{{ number_format($company->rating, 2) }}</small>
                </td>
                <td class="small">

                  @php
                    /** @var Model_Industry[] $industries */
                    $industries = $company->industries()->get();
                    $industriesCount = $industries->count();
                  @endphp

                  @if (!$industriesCount)
                    <em class='text-muted'>({{ __('не указано') }})</em>
                  @elseif ($industriesCount == 1)
                    {{ $industries->first()->title }}
                  @else
                    <a>{{ industries_count($industriesCount) }}</a>
                  @endif

                </td>
                <td>
                  <? if ($employers_count = $company->employers_count) { ?>
                  <a href="<?="/admin/employers?company=$company->id"?>" class="text-nowrap"><?=__(':count :users', [
                      ':count' => $employers_count,
                      ':users' => Text::getNumEnding($employers_count, [__('пользователь'), __('пользователя'), __('пользователей')]),
                    ])?></a>
                  <? } else { ?>
                  <small class="text-muted"><em>({{ __('нет') }})</em></small>
                  <? } ?>
                </td>
                <td>
                  <samp class="small">
                    {{ date('d.m.Y (H:i)', strtotime($company->created_at)) }}<br>

                    @if ($company->addedUser)
                      {{ $company->addedUser->name }}
                    @else
                      <em class='text-muted'>{{ __('нет') }}</em>
                    @endif

                  </samp>
                </td>
                <td>
                  {{--todo updated user--}}
                </td>
                <td class="text-nowrap">
                  <button class="btn btn-sm btn-secondary" name="remove" type="button" title="{{ __('удалить') }}"><i class="fa fa-trash"></i></button>
                  @php /*<a class="btn btn-sm btn-secondary" href="/admin/company/seo/<?=$company->id?>">META</a> todo company meta module */ @endphp
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      @endif
      @php
        // todo $pagination
      @endphp
    </div>
  </div>
@endsection