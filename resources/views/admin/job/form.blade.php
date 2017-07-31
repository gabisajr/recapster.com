@php
  /** @var \App\Model\Job $job */
  $employments = employments();
@endphp
<form method="post" role="form" id="job-form" action="{{ route('admin.job.store') }}">

  <input type="hidden" name="id" value="{{ $job->id }}">
  {{ csrf_field() }}

  <div class="row">
    <div class="col col-12 col-lg-3">
      <!--<editor-fold desc="компания">-->
      <div class="form-group{{ $errors->has('company') ? ' has-danger' : '' }}">
        <label for="job-company">{{ __("Компания") }}</label>
        <select name="company" class="form-control" id="job-company" data-placeholder="{{ __("Выберите компанию") }}">
          @php
            $companyId = old('company', $job->company_id);
            $company = null;
            if ($companyId) $company = \App\Model\Company::find($companyId);
          @endphp
          @if($company)
            <option value="{{ $company->id }}">{{ $company->title }}</option>
          @endif
        </select>
        <div class="form-control-feedback">{{ $errors->first('company') }}</div>
      </div>
      <!--</editor-fold>-->
    </div>
    <div class="col col-12 col-lg-4">
      <!--<editor-fold desc="должность">-->
      <div class="form-group form-group-sm has-feedback{{ $errors->has('position') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="job-position">{{ __('Должность') }}</label>
        @php
          $positionId = old('position', $job->position_id);
          $position = null;
          if ($positionId) $position = \App\Model\Position::find($positionId);
        @endphp
        <select name="position" id="job-position" class="form-control" data-placeholder="{{ __('Начните набирать название должности') }}">
          @if($position)
            <option value="{{ $position->id }}">{{ $position->title }}</option>
          @endif
        </select>
        {{--<input value="{{ $position }}">--}}
        @if ($job->position)
          <span class="glyphicon form-control-feedback glyphicon-ok text-success" aria-hidden="true"></span>
        @endif
        <div class="form-control-feedback">{{ $errors->first('position') }}</div>
      </div>
      <!--</editor-fold>-->
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6">

      <!--<editor-fold desc="заголовок">-->
      <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="title">{{ __('Заголовок вакансии') }}</label>
        <p class="text-muted">В названии вакансии не следует указывать название компании, город, бонусы и прочие атрибуты</p>
        <input type="text" name="title" value="{{ old('title', $job->title) }}" class="form-control input-sm" autocomplete="off" id="title">
        <div class="form-control-feedback">{{ $errors->first('title') }}</div>
      </div>
      <!--</editor-fold>-->

      <div class="row">
        <div class="col col-auto">
          <!--<editor-fold desc="флажок: стажировка">-->
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="is_internship" {{ old('is_internship', $job->is_internship) ? ' checked ' : '' }} id="internship">
                {{ __("Стажировка") }}
              </label>
            </div>
          </div>
          <!--</editor-fold>-->
        </div>
        <div class="col col-auto">
          <!--<editor-fold desc="флажок: горячая вакансия">-->
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="hot" {{ old('hot', $job->hot) ? ' checked ' : '' }} id="hot">
                {{ __("Горячая вакансия") }}
              </label>
            </div>
          </div>
          <!--</editor-fold>-->
        </div>
      </div>

      <!--<editor-fold desc="описание">-->
      <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
        <div class="row">
          <div class="col col-auto">
            <label for="description">{{ __("Описание вакансии") }}</label>
          </div>
          <div class="col">
            <div class="form-control-feedback mt-0">{{ $errors->first('description') }}</div>
          </div>
        </div>
        <p class="text-muted">Расскажите о своей вакансии, включая условия работы, обязанности и
          требования, предъявляемые к кандидатам. Чем больше информации — тем
          проще соискателю принять решение об отклике</p>
        <textarea name="description" class="form-control" data-ckeditor rows="10" id="description">{{ old('description', $job->description) }}</textarea>
      </div>
      <!--</editor-fold>-->

      <!--<editor-fold desc="теги">-->
      <div class="form-group{{ $errors->has('tags') ? 'has-danger' : '' }}">
        <label for="tags" class="form-control-label">{{ __("Теги") }}</label>
        <div class="form-control-feedback">{{ $errors->first('tags') }}</div>
        <textarea name="tags" class="form-control" id="tags">{{ old('tags', $job->tags()->get()->implode(',') ) }}</textarea>
      </div>
      <!--</editor-fold>-->

      <!--<editor-fold desc="зарплата">-->
      <div class="form-group">
        <label class="form-control-label">{{ __('Зарплата') }}</label>
        <p>{{ __("Указание зарплаты увеличивает число откликов на вакансию, так как все кандидаты хотят знать размер будущего заработка") }}</p>
        <div class="row">
          <div class="col-sm-4">
            @php $salary_min = old('salary_min', $job->salary_min); @endphp
            <input type="number" class="form-control" name="salary_min" value="{{ $salary_min ? $salary_min : '' }}" autocomplete="off" placeholder="{{ __('минимум') }}">
          </div>
          <div class="col-sm-4">
            @php $salary_max = old('salary_max', $job->salary_max); @endphp
            <input type="number" class="form-control" name="salary_max" value="{{ $salary_max ? $salary_max : '' }}" autocomplete="off" placeholder="{{ __('максимум') }}"></div>
          <div class="col-sm-4">
            <label>
              @php $currencyId = old('currency', $job->currency_id) @endphp
              <select name="currency" class="form-control input-sm selectpicker" data-live-search="true" id="currency">
                <option value="">{{ __("Валюта") }}</option>
                {{--todo select2--}}
              </select>
            </label>
          </div>
        </div>
      </div>
      <!--</editor-fold-->

      <!--<editor-fold desc="города">-->
      <div class="form-group{{ $errors->has('cities') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="city">{{ __('Город(a)') }}</label>
        <div class="form-control-feedback">{{ $errors->first('cities') }}</div>
        <textarea name="cities" id="cities" class="form-control" placeholder="{{ __("Города") }}">{{ old('cities', $job->cities()->get()->implode(',') ) }}</textarea>
      </div>
      <!--</editor-fold>-->

      <div class="row">
        <div class="col-sm-4">
          <!--<editor-fold desc="форма занятости">-->
          <div class="form-group">
            <label for="employment">{{ __('Форма занятости') }}</label>
            @php $employmentId = old('employment', $job->employment_form_id); @endphp
            <select name="employment" class="form-control" id="employment">
              <option value="">{{ __('Выберите') }}</option>
              @php /** @var \App\Model\EmploymentForm $employment */ @endphp
              @foreach ($employments as $employment)
                <option value="{{ $employment->id }}" {{ $employmentId == $employment->id ? ' selected' : '' }}>{{ $employment->title }}</option>
              @endforeach
            </select>
          </div>
          <!--</editor-fold>-->
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <!--<editor-fold desc="Тип отклика">-->
          <div class="form-group">
            <label class="form-control-label" for="job-apply_type">{{ __('Тип отклика') }}</label>
            <select class="form-control" name="apply_type" id="job-apply_type">
              @php $applyType = old('apply_type', $job->apply_type); @endphp
              <option value="internal"{{ $applyType == 'internal' ? ' selected' : '' }}>{{ __('Внтутренняя вакансия') }}</option>
              <option value="contacts"{{ $applyType == 'contacts' ? ' selected' : '' }}>{{ __('Показать контакты') }}</option>
              <option value="external"{{ $applyType == 'external' ? ' selected' : '' }}>{{ __('Внешняя ссылка') }}</option>
            </select>
          </div>
          <!--</editor-fold>-->
        </div>
        <div class="col-md-8">

          <!--<editor-fold desc="внешняя вакансия">-->
          <div class="form-group external_url{{ $errors->has('external_url') ? ' has-danger' : '' }}{{ $job->apply_type == 'external' ?: ' hidden' }}">
            <label class="form-control-label">{{ __('Ссылка на страницу вакансии') }}</label>
            <div class="form-control-feedback">{{ $errors->first('external_url') }}</div>
            <input type="url" class="form-control" value="{{ old('external_url', $job->external_url) }}" name="external_url" placeholder="http://" autocomplete="off">
          </div>
          <!--</editor-fold>-->

          <!--<editor-fold desc="Контактные данные">-->
          <div class="form-group contacts {{ $errors->has('contacts') ? ' has-danger' : '' }}{{ $job->apply_type == 'contacts' ?: ' hidden' }}">
            <label class="form-control-label">{{ __('Контактные данные') }}</label>
            <div class="form-control-feedback">{{ $errors->first('contacts') }}</div>
            <textarea name="contacts" class="form-control" placeholder="{{ __('Имя контактного лица, Телефон, Email, Skype') }}">{{ old('contacts', $job->contacts) }}</textarea>
          </div>
          <!--</editor-fold>-->

        </div>
      </div>


      <div class="row">
        <div class="col-sm-6">
          <!--<editor-fold desc="статус">-->
          <div class="form-group {{ $errors->has('status') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="job-status">{{ __('Статус') }}</label>
            <select name="status" class="form-control" id="job-status">
              <option value="">{{ __("Выберите статус") }}</option>
              @php $job_status = old('status', $job->status); @endphp
              @foreach (\App\Status::$all as $status)
                <option value='{{ $status }}' {{ $job_status == $status ? ' selected' : null }}>{{ status($status) }}</option>
              @endforeach
            </select>
            <div class="form-control-feedback">{{ $errors->first('status') }}</div>
          </div>
          <!--</editor-fold>-->
        </div>
      </div>

    </div>
  </div>

  <div class="top-buffer bottom-buffer">
    <button type="submit" class="btn btn-primary">{{ $job->exists ? __('Обновить вакансию') : __('Добавить вакансию') }}</button>
    <a href="{{ route('admin.jobs') }}" class="btn btn-secondary">{{ __('Отмена') }}</a>

    @if ($job->exists)
      <a class="small ml-3" href="{{ $job->url() }}" target="_blank">{{ __('Показать на сайте') }} <i class="fa fa-external-link"></i></a>
    @endif

  </div>

</form>