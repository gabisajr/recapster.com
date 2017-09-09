@php
  /**
   * @var string $title
   * @var \Illuminate\Support\Collection|\App\Model\Country[] $countries
   */
@endphp

@extends('admin.layout')

@section('content')
  <h4 class="page-header">{{ $title }}</h4>

  <nav class="breadcrumb">
    <a class="breadcrumb-item" href="{{ route('admin.vocabularies') }}">{{ __('Словари') }}</a>
    <span class="breadcrumb-item active">{{ __('Университеты') }}</span>
  </nav>

  <table class="table table-sm table-hover">
    <thead>
    <tr>
      <th><samp>id</samp></th>
      <th>{{ __('Страна') }}</th>
      <th>{{ __('Университеты') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($countries as $country)
      <tr>
        <td><samp>{{ $country->id }}</samp></td>
        <td>
          <a href="{{ route('admin.universities.cities', ['country_id' => $country->id]) }}">{{ $country->title }}</a>
        </td>
        <td class="small"><em class="text-muted">{{ universities_count($country->universities_count) }}</em></td>
      </tr>
    @endforeach
    </tbody>
  </table>
@endsection