@php

  /**
   * @var \App\Model\Company $company
   * @var \App\Model\Industry $industry
   */

  $industries = $company->industries()->get();
  $hasInfo = count($industries) || $company->hqCity || $company->site || $company->size;
  if (!$hasInfo) return;
@endphp

<ul class="summary">

  @if (count($industries))
    <li class="row">
      <div class="col-xs-4 summary-label">{{ __('Деятельность') }}</div>
      <div class="col-xs-8 summary-value">
        @php
          $links = [];
          foreach ($industries as $industry) {
            $href = route('companies', ['industry' => $industry->id]);
            $links[] = "<a href='{$href}'>{$industry->title}</a>";
          }
          echo implode(', ', $links);
        @endphp
      </div>
    </li>
  @endif

  @if ($company->hqCity)
    <li class="row">
      <div class="col-xs-4 summary-label">
        <span class="hidden-xs">{{ __('Местоположение') }}</span>
        <span class="visible-xs-inline">{{ __('Город') }}</span>
      </div>
      <div class="col-xs-8 list-value">
        <a href="{{ route('companies', ['city' => $company->hqCity->id]) }}">
          {{ $company->hqCity->title }}, {{ $company->hqCity->country->title }}
        </a>
      </div>
    </li>
  @endif

  @if ($company->site)
    <li class=" row">
      <div class="col-xs-4 summary-label">
        <span class="hidden-xs">{{ __('Сайт организации') }}</span>
        <span class="visible-xs-inline">{{ __('Сайт') }}</span>
      </div>
      <div class="col-xs-8 list-value">
        <a href="{{ $company->site }}" target="_blank">{{ str_limit($company->site_title, 30) }}</a>
      </div>
    </li>
  @endif

  @if ($company->size)
    <li class="row">
      <div class="col-xs-4 summary-label">
        <span class="hidden-xs">{{ __('Штат сотрудников') }}</span>
        <span class="visible-xs-inline">{{ __('Штат') }}</span>
      </div>
      <div class="col-xs-8 list-value">{{ $company->size->title }}</div>
    </li>
  @endif

</ul>