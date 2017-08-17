@php
  /**
   * @var \App\Model\User|null $currUser - global
   * @var array $exceptIds
   */

  $exceptIds = isset($exceptIds) ? $exceptIds : [];
  $companies = recommend_companies($currUser, 6, $exceptIds);
  if (!count($companies)) return;
@endphp
<section class="panel">
  <div class="panel-body">
    <h2 class="panel-title">{{ __('Интересные компании') }}</h2>
    <ul class="list-unstyled">
      @php /** @var \App\Model\Company $company */ @endphp
      @foreach ($companies as $company)
        <li class="post interest-company">
          <div class="post-left">
            <a href="{{ $company->url() }}">
              <img class="post-logo" src="{{ logo($company) }}">
            </a>
          </div>
          <div class="post-right">

            <h1 class="post-title">
              <a href="{{ $company->url() }}">{{ $company->title }}</a>
              {!! icon_confirmed_company($company, 'n') !!}
            </h1>

            <p class="post-info">
              @php

                $parts = [];

                if ($count = $company->jobs_count) {
                  $href = $company->url('jobs');
                  $text = jobs_count($count);
                  $parts[] = "<a href='$href'>$text</a>";
                }

                if ($count = $company->reviews_count) {
                  $href = $company->url('reviews');
                  $text = reviews_count($count);
                  $parts[] = "<a href='$href'>$text</a>";
                }

                echo implode('<span class="separator"></span>', $parts);

              @endphp
            </p>

          </div>
        </li>
      @endforeach
    </ul>
    <a href="{{ route('companies') }}" class="panel-see-all">{{ __('Смотреть все компании') }} <i class="fa fa-angle-right"></i></a>
  </div>
</section>