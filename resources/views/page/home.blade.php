@php
  /**
   * @var string $jobs
   * @var int    $total_jobs_count
   * @var string $app_name
   * @var View   $form
   */
@endphp

@extends('layout')

@section('content')
  <div class="container no-pad-xs v-100">
    <div class="row no-marg-xs v-100">
      <div class="col-lg-9 no-pad-xs v-100">
        <section class="panel v-100">
          <div class="panel-body v-100">
            <div class="max-700">
              <?/*=$form*/?>
              <em class="small text-muted found-count">{{ __('Топ свежих вакансий') }}</em>


              <div class="search-results post-list row">
                @foreach($jobs as $job)
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 post-list-col">
                    @include('post.job')
                  </div>
                @endforeach
              </div>


            </div>
          </div>
        </section>
      </div>
      <div class="col-lg-3 visible-lg aside-socials">
        <?/*
        <?=View::factory('banner/weekly-contest')?>
        <?=View::factory('share/list', [
          'header'        => __('Нравится :app_name?', [':app_name' => $app_name]),
          'share_intents' => ['vk', 'facebook', 'twitter'],
          'title'         => __(':app_name - молодежный job-портал', [':app_name' => $app_name]),
        ])
        */?>

        @include('social-widget.facebook-page')
        @include('social-widget.vk-group')
        <?/*
        <?=View::factory('social-widget/instagram')?>
        <section class="panel panel-body">
          <a class="twitter-follow-button" href="https://twitter.com/recapster" data-size="large">Читать @Recapster</a>
        </section>
        */?>

      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('/dist/js/home.bundle.js') }}"></script>
@endsection