@php
  /**
   * @var \App\Model\Company $company
   * @var \App\Model\CompanyRevenue $revenue
   */

  $revenues = \App\Model\CompanyRevenue::all();
  $revenue_id = old('revenue', $company->revenue_id);
@endphp
<div class="form-group">
  <label for="revenue" class="form-control-label">{{ __('Доход') }}</label>
  <select name="revenue" class="form-control input-sm" id="revenue">
    <option value="">- {{ __('Выберите') }} -</option>
    @foreach ($revenues as $revenue)
      <option value="{{ $revenue->id }}"{{ $revenue_id == $revenue->id ? ' selected' : '' }}>{{ $revenue->title }}</option>
    @endforeach
  </select>
</div>