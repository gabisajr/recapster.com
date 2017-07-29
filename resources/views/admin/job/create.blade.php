@extends('admin.layout')

@section('title', __("Добавить вакансию"))

@section('content')
  <h1 class="h5">{{ __("Добавить вакансию") }}</h1>
  @include('admin.job.form')
@endsection

@section('page_js', 'job/item')