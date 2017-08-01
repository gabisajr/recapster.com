<div class="form-group{{ $errors->has('short_desc') ? ' has-danger' : '' }}">
  <label class="form-control-label" for="short_desc">{{ __('Короткое описание') }}</label>
  <input class="form-control input-sm" name="short_desc" value="{{ old('short_desc', $company->short_desc) }}" id="short_desc">
  <div class="form-control-feedback">{{ $errors->first('short_desc') }}</div>
</div>