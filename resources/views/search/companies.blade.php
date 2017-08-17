@extends('search.layout')

@section('search-content')
  <h4 class="no-marg hidden">{{ $title }}</h4>

  {!! $form !!}

  <em class="small text-muted found-count" style="{{ !$foundCount ? 'display:none' :'' }}">{{ $foundCaption }}</em>

  <div class="search-results post-list row">
    @foreach($companies as $company)
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 post-list-col">
        @include('post.company')
      </div>
    @endforeach
  </div>

@endsection