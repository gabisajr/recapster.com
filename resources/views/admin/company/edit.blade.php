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

@extends('admin.company.layout')

@section('breadcrumb')
  <nav class="breadcrumb">
    <a class="breadcrumb-item" href="{{ route('admin.companies') }}">{{ __('Компании') }}</a>
    <span class="breadcrumb-item active">{{ str_limit($company->title, 40) }}</span>
  </nav>
@endsection

@section('company-content')
  @include('admin.company.form')
@endsection

@section('page_js', 'company/item')