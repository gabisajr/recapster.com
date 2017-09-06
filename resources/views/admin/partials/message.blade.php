{{--todo close button--}}

@if($success = Session::pull('message_success'))
  <div class="alert alert-success">{{ $success }}</div>
@endif

@if($error = Session::pull('message_error'))
  <div class="alert alert-danger">{{ $error }}</div>
@endif

@if($warning = Session::pull('message_warning'))
  <div class="alert alert-warning">{{ $warning }}</div>
@endif

@if($info = Session::pull('message_info'))
  <div class="alert alert-info">{{ $info }}</div>
@endif