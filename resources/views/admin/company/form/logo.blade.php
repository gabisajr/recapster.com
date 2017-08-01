@php
  /**
   * @var \App\Model\Company $company
   */

  $logoMinSize = config('app.logo_min_size', 250);
@endphp
<div class="form-group">
  <label class="form-control-label">{{ __('Логотип') }}</label>
  <input type="file" name="logo" accept="image/jpeg,image/png">

  <p class="help-block">{{ __('Минимум') }} {{ $logoMinSize }}×{{ $logoMinSize }}</p>
  @if ($company->logo)
    {{--todo replace from "Загрузки"--}}
    <figure class="image-upload-preview contain" style="background-image: url({{ $company->logo->path }})" data-path="{{ $company->logo->path }}">
      <div class="preloader"><i></i><i></i><i></i></div>
      <div class="delete" title="delete" style="display: block">×</div>
    </figure>
  @endif
</div>