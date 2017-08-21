@php
  /**
   * @var \App\Model\Company $company
   * @var Model_User         $curr_user
   * @var View               $info
   * @var array              $buttons
   */

  $rating = view('partials.mark-widget', ['rating' => $company->rating, 'show_number' => true])->render();
  $btnHtml = view('company.aside-buttons', ['company' => $company])->render();

@endphp
<div class="panel">
  <div class="panel-body">
    <aside class="profile-aside company-aside">

      <div class="badge">
        @php $bg = $company->cover ? $company->cover->path : null @endphp
        <div class="badge-bg{{ $bg ? ' has-bg' : '' }}" style="{{ $bg ? "background-image: url($bg)" : '' }}"></div>
        <div class="logo-wrapper">
          <img src="{{ logo_big($company, 640) }}" class="logo" alt="{{ $company->title }}">
        </div>
        <div class="badge-right hidden-xs-up">{!! $rating !!}</div>
      </div>

      <div class="hidden-xs">{!! $btnHtml !!}</div>

      <h1 class="clear profile-aside-title">
        <a class="hover_opacity" href="{{ $company->url() }}">{!! insert_br($company->title) !!}</a>
        {!! icon_confirmed_company($company) !!}
      </h1>

      <div>
        @if($company->short_desc)
          {{ $company->short_desc }}
        @else
          {{ $company->created_at->diffForHumans() . " на " . config('app.name') }}
        @endif
      </div>

      {{--todo remove duplication rating, use css grid--}}
      <div class="hidden-xs marg-top-sm marg-bot">{!! $rating !!}</div>

      {{--todo remove duplication buttons, use css grid--}}
      <div class="hidden-xs-up marg-top">{!! $btnHtml !!}</div>

    </aside>
  </div>
</div>