@php
  /**
   * @var \App\Model\Faculty $faculty
   */
@endphp

<form role="form" method="post" id="faculty-form" enctype="multipart/form-data" class="top-buffer" action="{{ route('admin.faculty.store') }}">
  {{ csrf_field() }}

  <input type="hidden" name="id" value="{{ $faculty->id }}">
  <input type="hidden" name="university" value="{{ $faculty->university_id }}">

  <div class="row">
    <div class="col-lg-6">

      {{--title--}}
      <div class="form-group">
        <label class="control-label" for="title">{{ __('Название факультета') }}</label>
        <input class="form-control form-control-sm{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title', $faculty->title) }}" id="title">
        <div class="invalid-feedback">{{ $errors->first('title') }}</div>
      </div>

      @if (Auth::getUser()->is_super_admin)

        {{--vk id--}}
        <div class="form-group">
          <label class="control-label" for="vk_id">{{ __('id факультета ВКонтакте') }}</label>
          <input class="form-control form-control-sm{{ $errors->has('vk_id') ? ' is-invalid' : '' }}" type="text" name="vk_id" value="{{ old('vk_id', $faculty->vk_id) }}" autocomplete="off" id="vk_id">
          <div class="invalid-feedback">{{ $errors->first('vk_id') }}</div>
        </div>

      @endif

    </div>
  </div>

  <button class="btn btn-sm btn-primary">{{ __('Сохранить') }}</button>

</form>