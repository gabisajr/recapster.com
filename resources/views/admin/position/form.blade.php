<form role="form" method="post" id="position-form" enctype="multipart/form-data" action="{{ route('admin.position.store') }}">
  {{ csrf_field() }}
  <input type="hidden" name="id" value="{{ $position->id }}">

  <div class="row">
    <div class="col col-lg-6">
      <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="position-title">{{ __('Наименование должности') }}</label>
        @php $title = old('title', $position->exists ? $position->title : array_get($_GET, 'title')); @endphp
        <input class="form-control" name="title" id="position-title" value="{{ $title }}" autocomplete="off">
        <div class="form-control-feedback">{{ $errors->first('title') }}</div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <div class="form-group{{ $errors->has('alias') ? ' has-danger' : '' }}">
        <div class="row">
          <div class="col col-auto">
            <label class="form-control-label">{{ __('Альяс') }}</label>
          </div>
          <div class="col">
            <div class="form-control-feedback mt-0">{{ $errors->first('alias') }}</div>
          </div>
        </div>
        <div class="input-group">
          <span class="input-group-addon" id="alias-addon"><samp>{{ config('app.url') }}/salary/</samp></span>
          <input pattern="{{ \App\Regex::INPUT_PATTERN_SLUG }}" aria-describedby="alias-addon" class="form-control"
                 name="alias" placeholder="{{ __('Маленькие символы латинского алфавита и -') }}" value="{{ old('alias', $position->alias) }}"
                 autocomplete="off">
        </div>
        <p class="help-block">
          {{ __('Пример зарплата дизайнера') }}:
          <code>{{ config('app.url') }}/salary/designer</code><br>
          Или например зарплата разработчика в компании Apple
          <code>{{ config('app.url') }}/apple/salary/developer</code><br>
          Или например зарплата официантов в Караганда
          <code>{{ config('app.url') }}/karaganda/salary/waiter</code><br>
        </p>
      </div>
    </div>
  </div>

  <input type="submit" class="btn btn-primary" value="{{ $position->exists ? __('Обновить') : __('Добавить') }}">

</form>