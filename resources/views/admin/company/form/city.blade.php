@php
  /**
   * @var \App\Model\Company $company
   */
  $city_id = old('city', $company->hq_city_id);
  $cities = \App\Model\City::all(); //todo select cities by country
@endphp
<div class="form-group{{ $errors->has('city_id') ? ' has-danger' : '' }}">
  <label class="form-control-label" for="city">{{ __('Город') }}</label>
  <select name="city" class="form-control input-sm select2" id="city" data-live-search="true"{{ !count($cities) ? ' disabled' : '' }}>
    <option value="">{{ __('Выберите город') }}</option>
    @foreach ($cities as $city) {
    <option value='{{ $city->id }}'{{ $city_id == $city->id ? ' selected' : '' }}>{{ $city->title }}</option>
    @endforeach
  </select>
  <div class="form-control-feedback">{{ $errors->first('city_id') }}</div>
</div>