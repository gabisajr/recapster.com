@php
  /**
   * @var \App\Model\Company $company
   * @var Model_User    $curr_user
   */

$images_limit = 3;

/*
  $images = (new Search_Engine_Images($curr_user))
    ->set_company($company)
    ->set_limit($images_limit)
    ->find()
    ->get_results();

  $images_json = (new Search_Engine_Images($curr_user))
    ->set_company($company)
    ->find()
    ->get_json_results(); */

$images = $company->images()->limit($images_limit)->get();
$images_json = $images->toJson();

@endphp

<section class="panel company-profile-images">
  <header class="panel-header no-border">
    <span class="hidden-xs">{{ __('Фотографии') . " ". $company->ofCompany() }}</span>
    <span class="visible-xs-inline">{{ __('Фотографии') }}</span>
    @if ($company->images_count)
      <small>{{ $company->images_count }}</small>
    @endif
    <a href="{{ $company->url('photos') }}" class="right-link">{{ __('Все фотографии') }} <i class="fa fa-angle-right" aria-hidden="true"></i></a>
  </header>
  <div class="panel-body clear">
    <div class="gallery-row profile-images">
      <script type="application/json" class="gallery-json">{!! $images_json !!}</script>
      <div class="row">
        @foreach($images as $index => $image)
          <div class='col-xs-4'>
            @include('company.images-item')
          </div>
        @endforeach
      </div>
    </div>
    <span class="hidden-xs add-photos link fast-image-upload" data-url="{{ $company->addPhotoUrl() }}">+ {{ __('Добавить фото') }}</span>
  </div>
</section>