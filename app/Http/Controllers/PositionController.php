<?php

namespace App\Http\Controllers;

use App\Model\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PositionController extends Controller {

  //search position
  public function search(Request $request) { //todo make api endpoint

    /** @var Collection $positions */
    $positions = Position::query()
      ->select('id', 'title')
      ->search($request->input('q'))
      ->get();

    return response()->json($positions);
  }

}