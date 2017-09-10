@php
  /**
   * @var \App\Model\User $user
   * @var \App\Model\UserEducation[] $educations
   */

  $educations_count = count($educations);
@endphp

@if ($educations_count)
  <section class="user-profile-block" id="education">
    @if ($user->isMe())
      <a href="{{ route('user.edit.education') }}" class="pencil hidden-print" title="{{ __('Редактировать') }}"></a>
    @endif
    <h3 class="user-profile-block-title">{{ __('Образование') }}</h3>
    @foreach ($educations as $education)
      {{--todo stop here: use blade--}}
      echo new Post_Education($education);
    @endforeach
  </section>
@elseif ($user->isMe())
  @include('user.gag.education')
@endif