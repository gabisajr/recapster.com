@extends('search.layout')

@section('title'){{ $title }}@endsection

@section('search-content')
  <h4 class="no-marg hidden">{{ $title }}</h4>

  {!! $form !!}

  <em class="small text-muted found-count" style="{{ !$foundCount ? 'display:none' :'' }}">{{ $foundCaption }}</em>

  <div class="search-results post-list row">
    @foreach($jobs as $job)
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 post-list-col">
        @include('post.job')
      </div>
    @endforeach
  </div>

@endsection