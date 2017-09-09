@php
  /**
   * @var \App\Model\Chair $chair
   */
@endphp
<form role="form" method="post" id="chair-form" enctype="multipart/form-data" action="{{ route('admin.chair.store') }}">
  {{ csrf_field() }}

  <input type="hidden" name="id" value="{{ $chair->id }}">
  <input type="hidden" name="faculty" value="{{ $chair->faculty_id }}">

  <div class="row">
    <div class="col col-lg-6">

      {{--title--}}
      <div class="form-group">
        <label class="control-label" for="title">{{ __('Chair title') }}</label>
        <input class="form-control form-control-sm{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title', $chair->title) }}" id="title" autocomplete="off">
        <div class="invalid-feedback">{{ $errors->first('title') }}</div>
      </div>

      @if (Auth::getUser()->is_super_admin)

        {{--vk id--}}
        <div class="form-group">
          <label class="control-label" for="vk_id">{{ __("Chair VK id") }}</label>
          <input class="form-control form-control-sm{{ $errors->has('vk_id') ? ' is-invalid' : '' }}" name="vk_id" value="{{ old('vk_id', $chair->vk_id) }}" autocomplete="off" id="vk_id">
          <div class="invalid-feedback">{{ $errors->first('vk_id') }}</div>
        </div>

      @endif

    </div>
  </div>

  <button class="btn btn-sm btn-primary">{{ $chair->exists ? __("Update chair") : __("Add chair") }}</button>
  <a href="{{ route('admin.chairs', ['faculty' => $chair->faculty_id]) }}" class="btn btn-sm btn-secondary">{{ __('Cancel') }}</a>

</form>