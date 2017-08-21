@php
  /**
   * @var \App\Model\Company $company
   * @var string        $activeTab
   */

  if(!isset($activeTab)) $activeTab = "profile";
@endphp

<nav class="profile-tabs profile-tabs-company">

  <div class="profile-tabs-inner">

    <a class="profile-tabs-item profile{{ $activeTab == 'profile' ? ' active' : '' }}" href="{{ $company->url() }}">
      <div class="label">{{ __('Профиль') }}</div>
      <div class="count at">@</div>
    </a>

    <a class="profile-tabs-item jobs{{ $activeTab == 'jobs' ? ' active' : '' }}" href="{{ $company->url('jobs') }}">
      <div class="label">{{ __('Вакансии') }}</div>
      <div class="count">{!! $company->jobs_count ? $company->jobs_count : '<span class="no">--</span>' !!}</div>
    </a>

    <a class="profile-tabs-item reviews{{ $activeTab == 'reviews' ? ' active' : '' }}" href="{{ $company->url('reviews') }}">
      <div class="label">{{ __('Отзывы') }}</div>
      <div class="count">{!! $company->reviews_count ? $company->reviews_count : '<span class="no">--</span>' !!}</div>
    </a>

    <a class="profile-tabs-item photos{{ $activeTab == 'photos' ? ' active' : '' }}" href="{{ $company->url('photos') }}">
      <div class="label">{{ __('Фото') }}</div>
      <div class="count">{!! $company->images_count ? $company->images_count : '<span class="no">--</span>' !!}</div>
    </a>

    <a class="profile-tabs-item followers{{ $activeTab == 'followers' ? ' active' : '' }}" href="{{ $company->url('followers') }}">
      <div class="label">{{ __('Подписчики') }}</div>
      <div class="count">{!! $company->followers_count ? $company->followers_count : '<span class="no">--</span>' !!}</div>
    </a>


    @php /*

    <a class="item item-salaries{{ $activeTab == 'salaries' ? ' active' : '' }}" href="{{ $company->url('salaries') }}">
      <div class="label">{{ __('Зарплата') }}</div>
      <div class="count">{!! $company->salaries_count ? $company->salaries_count : '<span class="no">--</span>' !!}</div>
    </a>

    <a class="item item-interviews{{ $activeTab == 'interviews' ? ' active' : '' }}" href="{{ $company->url('interviews') }}">
      <div class="label">{{ __('Собеседования') }}</div>
      <div class="count">{!! $company->interviews_count ? $company->interviews_count : '<span class="no">--</span>' !!}</div>
    </a>

    <a class="item item-internships{{ $activeTab == 'internships' ? ' active' : '' }}" href="{{ $company->url('internships') }}">
      <div class="label">{{ __('Стажировки') }}</div>
      <div class="count">{!! $company->internship_count ? $company->internship_count : '<span class="no">--</span>' !!}</div>
    </a>

    <a class="item item-benefits{{ $activeTab == 'benefits' ? ' active' : '' }}" href="{{ $company->url('benefits') }}">
      <div class="label">{{ __('Приемущества') }}</div>
      <div class="count">{!! $company->benefits_count ? $company->benefits_count : '<span class="no">--</span>' !!}</div>
    </a>

    <div class="item item-more open-profile-more-modal pointer">
      <div class="label">{{ __('Еще') }}</div>
      <div class="count"><span class="no">⋅⋅⋅</span></div>
    </div>
    <div class="hidden">@include('modal/profile-more', ['company' => $company])</div>

     */
    @endphp

  </div>
</nav>