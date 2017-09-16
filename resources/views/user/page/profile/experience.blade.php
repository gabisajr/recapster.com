@php
  /**
   * @var \App\Model\User $user
   * @var \Illuminate\Support\Collection|\App\Model\UserExperience[] $experiences
   */
  $experiences_count = $experiences->count();
@endphp

@if ($experiences_count)
  <section class="user-profile-block" id="experience">
    @if ($user->isMe())
      <a href="{{ route('user.edit.experience') }}" class="pencil hidden-print" title="{{ __('Редактировать') }}"></a>
    @endif
    <h3 class="user-profile-block-title">{{ __('Опыт работы') }}</h3>

    @foreach ($experiences as $experience)
      @include('user.page.profile.experience-item')
    @endforeach

  </section>
@elseif ($user->isMe())
  @include('user.gag.experience')
@endif