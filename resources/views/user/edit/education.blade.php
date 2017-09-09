@php
  /**
   * @var \Illuminate\Support\Collection|\App\Model\UserEducation[] $educations
   */
@endphp

@extends('user.edit.layout')

@section('edit-content')
  <div class="panel">
    <header class="panel-header hidden-xs">{{ __('Высшее образование') }}</header>
    <div class="panel-body">

      <form class="form-horizontal education-form" method="post" role="form" id="education-form" action="{{ route('user.edit.education') }}" enctype="multipart/form-data">
        <div class="education-list">
          @if ($educations->count())
            @each('user.edit.education.item', $educations, 'education')
          @else
            @include('user.edit.education.item', ['index' => 0])
          @endif
        </div>
        <div class="form-group">
          <div class="col-sm-7 col-sm-offset-4">
            <span class="add-education link">+ {{ __('Добавить образование') }}</span>
          </div>
        </div>
        <hr>
        <div class="col-sm-7 col-sm-offset-4">
          <input type="submit" value="{{ __('Сохранить') }}" class="btn btn-primary btn-submit">
          <a href="{{ route('user.edit.education') }}" class="marg-lt">{{ __('Отмена') }}</a>
        </div>
      </form>

    </div>
  </div>
@endsection

@section('page_js', 'edit/education')