@if (count($items))
  <section class="panel hidden-xs">
    <div class="panel-body">
      @if (isset($header) && $header)
      <h1 class="panel-title">{{ $header }}</h1>
      @endif
      <div class="share-list">
        @foreach ($items as $item)
          {!! $item !!}
        @endforeach
      </div>
    </div>
  </section>
@endif