@php /** @var \App\Model\Job $job */ @endphp
@if ($salary_range = salary_range($job))
  <span class='job-salary'>{$salary_range}</span>
@endif