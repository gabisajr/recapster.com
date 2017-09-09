@php
  /**
   * @var string $title
   * @var \Illuminate\Support\Collection|\App\Model\City[]  $cities
   * @var \App\Model\Country $country
   */
@endphp

@extends('admin.layout')

@section('content')
  <h4 class="page-header">{{ $title }}</h4>
  <nav class="breadcrumb">
    <a class="breadcrumb-item" href="{{ route('admin.vocabularies') }}">{{ __('Словари') }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.universities.countries') }}">{{ __('Университеты') }}</a>
    <span class="breadcrumb-item active">{{ $country->title }}</span>
  </nav>

  <table class="table table-sm table-hover">
    <thead>
    <tr>
      <th><samp>id</samp></th>
      <th>{{ __('Город') }}</th>
      <th>{{ __('Университеты') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($cities as $city)
      <tr>
        <td><samp>{{ $city->id }}</samp></td>
        <td>
          <a href="{{ route('admin.universities', ['city' => $city->id]) }}">{{ $city->title }}</a>
        </td>
        <td class="small"><em class="text-muted">{{ universities_count($city->universities_count) }}</em></td>
      </tr>
    @endforeach
    </tbody>
  </table>
@endsection