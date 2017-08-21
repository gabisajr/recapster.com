<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Model\Job;
use App\Search\Form\SearchFormJobs as SearchJobsForm;
use Illuminate\Http\Request;

class JobsController extends Controller {

  public function index(Request $request) {

    //извлекаем параметры поиска
    $q = $request->input('q');
    $job_type = $request->input('job_type');
    $city_id = $request->input('city');
    $employment = $request->input('employment');
    $industry_id = $request->input('industry');
    $sort = $request->input('sort');
    $skip = $request->input('skip');

    if (!$sort) $sort = 'added';

    \DB::enableQueryLog();

    //выполняем поиск
    $query = Job::query()
      ->approved()
      ->ofActiveCompanies();

    //общее количество вакансий
    $total = $query->count();

    //срез
    $jobs = $query
      ->limit(20)
      ->offset($skip)
      ->get();

    //dd(\DB::getQueryLog());

    $found_count = $jobs->count();
    $found = found_jobs($found_count);
    $hasMore = ($skip + count($jobs)) < $total;

    //$search = new Search_Engine_Jobs($this->curr_user);
    //$jobs = $search
    //  ->set_q($q)
    //  ->set_job_type($job_type)
    //  ->set_city_id($city_id)
    //  ->set_employment($employment)
    //  ->set_industry_id($industry_id)
    //  ->set_sort($sort)
    //  ->set_limit(20)
    //  ->set_skip($skip)
    //  ->find()
    //  ->get_results();


    //$results = new Search_Results_Jobs($jobs, $skip);
    //$has_more = $search->has_more();
    //
    //if ($this->request->is_ajax() && ($this->request->method() == Request::POST)) {
    //
    //  return $this->response
    //    ->headers('Content-Type', 'application/json; charset=utf-8')
    //    ->body(json_encode([
    //      'found'       => $found,
    //      'found_count' => $found_count,
    //      'results'     => $results->get_results(),
    //      'has_more'    => $has_more,
    //    ]));
    //}

    $form = new SearchJobsForm([
      'q'           => $q,
      'job_type'    => $job_type,
      'city_id'     => $city_id,
      'employment'  => $employment,
      'industry_id' => $industry_id,
      'sort'        => $sort,
    ]);

    return view('search.jobs', [
      'title'        => __('Поиск вакансий'),
      'foundCount'   => 0,
      'foundCaption' => $found,
      'hasMore'      => $hasMore,
      'jobs'         => $jobs,
      'form'         => $form,
    ]);

    //$this->main_js = '/js/search/jobs.js'; //todo add js
    //$this->styles[] = CSS::AWESOME_BOOTSTRAP_CHECKBOX;

  }

}