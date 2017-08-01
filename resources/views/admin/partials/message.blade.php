@if($message_warning = session()->pull('message_warning'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true" title="{{ __("Закрыть") }}">&times;</span>
    </button>
    {!! $message_warning !!}
  </div>
@endif

@if($message_success = session()->pull('message_success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true" title="{{ __("Закрыть") }}">&times;</span>
    </button>
    {!! $message_success !!}
  </div>
@endif

@if($message_info = session()->pull('message_info'))
  <div class="alert alert-info alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true" title="{{ __("Закрыть") }}">&times;</span>
    </button>
    {!! $message_info !!}
  </div>
@endif

@if($message_error = session()->pull('message_error'))
  <div class="alert alert-info alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true" title="{{ __("Закрыть") }}">&times;</span>
    </button>
    {!! $message_error !!}
  </div>
@endif