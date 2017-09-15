@php
  /**
   * @var \App\Model\User $user
   */
@endphp
<div class="user-badge">
  <div class="user-badge-left">
    <a href="{{ $user->url() }}"><img src="{{ avatar($user) }}" class="user-badge-avatar"></a>
  </div>
  <div class="user-badge-right">
    <h1 class="user-badge-title"><a href="{{ $user->url() }}">{{ $user->fullname() }}</a></h1>
    <div class="user-badge-text blue-gray">
      @if ($positionTitle = $user->positionTitle())
        {{ $positionTitle }}<br>
      @endif

      @php
        $pieces = [];
        if ($age = $user->age()) $pieces[] = age($age);
        if ($user->city) $pieces[] = $user->city->title;
        echo implode(', ', $pieces);
      @endphp
    </div>
  </div>
</div>