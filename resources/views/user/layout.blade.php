@extends('layout')

@section('content')
  <div class="container v-100">
    <div class="row v-100">
      <div class="col-lg-3 col-md-3 col-sm-4 no-pad-xs">
        @include('user.aside')
      </div>
      <div class="col-lg-6 col-md-9 col-sm-8 no-pad-xs v-100">
        @yield('user-content')
      </div>
      <div class="col-lg-3 visible-lg">
        @include('partials.interest-jobs')
        @include('partials.interest-companies')
      </div>
    </div>
  </div>
@endsection