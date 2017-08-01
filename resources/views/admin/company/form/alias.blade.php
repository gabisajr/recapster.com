@php
$placeholder = __('Маленькие символы латинского алфавита и -');
@endphp
<div class="form-group{{ $errors->has('alias') ? ' has-danger' : '' }}">
  <label class="form-control-label">{{ __('Альяс') }}</label>
  <div class="input-group input-group-sm">
    <span class="input-group-addon" id="alias-addon"><samp>http://<?=$_SERVER['HTTP_HOST']?>/</samp></span>
    <input pattern="^[A-Za-z0-9]+[ -A-Za-z0-9]+[A-Za-z0-9]+$" aria-describedby="alias-addon"
           value="{{ old('alias', $company->alias) }}" class="form-control" name="alias" placeholder="{{ $placeholder }}" required autocomplete="off">
    <div class="form-control-feedback">{{ $errors->first('alias') }}</div>
  </div>
</div>