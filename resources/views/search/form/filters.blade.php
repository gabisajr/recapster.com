@php
  /**
   * @var boolean              $hasFilter
   * @var \App\Search\Form\Filter\Filter[] $filters
 */

if (!count($filters)) return;

@endphp

<div class="search-form-filters">
  <button class="d-inline hidden-xs-up mobile-filter-open{{ $hasFilter ? ' has-value' : '' }}" type="button">{{ __('Фильтры') }}</button>
  @foreach ($filters as $filter)
    {!! $filter !!}
  @endforeach
  <button type="reset" style="{{ $hasFilter ? 'display:none;' : '' }}">{{ __('Очистить фильтры') }}</button>
</div>