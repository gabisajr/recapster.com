@php
/**
 * @var \App\Model\Company $company - Компания к которой хотим добавить руководителя
 */
@endphp
<div class="modal fade" id="add-ceo-modal">
  <div class="modal-dialog" style="width:400px;">
    {{--todo route--}}
    <form class="modal-content" method="post" action="{{ "/admin/company/attachCeo" }}" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">{{ __('Добавить руководителя для') }}  «{{ $company->title }}»</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="company" value="{{ $company->id }}">
        <input type="hidden" name="ceo">
        <div class="form-group">
          <input class="form-control input-sm" name="firstname" placeholder="{{ __('Имя') }}" autocomplete="off">
        </div>
        <div class="form-group">
          <input class="form-control input-sm" name="lastname" placeholder="{{ __('Фамилия') }}" autocomplete="off">
        </div>
        <div class="form-group">
          <label>{{ __('Автарка') }}</label>
          <input type="file" name="avatar">
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Отмена') }}</button>
        <button type="submit" class="btn btn-primary">{{ __('Добавить') }}</button>
      </div>

    </form>
  </div>
</div>