@if ($company->exists)
  <div class="row">
    <div class="col-lg-5">
      <div class="form-group">
        <label class="form-control-label mr-2">{{ __('CEO') }}</label>
        @if (!$company->ceo)
          <button class="btn btn-sm btn-primary" name="add-ceo" type="button">{{ __('Добавить') }}</button>
        @endif
      </div>
      @if ($company->ceo)
        <div class="panel panel-default ceo-panel">
          <div class="panel-body">
            <div class="media">
              <div class="media-left media-middle">
                @php $src = $company->ceo->avatar->exists ? $company->ceo->avatar->resize(30, 30)->path : '/images/empty-ceo.png' @endphp
                <img width="30" height="30" class="media-object" src="{{ $src }}" alt="{{ $company->ceo->firstname . ' ' . $company->ceo->lastname }}">
              </div>
              <div class="media-body media-middle">
                @php $url = "/admin/ceo/item/" . $company->ceo->id; //todo route @endphp
                <a href="{{ $url }}" class="media-heading">{{ $company->ceo->firstname . ' ' . $company->ceo->lastname }}</a>
              </div>
            </div>
          </div>
          <button name="remove-ceo" class="btn-remove" type="button" title="{{ __('Удалить') }}">×</button>
        </div>
      @endif
    </div>
  </div>
@endif