@extends('layout')

@section('content')
  <div class="container no-pad-xs">
    <div class="row no-marg-xs">
      <div class="col-lg-9 no-pad-xs">
        <section class="panel">
          <div class="panel-body">
            <div class="max-700">
              @yield('search-content')
            </div>
          </div>
        </section>
        <button type="button" class="btn btn-default btn-centered btn-load-more" style="{{ !$hasMore ? 'display: none' : '' }}">{{ __('Загрузить еще') }}</button>
      </div>

      <div class="col-lg-3 visible-lg">
        @yield('aside')
      </div>

    </div>
  </div>
@endsection