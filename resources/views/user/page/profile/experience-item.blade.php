@php
  /**
   * @var \App\Model\UserExperience $experience
   * @var \App\Model\User $curr_user
   */

  $companyTitle = $experience->getCompanyTitle();
  $positionTitle = $experience->getPositionTitle();
  $cityTitle = $experience->getCityTitle();
  $period = $experience->period();
  $periodInterval = $experience->periodInterval();

  $review = $experience->getReview();
  $hasReview = $review && (!$review->anonym || $review->isMy());
@endphp
<article class="edu-post">
  <ul class="summary">
    <li class="row">
      <div class="summary-label col col-4">{{ __('Компания') }}</div>
      <div class="summary-value col col-8">
        @if ($experience->company && $experience->company->active)
          <a href="{{ $experience->company->url() }}">{{ $companyTitle }}</a>
        @else
          {{ $companyTitle }}
        @endif
      </div>
    </li>
    <li class="row">
      <div class="summary-label col col-4">{{ __('Должность') }}</div>
      <div class="summary-value col col-8">{{ $positionTitle }}
        @if ($experience->is_internship)
          <span class="blue-gray">— {{ __('стажировка') }}</span>
        @endif
      </div>
    </li>

    @if ($period)
      <li class="row">
        <div class="summary-label col col-4">{{ __('Период работы') }}</div>
        <div class="summary-value col col-8">{{ $period }}</div>
      </li>
    @endif

    @if ($periodInterval)
      <li class="row">
        <div class="summary-label col col-4">{{ __('Стаж работы') }}</div>
        <div class="summary-value col col-8">{{ $periodInterval }}</div>
      </li>
    @endif

    @if ($cityTitle)
      <li class="row">
        <div class="summary-label col col-4">{{ __('Город') }}</div>
        <div class="summary-value col col-8">{{ $cityTitle }}</div>
      </li>
    @endif

    @if ($hasReview || $user->isMe())
      <li class="row">
        <div class="summary-label col col-4">{{ __('Отзыв о работе') }}</div>
        <div class="summary-value col col-8">
          @if ($hasReview)
            {{--todo stars rating--}}
            <input placeholder="review rating" type="number" class="review-rating hidden" value="{{ number_format($review->rating, 1) }}" readonly data-size="vs" data-display-only="true" data-theme="krajee-svg">
            <a href="{{ $review->url }}">{{ __('Читать отзыв') }}</a>
          @elseif ($user->isMe())

            @if($experience->company || $experience->company_title)
              @php $addReviewCompany = $experience->company ? $experience->company->id : $experience->company_title; @endphp
              <a href="/review?company={{ $addReviewCompany }}">{{ __('Добавить отзыв о работе') }}</a>
            @endif

          @endif
        </div>
      </li>
    @endif

    @if ($experience->text)
      <li class="row">
        <div class="summary-label col col-4">{{ __('Обязанности') }}</div>
        <div class="summary-value col col-8">
          <div class="post-desc">
            @php
              $text = strip_tags($experience->text);
              $endChar = "… <span class='more blue-gray'>" . __('Смотреть') . "</span>";
            @endphp
            <div class="short">{!! str_limit($text, 100, $endChar) !!}</div>
            <div class="full">{!! nl2br(strip_tags($experience->text)) !!}</div>
          </div>
        </div>
      </li>
    @endif

  </ul>
</article>