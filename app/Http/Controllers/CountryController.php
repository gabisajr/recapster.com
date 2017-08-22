<?php

namespace App\Http\Controllers;

use App\Model\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CountryController extends Controller {

  // get cities from country
  public function cities(Request $request) {

    $cities = new Collection([]);

    /** @var Country $country */
    $country = Country::find($request->input('country'));
    if ($country) {

      $cities = $country->cities()
        ->select('id', 'title')
        ->orderBy('cities.title')
        ->get();

      ////только с университетами
      //if ($request->input('hasUniversity')) {
      //  //todo create scope
      //  $query->join('university', 'LEFT')->on('university.city_id', '=', 'cities.id')
      //    ->select([DB::expr('COUNT(DISTINCT university.id)'), 'universities_count'])
      //    ->group_by('cities.id')
      //    ->having('universities_count', '>', 0)
      //    ->order_by('universities_count', 'DESC');
      //}
      //
      //$cities = $query->execute()->as_array();
    }

    return $cities->toJson();
  }

}