@extends('admin.layout')

@section('title', __("Редактировать вакансию"))

@section('content')
  <h1 class="h5">{{ __('Редактировать вакансию') }}</h1>
  @include('admin.job.form')
@endsection

@section('page_js', 'job/item')