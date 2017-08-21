@extends('layout')

@section('content')
  <div class="container job-page">
    <div class="row">
      <div class="col-md-9 no-pad-xs">@yield('center')</div>
      <div class="col-md-3 visible-lg visible-md">@yield('right')</div>
    </div>
  </div>
@endsection