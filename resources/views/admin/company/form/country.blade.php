@php
  /**
   * @var \App\Model\Company $company
   * @var \App\Model\Country $country
   */

   $countries = \App\Model\Country::all(); //todo create vocabulary.php

   $country_id_exists = null;
   if ($company->hqCity) {
      $country_id_exists = $company->hqCity->country_id;
   }
   $country_id = old('country', $country_id_exists);
@endphp

<div class="form-group{{ $errors->has('country_id') ? ' has-danger' : '' }}">
  <label class="form-control-label" for="country">{{ __('Страна') }}</label>
  <select name="country" class="form-control input-sm select2" id="country" data-live-search="true">
    <option value="">{{ __('Выберите страну') }}</option>
    @foreach ($countries as $country)
      <option value="{{ $country->id }}" {{ $country_id == $country->id ? ' selected' : '' }}>{{ $country->title }}</option>
    @endforeach
  </select>
  <div class="form-control-feedback">{{ $errors->first('country_id') }}</div>
</div>