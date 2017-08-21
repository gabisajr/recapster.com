@php
  /**
   * @var \App\Model\Job $job
   * @var \App\Model\City $city
   */
  $tags = $job->tags()->get(); //todo load with tags
@endphp

<article class="post job-post search-post" data-id="{{ $job->id }}" data-url="{{ $job->url() }}">
  <div class="post-inner">
    <header class="post-header">
      @php /*=View::factory('post/job/menu', ['job' => $job]) */ @endphp
      <div class="post-left">
        <a href="{{ $job->company->url() }}">
          <img src="{{ logo($job->company) }}" class="post-logo">
        </a>
      </div>
      <div class="post-right">

        <label class="fave no-mobile-go hidden-print">
          <input type="checkbox" hidden name="fave" value="{{ $job->id }}"{{ $job->is_fave ?  ' checked' : '' }}>
          <i class="fa fa-fw fa-star fave-star"></i>
        </label>

        <h1 class="post-title">
          <a href="{{ $job->url() }}">{{ str_limit($job->title) }}</a>
          @if ($job->hot)<span class="hot">HOT</span>@endif
          @include('partials.job-salary', ['job' => $job])
        </h1>
        <ul class="post-info">

          @php

            $parts = [];


            if ($job->company) {
              $parts[] = "<a href='{$job->company->url()}' class='company'>{$job->company->title}</a>";
            }

            //если у вакансии 1 город - то его показываем
            $job_cities = $job->cities()->get(); //todo load with cities
            if (count($job_cities) == 1) {
              $city = $job_cities[0];
              $href = '#'; // "/search" . URL::query(['type' => 'jobs', 'city' => $city->id]);
              $parts[] = "<a href='{$href}'>{$city->title}</a>";
            }

            if ($job->is_internship) {
              $href = '#'; // "/search" . URL::query(['type' => 'jobs', 'job_type' => 'internship']);
              $text = __('Стажировка');
              $parts[] = "<a href='{$href}'>{$text}</a>";
            }

            if ($job->employmentForm) {
              $href = '#';// "/search" . URL::query(['type' => 'jobs', 'employment' => $job->employment->alias]);
              $parts[] = "<a href='{$href}'>{$job->employment->title}</a>";
            }

            echo implode('<span class="separator"></span>', $parts);

          @endphp

        </ul>
      </div>
    </header>

    <div class="post-body">
      <div class="post-right">
        <p class="post-desc post-desc-limit">{{ str_limit($job->noHtmlDescription(), 500) }}</p>

        @if ($tags->count())
          <p class="tags">
            @foreach ($tags as $tag)
              <a class="post-tag" href="{{ "/search?q={$tag->title}&type=jobs" }}">{{ $tag->title }}</a>
            @endforeach
          </p>
        @endif

        <div class="post-stats">
          <time datetime="{{ date('Y-m-d H:i', strtotime($job->created_at)) }}">
            {{ $job->created_at->diffForHumans() }}
          </time>
        </div>

      </div>
    </div>

  </div>
</article>