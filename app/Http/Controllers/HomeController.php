<?php

namespace App\Http\Controllers;

use App\Model\Job;
use App\Search\SearchJobs as SearchEngineJobs;
use Auth;

class HomeController extends Controller {

  protected $itemPerPage = 10;

  public function index() {

    return view('page.home', [
      'title' => __('Recapster &ndash; молодежный job-портал'),
      'jobs'  => $this->getJobs(),
      //'form' => new Search_Form(),
    ]);

    //$this->template->content = $view;
    //$this->main_js = '/js/home.js'; //todo add js
    //$this->styles[] = CSS::AWESOME_BOOTSTRAP_CHECKBOX;

  }

  private function getJobs() {

    $user = Auth::getUser();

    $jobs = Job::all();

    return $jobs;

    //$jobs = (new SearchEngineJobs($user))
    //  ->set_limit($this->itemPerPage)
    //  ->set_sort('added')
    //  ->find()
    //  ->get_results();

    //return new Search_Results_Jobs($jobs);

  }

}
