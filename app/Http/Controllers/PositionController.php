<?php

namespace App\Http\Controllers;

use App\Model\Position;
use Illuminate\Http\Request;

class PositionController extends Controller {

  //search position
  public function search(Request $request) { //todo make api endpoint
    $positions = Position::search($request->input('q'))->get();

    $items = [];
    /** @var Position $position */
    foreach ($positions as $position) {
      $items[] = [
        'id'   => $position->id,
        'text' => $position->title,
      ];
    }

    $data = [
      'items' => $items,
    ];

    return response()->json($data);
  }

}