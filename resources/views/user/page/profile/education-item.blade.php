@php
  /**
   * @var \App\Model\UserEducation $education
   */
@endphp
<article class="edu-post">
  <ul class="summary">
    <li class="row">
      <div class="col col-4 summary-label">{{ __('Университет') }}</div>
      <div class="col col-8 summary-value">
        @if ($education->university->site)
          <a href="{{ $education->university->site }}" target="_blank">{{ $education->university->title }}</a>
        @else
          {{ $education->university->title }}
        @endif
      </div>
    </li>
    @if ($education->faculty)
      <li class="row">
        <div class="col col-4 summary-label">{{ __('Факультет') }}</div>
        <div class="col col-8 summary-value">{{ $education->faculty->title }}</div>
      </li>
    @endif

    @if ($education->chair)
      <li class="row">
        <div class="col col-4 summary-label">
          @php $thin = \App\HTMLMnemonics::THIN_NON_BREAKING_SPACE; @endphp
          {{--todo resolve hidden sm down--}}
          {{ __('Кафедра') }}<span class="d-sm-none">{{ $thin }}/{{ $thin }}{{ __('направление') }}</span>
        </div>
        <div class="col col-8 summary-value">{{ $education->chair->title }}</div>
      </li>
    @endif

    @if ($education->form)
      <li class="row">
        <div class="col col-4 summary-label">{{ __('Форма обучения') }}</div>
        <div class="col col-8 summary-value">{{ $education->form->title }}</div>
      </li>
    @endif

    @if ($education->start_year && $education->end_year)
      <li class="row">
        <div class="col col-4 summary-label">{{ __('Период обучения') }}</div>
        <div class="col col-8 summary-value">{{ $education->start_year }} - {{ $education->end_year }} {{ __('годы') }}</div>
      </li>
    @elseif ($education->start_year)
      <li class="row">
        <div class="col col-4 summary-label">{{ __('Начало обучения') }}</div>
        <div class="col col-8 summary-value">{{ $education->start_year }} {{ __('год') }}</div>
      </li>
    @elseif ($education->end_year)
      <li class="row">
        <div class="col col-4 summary-label">
          <span class="hidden-xs">{{ __('Окончание обучения') }}</span>
          <span class="visible-xs-inline">{{ __('Окончание') }}</span>
        </div>
        <div class="col col-8 summary-value">{{ $education->end_year }} {{ __('год') }}</div>
      </li>
    @endif

    @if ($education->status)
      <div class="row">
        <div class="col col-4 summary-label">{{ __('Статус') }}</div>
        <div class="col col-8 summary-value">{{ $education->status->title }}</div>
      </div>
    @endif

    @if ($education->text)
      <div class="row">
        <div class="col col-4 summary-label">{{ __('Достижения') }}</div>
        <div class="col col-8 summary-value">
          <div class="post-desc">
            @php
            $end_char = "… <span class='more blue-gray'>" . __('Смотреть') . "</span>";
            @endphp
            <div class="short">{!! str_limit($education->text, 100, $end_char) !!}</div>
            <div class="full">{!! nl2br($education->text) !!}</div>
          </div>
        </div>
      </div>
    @endif

  </ul>

</article>