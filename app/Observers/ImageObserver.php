<?php

/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 16.03.2017
 * Time: 18:21
 */

namespace App\Observers;

use App\Model\Image;
use Illuminate\Support\Facades\File;

class ImageObserver {

  public function deleting(Image $image) {

    foreach ($image->childs()->get() as $child) {
      $child->delete();
    }

    File::delete($image->realPath());
  }

}