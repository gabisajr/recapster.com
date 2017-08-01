<div class="form-group{{ $errors->has('site') ? ' has-danger' : '' }}">
  <label class="form-control-label">{{ __('Сайт компании') }}</label>
  <input type="url" class="form-control input-sm" name="site" placeholder="http://site.com" value="{{ old('site', $company->site) }}" autocomplete="off">
  <div class="form-control-feedback">{{ $errors->first('site') }}</div>
</div>