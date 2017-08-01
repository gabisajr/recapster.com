<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
  <label class="form-control-label" for="description">{{ __('Описание компании') }}</label>
  <div class="form-control-feedback">{{ $errors->first('description') }}</div>
  <textarea name="description" id="description" class="form-control" rows="5">{{ old('description', $company->description) }}</textarea>
</div>