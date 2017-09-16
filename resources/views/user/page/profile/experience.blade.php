@php
  /**
   * @var \App\Model\User $user
   * @var \App\Model\UserExperience[] $experiences
   */
  $experiences_count = count($experiences);
@endphp

@if ($experiences_count)
  <section class="user-profile-block" id="experience">
    @if ($user->isMe())
      <a href="{{ route('user.edit.experience') }}" class="pencil hidden-print" title="{{ __('Редактировать') }}"></a>
    @endif
    <h3 class="user-profile-block-title">{{ __('Опыт работы') }}</h3>

    @foreach ($experiences as $experience)
      {{--todo use blade--}}
      echo new Post_Experience($experience);
    @endforeach

  </section>
@elseif ($user->isMe())
  @include('user.gag.experience')
@endif