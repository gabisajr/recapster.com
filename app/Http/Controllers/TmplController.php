<?php

namespace App\Http\Controllers;

class TmplController extends Controller {

  public function template(string $filepath) {

    if (!view()->exists($filepath)) {
      abort(404, 'template not found');
    }

    return response(view($filepath))->header('Content-Type', 'text/plain');
  }

}