@extends('admin.layout')

@section('content')
  <h1 class="h5 mb-4">{{ $position->title }}</h1>
  <nav class="breadcrumb mb-4">
    <a class="breadcrumb-item" href="{{ route('admin.vocabularies') }}">{{ __('Словари') }}</a>
    <a class="breadcrumb-item" href="{{ route('admin.positions') }}">{{ __('Профессии') }}</a>
    <span class="breadcrumb-item active">{{ $position->title }}</span>
  </nav>

  @include('admin.position.form')
@endsection