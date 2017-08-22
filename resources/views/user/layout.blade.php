@extends('layout')

@section('content')
  <div class="container user-profile">
    <div class="user-profile-aside">
      @include('user.aside')
    </div>
    <div class="user-profile-content">
      @yield('user-content')
    </div>
    <div class="user-profile-right">
      @include('partials.interest-jobs')
      @include('partials.interest-companies')
    </div>
  </div>
@endsection