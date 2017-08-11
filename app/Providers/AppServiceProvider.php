<?php

namespace App\Providers;

use App\Model\Image;
use App\Observers\ImageObserver;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use GuzzleHttp\Client as GuzzleHttpClient;

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
    $this->defineRecaptchaValidationRule();

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

  private function defineRecaptchaValidationRule() {
    Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
      $client = new GuzzleHttpClient();
      $url = config('google-recaptcha.verify_url');
      $secret = config('google-recaptcha.secret');
      $response = $client->request('POST', $url, [
        'form_params' => [
          'secret'   => $secret,
          'response' => $value,
          'remoteip' => get_client_ip(),
        ],
      ]);


      if ($response->getStatusCode() == 200) { //OK
        $obj = json_decode((string)$response->getBody());
        return $obj->success;
      }

      return false;
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
