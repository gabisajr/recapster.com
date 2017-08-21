@php
  /**
   * @var \App\Model\Company $company
   * @var Model_User    $curr_user
   * @var Post_Review   $review
   * @var boolean       $has_my_review
   */

  $summary = null; //view('company.summary', ['company' => $company])->render();
  $description = nl2br($company->description);
@endphp

@extends('company.layout.base-new')

@section('center')

  @if ($company->description || $summary)
    <section class="panel">
      <div class="panel-body">
        @php
          if ($summary) echo $summary;
          if ($summary && $description) echo "<hr>";
          if ($description) echo "<p>{$description}</p>";
        @endphp
      </div>
    </section>
  @endif

  @include('company.images')

  <section class="panel last-review{{ $review ?: ' hidden' }}">
    <header class="panel-header no-border">
      <span class="hidden-xs">{{ __('Отзывы о работе в :company', [':company' => $company->in_company]) }}</span>
      <span class="visible-xs-inline">{{ __('Отзывы о работе') }}</span>
      @if ($company->reviews_count)
        <small>{{ $company->reviews_count }}</small>
      @endif

      <a href="{{ $company->url('reviews') }}" class="right-link">{{ __('Все отзывы') }} <i class="fa fa-angle-right" aria-hidden="true"></i></a>
    </header>
    <div class="panel-body no-pad-top">
      <div class="post-list">
        <div class="post-list-col">{{ $review }}</div>
      </div>
    </div>
  </section>

  @php//=View::factory('company/add-review', ['company' => $company, 'has_my_review' => $has_my_review])@endphp

@endsection