@php
  /**
   * @var \App\Model\Subscription[] $subscriptions
   */
@endphp
@if ($subscriptionsCount = count($subscriptions))
  <section class="user-profile-block user-subscriptions hidden-xs hidden-print" id="following">
    <h3 class="user-profile-block-title">{{ __('Подписки пользователя') }}</h3>


    @php $maxVisible = 6; @endphp
    <div class="post-list row auto-clear">
      @foreach ($subscriptions as $i => $subscription)
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 post-list-col{{ $i >= $maxVisible ? ' hidden' : '' }}">
          @if ($subscription->object_type == 'company')
            {{--todo use blade--}}
            {{--echo (new Post_Company($subscription->company, ['show_industries' => false]))->render();--}}
          @else
            {{--todo use blade--}}
            {{--echo (new Post_User($subscription->to_user))->render();--}}
          @endif
        </div>
      @endforeach
    </div>

    @if (($hidden_count = $subscriptionsCount - $maxVisible) > 0)
      <small class="more blue-gray">{{ __('messages.show_all', [':count' => $subscriptionsCount]) }}</small>
    @endif
  </section>
@elseif ($user->isMe())
  @include('user.gag.subscriptions')
@endif