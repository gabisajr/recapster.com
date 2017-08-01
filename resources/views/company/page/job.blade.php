@php
  /**
   * @var \App\Model\Job $job
   */

  $job_cities = $job->cities()->get(); //todo load job with cities
  $job_tags = $job->tags()->get(); //todo load job with tags
@endphp

@extends('company.layout.job')

@section('center')
  <div class="panel">
    <div class="panel-body page-post">

      <article data-id="{{ $job->id }}" class="html-text rel">

        <label class="add-fave" title="{{ $job->is_fave ? __('Избранная вакансия') : __('Добавить в избранное') }}">
          <input type="checkbox" hidden name="fave" {{ $job->is_fave ? ' checked ' : '' }} value="{{ $job->id }}">
          <i class="fa fa-star fave-star"></i>
        </label>

        <p class="no-marg-top marg-bot visible-xs visible-sm"><a href="{{ $job->company->url() }}">{{ $job->company->title }}</a>
          {!! icon_confirmed_company($job->company) !!}
        </p>

        <h1>
          {{ $job->title }}
          @if ($job->hot) <span class="hot">HOT</span> @endif
        </h1>

        <p class="page-post-pre">
          <time datetime="{{ $job->created_at->format('Y-m-d H:i') }}">
            {{ $job->created_at->format('j M Y') }}
            {{--          {{ mb_strtolower(Date::rus_date('j M Y', $time)) }}--}}
          </time>


          {{--если у вакансии 1 город - то его показываем--}}
          @if (count($job_cities) == 1)
            @php $city = $job_cities[0]; @endphp
            <span class="separator"></span>
            <a href="{{ route('jobs', ['city' => $city->id]) }}">{{ $city->title }}</a>
          @endif

          @if ($job->employmentForm)
            <span class="separator"></span>
            <a href="">{{ $job->employmentForm->title }}</a>
          @endif

          @if ($job->is_internship)
            <span class="separator"></span>
            <a href="{{ route('jobs', ['internship' => true]) }}">{{ __('Стажировка') }}</a>
          @endif

          @if ($salary_range = salary_range($job))
            <span class="separator"></span>
            {!! $salary_range !!}
          @endif

        </p>

        <hr>

        {!! $job->description !!}

        @if ($job_tags->count())
          <p class="tags">
            @foreach ($job_tags as $tag)
              <a class="post-tag" href="{{ route('jobs', ['search' => $tag->title]) }}">{{ $tag->title }}</a>
            @endforeach
          </p>
        @endif

      </article>

      @if (!Auth::check())
        <hr>
        <div class="gag">
          {{--todo asset and routes--}}
          <img src="/images/locked.png" class="gag-img">
          <div class="gag-title p text-muted">{{ __('Авторизуйтесь') }}</div>
          <div class="gag-text p small text-muted">{{ __('Откликаться на вакансии могут только зарегистрированные пользователи.') }}</div>
          <div class="btns">
            <a href="/signin" class="btn btn-primary open-signin-modal">{{ __('Войдите') }}</a>
            <a href="/signup" class="btn btn-primary open-signup-modal">{{ __('Зарегистрируйтесь') }}</a>
          </div>
        </div>

      @else

        <div class="marg-vert-lg">
          @if ($job->apply_type == 'external')
            <a href="{{ $job->external_url }}" class="btn btn-primary btn-external" target="_blank">{{ __('Подать заявку на сайте компании') }} <i class="fa fa-external-link"></i></a>
          @elseif ($job->apply_type == 'contacts')
            <button class="btn btn-primary btn-show-contacts">{{ __('Показать контакты') }}</button>
            <div class="job-contacts html-text">
              <hr>
              {{--todo auto_p analog--}}
              {!! $job->contacts !!}
            </div>
          @else
            <button class="btn btn-success">{{ __('Откликнуться на вакансию') }}</button>
          @endif
        </div>

      @endif

    </div>
  </div>
@endsection

@section('right')
  {{--todo stop here: right from D:\OpenServer\domains\www.recapster.local\modules\company\classes\Layout\Company\Job.php--}}
@endsection