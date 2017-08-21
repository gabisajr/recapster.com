@php
  /**
   * @var Model_User $user
   * @var string     $editMenuActive
   * @var boolean    $isEditHome
   */
  if (!isset($isEditHome)) $isEditHome = false;
@endphp

@extends('layout')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-3 no-pad-xs">
        <div class="user-badge-panel panel hidden-md hidden-sm{{ !$isEditHome ? ' hidden-xs' : '' }}">
          <div class="panel-body">
            @include('user.user-badge', ['user' => $user])
          </div>
        </div>
        <div class="visible-lg">
          @include('user.user-control-menu', ['user' => $user, 'active' => 'edit'])
        </div>
      </div>

      <div class="col-lg-6 col-md-8 no-pad-xs{{ $isEditHome ? ' hidden-xs' : '' }}">
        @yield('edit-content')
      </div>

      <div class="col-lg-3 col-md-4 no-pad-xs hidden-sm{{ !$isEditHome ? ' hidden-xs' : '' }}">
        @include('user.edit.menu', ['active' => $editMenuActive])
      </div>
    </div>
  </div>
@endsection