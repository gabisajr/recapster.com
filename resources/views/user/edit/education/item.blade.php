@php
  /**
   * @var \App\Model\UserEducation $education
   * @var int $index
   * @var \App\Model\User $user
   */
  if (!isset($education) || !$education || !$education->exists) $education = new \App\Model\UserEducation();
  if(!isset($user)) $user = Auth::getUser();
  if(!isset($index)) $index = request()->input('index', 0);


  /** @var \Illuminate\Support\Collection|\App\Model\Country[] $countries */
  $countries = \App\Model\Country::query()
    ->select('countries.*')
    ->addSelect(DB::raw("if(countries.id = '{$user->country->id}', true, false) as is_my"))
    ->has('universities')
    ->withCount('universities')
    ->orderBy('is_my', 'desc')
    ->orderBy('universities_count', 'desc')
    ->orderBy('countries.title')
    ->get();

  /** @var \Illuminate\Support\Collection|\App\Model\City[] $cities */
  $cities = new \Illuminate\Support\Collection();
  if($education->exists) {
    $cities = $education->university->city->country->cities()
      ->select('cities.*')
      ->addSelect(DB::raw("if(cities.id = '{$user->city->id}', true, false) as is_my"))
      ->has('universities')
      ->withCount('universities')
      ->orderBy('is_my', 'DESC')
      ->orderBy('universities_count', 'desc')
      ->orderBy('cities.title')
      ->get();
  }

  /** @var \Illuminate\Support\Collection|\App\Model\University[] $universities */
  $universities = new \Illuminate\Support\Collection();
  if($education->exists) {
    $universities = $education->university->city->universities()->orderBy('universities.title')->get();
  }

  /** @var \Illuminate\Support\Collection|\App\Model\Faculty[] $faculties */
  $faculties = new \Illuminate\Support\Collection();
  if($education->exists) {
    $faculties = $education->university->faculties()->orderBy('faculties.title')->get();
  }

  /** @var \Illuminate\Support\Collection|\App\Model\Chair[] $chairs */
  $chairs = new \Illuminate\Support\Collection();
  if($education->exists && $education->faculty) {
    $chairs = $education->faculty->chairs()->orderBy('chairs.title')->get();
  }

  /** @var \Illuminate\Support\Collection|\App\Model\EducationForm[] $educationForms */
  $educationForms = \App\Model\EducationForm::orderBy('sort')->orderBy('title')->get();

  /** @var \Illuminate\Support\Collection|\App\Model\EducationStatus[] $educationStatuses */
  $educationStatuses = \App\Model\EducationStatus::orderBy('sort')->orderBy('title')->get();

  $currYear = (int)date('Y');
@endphp

<fieldset class="education-form-group group">
  <img src="{{ asset('/images/delete.svg') }}" class="group-delete" data-toggle="tooltip" title="{{ __('Удалить') }}" data-id="{{ $education->id }}">
  <input type="hidden" name="education[id][{{ $index }}]" value="{{ $education->id }}">


  {{--country--}}
  <div class="form-group row">
    <label class="col-sm-4 col-form-label" for="education-country-{{ $index }}">{{ __('Страна') }}</label>
    <div class="col-sm-7">
      @php $countryId = old("education.country.$index", ($education->exists ? $education->university->country_id : null)); @endphp
      <select name="education[country][{{ $index }}]" class="form-control country" id="education-country-{{ $index }}">
        <option value="">{{ __('Не выбрана') }}</option>
        @foreach ($countries as $country)
          @php $selected = $countryId == $country->id ? ' selected' : ''; @endphp
          <option value="{{ $country->id }}" {{ $selected }}>{{ $country->title }}</option>
        @endforeach
      </select>
    </div>
  </div>

  {{--city--}}
  @php
    $citiesCount = count($cities);
    $hide = !$education->exists || !$citiesCount;
    $cityId = old("education.city.$index", ($education->exists ? $education->university->city_id : null));
  @endphp
  <div class="form-group row" style="{{ $hide ? 'display:none;' : '' }}">
    <label class="col-sm-4 col-form-label" for="education-city-{{ $index }}">{{ __('Город') }}</label>
    <div class="col-sm-7">
      <select name="education[city][{{ $index }}]" class="form-control city" id="education-city-{{ $index }}">
        <option value="">{{ __('Не выбран') }}</option>
        @foreach ($cities as $city)
          @php $selected = $cityId == $city->id ? ' selected' : ''; @endphp
          <option value="{{ $city->id }}" {{ $selected }}>{{ $city->title }}</option>
        @endforeach
      </select>
    </div>
  </div>

  {{--university--}}
  @php
    $universitiesCount = count($universities);
    $hide = !$education->exists || !$universitiesCount;
    $universityId = old("education.university.$index", ($education->exists ? $education->university_id : null));
  @endphp
  <div class="form-group row" style="{{ $hide ? 'display:none;' : '' }}">
    <label class="col-sm-4 col-form-label" for="education-university-{{ $index }}">{{ __('Вуз') }}</label>
    <div class="col-sm-7">
      <select name="education[university][{{ $index }}]" class="form-control university" id="education-university-{{ $index }}">
        <option value="">{{ __('Не выбран') }}</option>
        @foreach ($universities as $university)
          @php $selected = $universityId == $university->id ? ' selected' : ''; @endphp
          <option value="{{ $university->id }}" {{ $selected }}>{{ $university->title }}</option>
        @endforeach
      </select>
    </div>
  </div>

  {{--faculty--}}
  @php
    $facultiesCount = count($faculties);
    $hide = !$education->exists || !$facultiesCount;
    $facultyId = old("education.faculty.$index", ($education->exists ? $education->faculty_id : null));
  @endphp
  <div class="form-group row" style="{{ $hide ? 'display:none;' : '' }}">
    <label class="col-sm-4 col-form-label" for="education-faculty-{{ $index }}">{{ __('Факультет') }}</label>
    <div class="col-sm-7">
      <select name="education[faculty][{{ $index }}]" class="form-control faculty" id="education-faculty-{{ $index }}">
        <option value="">{{ __('Не выбран') }}</option>
        @foreach ($faculties as $faculty)
          @php $selected = $facultyId == $faculty->id ? ' selected' : ''; @endphp
          <option value="{{ $faculty->id }}" {{ $selected }}>{{ $faculty->title }}</option>
        @endforeach
      </select>
    </div>
  </div>

  {{--chair--}}
  @php
    $chairsCount = count($chairs);
    $hide = !$education->exists || !$chairsCount;
    $chairId = old("education.chair.$index", ($education->exists ? $education->chair_id : null));
  @endphp
  <div class="form-group row" style="{{ $hide ? 'display:none;' : '' }}">
    <label class="col-sm-4 col-form-label" for="education-chair-{{ $index }}">{{ __('Кафедра/направление') }}</label>
    <div class="col-sm-7">
      <select name="education[chair][{{ $index }}]" class="form-control chair" id="education-chair-{{ $index }}">
        <option value="">{{ __('Not selected') }}</option>
        @foreach ($chairs as $chair)
          @php $selected = $chairId == $chair->id ? ' selected' : ''; @endphp
          <option value="{{ $chair->id }}" {{ $selected }}>{{ $chair->title }}</option>
        @endforeach
      </select>
    </div>
  </div>

  {{--education form--}}
  @php
    $hide = !$education->exists;
    $educationFormId = old("education.educationForm.$index", ($education->exists ? $education->edu_form_id : null));
  @endphp
  <div class="form-group row" style="{{ $hide ? 'display:none;' : '' }}">
    <label class="col-sm-4 col-form-label" for="education-educationForm-{{ $index }}">{{ __('Форма обучения') }}</label>
    <div class="col-sm-7">
      <select name="education[educationForm][{{ $index }}]" class="form-control edu_form" data-dropup-auto="false" id="education-educationForm-{{ $index }}">
        <option value="">{{ __('Не выбрана') }}</option>
        @foreach ($educationForms as $educationForm)
          @php $selected = $educationFormId == $educationForm->id ? ' selected' : ''; @endphp
          <option value="{{ $educationForm->id }}" {{ $selected }}>{{ $educationForm->title }}</option>
        @endforeach
      </select>
    </div>
  </div>

  {{--education status--}}
  @php
    $hide = !$education->exists;
    $educationStatusId = old("education.educationStatus.$index", ($education->exists ? $education->status_id : null));
  @endphp
  <div class="form-group row" style="{{ $hide ? 'display:none;' : '' }}">
    <label class="col-sm-4 col-form-label" for="education-educationStatus-{{ $index }}">{{ __('Статус') }}</label>
    <div class="col-sm-7">
      <select name="education[educationStatus][{{ $index }}]" class="form-control status" data-dropup-auto="false" id="education-educationStatus-{{ $index }}">
        <option value="">{{ __('Не выбран') }}</option>
        @foreach ($educationStatuses as $status)
          @php $selected = $educationStatusId == $status->id ? ' selected' : ''; @endphp
          <option value="{{ $status->id }}" {{ $selected }}>{{ $status->title }}</option>
        @endforeach
      </select>
    </div>
  </div>

  {{--education period--}}
  @php $hide = !$education->exists; @endphp
  <div class="form-group row" style="{{ $hide ? 'display:none;' : '' }}">
    <legend class="col-sm-4 col-form-legend">{{ __('Период обучения') }}</legend>
    <div class="col-sm-7">
      <div class="education-period">
        <div class="row">
          <div class="col col-5">
            <label for="education-startYear-{{ $index }}" class="sr-only">{{ __("Start year") }}</label>
            <select class="form-control start_year" name="education[startYear][{{ $index }}]" data-dropup-auto="false" id="education-startYear-{{ $index }}">
              <option value="">{{ __('Начало') }}</option>
              @php
                $yearTop = $currYear;
                $yearDown = $yearTop - 100;
                $startYearValue = old("education.startYear.$index", ($education->exists ? $education->start_year : null));
              @endphp

              @for ($year = $yearTop; $year >= $yearDown; $year--)
                @php $selected = $startYearValue == $year ? ' selected' : ''; @endphp
                <option value="{{ $year }}" {{ $selected }}>{{ $year }}</option>
              @endfor
            </select>
          </div>
          <div class="col col-5">
            <label for="education-endYear-{{ $index }}" class="sr-only">{{ __("End year") }}</label>
            <select class="form-control end_year" name="education[endYear][{{ $index }}]" data-dropup-auto="false" id="education-endYear-{{ $index }}">
              <option value="">{{ __('Окончание') }}</option>
              @php
                $yearTop = $currYear + 10;
                $yearDown = $yearTop - 100;
                $endYearValue = old("education.endYear.$index", ($education->exists ? $education->end_year : null));
              @endphp
              @for ($year = $yearTop; $year >= $yearDown; $year--)
                @php $selected = $endYearValue == $year ? ' selected' : ''; @endphp
                <option value="{{ $year }}" {{ $selected }}>{{ $year }}</option>
              @endfor
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>


  {{--Achievements--}}
  @php $hide = !$education->exists; @endphp
  <div class="text-group" style="{{ $hide ? 'display:none;' : '' }}">

    <div class="row">
      <div class="col col-sm-4"></div>
      <div class="col col-12 col-sm-7">
        <div class="btn-toggle mb-2">
          <input type="checkbox" id="education-text-toggle-{{ $index }}" class="has_text" name="education[hasText][{{ $index }}]" {{ $education->text ? ' checked' : '' }}>
          <label for="education-text-toggle-{{ $index }}">{{ __('Ваши достижения за период обучения') }}</label>
        </div>
      </div>
    </div>

    <div class="form-group text-wrapper" style="{{ !$education->text ? 'display:none;' : '' }}">
      <textarea name="education[text][{{ $index }}]" placeholder="{{ __("Describe your Achievements") }}"
                class="form-control form-control-sm text" rows="5" id="education-text-{{ $index }}">{{ $education->text }}</textarea>
    </div>
  </div>

  <hr>
</fieldset>
