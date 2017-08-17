@php
  /**
   * @var \App\Model\User $user
   */
@endphp

@if ($user->about)
  <section class="user-profile-block">
    @if ($user->isMe())
      {{--todo route--}}
      <a href="/edit/personal" class="pencil hidden-print" title="{{ __('Редактировать') }}"></a>
    @endif
    <h3 class="user-profile-block-title hidden-xs">{{ __('О себе') }}</h3>
    <div>{{ $user->about }}</div> {{--todo auto paragraphs, share on github--}}
  </section>
@elseif ($user->isMe())
  @include('user.gag.about-user')
@endif