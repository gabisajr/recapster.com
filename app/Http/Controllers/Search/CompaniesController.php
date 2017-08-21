<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Model\Company;
use App\Search\Form\SearchFormCompanies;
use Illuminate\Http\Request;

class CompaniesController extends Controller {


  function index(Request $request) {

    //извлекаем параметры поиска
    $q = $request->input('q');
    $city_id = $request->input('city');
    $industry_id = $request->input('industry');
    $sort = $request->input('sort', 'rating');
    $skip = $request->input('skip');


    //выполняем поиск
    $query = Company::query();

    //общее количество компании
    $total = $query->count();

    //срез
    $companies = $query
      ->limit(24)
      ->offset($skip)
      ->get();

    $found_count = $companies->count();
    $found = found_companies($found_count);
    //$results = new Search_Results_Companies($companies, $skip, 'auto-clear');
    $hasMore = ($skip + count($companies)) < $total;

    //$search = new SearchCompanies(Auth::getUser());
    //
    ////todo scopes
    //$companies = $search
    //  ->setQ($q)
    //  ->setCityId($city_id)
    //  ->industryId($industry_id)
    //  ->setSort($sort)
    //  ->limit(24)
    //  ->skip($skip)
    //  ->find()
    //  ->get();


    //if ($request->is_ajax() && ($request->method() == Request::POST)) {
    //
    //  $this->response
    //    ->headers('Content-Type', 'application/json; charset=utf-8')
    //    ->body(json_encode([
    //      'found'       => $found,
    //      'found_count' => $found_count,
    //      'results'     => $results->get_results(),
    //      'has_more'    => $has_more,
    //    ]));
    //
    //} else {
    //

    //
    //
    //  $page = new Search_Page_Companies([
    //    'title'       => __('Поиск компаний'),
    //    'form'        => $form,

    //    'found_count' => $found_count,
    //    'results'     => $results->__toString(),

    //  ]);
    //
    //  $this->template->content = $page;
    //  $this->main_js = '/js/search/companies.js';
    //  $this->styles[] = CSS::AWESOME_BOOTSTRAP_CHECKBOX;
    //
    //}

    $form = new SearchFormCompanies([
      'q'           => $q,
      'sort'        => $sort,
      'city_id'     => $city_id,
      'industry_id' => $industry_id,
    ]);

    return view('search.companies', [
      'title'        => __('Поиск компаний'),
      'foundCount'   => 0,
      'foundCaption' => $found,
      'hasMore'      => $hasMore,
      'companies'    => $companies,
      'form'         => $form,
    ]);

  }

  function search(Request $request) { //todo make api endpoint
    $companies = Company::search($request->input('q'))->get();

    $items = [];
    /** @var Company $company */
    foreach ($companies as $company) {
      $items[] = [
        'id'   => $company->id,
        'text' => $company->title,
      ];
    }

    $data = [
      'items' => $items,
    ];

    return response()->json($data);
  }

}