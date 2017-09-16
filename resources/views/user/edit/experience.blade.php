@php
  /**
   * @var \Illuminate\Support\Collection|\App\Model\UserExperience[] $experiences
   */
@endphp

@extends('user.edit.layout')

@section('edit-content')
  <div class="panel">
    <header class="panel-header hidden-xs">{{ __('Опыт работы') }}</header>
    <div class="panel-body">

      <form class="form-horizontal experience-form" method="post" role="form" id="experience-form" action="{{ route('user.edit.experience') }}" enctype="multipart/form-data">
        <div class="experience-list">
          @if ($experiences->count())
            @foreach ($experiences as $index => $experience)
              @include('user.edit.experience.item')
            @endforeach
          @else
            @include('user.edit.experience.item', ['index' => 0])
          @endif
        </div>

        <div class="row mb-3">
          <div class="col col-sm-4"></div>
          <div class="col col-sm-7">
            <span class="add-experience link">+ {{ __('Добавить место работы') }}</span>
          </div>
        </div>

        <hr>

        <div class="row">
          <div class="col col-sm-4"></div>
          <div class="col col-sm-7">
            <input type="submit" value="{{ __('Сохранить') }}" class="btn btn-primary btn-submit">
            <a href="{{ route('user.edit.experience') }}" class="marg-lt">{{ __('Отмена') }}</a>
          </div>
        </div>
      </form>

    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('/dist/js/edit-experience.bundle.js') }}"></script>
@endsection