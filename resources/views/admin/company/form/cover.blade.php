@php
  /**
   * @var \App\Model\Company $company
   */
@endphp
<div class="form-group">
  <label class="form-control-label">{{ __('Обложка') }}</label>
  <input type="file" name="cover" accept="image/jpeg,image/png">
  <p class="help-block">1140 × 342</p>
  @if ($company->cover)
    {{--todo use image fragment--}}
    <figure class="image-upload-preview contain" style="background-image: url(<?=$company->cover->path?>)" data-path="<?=$company->cover->path?>">
      <div class="preloader"><i></i><i></i><i></i></div>
      <div class="delete" title="delete" style="display: block">×</div>
    </figure>
  @endif
</div>