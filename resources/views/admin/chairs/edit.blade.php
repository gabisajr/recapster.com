@extends('admin.layout')

@section('content')
  <h4 class="page-header">{{ $title }}</h4>
  <nav class="breadcrumb">
    <a class="breadcrumb-item" href="{{ route('admin.vocabularies') }}">{{ __('Словари') }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.universities.countries') }}">{{ __('Университеты') }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.universities.cities', ['country' => $faculty->university->country_id]) }}">{{ $faculty->university->country->title }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.universities', ['city' => $faculty->university->city_id]) }}">{{ $faculty->university->city->title }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.university.edit', ['id' => $faculty->university_id]) }}" title="{{ $faculty->university->title }}">{{ str_limit($faculty->university->title, 30) }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.faculties', ['university' => $faculty->university_id]) }}">{{ __("Faculties") }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.faculty.edit', ['id' => $faculty->id]) }}">{{ str_limit($faculty->title) }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.chairs', ['faculty' => $faculty->id]) }}">{{ __("Кафедры") }}</a>
    <span class="breadcrumb-item active">{{ $chair->title }}</span>
  </nav>
  @include('admin.chairs.form')
@endsection