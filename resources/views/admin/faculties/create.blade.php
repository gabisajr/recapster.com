@php
  /**
   * @var string $title
   * @var \App\Model\Faculty $faculty
   * @var \App\Model\University $university
   */
@endphp

@extends('admin.layout')

@section('content')
  <h4 class="page-header">{{ $title }}</h4>
  <nav class="breadcrumb">
    <a class="breadcrumb-item" href="{{ route('admin.vocabularies') }}">{{ __('Словари') }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.universities.countries') }}">{{ __('Учебные заведения') }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.universities.cities', ['country_id' => $university->country_id]) }}">{{ $university->country->title }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.universities', ['city' => $university->city_id]) }}">{{ $university->city->title }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.university.edit', ['id' => $university->id]) }}" title="{{ $university->title }}">{{ str_limit($university->title, 30) }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.faculties', ['university' => $university->id]) }}">{{ __('Факультеты') }}</a>
    <span class="breadcrumb-item active">{{ __('Добавить факультет') }}</span>
  </nav>

  @include('admin.faculties.form')

@endsection