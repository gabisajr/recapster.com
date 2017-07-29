<?php

namespace App\Http\Controllers\Admin;

class VocabulariesController extends AdminController {

  public function list() {
    return view("admin/vocabulary/list", [
      'title' => __('Словари'),
    ]);
  }

}