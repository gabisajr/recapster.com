@php
  /**
   * @var \App\Model\City $city
   * @var \App\Model\Country $country
   */
  $start_typing = __('Начните набирать') . '…';
@endphp

@extends('admin.layout')

@section('content')
  <h4 class="page-header">{{ $title }}</h4>
  <nav class="breadcrumb">
    <a class="breadcrumb-item" href="{{ route('admin.vocabularies') }}">{{ __('Словари') }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.universities.countries') }}">{{ __('Университеты') }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.universities.cities', ['country' => $country->id]) }}">{{ $country->title }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.universities', ['city' => $city->id]) }}">{{ $city->title }}</a>
    <span class="breadcrumb-item active">{{ $university->title }}</span>
  </nav>

  <p><a href="{{ route('admin.faculties', ['university' => $university->id]) }}">{{ __('Открыть список факультетов') }}</a></p>

  @include('admin.universities.form')

@endsection