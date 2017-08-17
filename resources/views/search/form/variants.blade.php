@php
  /**
   * @var string $dropdownId
   * @var string $name
   * @var string $value
   * @var array  $items
   */
@endphp
<ul class="dropdown-menu" aria-labelledby="{{ $dropdownId }}">
  @foreach ($items as $item)
    <li class="dropdown-menu-item">
      <div class="radio radio-check">
        @php

          $inputId = "search-{$name}-{$item->id}";

          $attributes = [
            'type' => 'radio',
            'name' => $name,
          ];

          if ($item->id == $value) $attributes['checked'] = 'checked';
          if (isset($item->title) && $item->title) $attributes['data-title'] = $item->title;
          if (isset($item->placeholder) && $item->placeholder) $attributes['data-placeholder'] = $item->placeholder;

        @endphp
        <input hidden id="{{ $inputId }}" {!! html_attributes($attributes) !!} value="{{ $item->id }}">
        <label for="{{ $inputId }}">{{ $item->title }}
          @if (isset($item->count) && $item->count)
            <small class='text-muted'>{{ $item->count }}</small>
          @endif
        </label>
      </div>
    </li>
  @endforeach
</ul>