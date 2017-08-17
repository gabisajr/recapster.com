@php
  /**
   * @var \App\Model\User $user
   * @var \App\Model\UserExam[] $exams
   */
  $examsCount = count($exams);
@endphp
@if ($examsCount)
  <section class="user-profile-block" id="certificates">
    @if ($user->isMe())
      {{--todo route--}}
      <a href="/edit/exams" class="pencil hidden-print" title="{{ __('Редактировать') }}"></a>
    @endif

    <h3 class="user-profile-block-title">{{ __('Тесты, экзамены и курсы') }}</h3>
    @foreach ($exams as $exam)
      {{--todo use blade--}}
      echo new Post_Exam($exam);
    @endforeach

  </section>
@elseif ($user->isMe())
  @include('user.gag.exams')
@endif