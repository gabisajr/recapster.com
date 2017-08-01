<?php

namespace App\Providers;

use App\Model\Image;
use App\Observers\ImageObserver;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider {
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot() {
    //observers
    Image::observe(ImageObserver::class);

    //custom validation functions
    $this->defineGreaterThanValidationRule();

    //set default pagination view
    LengthAwarePaginator::defaultView('pagination.bootstrap-4');
  }

  private function defineGreaterThanValidationRule() {
    Validator::extend('greater_than', function ($attribute, $value, $parameters, $validator) {
      $min_field = $parameters[0];
      $data = $validator->getData();
      $min_value = $data[$min_field];
      return $value > $min_value;
    });

    Validator::replacer('greater_than', function ($message, $attribute, $rule, $parameters) {
      return str_replace(':field', $parameters[0], $message);
    });
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
