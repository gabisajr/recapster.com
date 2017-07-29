@extends('admin.layout')

@section('title', $title)

@section('content')
  <h1 class="h5 mb-4">{{ $title }}</h1>
  <nav class="breadcrumb">
    <span class="breadcrumb-item active">{{ __('Словари') }}</span>
  </nav>

  <a class="btn btn-primary" href="{{ route('admin.positions') }}" role="button">{{ __('Профессии') }}</a>
  <a class="btn btn-primary" href="/admin/AdditionalPaymentsType/list" role="button">{{ __('Виды дополнительных выплат') }}</a>{{--todo route--}}
  <a class="btn btn-primary" href="/admin/morpher/list" role="button">{{ __('Склонятор') }}</a>{{--todo route--}}
  <a class="btn btn-primary" href="/admin/industry/list" role="button">{{ __('Виды деятельности') }}</a>{{--todo route--}}
  <a class="btn btn-primary" href="/admin/country/list" role="button">{{ __('Города и страны') }}</a>{{--todo route--}}
  <a class="btn btn-primary" href="/admin/university/countries" role="button">{{ __('Университеты (учебные заведения)') }}</a>{{--todo route--}}
@endsection