@php
  /**
   * @var \App\Model\Company $company
   */
  $industries = $company->industries()->get()->implode(', ');

@endphp
<div class="form-group form-group-sm has-feedback{{ $errors->first('industry') ? ' has-danger' : '' }}">
  <label class="form-control-label" for="industries">{{ __('Вид деятельности') }}</label>
  <div class="form-control-feedback">{{ $errors->first('industry') }}</div>
  <textarea name="industries" id="industries" class="form-control" placeholder="{{ __('Начните набирать') }}">{{ old('industries', $industries) }}</textarea>
</div>