@php
  /**
   * @var \App\Model\Faculty $faculty
   * @var \Illuminate\Support\Collection|\App\Model\Chair[] $chairs
   */
@endphp

@extends('admin.layout')

@section('content')
  <h4 class="page-header">{{ $title }}
    <small>{{ chairs_count($chairs->total()) }}</small>
  </h4>

  <nav class="breadcrumb">
    <a class="breadcrumb-item" href="{{ route('admin.vocabularies') }}">{{ __('Словари') }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.universities.countries') }}">{{ __('Университеты') }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.universities.cities', ['country' => $faculty->university->country_id]) }}">{{ $faculty->university->country->title }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.universities', ['city' => $faculty->university->city_id]) }}">{{ $faculty->university->city->title }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.university.edit', ['id' => $faculty->university_id]) }}" title="{{ $faculty->university->title }}">{{ str_limit($faculty->university->title, 30) }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.faculties', ['university' => $faculty->university_id]) }}">{{ __("Faculties") }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.faculty.edit', ['id' => $faculty->id]) }}">{{ str_limit($faculty->title) }}</a>
    <span class="breadcrumb-item active">{{ __("Кафедры") }}</span>
  </nav>

  <a class="btn btn-success btn-sm" href="{{ route('admin.chair.create', ['faculty' => $faculty->id]) }}">{{ __('Add department for the faculty') }}</a>

  @if (Auth::getUser()->is_super_admin && $faculty->vk_id)
    {{--todo route--}}
    <form method="post" action="/admin/chair/vk_import" class="pull-right" role="form">
      <button type="submit" name="faculty" value="{{ $faculty->id }}" class="btn btn-primary">{{ __("Import chairs from VK") }}</button>
    </form>
  @endif

  @if (count($chairs))
    <div class="table-responsive top-buffer">
      <table class="table table-sm table-hover" id="faculty-list">
        <thead>
        <tr>
          <th><samp>id</samp></th>
          <th>{{ __('Title') }}</th>
          <th><samp>VK id</samp></th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($chairs as $chair)
          <tr data-id="{{ $chair->id }}">
            <td><samp>{{ $chair->id }}</samp></td>
            <td class="search-cell">
              {{--todo route--}}
              <a class="title" href="{{ route('admin.chair.edit', ['id' => $chair->id]) }}">{{ str_limit($chair->title) }}</a><br>
            </td>
            <td><samp>{{ $chair->vk_id }}</samp></td>
            <td class="text-nowrap">
              <a href="{{ route('admin.chair.edit', ['id' => $chair->id]) }}" class="text-muted" title="{{ __('Edit') }}"><i class="fa fa-fw fa-pencil"></i></a>
              <button class="btn btn-sm btn-default" name="remove" type="button" title="{{ __('Delete') }}"><i class="fa fa-trash"></i></button>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  @endif
  {!! $chairs->links() !!}

@endsection