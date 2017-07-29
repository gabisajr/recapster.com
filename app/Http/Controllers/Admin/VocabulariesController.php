<?php

namespace App\Http\Controllers\Admin;

class VocabulariesController extends AdminController {

  public function action_list() {
    return view("admin/vocabulary/list", [
      'title' => __('Словари'),
    ]);
  }

}