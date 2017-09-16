@php
  /**
   * @var \App\Model\User $user
   * @var Model_Job_Preferences $job_preferences
   * @var \App\Model\UserExperience[] $experiences
   * @var Model_User_Skill[] $userSkills
   * @var Model_User_Lang[] $userLangs
   * @var Model_Exam[] $exams
   * @var Model_Company[] $subscriptions
   * @var Model_Education[] $educations
   * @var boolean $emptyProfile
   * @var boolean $is_me
   */
@endphp
<div class="panel content-intro hidden-print">

  @include('user.tabs', ['activeTab' => 'profile'])

  @if ($emptyProfile && !$user->isMe())
    @include('user.gag.empty-profile')
  @else
    <div class="panel-body hidden-xs">
      <ul class="summary">
        <li class="row">
          <div class="col col-4 summary-label">{{ __('Готовность к работе') }}</div>
          <div class="col col-8 summary-value">{{ $user->jobStatusTitle() }}</div>
        </li>

        @if (in_array($user->job_status, [\App\UserJobStatus::PASSIVE, \App\UserJobStatus::ACTIVE]))
          <li class="row">
            <div class="col col-4 summary-label">{{ __('Желаемое вознаграждение') }}</div>
            <div class="col col-8 list-value">@php
                $hair_space = HTML_Mnemonics::THIN_NON_BREAKING_SPACE;
                echo Text::formatMoneyDischarges($job_preferences->salary, $job_preferences->currency);
                echo "{$hair_space}/{$hair_space}" . __('мес');
              @endphp</div>
          </li>
        @endif

        <li class="row">
          <div class="col col-4 summary-label">{{ __('Опыт работы') }}</div>
          <div class="col col-8 list-value">
            @if ($experiences_count = count($experiences))
              <a href="#experience">@php
                  $period = total_period($experiences);
                  $companies_count = companies_count($experiences_count);
                  echo $period ? $period : $companies_count;
                @endphp</a>
            @elseif ($user->isMe())
              <a href="{{ route('user.edit.experience') }}">{{ __('Добавить') }}</a>
            @else
              {{ __('Не указан') }}
            @endif
          </div>
        </li>

        <li class="row">
          <div class="col col-4 summary-label">{{ __('Образование') }}</div>
          <div class="col col-8 summary-value">
            @if (count($educations))
              @php $education = $educations->first(); @endphp
              <a href="#education">{{ $education->university->title }}
                @if ($education->end_year)
                  '{{ date('y', mktime(null, null, null, 1, 1, $education->end_year)) }}
                @endif
              </a>
            @elseif ($user->isMe())
              <a href="{{ route('user.edit.education') }}">{{ __('Добавить') }}</a>
            @else
              {{ __('Не указано') }}
            @endif
          </div>
        </li>

        @if ($count = count($userSkills))
          <li class="row">
            <div class="col col-4 summary-label">{{ __('Навыки') }}</div>
            <div class="col col-8 summary-value"><a href="#skills">{{ skills_count($count) }}</a></div> {{--todo create helper--}}
          </li>
        @endif

        @if ($count = count($userLangs))
          <li class="row">
            <div class="col col-4 summary-label">{{ __('Владение языками') }}</div>
            <div class="col col-8 summary-value"><a href="#langs">{{ langs_count($count) }}</a></div> {{--todo create helper--}}
          </li>
        @endif

        @if ($count = count($exams))
          <li class="row">
            <div class="col col-4 summary-label">{{ __('Тесты, экзамены и курсы') }}</div>
            <div class="col col-8 summary-value"><a href="#certificates">{{ certificates_count($count) }}</a></div> {{--todo create helper--}}
          </li>
        @endif

        @if ($count = count($subscriptions))
          <li class="row">
            <div class="col col-4 summary-label">{{ __('Подписки') }}</div>
            <div class="col col-8 summary-value"><a href="#following">{{ companies_count($count) }}</a></div>
          </li>
        @endif

        @if ($user->site)
          <li class="row">
            <div class="col col-4 summary-label">{{ __('Веб-сайт') }}</div>
            <div class="col col-8 summary-value"><a href="{{ $user->site }}" target="_blank">{{ $user->site }}</a></div>
          </li>
        @endif

      </ul>
    </div>
  @endif

</div>