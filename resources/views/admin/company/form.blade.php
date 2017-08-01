@php
  /** @var \App\Model\Company $company */
@endphp
<form role="form" method="post" id="company-form" enctype="multipart/form-data" class="bottom-buffer" action="{{ route('admin.company.store') }}">

  {{ csrf_field() }}

  <input type="hidden" name="id" value="{{ $company->id }}">

  <div class="row">

    <div class="col-lg-7">

      <div class="row align-items-end">
        <div class="col-lg-7">
          @include('admin.company.form.title')
        </div>
        <div class="col col-auto">
          @include('admin.company.form.active')
        </div>
        <div class="col col-auto">
          @include('admin.company.form.confirmed')
        </div>
      </div>
      @include('admin.company.form.short_desc')
      @include('admin.company.form.alias')

      <div class="row">
        <div class="col-lg-4">
          @include('admin.company.form.site')
        </div>
        <div class="col-lg-4">
          @include('admin.company.form.size')
        </div>
        <div class="col-lg-4">
          @include('admin.company.form.foundation-year')
        </div>
      </div>

      <div class="row">
        <div class="col-lg-4">
          @include('admin.company.form.revenue')
        </div>
        <div class="col-lg-8">
          @include('admin.company.form.head-office')
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          @include('admin.company.form.industries')
        </div>
      </div>

      @include('admin.company.form.ceo')

    </div>

    <div class="col-lg-5">
      @include('admin.company.form.logo')
      @include('admin.company.form.cover')
    </div>

  </div>

  <div class="row">
    <div class="col-lg-12">
      @include('admin.company.form.description')
    </div>
  </div>

  <button type="submit" class="btn btn-primary">{{ $company->exists ? __('Обновить компанию') : __('Добавить компанию') }}</button>
  <a class="btn btn-secondary" href="{{ route('admin.companies') }}">{{ __('Отмена') }}</a>

</form>

@include('admin.modal.add-ceo')