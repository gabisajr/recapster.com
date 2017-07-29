@php
  /**
   * @var \Illuminate\Support\Collection $positions
   * @var string                         $q              - строка поиска
   * @var string                         $orderBy        - поле сортировки
   * @var string                         $orderDirection - направление сортировки
   */
@endphp

@extends('admin.layout')

@section('content')
  <h1 class="h5 mb-4">
    {{ __('Профессии') }} {{ $q ? "'$q'" : '' }}
    <small>{{ positions_count($positions->total()) }}</small>
  </h1>
  <nav class="breadcrumb">
    <a class="breadcrumb-item" href="{{ route('admin.vocabularies') }}">{{ __('Словари') }}</a>
    <span class="breadcrumb-item active">{{ __('Профессии') }}</span>
  </nav>

  <div class="row mb-4">
    <div class="col col-auto">
      <a class="btn btn-sm btn-success" href="{{ route('admin.position.create') }}">{{ __('Добавить профессию') }}</a>
    </div>

    <div class="col col-4">
      <form role="form" id="search-positions-form">
        <div class="form-group">
          <div class="input-group input-group-sm">
            <input name="q" value="{{ $q }}" type="search" class="form-control" placeholder="{{ __('Поиск профессиий: Название или Альяс') }}" autocomplete="off">
            <div class="input-group-btn">
              <button class="btn btn-primary" type="submit">{{ __('Найти') }}</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      @if ($positions->count())
        <div class="table-responsive">
          <table class="table table-striped" id="positions-list">
            <thead>
            <tr>
              @php $newOrderDirection = $orderDirection == 'ASC' ? 'DESC' : 'ASC'; @endphp
              <th>
                <a href="{{ route('admin.positions', ['order' => 'title', 'order_direction' => $newOrderDirection]) }}">
                  {{ __('Название') }}
                  @if ($orderBy == 'title')
                    <i class="fa {{ $orderDirection == 'DESC' ? 'fa-angle-down' : 'fa-angle-up' }}"></i>
                  @endif
                </a>
              </th>
              <th>
                <a href="{{ route('admin.positions', ['order' => 'reviews_count', 'order_direction' => $newOrderDirection]) }}">
                  {{ __('Одобренных отзывов') }}
                  @if ($orderBy == 'reviews_count')
                    <i class="fa {{ $orderDirection == 'DESC' ? 'fa-angle-down' : 'fa-angle-up' }}"></i>
                  @endif
                </a>
              </th>
              <th>
                <a href="{{ route('admin.positions', ['order' => 'salaries_count', 'order_direction' => $newOrderDirection]) }}">
                  {{ __('Одобренных зарплат') }}
                  @if ($orderBy == 'salaries_count')
                    <i class="fa {{ $orderDirection == 'DESC' ? 'fa-angle-down' : 'fa-angle-up' }}"></i>
                  @endif
                </a>
              </th>
              <th>
                <a href="{{ route('admin.positions', ['order' => 'interviews_count', 'order_direction' => $newOrderDirection]) }}">
                  {{ __('Одобренных собеседований') }}
                  @if ($orderBy == 'interviews_count')
                    <i class="fa {{ $orderDirection == 'DESC' ? 'fa-angle-down' : 'fa-angle-up' }}"></i>
                  @endif
                </a>
              </th>
              <th>
                <a href="{{ route('admin.positions', ['order' => 'jobs_count', 'order_direction' => $newOrderDirection]) }}">
                  {{ __('Активных вакансий') }}
                  @if ($orderBy == 'jobs_count')
                    <i class="fa {{ $orderDirection == 'DESC' ? 'fa-angle-down' : 'fa-angle-up' }}"></i>
                  @endif
                </a>
              </th>
              <th>{{ __('Всего') }}</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @php /** @var \App\Model\Position $position */ @endphp
            @foreach ($positions as $position)
              <tr data-id="{{ $position->id }}">
                <td class="search-cell">
                  <a class="title" href="{{ route('admin.position.edit', $position) }}">{{ str_limit($position->title, 50) }}</a><br>
                  <small class="text-muted">{{ $position->alias }}</small>
                </td>
                <td>
                  {!! $position->reviews_count ? $position->reviews_count : "<small class='text-muted'><em>(" . __('нет') . ")</em></small>" !!}
                </td>
                <td>
                  {!! $position->salaries_count ? $position->salaries_count : "<small class='text-muted'><em>(" . __('нет') . ")</em></small>" !!}
                </td>
                <td>
                  {!! $position->interviews_count ? $position->interviews_count : "<small class='text-muted'><em>(" . __('нет') . ")</em></small>" !!}
                </td>
                <td>
                  {!! $position->jobs_count ? $position->jobs_count : "<small class='text-muted'><em>(" . __('нет') . ")</em></small>" !!}
                </td>
                <td>
                  {!! $position->total_contributions_count ? $position->total_contributions_count : "<small class='text-muted'><em>(" . __('нет') . ")</em></small>" !!}
                </td>
                <td class="text-nowrap">
                  <button class="btn btn-sm btn-secondary" name="remove" type="button" title="{{ __('удалить') }}"><i class="fa fa-trash"></i></button>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
@endsection

@section('page_js', 'position/list')