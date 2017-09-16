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

      <form class="education-form" method="post" role="form" id="education-form" action="{{ route('user.edit.education') }}" enctype="multipart/form-data">
        <div class="education-list">
          @if ($educations->count())

            @foreach($educations as $index => $education)
              @include('user.edit.education.item')
            @endforeach

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

@section('scripts')
  <script src="{{ asset('/dist/js/edit-education.bundle.js') }}"></script>
@endsection