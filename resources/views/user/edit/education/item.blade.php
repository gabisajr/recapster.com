@php
  /**
   * @var \App\Model\UserEducation $education
   * @var int $index
   * @var Model_User $user
   */
  if (!isset($education) || !$education || !$education->exists) $education = new \App\Model\UserEducation();

  /** @var Model_Country[] $countries */
  $countries = \App\Model\Country::query()
    ->addSelect(DB::raw("IF(countries.id = '{$user->country->id}', true, false) as is_my"))
    ->has('universities')
    ->withCount('universities')
    ->orderBy('is_my', 'desc')
    ->orderBy('universities_count', 'desc')
    ->orderBy('countries.title')
    ->get();

  dd($countries);

  /** @var Model_City[] $cities */
  $cities = $education->university->city->country->cities
    ->select([DB::expr("IF(city.id = '{$user->city->id}', TRUE, FALSE)"), 'is_my'])
    ->join('university', 'LEFT')->on('city.id', '=', 'university.city_id')
    ->select([DB::expr('COUNT(DISTINCT university.id)'), 'universities_count'])
    ->group_by('city.id')
    ->having('universities_count', '>', 0)
    ->order_by('is_my', 'DESC')
    ->order_by('universities_count', 'DESC')
    ->order_by('city.title')
    ->find_all();

  /** @var Model_University[] $universities */
  $universities = $education->university->city->universities->order_by('university.title')->find_all();

  /** @var Model_Faculty[] $faculties */
  $faculties = $education->university->faculties->order_by('faculty.title')->find_all();

  /** @var Model_Chair[] $chairs */
  $chairs = $education->faculty->chairs->order_by('chair.title')->find_all();

  /** @var Model_Education_Form[] $edu_forms */
  $edu_forms = ORM::factory('Education_Form')->order_by('sort')->order_by('title')->find_all();

  /** @var Model_Education_Status[] $statuses */
  $statuses = ORM::factory('Education_Status')->order_by('sort')->order_by('title')->find_all();

  $year_curr = (int)date('Y');
  $start_typing = __('Начните набирать') . '…';
@endphp

<fieldset class="education-form-group group">
  <img src="/images/delete.svg" class="group-delete powertip" title="{{ __('Удалить') }}" data-id="{{ $education->id }}">
  <input type="hidden" name="education[id][{{ $index }}]" value="{{ $education->id }}">


  {{--country--}}
  <div class="form-group">
    <label class="col-sm-4 control-label">{{ __('Страна') }}</label>
    <div class="col-sm-7">
      {{--todo select2--}}
      <select name="education[country][{{ $index }}]" class="form-control country">
        <option value="">{{ __('Не выбрана') }}</option>
        @foreach ($countries as $country)
          {{--$selected = $education->university->city->country->id == $country->id ? ' selected' : null; --}}
          <option value="{{ $country->id }}" {{ $selected }}>{{ $country->title }}</option>
        @endforeach
      </select>
    </div>
  </div>

  {{--city--}}
  @php
    $cities_count = count($cities);
    $hide = !$education->loaded() || !$cities_count;
  @endphp
  <div class="form-group" style="{{ $hide ? 'display:none;' : '' }}">
    <label class="col-sm-4 control-label">{{ __('Город') }}</label>
    <div class="col-sm-7">
      {{--todo select2--}}
      <select name="education[city][{{ $index }}]" class="form-control city">
        <option value="">{{ __('Не выбран') }}</option>
        @foreach ($cities as $city)
          {{--$selected = $education->university->city->id == $city->id ? ' selected' : null;--}}
          <option value="{{ $city->id }}" {{ $selected }}>{{ $city->title }}</option>
        @endforeach
      </select>
    </div>
  </div>

  {{--university--}}
  @php
    $universities_count = count($universities);
    $hide = !$education->loaded() || !$universities_count;
  @endphp
  <div class="form-group" style="{{ $hide ? 'display:none;' : '' }}">
    <label class="col-sm-4 control-label">{{ __('Вуз') }}</label>
    <div class="col-sm-7">
      {{--todo select2--}}
      <select name="education[university][{{ $index }}]" class="form-control university">
        <option value="">{{ __('Не выбран') }}</option>
        @foreach ($universities as $university)
          {{--$selected = $education->university->id == $university->id ? ' selected' : null;--}}
          <option value="{{ $university->id }}" {{ $selected }}>{{ $university->title }}</option>
        @endforeach
      </select>
    </div>
  </div>

  {{--faculty--}}
  @php
    $faculties_count = count($faculties);
    $hide = !$education->loaded() || !$faculties_count;
  @endphp
  <div class="form-group" style="{{ $hide ? 'display:none;' : '' }}">
    <label class="col-sm-4 control-label">{{ __('Факультет') }}</label>
    <div class="col-sm-7">
      {{--todo select2--}}
      <select name="education[faculty][{{ $index }}]" class="form-control faculty">
        <option value="">{{ __('Не выбран') }}</option>
        @foreach ($faculties as $faculty)
          {{--$selected = $education->faculty->id == $faculty->id ? ' selected' : null;--}}
          <option value="{{ $faculty->id }}" {{ $selected }}>{{ $faculty->title }}</option>
        @endforeach
      </select>
    </div>
  </div>

  {{--chair--}}
  @php
    $chairs_count = count($chairs);
    $hide = !$education->loaded() || !$chairs_count;
  @endphp
  <div class="form-group" style="{{ $hide ? 'display:none;' : '' }}">
    <label class="col-sm-4 control-label">{{ __('Кафедра/направление') }}</label>
    <div class="col-sm-7">
      {{--todo select2--}}
      <select name="education[chair][{{ $index }}]" class="form-control chair">
        <option value="">{{ __('Не выбрана') }}</option>
        @foreach ($chairs as $chair)
          {{--$selected = $education->chair->id == $chair->id ? ' selected' : null;--}}
          <option value="{{ $chair->id }}" {{ $selected }}>{{ $chair->title }}</option>
        @endforeach
      </select>
    </div>
  </div>

  {{--education form--}}
  @php
    $hide = !$education->loaded();
  @endphp
  <div class="form-group" style="{{ $hide ? 'display:none;' : '' }}">
    <label class="col-sm-4 control-label">{{ __('Форма обучения') }}</label>
    <div class="col-sm-7">
      <select name="education[edu_form][{{ $index }}]" class="form-control edu_form" data-dropup-auto="false">
        <option value="">{{ __('Не выбрана') }}</option>
        @foreach ($edu_forms as $edu_form)
          {{--$selected = $education->edu_form->id == $edu_form->id ? ' selected' : null;--}}
          <option value="{{ $edu_form->id }}" {{ $selected }}>{{ $edu_form->title }}</option>
        @endforeach
      </select>
    </div>
  </div>

  {{--education status--}}
  @php $hide = !$education->loaded(); @endphp
  <div class="form-group" style="{{ $hide ? 'display:none;' : '' }}">
    <label class="col-sm-4 control-label">{{ __('Статус') }}</label>
    <div class="col-sm-7">
      <select name="education[status][{{ $index }}]" class="form-control status" data-dropup-auto="false">
        <option value="">{{ __('Не выбран') }}</option>
        @foreach ($statuses as $status)
          {{--$selected = $education->status->id == $status->id ? ' selected' : null;--}}
          <option value="{{ $status->id }}" {{ $selected }}>{{ $status->title }}</option>
        @endforeach
      </select>
    </div>
  </div>

  {{--education period--}}
  @php $hide = !$education->loaded(); @endphp
  <div class="form-group" style="{{ $hide ? 'display:none;' : '' }}">
    <label class="col-sm-4 control-label">{{ __('Период обучения') }}</label>
    <div class="col-sm-7">
      <div class="row">
        <div class="col-xs-5">
          <select class="form-control start_year" name="education[start_year][{{ $index }}]" data-dropup-auto="false">
            <option value="">{{ __('Начало') }}</option>
            @php
              $year_top = $year_curr;
              $year_down = $year_top - 100;
            @endphp

            @for ($year = $year_top; $year >= $year_down; $year--)
              {{--$selected = $education->start_year == $year ? ' selected' : null;--}}
              <option value="{{ $year }}" {{ $selected }}>{{ $year }}</option>
            @endfor
          </select>
        </div>
        <div class="col-xs-5">
          <select class="form-control end_year" name="education[end_year][{{ $index }}]" data-dropup-auto="false">
            <option value="">{{ __('Окончание') }}</option>
            @php
            $year_top = $year_curr + 10;
            $year_down = $year_top - 100;
            @endphp
            @for ($year = $year_top; $year >= $year_down; $year--)
              {{--$selected = $education->end_year == $year ? ' selected' : null;--}}
              <option value="{{ $year }}" {{ $selected }}>{{ $year }}</option>
            @endfor
          </select>
        </div>
      </div>
    </div>
  </div>


  {{--Achievements--}}
  @php $hide = !$education->loaded(); @endphp
  <div class="text-group" style="{{ $hide ? 'display:none;' : '' }}">
    <div class="form-group">
      <div class="col-sm-7 col-sm-offset-4">
        <div class="btn-toggle">
          <input type="checkbox" id="education-text-toggle-{{ $index }}" class="has_text" name="education[has_text][{{ $index }}]" {{ $education->text ? ' checked' : '' }}>
          <label for="education-text-toggle-{{ $index }}">{{ __('Ваши достижения за период обучения') }}</label>
        </div>
      </div>
    </div>
    <div class="form-group text-wrapper" style="{{ !$education->text ? 'display:none;' : '' }}">
      <div class="col-xs-12">
        <textarea name="education[text][{{ $index }}]" class="form-control input-sm text" rows="5" id="education-text-{{ $index }}">{{ $education->text }}</textarea>
      </div>
    </div>
  </div>

  <hr>
</fieldset>
