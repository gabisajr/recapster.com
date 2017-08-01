@extends('admin.layout')

@section('content')
  <h4 class="page-header">{{ $company->title }}
    <small style="vertical-align: middle; font-size: 14px; margin: 0 10px">
      @if ($company->active)
        <i class="fa fa-circle" style="color: #5cb85c" title="{{ __('Активаня') }}"></i>
      @else
        <i class="fa fa-circle-thin" style="color: #ccc" title="{{ __('Не активная') }}"></i>
      @endif
    </small>
    @if ($company->confirmed)
      <img src="/images/icon/check23.png" title="{{ __('Подтверждена') }}">
    @endif

    <small>{{ __('Рейтинг') }}: {{ $company->rating }}</small>
  </h4>

  @yield('breadcrumb')

  <ul class="nav nav-tabs mb-4">
    <li class="nav-item"><a class="nav-link{{ $activeTab == 'main' ? ' active' : '' }}" href="{{ route('admin.company.edit', $company) }}">{{ __('Основное') }}</a></li>
    <li class="nav-item"><a class="nav-link{{ $activeTab == 'reviews' ? ' active' : '' }}" href="{{ "/admin/review/list?company=$company->id" }}">{{ __('Отзывы') }}</a></li>
    <li class="nav-item"><a class="nav-link{{ $activeTab == 'salaries' ? ' active' : '' }}" href="{{ "/admin/salary/list?company=$company->id" }}">{{ __('Зарплаты') }}</a></li>
    <li class="nav-item"><a class="nav-link{{ $activeTab == 'interviews' ? ' active' : '' }}" href="{{ "/admin/interview/list?company=$company->id" }}">{{ __('Собеседования') }}</a></li>
    <li class="nav-item"><a class="nav-link{{ $activeTab == 'jobs' ? ' active' : '' }}" href="{{ route('admin.company.jobs', $company) }}">{{ __('Вакансии') }}</a></li>
    <li class="nav-item disabled"><a class="nav-link{{ $activeTab == 'internships' ? ' active' : '' }}" href="{{ "#" }}">{{ __('Стажировки') }}</a></li>
    <li class="nav-item"><a class="nav-link{{ $activeTab == 'images' ? ' active' : '' }}" href="{{ route('admin.company.images', $company) }}">{{ __('Фотографии') }}</a></li>
    <li class="nav-item disabled"><a class="nav-link{{ $activeTab == 'advantages' ? ' active' : '' }}" href="{{ "#" }}">{{ __('Приемущества') }}</a></li>
    <li class="nav-item"><a class="nav-link{{ $activeTab == 'employers' ? ' active' : '' }}" href="{{ "/admin/employers?company=$company->id" }}">{{ __('Представители') }}</a></li>
    <li class="nav-item{{ !$company->active ? ' disabled' : '' }}"><a class="nav-link{{ $activeTab == 'profile' ? ' active' : '' }}" href="{{ $company->url() }}" target="_blank">{{ __('Открыть профиль') }} <i class="fa fa-external-link"></i></a>
    </li>
  </ul>

  <div>
    @yield('company-content')
  </div>

@endsection