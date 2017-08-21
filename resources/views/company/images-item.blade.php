@php
/**
 * @var Model_Image   $image
 * @var Model_Company $company
 * @var int           $index
 */
if ($image) {
  $size = 200;
  $src = $image->fit($size, $size)->path;
  $in_moderation = $image->status == \App\Status::PENDING;

  $attributes = [
    'class'      => 'img bubble-image',
    'data-index' => $index,
  ];

  $bg_class = $in_moderation ? ' in-moderation' : null;
  $inner = "<img class='bg{$bg_class}' src='$src'>";
  if ($in_moderation) $inner .= View::factory('moderation-warning', ['repeat' => 1]);

} else {

  $attributes = [
    'class'    => 'img empty fast-image-upload',
    'data-url' => $company->add_photo_url(),
  ];

  $inner = View::factory('partials/add-image-tile');
}


@endphp
<div{!! html_attributes($attributes) !!}>{!! $inner !!}</div>