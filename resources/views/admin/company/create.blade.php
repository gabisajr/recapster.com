@php
  /**
   * @var \App\Model\Company           $company
   * @var array                   $errors
   * @var Model_Company_Size[]    $sizes      Размеры компании
   * @var Model_Company_Revenue[] $revenues   Доходы компании
   * @var Model_Country[]         $countries  Страны
   * @var Model_City[]            $cities     Города
   * @var string                  $industries - виды деятельности компании
   */
@endphp

@extends('admin.layout')

@section('content')
  <h4 class="page-header">{{ __('Добавить компанию') }}</h4>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.companies') }}">{{ __('Компании') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Новая компания') }}</li>
  </ol>
  @include('admin.company.form')
@endsection