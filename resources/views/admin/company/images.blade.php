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
    <span class="breadcrumb-item active">{{ __('Фотографии') }}</span>
  </nav>
@endsection

@section('company-content')

  <div class="row">
    <div class="col col-auto">
      <form class="card card-block mb-4" role="form" method="post" enctype="multipart/form-data" action="{{ route('admin.company.addImages') }}">
        {{ csrf_field() }}
        <input type="hidden" name="company" value="{{ $company->id }}">
        <p>{{ __('Загрузить фотографии компании') }}</p>
        <div class="row no-gutters">
          <div class="col col-auto"><input type="file" name="images[]" accept="image/jpeg" multiple></div>
          <div class="col"><input type="submit" class="btn btn-success btn-sm" value="{{ __('Загрузить') }}"></div>
        </div>
      </form>
    </div>
  </div>

  <h1 class="h5 mb-3">
    {{ $title }}
    <small>
      @if ($images->total())
        {{ __("Всего") }} {{ photos_count($images->total()) }}
      @else
        {{ __('Пока нет фотографий') }}
      @endif
    </small>
  </h1>

  @if ($images->count())
    @include('admin.images.list', ['images' => $images, 'company_col' => false])
  @endif
@endsection

@section('page_js', 'image/list')