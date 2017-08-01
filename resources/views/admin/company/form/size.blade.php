@php
  /**
   * @var \App\Model\Company $company
   * @var \App\Model\CompanySize $size
   */

  $sizes = \App\Model\CompanySize::all();
  $size_id = old('size', $company->size_id)
@endphp
<div class="form-group{{ $errors->has('size_id') ? ' has-danger' : '' }}">
  <label class="form-control-label" for="size">{{ __('Размер') }}</label>

  <select name="size" class="form-control input-sm" id="size">
    <option value="">- {{ __('Выберите') }} -</option>
    @foreach ($sizes as $size)
      <option value="{{ $size->id }}"{{ $size_id == $size->id ? ' selected' : '' }}>{{ $size->employees_count }} {{ __('сотрудников') }}</option>
    @endforeach
  </select>
  <div class="form-control-feedback">{{ $errors->first('size_id') }}</div>
</div>