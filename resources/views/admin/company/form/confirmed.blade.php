@php /* @var \App\Model\Company $company */ @endphp
<div class="form-group">
  <div class="form-check">
    <label class="form-check-label">
      <input class="form-check-input" type="checkbox" name="confirmed"{{ $company->confirmed ? ' checked' : '' }}>
      {{ __("Подтверждена") }}
    </label>
  </div>
</div>