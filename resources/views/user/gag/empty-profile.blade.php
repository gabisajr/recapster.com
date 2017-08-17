@php
  /**
   * @var \App\Model\User $user
   */
@endphp
<div class="gag not-found">
  <img src="{{ asset('/images/notebook.png') }}" class="gag-img">
  <div class="gag-text">
    <strong>{{ __('Профиль пока не заполнен') }}</strong><br>
    @php $him = $user->sex == \App\Sex::MALE ? __('нем') : ($user->sex == \App\Sex::FEMALE ? __('ней') : __('нем(ней)')); @endphp
    {{ __('messages.suggest_complete_profile', ['firstname' => $user->to_firstname, 'him' => $him]) }}
  </div>
  <button class="btn btn-primary btn-profile-offer" data-id="{{ $user->id }}">{{ __('Предложить заполнить профиль') }}</button>
</div>