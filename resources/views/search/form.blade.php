@php
  /**
   * @var \DeepCopy\TypeFilter\TypeFilter $typeFilter
   * @var Search_Form_Filter[]    $filters
   * @var boolean                 $has_filter
   * @var string                  $q
   */
@endphp
<form method="get" class="search-form" action="/search">
  <div class="search-form-query">
    <button type="submit" class="btn btn-primary btn-submit"><i class="fa fa-search"></i><span class="hidden-xs">{{ __('Поиск') }}</span></button>
    {!! $typeFilter !!}
    <div class="q_box">
      <input class="form-control" type="search" name="q" placeholder="{{ $typeFilter->placeholder() }}" value="{{ isset($q) ? $q : '' }}" autocomplete="off">
    </div>
  </div>
  @include('search.form.filters')
</form>
<?//=View::factory('search/form/mobile/filters', ['filters' => $filters])?>