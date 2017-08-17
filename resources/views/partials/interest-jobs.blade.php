@php
  /**
   * @var \App\Model\User|null $currUser - global
   * @var array $excludeIds
   */

  $excludeIds = isset($excludeIds) ? $excludeIds : [];

  $jobs = (new \App\Recommend($currUser))->jobs(10, $excludeIds);

  if (!count($jobs)) return;

  $showDebug = false;
@endphp

<section class="panel panel-body hidden-xs">
  <h2 class="panel-title">{{ __('Интересные вакансии') }}</h2>
  <ul class="list-unstyled">
    @foreach ($jobs as $job)


      @if ($showDebug)
        <samp>
          {{ 'total_comfort: ' . $job->total_comfort }}<br>
          {{ 'is_good_position: ' . $job->is_good_position }}<br>
          {{ 'is_good_city: ' . $job->is_good_city }}<br>
          {{ 'is_good_salary: ' . $job->is_good_salary }}<br>
          {{ 'is_good_employment: ' . $job->is_good_employment }}<br>
        </samp>
      @endif

      <li class="interest-job">
        <div class="interest-job-title">
          <a href="{{ $job->url() }}">{{ $job->title }}</a>
          {{--todo svg icon--}}
          @if ($job->hot)<img src='/images/hot-vacancy.svg' alt="hot">@endif
        </div>
        <div class="interest-job-company small">
          @php
            $parts = [];
            $parts[] = $job->company->title;

            /** @var Model_City[] $jobCities */
            $jobCities = $job->cities()->get();
            if (count($jobCities) == 1) {
              $parts[] = $jobCities->first()->title;
            }

            if ($salaryRange = salary_range($job)) {
              $parts[] = $salaryRange;
            }

            echo implode(', ', $parts);
          @endphp
        </div>
      </li>
    @endforeach

  </ul>
  <a href="{{ route('jobs') }}" class="panel-see-all">{{ __('Смотреть все вакансии') }} <i class="fa fa-caret-right"></i></a>
</section>