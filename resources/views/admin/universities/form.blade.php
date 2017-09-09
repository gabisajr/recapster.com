@php
  /**
   * @var \App\Model\University $university
   */
@endphp
<form role="form" method="post" id="university-form" enctype="multipart/form-data" action="{{ route('admin.university.store') }}">

  {{ csrf_field() }}
  <input type="hidden" name="id" value="{{ $university->id }}">

  <div class="row">
    <div class="col col-lg-6">

      <div class="row">
        <div class="col col-sm-6">

          {{--country--}}
          <div class="form-group">
            <label class="control-label" for="country">{{ __('Страна') }}</label>
            {{--todo select2--}}
            <select name="country_id" class="form-control form-control-sm{{ $errors->has('country_id') ? ' is-invalid' : '' }}" id="country">
              <option value="">{{ __('Страна') }}</option>
              @php $countryId = old('country_id', $university->country_id); @endphp
              @foreach ($countries as $_country)
                @php $selected = $countryId == $_country->id ? ' selected' : ''; @endphp
                <option value="{{ $_country->id }}" {{ $selected }}>{{ $_country->title }}</option>
              @endforeach
            </select>
            <div class="invalid-feedback">{{ $errors->first('country_id') }}</div>
          </div>

        </div>
        <div class="col col-sm-6">

          {{--city--}}
          <div class="form-group">
            <label class="control-label" for="city">{{ __('Город') }}</label>
            {{--todo select2--}}
            <select name="city_id" class="form-control form-control-sm{{ $errors->has('city_id') ? ' is-invalid' : '' }}" id="city"{{ !$cities->count() ?  ' disabled' : '' }}>
              <option value="">{{ __('Город') }}</option>
              @php $cityId = old('city_id', $university->city_id); @endphp
              @foreach ($cities as $_city)
                @php $selected = $cityId == $_city->id ? ' selected' : ''; @endphp
                <option value="{{ $_city->id }}" {{ $selected }}>{{ $_city->title }}</option>
              @endforeach
            </select>
            <div class="invalid-feedback">{{ $errors->first('city_id') }}</div>
          </div>

        </div>
      </div>

      {{--title--}}
      <div class="form-group">
        <label class="control-label" for="title">{{ __('Название учебного заведения') }}</label>
        <input class="form-control form-control-sm{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title', $university->title) }}" id="title" autocomplete="off">
        <div class="invalid-feedback">{{ $errors->first('title') }}</div>
      </div>

      {{--abbreviation--}}
      <div class="form-group">
        <label class="control-label" for="abbreviation">{{ __('Аббривиатура') }}</label>
        <input class="form-control form-control-sm{{ $errors->has('abbreviation') ? ' is-invalid' : '' }}" name="abbreviation" value="{{ old('abbreviation', $university->abbreviation) }}" id="abbreviation" autocomplete="off">
        <div class="invalid-feedback">{{ $errors->first('abbreviation') }}</div>
      </div>

      {{--slug--}}
      <div class="form-group">
        <label class="control-label" for="slug">Slug</label>
        <input pattern="{{ \App\Regex::INPUT_PATTERN_SLUG }}" class="form-control form-control-sm{{ $errors->has('slug') ? ' is-invalid' : '' }}"
               name="slug" placeholder="{{ __('Маленькие символы латинского алфавита и -') }}" value="{{ old('slug', $university->slug) }}"
               autocomplete="off" id="slug">
        <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
      </div>

      {{--site--}}
      <div class="row">
        <div class="col col-xs-6">
          <div class="form-group">
            <label for="site" class="control-label">{{ __('Веб-сайт') }}</label>
            <input type="url" class="form-control form-control-sm{{ $errors->has('site') ? ' is-invalid' : '' }}" value="{{ old('site', $university->site) }}" name="site" id="site" placeholder="http://">
            <div class="invalid-feedback">{{ $errors->first('site') }}</div>
          </div>
        </div>
        <div class="col col-xs-6">
          @if ($university->site)
            <a class="small mt-4 d-inline-block" target="_blank" href="{{ $university->site }}">{{ __('Открыть') }} <i class="fa fa-external-link"></i></a>
          @endif
        </div>
      </div>

      @if(Auth::getUser()->is_super_admin)
        <div class="form-group">
          <label class="control-label" for="vk_id">{{ __('id университета ВКонтакте') }}</label>
          <input class="form-control form-control-sm{{ $errors->has('vk_id') ? ' is-invalid' : ''}}" type="text" name="vk_id" value="{{ old('vk_id', $university->vk_id) }}" autocomplete="off" id="vk_id">
          <div class="invalid-feedback">{{ $errors->first('vk_id') }}</div>
        </div>
      @endif

    </div>

    <div class="col col-lg-5">

      {{--logo--}}
      <div class="form-group">
        <label>{{ __('Логотип') }}</label>
        <input type="file" name="logo" accept="image/jpeg,image/png">
        <p class="help-block">Минимум 200 × 200</p>
        @if ($university->logo)
          <div class="row">
            @include('admin.image', ['image' => $university->logo])
          </div>
        @endif
      </div>

    </div>
  </div>

  <div class="row">
    <div class="col col-lg-12">
      <button class="btn btn-primary btn-sm">{{ __('Сохранить') }}</button>
      <a href="{{ route('admin.universities', ['city' => $university->city_id]) }}" class="btn btn-secondary btn-sm">{{ __('Отмена') }}</a>
    </div>
  </div>

</form>

{{--<script src="university/item"></script> todo js--}}