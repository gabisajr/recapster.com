<?
/**
 * @var \App\Model\User $user
 * @var string          $activeTab
 */
?>
<nav class="profile-tabs profile-tabs-user">
  <div class="profile-tabs-inner">
    <a class="profile-tabs-item profile{{ $activeTab == 'profile' ? ' active' : '' }}" href="{{ $user->url() }}">
      <div class="label">{{ __('Профиль') }}</div>
    </a>
    <a class="profile-tabs-item activity{{ $activeTab == 'activity' ? ' active' : '' }}" href="<?=$user->url('activity')?>">
      <div class="label">{{ __('Активность') }}</div>
    </a>
  </div>
</nav>