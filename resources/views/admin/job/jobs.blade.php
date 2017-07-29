@php
  /**
   * @var \App\Model\Company             $company
   * @var \Illuminate\Support\Collection $jobs
   * @var string                         $status
   * @var \Illuminate\Support\Collection $counts
   */
  if (!isset($company)) $company = new \App\Model\Company(); //todo remove
@endphp

@extends('admin.layout')

@section('content')
  <h1 class="h5 mb-4">
    {{ $title }}
    <small>{{ jobs_count($jobs->total()) }}</small>
  </h1>

  <a class="btn btn-success btn-sm mb-4" href="{{ route('admin.job.create') }}">{{ __('Добавить вакансию') }}</a> {{--todo route--}}

  <nav class="nav nav-pills">
    <a class="nav-link<? if (is_null($status)) echo ' active' ?>" href="<?="/admin/job/list?company=$company->id"?>"><?=__('Все вакансии')?>
      <? if ($jobs->total()) echo "<span class='badge'>{$jobs->total()}</span>" ?>
    </a>
    <a class="nav-link<? if ($status == \App\Status::PENDING) echo ' active' ?>" href="<?="/admin/job/list?company=$company->id&status=" . \App\Status::PENDING?>">{{ __('В ожидании') }}
      <? if ($count = $counts->get(\App\Status::PENDING, 0)) echo "<span class='badge'>{$count}</span>" ?>
    </a>
    <a class="nav-link<? if ($status == \App\Status::APPROVED) echo ' active' ?>" href="<?="/admin/job/list?company=$company->id&status=" . \App\Status::APPROVED?>">{{ __('Одобренные') }}
      <? if ($count = $counts->get(\App\Status::APPROVED, 0)) echo "<span class='badge'>{$count}</span>" ?>
    </a>
    <a class="nav-link<? if ($status == \App\Status::REJECTED) echo ' active' ?>" href="<?="/admin/job/list?company=$company->id&status=" . \App\Status::REJECTED?>">{{ __('Отклоненные') }}
      <? if ($count = $counts->get(\App\Status::REJECTED, 0)) echo "<span class='badge'>{$count}</span>" ?>
    </a>
    <a class="nav-link<? if ($status == \App\Status::DRAFT) echo ' active' ?>" href="<?="/admin/job/list?company=$company->id&status=" . \App\Status::DRAFT?>">{{ __('Черновики') }}
      <? if ($count = $counts->get(\App\Status::DRAFT, 0)) echo "<span class='badge'>{$count}</span>" ?>
    </a>
    {{--todo add soft deleted tab--}}
  </nav>

  @if ($jobs->count())
    @include('admin.job.list', ['company_col' => true])
  @endif
@endsection

@section('page_js', 'job/list')