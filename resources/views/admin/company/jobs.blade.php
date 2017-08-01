@php
  /**
   * @var \Illuminate\Support\Collection $images
   * @var \App\Model\Company             $company
   */
@endphp

@extends('admin.company.layout')

@section('title', $title)

@section('breadcrumb')
  <nav class="breadcrumb">
    <a class="breadcrumb-item" href="{{ route('admin.companies') }}">{{ __('Компании') }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.company.edit', $company) }}">{{ str_limit($company->title, 15) }}</a>
    <span class="breadcrumb-item active">{{ __('Вакансии') }}</span>
  </nav>
@endsection

@section('company-content')
  @include('admin.job.list', ['company_col' => false])
@endsection

@section('page_js', 'job/list')