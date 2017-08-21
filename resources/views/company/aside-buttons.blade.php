<div class="buttons_wrapper clear">

  {{--subscribe button --}}
  @php
    /** @var \App\Model\User $currUser */
    $currUser = Auth::getUser();
    $subscribed = $currUser && $currUser->subscribedOn($company);

    $cssClass = 'btn btn-block btn-subscribe btn-subscribe-company';
    if ($subscribed) $cssClass .= ' btn-success';

    $attributes = html_attributes(['class' => $cssClass, 'data-id' => $company->id]);
    $btnText = $subscribed ? __('Вы подписаны') : __('Подписаться');
  @endphp
  <button{!! $attributes !!}>{{ $btnText }}</button>

</div>