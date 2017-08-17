@php
  /**
   * @var array  $items
   * @var        $value
   * @var string $name
   * @var string $title
   */

  $caption = $title;
  if ($value) {
    foreach ($items as $item) {
      if ($item->id == $value) {
        $caption = $item->title;
        break;
      }
    }
  }

  $dropdownId = "search-$name";

@endphp
<div class="dropdown {{ $name }}">
  <span class="dropdown-toggle {{ $name }} {{ $value ?  ' has-value' : '' }}" id="{{ $dropdownId }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" data-title="{{ $title }}"
        role="menu">
    <span class="title">{{ $caption }}</span> <span class="caret"></span>
  </span>
  @include('search.form.variants', [
    'dropdownId' => $dropdownId,
    'name'       => $name,
    'value'      => $value,
    'items'      => $items,
  ])
</div>