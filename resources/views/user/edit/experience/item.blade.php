@php
  /**
   * @var \App\Model\UserExperience $experience
   * @var int $index
   */
  $experience = $experience ?? new \App\Model\UserExperience();
  $index = $index ?? request()->input('index', 0);

  $months = [
    1  => __('January'),
    2  => __('February'),
    3  => __('March'),
    4  => __('April'),
    5  => __('May'),
    6  => __('June'),
    7  => __('July'),
    8  => __('August'),
    9  => __('September'),
    10 => __('October'),
    11 => __('November'),
    12 => __('December'),
  ];

  $yearCurr = (int)date('Y');
@endphp

<fieldset class="experience-form-group group">
  <img src="{{ asset('/images/delete.svg') }}" class="group-delete" data-toggle="tooltip" title="{{ __('Удалить') }}" data-id="{{ $experience->id }}">
  <input type="hidden" name="experience[id][{{ $index }}]" value="{{ $experience->id }}">


  {{--is internship--}}
  <div class="form-group row form-group-sm">
    <legend class="col col-sm-4 col-form-legend">{{ __('Тип') }}</legend>
    <div class="col col-sm-7">

      <div class="form-check">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="experience[is_internship][{{ $index }}]"{{ $experience->is_internship ? '' : ' checked' }}>
          {{ __('Постоянная работа') }}
        </label>
      </div>

      <div class="form-check">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="experience[is_internship][{{ $index }}]" {{ $experience->is_internship ? ' checked' : '' }} value="1">
          {{ __('Стажировка') }}
        </label>
      </div>

    </div>
  </div>

  {{--company--}}
  <div class="form-group row">
    <label for="experience-company-{{ $index }}" class="col col-sm-4 col-form-label">{{ __('Компания') }}</label>
    <div class="col-sm-7 ui-front" style="z-index: 105">
      @php $companyTitle = $experience->company ? $experience->company->title : $experience->company_title; @endphp
      <input type="text" id="experience-company-{{ $index }}" name="experience[companyTitle][{{ $index }}]" value="{{ $companyTitle }}" class="form-control companyTitle" autocomplete="off">
    </div>
  </div>

  {{--position--}}
  <div class="form-group row">
    <label for="experience-position-{{ $index }}" class="col col-sm-4 col-form-label">{{ __('Должность') }}</label>
    <div class="col-sm-7 ui-front" style="z-index: 104">
      @php $positionTitle = $experience->position ? $experience->position->title : $experience->position_title; @endphp
      <input type="text" id="experience-position-{{ $index }}" name="experience[positionTitle][{{ $index }}]" value="{{ $positionTitle }}" class="form-control positionTitle" autocomplete="off">
    </div>
  </div>

  {{--city--}}
  <div class="form-group row">
    <label for="experience-city-{{ $index }}" class="col col-sm-4 col-form-label">{{ __('Город') }}</label>
    <div class="col-sm-7 ui-front">
      @php $cityTitle = $experience->city ? $experience->city->title : $experience->city_title; @endphp
      <input type="text" id="experience-city-{{ $index }}" name="experience[cityTitle][{{ $index }}]" value="{{ $cityTitle }}" class="form-control cityTitle" autocomplete="off">
    </div>
  </div>

  {{--job period start--}}
  <div class="form-group row">
    <legend class="col col-sm-4 col-form-legend">{{ __('Начало работы') }}</legend>
    <div class="col-sm-7">
      <div class="form-row">
        <div class="col col-xs-7 col">
          <label for="experience-startMonth-{{ $index }}" class="sr-only">{{ __("Месяц") }}</label>
          <select id="experience-startMonth-{{ $index }}" name="experience[startMonth][{{ $index }}]" class="form-control startMonth">
            <option value="">{{ __('Месяц') }}</option>
            @foreach ($months as $monthNum => $monthTitle)
              @php $selected = $experience->start_month == $monthNum ? ' selected' : ''; @endphp
              <option value="{{ $monthNum }}"{{ $selected }}>{{ $monthTitle }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-xs-5 col">
          <label for="experience-startYear-{{ $index }}" class="sr-only">{{ __("Год") }}</label>
          <select id="experience-startYear-{{ $index }}" name="experience[startYear][{{ $index }}]" class="form-control startYear">
            <option value="">{{ __('Год') }}</option>
            @php
              $yearTop = $yearCurr;
              $down_year = $yearTop - 20;
            @endphp
            @for ($year = $yearTop; $year >= $down_year; $year--)
              @php $selected = $experience->start_year == $year ? ' selected' : ''; @endphp
              <option value="{{ $year }}"{{ $selected }}>{{ $year }}</option>
            @endfor
          </select>
        </div>
      </div>
    </div>
  </div>

  {{--job period end--}}
  <div class="form-group row">
    <legend class="col col-sm-4 col-form-legend">{{ __('Окончание работы') }}</legend>
    <div class="col-sm-7">
      <div class="form-row">
        <div class="col col-xs-7 col">
          <label for="experience-endMonth-{{ $index }}" class="sr-only">{{ __("Месяц") }}</label>
          <select id="experience-endMonth-{{ $index }}" name="experience[endMonth][{{ $index }}]"
                  class="form-control endMonth"{{ $experience->is_current ? ' disabled' : '' }}>
            <option value="">{{ __('Месяц') }}</option>
            @foreach ($months as $monthNum => $monthTitle)
              @php $selected = $experience->end_month == $monthNum ? ' selected' : ''; @endphp
              <option value="{{ $monthNum }}"{{ $selected }}>{{ $monthTitle }}</option>
            @endforeach
          </select>
        </div>
        <div class="col col-xs-5 col">
          <label for="experience-endYear-{{ $index }}" class="sr-only">{{ __('Год') }}</label>
          <select id="experience-endYear-{{ $index }}" name="experience[endYear][{{ $index }}]" class="form-control endYear"{{ $experience->is_current ? ' disabled' : '' }}>
            <option value="">{{ __('Год') }}</option>
            @php
              $yearTop = $yearCurr;
              $down_year = $yearTop - 20;
            @endphp
            @for ($year = $yearTop; $year >= $down_year; $year--)
              @php $selected = $experience->end_year == $year ? ' selected' : ''; @endphp
              <option value="{{ $year }}"{{ $selected }}>{{ $year }}</option>
            @endfor
          </select>
        </div>
      </div>
      <div class="form-check mt-sm-2">
        <label class="form-check-label">
          <input type="checkbox" class="form-check-input isCurrent" value="1" name="experience[isCurrent][{{ $index }}]"{{ $experience->is_current ? ' checked' : '' }}>
          {{ __('По настоящее время') }}
        </label>
      </div>
    </div>
  </div>

  {{--responsibilities--}}
  <div class="text-group">
    <div class="form-group row">
      <div class="col col-sm-4"></div>
      <div class="col col-sm-7">
        <div class="btn-toggle">
          <input type="checkbox" id="experience-text-toggle-{{ $index }}" class="hasText" name="experience[hasText][{{ $index }}]"{{ $experience->text ? ' checked' : '' }}>
          <label for="experience-text-toggle-{{ $index }}">{{ __('Ваши обязанности и достижения') }}</label>
        </div>
      </div>
    </div>
    <div class="form-group text-wrapper" style="{{ !$experience->text ? 'display:none;' : '' }}">
      <textarea name="experience[text][{{ $index }}]" class="form-control input-sm text" rows="5"
                placeholder="{{ __('Ваши обязанности и достижения') }}"
                id="experience-text-{{ $index }}">{{ $experience->text }}</textarea>
    </div>
  </div>

  <hr>
</fieldset>