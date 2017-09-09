@php
  /**
   * @var \App\Model\City $city
   * @var \Illuminate\Support\Collection|\App\Model\University[] $universities
   * @var Pagination $pagination
   */
@endphp

@extends('admin.layout')

@section('content')
  <h4 class="page-header">{{ $title }}
    <small>{{ universities_count($universities->total()) }}</small>
  </h4>
  <nav class="breadcrumb">
    <a class="breadcrumb-item" href="{{ route('admin.vocabularies') }}">{{ __('Словари') }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.universities.countries') }}">{{ __('Университеты') }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.universities.cities', ['country_id' => $city->country->id]) }}">{{ $city->country->title }}</a>
    <span class="breadcrumb-item active">{{ $city->title }}</span>
  </nav>

  <div class="row">
    <div class="col col-auto">
      <a class="btn btn-success btn-sm" href="{{ route('admin.university.create', ['city' => $city->id]) }}">
        {{ __('Добавить вуз в') . " " . $city->in('title') }}
      </a>
    </div>
    <div class="col">

      @if (Auth::getUser()->is_super_admin && $city->vk_id)
        {{--todo route--}}
        <form method="post" action="/admin/universities/vk_import">
          <button type="submit" name="city" value="{{ $city->id }}" class="btn btn-primary btn-sm">
            {{ __('admin.import_universities_from_vk', ['city' => $city->of('title')]) }}
          </button>
        </form>
      @endif

    </div>
  </div>

  @if ($universities->count())
    <div class="table-responsive top-buffer">
      <table class="table table-sm table-hover" id="universities-list">
        <thead>
        <tr>
          <th><samp>id</samp></th>
          <th>{{ __('Логотип') }}</th>
          <th>{{ __('Название') }}</th>
          <th>{{ __('Аббривиатура') }}</th>
          <th>{{ __('Город') }}</th>
          <th><samp>VK id</samp></th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($universities as $university)
          <tr data-id="{{ $university->id }}">
            <td><samp>{{ $university->id }}</samp></td>
            <td>
              @php $src = $university->logo ? $university->logo->resize(50, 50)->path : asset('/images/empty-logo-university.svg'); @endphp
              <img class="logo" width="50" height="50" src="{{ $src }}" alt="{{ $university->title }}">
            </td>
            <td class="search-cell">
              {{--todo route--}}
              <a class="title" href="{{ route('admin.faculties', ['university' => $university->id]) }}">{{ str_limit($university->title) }}</a><br>
              <em class="small text-muted">{{ faculties_count($university->faculties_count) }}</em>
            </td>
            <td>{{ $university->abbreviation }}</td>
            <td>{{ $university->city->title }}</td>
            <td class="small">
              <samp>{{ $university->vk_id }}</samp>
            </td>
            <td class="text-nowrap">
              {{--todo route--}}
              <a href="/admin/university/edit/{{ $university->id }}" class="text-muted" title="{{ __('Правка') }}"><i class="fa fa-fw fa-pencil"></i></a>
              <button class="btn btn-sm btn-default" name="remove" type="button" title="{{ __('удалить') }}"><i class="fa fa-trash"></i></button>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  @endif
  {!! $universities->links() !!}
@endsection

@section('page_js', 'universities/list')