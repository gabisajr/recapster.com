@php
  /**
   * @var \App\Model\User $user
   * @var boolean $showWelcome
   * @var boolean $emptyProfile
   * @var \Illuminate\Database\Eloquent\Collection|\App\Model\Skill[] $userSkills
   * @var \Illuminate\Database\Eloquent\Collection|\App\Model\Lang[] $userLangs
   */
@endphp

@extends('user.layout')

@section('user-content')
  <div class="user-profile" data-show-welcome="{{ $showWelcome }}">
    @include('user.page.profile.intro')

    @if (!$emptyProfile || $user->isMe())

      <div class="panel">
        <div class="panel-body">

          @include('user.page.profile.about')
          @include('user.page.profile.experience')
          @include('user.page.profile.education')

          {{--Навыки и языки--}}
          @if (count($userSkills) || count($userLangs))

            {{--todo add views--}}
            @include('user.page.profile.skills')
            @include('user.page.profile.langs')

          @elseif ($user->isMe())
            @include('user.gag.skills')
          @endif

          @include('user.page.profile.exams')
          @include('user.page.profile.subscriptions')

        </div>
      </div>

    @endif
  </div>
@endsection

@section('page_js', 'user/profile')