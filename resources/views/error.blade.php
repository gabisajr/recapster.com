@extends('layout')

@section('title', $title)

@section('style')
  <style>
    #page-content {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
  </style>
@endsection

@section('content')
  <div class="error pt-5 pb-5">
    <div class="container">
      <h1 class="text-center m-0">{{ $title }}</h1>
    </div>
  </div>
@endsection