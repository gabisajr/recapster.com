<?php

namespace App\Providers;

use App\Model\Image;
use App\Observers\ImageObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot() {
    Image::observe(ImageObserver::class);
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register() {
    //
  }
}
