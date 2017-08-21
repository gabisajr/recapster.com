@extends('layout')

@section('content')
  <div class="container company-profile">
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-4 no-pad-xs">@include('company.aside')</div>
      <div class="col-lg-9 col-md-9 col-sm-8 no-pad-xs">@include('company.top')</div>
      <div class="col-lg-6 col-md-9 col-sm-8 no-pad-xs">@yield('center')</div>
      <div class="col-xs-3 visible-lg">@yield('right')</div>
    </div>
  </div>
@endsection