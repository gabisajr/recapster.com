@extends('layout')

@section('content')
  <div class="container company-profile">
    @include('company.header')
    <div class="company-profile-aside">
      @include('company.aside')
      <div class="company-profile-left">@yield('left')</div>
    </div>
    <div class="company-profile-content">@yield('center')</div>
    <div class="company-profile-right">@yield('right')</div>
  </div>
@endsection