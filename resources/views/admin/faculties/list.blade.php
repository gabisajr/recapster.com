@php
  /**
   * @var \App\Model\University $university
   * @var \Illuminate\Support\Collection|\App\Model\Faculty[] $faculties
   * @var string $q строка поиска
   * @var string $order_by поле сортировки
   * @var string $order_direction направление сортировки
   */
@endphp

@extends('admin.layout')

@section('content')
  <h4 class="page-header">{{ $title }}
    <small>{{ faculties_count($faculties->total()) }}</small>
  </h4>
  <nav class="breadcrumb">
    <a class="breadcrumb-item" href="{{ route('admin.vocabularies') }}">{{ __('Словари') }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.universities.countries') }}">{{ __('Университеты') }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.universities.cities', ['country' => $university->country_id]) }}">{{ $university->country->title }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.universities', ['city' => $university->city_id]) }}">{{ $university->city->title }}</a>
    <span class="breadcrumb-item active">{{ str_limit($university->title, 30) }}</span>
  </nav>

  <a class="btn btn-success btn-sm" href="{{ route('admin.faculty.create', ['university' => $university->id]) }}">
    {{ __('admin.add_faculty_for_university', ['university' => $university->abbreviation]) }}
  </a>

  @if (Auth::getUser()->is_super_admin && $university->vk_id)
    {{--todo route--}}
    <form method="post" action="/admin/faculty/vk_import" class="pull-right" role="form">
      <button type="submit" name="university" value="{{ $university->id }}" class="btn btn-primary">{{ __("Импорт факультетов из ВКонтакте") }}</button>
    </form>
  @endif

  @if ($faculties->count())
    <div class="table-responsive top-buffer">
      <table class="table table-sm table-hover" id="faculty-list">
        <thead>
        <tr>
          <th><samp>id</samp></th>
          <th>{{ __('Название') }}</th>
          <th><samp>VK id</samp></th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($faculties as $faculty)
          <tr data-id="{{ $faculty->id }}">
            <td><samp>{{ $faculty->id }}</samp></td>
            <td class="search-cell">
              <a class="title" href="{{ route('admin.chairs', ['faculty' => $faculty->id]) }}">{{ str_limit($faculty->title) }}</a><br>
              <em class="text-muted small">{{ chairs_count($faculty->chairs_count) }}</em>
            </td>
            <td><samp>{{ $faculty->vk_id }}</samp></td>
            <td class="text-nowrap">
              <a href="{{ route('admin.faculty.edit', ['id' => $faculty->id]) }}" class="text-muted" title="{{ __('Правка') }}"><i class="fa fa-fw fa-pencil"></i></a>
              <button class="btn btn-sm btn-default" name="remove" type="button" title="{{ __('удалить') }}"><i class="fa fa-trash"></i></button>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  @endif
  {!! $faculties->links() !!}
@endsection

{{--todo webpack bundle--}}
@section('page_js', 'faculty/list')