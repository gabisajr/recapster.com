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
  <div class="container edit-layout">
    <aside class="edit-layout-aside">
      <div class="user-badge-panel panel hidden-md hidden-sm{{ !$isEditHome ? ' hidden-xs' : '' }}">
        <div class="panel-body">
          @include('user.user-badge', ['user' => $user])
        </div>
      </div>
      <div class="visible-lg">
        @include('user.user-control-menu', ['user' => $user, 'active' => 'edit'])
      </div>
    </aside>
    <div class="edit-layout-right">
      @include('user.edit.menu', ['active' => $editMenuActive])
    </div>
    <div class="edit-layout-content">
      @yield('edit-content')
    </div>
  </div>
@endsection