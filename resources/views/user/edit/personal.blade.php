@php
  /**
   * @var \App\Model\User $user
   */
@endphp

@extends('user.edit.layout')

@section('edit-content')
  <div class="panel">
    <header class="panel-header hidden-xs">{{ __('Личная информация') }}</header>
    <div class="panel-body">
      <form method="post" class="edit-personal" id="edit-personal-form" action="{{ route('user.edit.personal') }}">

        {{ csrf_field() }}

        {{--Аватар--}}
        <div class="form-group">
          <div class="edit-personal-avatar-wrapper wrapper">
            <label for="avatar" class="pointer"><img src="{{ avatar($user, 150) }}" class="edit-personal-avatar avatar"></label>
          </div>
          <div class="text-center">
            <p class="blue-gray avatar-desc">
              <strong>Ваша фотография:</strong> Формат jpg, png<br>
              Максимальный размер файла 2MB<br>
              Минимальный размер 200×200</p>
            <label class="link dotted b">{{ $user->avatar ? __('Сменить фото') : __('Загрузить фото') }}
              <input class="hidden" type="file" name="avatar" id="avatar" hidden accept="image/jpeg, image/png"></label>
          </div>
        </div>

        <hr>

        @if(session('success'))
          <div class="alert alert-success">{{ __("Личная информация успешно сохранена") }}</div>
        @endif

        {{--имя--}}
        <div class="form-group row">
          <label for="firstname" class="col-sm-3 col-form-label">{{ __('Имя') }} <span class="required"></span></label>
          <div class="col-sm-8">
            <input class="form-control{{ $errors->has('firstname') ? ' is-invalid'  : '' }}"
                   value="{{ old('firstname', $user->firstname) }}" autocomplete="off" name="firstname" id="firstname">
            <div class="invalid-feedback">{{ $errors->first('firstname') }}</div>
          </div>
        </div>

        {{--фамилия--}}
        <div class="form-group row">
          <label for="lastname" class="col-sm-3 col-form-label">{{ __('Фамилия') }} <span class="required"></span></label>
          <div class="col-sm-8">
            <input class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}"
                   value="{{ old('lastname', $user->lastname) }}" autocomplete="off" name="lastname" id="lastname">
            <div class="invalid-feedback">{{ $errors->first('lastname') }}</div>
          </div>
        </div>

        {{--отчество--}}
        @php
          /*
          <div class="form-group">
            <label for="patronymic" class="col-sm-3 control-label">{{ __('Отчество') }}</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" value="{{ old('patronymic', $patronymic) }}" autocomplete="off" name="patronymic" id="patronymic">
            </div>
          </div>
          */
        @endphp

        {{--логин--}}
        <div class="form-group row">
          <label for="username" class="col-sm-3 col-form-label">{{ __('Логин') }} <span class="required"></span></label>
          <div class="col-sm-8">
            <input class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" value="{{ old('username', $user->username) }}" autocomplete="off" name="username" id="username">
            <div class="invalid-feedback">{{ $errors->first('username') }}</div>
          </div>
        </div>

        {{--должность--}}
        <div class="form-group row">
          <label for="position" class="col-sm-3 col-form-label">{{ __('Должность или профессия') }}</label>
          <div class="col-sm-8 ui-front">
            <input class="form-control{{ $errors->has('position') ? ' is-invalid' : '' }}" value="{{ old('position', $user->positionTitle()) }}" autocomplete="off" name="position" id="position">
          </div>
        </div>

        {{--статус по работе--}}
        <div class="form-group row">
          <label for="status" class="col-sm-3 col-form-label">{{ __('Статус') }}</label>
          <div class="col-sm-8">
            <select name="job_status" class="form-control{{ $errors->has('job_status') ? ' is-invalid' : '' }}" id="status">
              @foreach ($statuses as $statusId => $statusTitle)
                <option value='{{ $statusId }}' {{ $statusId == $user->job_status ? ' selected' : '' }}>{{ $statusTitle }}</option>
              @endforeach
            </select>
            <div class="invalid-feedback">{{ $errors->first('job_status') }}</div>
            {{--todo route--}}
            <a href="/settings/search" target="_blank" class="job-search-settings"
               style="{{ $user->job_status == \App\UserJobStatus::NOT_SEARCH ? 'display:  none;' : '' }}">{{ __('Настройки поиска работы') }}</a>
          </div>
        </div>

        {{--пол--}}
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">{{ __('Пол') }}</label>
          <div class="col-sm-8">

            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="radio" name="sex" value="{{ \App\Sex::MALE }}" {{ $user->sex == \App\Sex::MALE ? ' checked' : '' }}>
                {{ __('Мужской') }}
              </label>
            </div>

            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="radio" name="sex" value="{{ \App\Sex::FEMALE }}" {{ $user->sex == \App\Sex::FEMALE ? ' checked' : '' }}>
                {{ __('Женский') }}
              </label>
            </div>

          </div>
        </div>

        {{--дата рождения--}}
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">{{ __('Дата рождения') }}</label>
          <div class="col-sm-8">
            <div class="birthday-inputs">
              <div class="row">
                <div class="col col-3">
                  <select class="form-control" title="{{ __('День') }}" name="birth_day">
                    <option value="">{{ __('День') }}</option>
                    @for ($d = 1; $d <= 31; $d++)
                      <option value='{{ $d }}' {{ $d == $user->birth_day ? ' selected' : '' }}>{{ $d }}</option>
                    @endfor
                  </select>
                </div>
                <div class="col col-5">
                  <select class="form-control" name="birth_month" title="{{ __('Месяц') }}">
                    <option value="">{{ __('Месяц') }}</option>
                    <option value="1"{{ $user->birth_month == 1 ? ' selected' : '' }}>{{ __('Январь') }}</option>
                    <option value="2"{{ $user->birth_month == 2 ? ' selected' : '' }}>{{ __('Февраль') }}</option>
                    <option value="3"{{ $user->birth_month == 3 ? ' selected' : '' }}>{{ __('Март') }}</option>
                    <option value="4"{{ $user->birth_month == 4 ? ' selected' : '' }}>{{ __('Апрель') }}</option>
                    <option value="5"{{ $user->birth_month == 5 ? ' selected' : '' }}>{{ __('Май') }}</option>
                    <option value="6"{{ $user->birth_month == 6 ? ' selected' : '' }}>{{ __('Июнь') }}</option>
                    <option value="7"{{ $user->birth_month == 7 ? ' selected' : '' }}>{{ __('Июль') }}</option>
                    <option value="8"{{ $user->birth_month == 8 ? ' selected' : '' }}>{{ __('Август') }}</option>
                    <option value="9"{{ $user->birth_month == 9 ? ' selected' : '' }}>{{ __('Сентябрь') }}</option>
                    <option value="10"{{ $user->birth_month == 10 ? ' selected' : '' }}>{{ __('Октябрь') }}</option>
                    <option value="11"{{ $user->birth_month == 11 ? ' selected' : '' }}>{{ __('Ноябрь') }}</option>
                    <option value="12"{{ $user->birth_month == 12 ? ' selected' : '' }}>{{ __('Декабрь') }}</option>
                  </select>
                </div>
                <div class="col col-4">
                  <select class="form-control" name="birth_year" title="{{ __('Год') }}">
                    <option value="">{{ __('Год') }}</option>
                    @php
                      $top_year = (int)date('Y');
                      $downYear = $top_year - 100;
                    @endphp
                    @for ($y = $top_year; $y >= $downYear; $y--)
                      <option value="{{ $y }}" {{ $y == $user->birth_year ? ' selected' : '' }}>{{ $y }}</option>
                    @endfor
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{--страна--}}
        <div class="form-group row">
          <label for="country" class="col-sm-3 col-form-label">{{ __('Страна') }}</label>
          <div class="col-sm-8">
            @php $countryId = old('country', $user->country_id); @endphp
            <select class="form-control" name="country" id="country">
              <option value="">{{ __('Страна') }}</option>
              @foreach ($countries as $country)
                <option value='{{ $country->id }}' {{ $country->id == $countryId ? ' selected' : '' }}>{{ $country->title }}</option>
              @endforeach
            </select>
          </div>
        </div>

        {{--город--}}
        <div class="form-group row">
          <label for="city" class="col-sm-3 col-form-label">{{ __('Город') }}</label>
          <div class="col-sm-8">
            @php $cityId = old('city', $user->city_id); @endphp
            <select class="form-control" name="city" id="city">
              <option value="">{{ __('Город') }}</option>
              @foreach ($cities as $city)
                <option value="{{ $city->id }}" {{ $city->id == $cityId ? ' selected' : '' }}>{{ $city->title }}</option>
              @endforeach
            </select>
          </div>
        </div>

        {{--О себе--}}
        <div class="form-group row">
          <label for="about" class="col-sm-3 col-form-label">{{ __('О себе') }}</label>
          <div class="col-sm-8">
            <textarea class="form-control autosize" name="about" id="about" rows="3">{{ old('about', $user->about) }}</textarea>
          </div>
        </div>

        {{--submit--}}
        <div class="form-group row">
          <div class="col col-sm-3"></div>
          <div class="col-sm-8">
            <input type="submit" value="{{ __('Сохранить') }}" class="btn btn-primary btn-submit">
            <a href="{{ route('user.edit.personal') }}" class="marg-lt">{{ __('Отмена') }}</a>
          </div>
        </div>

      </form>
    </div>
  </div>
@endsection

@section('page_js', 'edit/personal')