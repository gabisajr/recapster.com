<?php

namespace App\Search\Form;

use App\Model\Country;
use App\Model\Industry;
use App\Search\Form\Filter\FilterCity;
use App\Search\Form\Filter\FilterEmploymentForm;
use App\Search\Form\Filter\FilterIndustry;
use App\Search\Form\Filter\FilterJobType;
use App\Search\Form\Filter\FilterSort;
use App\Status;
use Auth;
use DB;
use Illuminate\Support\Collection;

class SearchFormJobs extends SearchForm {

  protected $type = 'jobs';

  protected function getFilters() {

    $filters = new Collection([
      new FilterSort($this),
      new FilterCity($this),
      new FilterJobType($this),
      new FilterEmploymentForm($this),
      new FilterIndustry($this),
    ]);

    return $filters;
  }

  public function getSorts() {
    $sorts = [
      [
        'title' => __('По дате'),
        'id'    => 'added',
      ],
      [
        'title' => __('По рейтингу'),
        'id'    => 'rating',
      ],
    ];

    return json_decode(json_encode($sorts));
  }

  //города в которых есть вакансии
  public function getCities() {

    $country = $this->getUserCountry();

    $cities = $country->cities()
      ->rightJoin('jobs_cities', 'jobs_cities.city_id', '=', 'cities.id')
      ->leftJoin('jobs', function ($join) {
        $join->on('jobs_cities.job_id', '=', 'jobs.id')
          ->where('jobs.status', '=', Status::APPROVED);
      })
      ->select('cities.*', DB::raw("COUNT(jobs_cities.job_id) as count"))//todo use loader function for count jobs in city
      ->groupBy('cities.id')
      ->orderBy('count', 'DESC')
      ->orderBy('cities.title')
      ->get();

    $anyCity = json_decode(json_encode([
      'title' => __('Любой город'),
      'id'    => null,
      'count' => null,
    ]));

    $cities->prepend($anyCity);

    return $cities;
  }

  //виды деятельности в которых есть вакансии
  public function getIndustries() {

    $industries = Industry::query()
      ->approved()
      ->leftJoin('company_industries', function ($join) {
        $join->on('industries.id', '=', 'company_industries.industry_id');
      })
      ->leftJoin('companies', function ($join) {
        $join->on('company_industries.company_id', '=', 'companies.id')
          ->where('companies.active', '=', true);
      })
      ->leftJoin('jobs', function ($join) {
        $join->on('companies.id', '=', 'jobs.company_id')
          ->where('jobs.status', '=', Status::APPROVED);
      })
      ->select('industries.*', DB::raw("COUNT(jobs.id) as count"))
      ->groupBy('industries.id')
      ->orderBy('count', 'DESC')
      ->orderBy('industries.title')
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