@php /* @var \App\Model\Company $company */ @endphp
<div class="form-group">
  <div class="form-check">
    <label class="form-check-label">
      <input class="form-check-input" name="active" type="checkbox"{{ $company->active ? ' checked' : '' }}>
      {{ __("Активная") }}
    </label>
  </div>
</div>