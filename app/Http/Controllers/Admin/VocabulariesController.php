<?php

namespace App\Http\Controllers\Admin;

use View;

class VocabulariesController extends AdminController {

  public function __construct() {
    parent::__construct();
    View::share('sidebarActive', 'vocabulary');
  }

  public function list() {
    return view("admin.vocabulary.list", [
      'title' => __('Словари'),
    ]);
  }

}