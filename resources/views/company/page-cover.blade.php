@php
  /** @var \App\Model\Company $company */

  $aspectRatio = 10 / 3;
  $width = 970; //max layout width
  $height = $width / $aspectRatio;
@endphp
<div class="company-page-cover hidden-xs {{ $company->cover ? 'with-cover-img' : 'no-cover-img' }}">
  @if ($company->cover)
    <img class="cover-img" src="{{ $company->cover->resize($width, $height)->path }}" alt="{{ $company->title }}">
  @endif
</div>