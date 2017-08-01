<div class="form-group {{ $errors->has('title') ? ' has-danger' : '' }}">
  <label class="form-control-label"><?=__('Название компании')?></label>
  <input class="form-control input-sm" name="title" value="{{ old('title', $company->title) }}" required placeholder="{{ __('10-50 сиволов') }}" autocomplete="off">
  <div class="form-control-label">{{ $errors->first('title') }}</div>
</div>