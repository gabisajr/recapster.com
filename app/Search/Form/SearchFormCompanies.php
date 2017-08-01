<?php

namespace App\Search\Form;

use App\Model\City;
use App\Model\Industry;
use App\Search\Form\Filter\FilterCity;
use App\Search\Form\Filter\FilterIndustry;
use App\Search\Form\Filter\FilterSort;
use DB;

class SearchFormCompanies extends SearchForm {

  protected $type = 'companies';

  protected function getFilters() {

    $filters = [];

    $filters[] = new FilterSort($this);
    $filters[] = new FilterCity($this);
    $filters[] = new FilterIndustry($this);

    return $filters;
  }

  public function getSorts() {
    $sorts = [
      [
        'title' => __('По рейтингу'),
        'id'    => 'rating',
      ],
      [
        'title' => __('По популярности'),
        'id'    => 'popular',
      ],
    ];

    return json_decode(json_encode($sorts));
  }

  public function getCities() {

    $country = $this->getUserCountry();

    $cities = $country->cities()
      ->hasActiveCompanies()
      ->withActiveCompaniesCount()
      ->groupBy('cities.id')
      ->orderBy('cities.title')
      ->get()
      ->sortByDesc('active_companies_count');

    $cities->map(function (City $item) {
      $item->setAttribute('count', $item->getAttribute('active_companies_count'));
      return $item;
    });

    $anyCity = json_decode(json_encode([
      'title' => __('Любой город'),
      'id'    => null,
      'count' => null,
    ]));

    $cities->prepend($anyCity);

    return $cities;
  }

  public function getIndustries() {
    $industries = Industry::query()
      ->approved()
      ->rightJoin('company_industries', 'company_industries.industry_id', '=', 'industries.id')
      ->leftJoin('companies', function ($join) {
        $join->on('company_industries.company_id', '=', 'companies.id')
          ->where('companies.active', '=', true);
      })
      ->select('industries.*', DB::raw("COUNT(DISTINCT companies.id) as count"))
      ->groupBy('industries.id')
      ->orderBy('count', 'desc')
      ->orderBy('title')
      ->get();

    $anyIndustry = json_decode(json_encode([
      'title' => __('Любое направление'),
      'id'    => null,
      'count' => null,
    ]));

    $industries->prepend($anyIndustry);

    return $industries;
  }

}