<?php

namespace App;

use Intervention\Image\ImageManager as InterventionImageManager;

class ImageManager {

  /** @var InterventionImageManager */
  private static $manager;

  private function __construct() {
  }

  public static function instance() {
    if (!self::$manager) {
      self::$manager = new InterventionImageManager([
        'driver' => config('image.driver'),
      ]);
    }
    return self::$manager;
  }

}