@php
  /**
   * @var \App\Model\User $user
   */

   /** @var \App\Model\User $currUser */
  $currUser = Auth::getUser();

  $buttons = [];

  if ($user->isMe()) {
    $text = __('Панель управления');
    $buttons[] = "<a class='btn btn-info btn-block' href='/edit'>{$text}</a>";
  } else {
    $subscribed = $currUser && $currUser->is_user_subscribed($user);
    $class = $subscribed ? ' btn-success' : null;
    $btn_text = $subscribed ? __('Вы подписаны') : __('Подписаться');
    $buttons[] = " <button class='btn btn-block btn-subscribe btn-subscribe-user {$class}' data-id='{$user->id}'>{$btn_text}</button>";
  }

  if (false) { //todo chat
    $text = __('Написать сообщение');
    $buttons[] = " <button class='btn btn-success btn-block'>{$text}</button>";
  }

  $btnHtml = null;
  if (count($buttons)) {
    $btnHtml .= "<div class='buttons_wrapper clear'>";
    $btnHtml .= join('', $buttons);
    $btnHtml .= "</div>";
  }


  //базовая информация
  if ($positionTitle = ($user->position ? $user->position->title : $user->position_title)) {
    $positionTitle = "<span class='position'><a href='#'>{$positionTitle}</a></span>";
  }

  $pieces = [];
  if ($user->city) {
    $pieces[] = "<a href='#'>" . $user->city->titleRegardToMe() . "</a>";
  } elseif ($user->country) {
    $pieces[] = "<a href='#'>" . $user->country->title . "</a>";
  }

  if ($age = $user->age()) $pieces[] = "<span class='nowrap'>" . age($age) . "</span>";

  $baseInfo = "";
  if ($positionTitle) $baseInfo .= $positionTitle . '<br>';
  $baseInfo .= implode(', ', $pieces);

@endphp
<div class="panel">
  <div class="panel-body">
    <aside class="profile-aside user-aside">

      <div class="badge">
        <div class="badge-left">
          <div class="avatar-wrapper">
            <img src="{{ avatar($user, 640) }}" class="avatar" alt="{{ $user->fullname() }}">
          </div>
        </div>
        <div class="badge-right">

          <div class="hidden-xs hidden-print">{!! $btnHtml !!}</div>

          <h1 class="profile-aside-title">
            <a class="hover_opacity" href="{{ $user->url() }}">{{ $user->fullname() }}</a>
          </h1>

          <p class="blue-gray base-info">{!! $baseInfo !!}</p>

          {{--статус готовности к работе--}}
          @if (in_array($user->job_status, [\App\UserJobStatus::READY, \App\UserJobStatus::SEARCH]))
            <div class='status'>{{ $user->jobStatusTitle() }}</div>
          @endif
          {{--/статус готовности к работе--}}

        </div>
      </div>

      <div class="hidden-xs-up marg-top clear hidden-print">{!! $btnHtml !!}</div>

    </aside>
  </div>
</div>