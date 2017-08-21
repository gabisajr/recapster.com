<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User_Fave extends Controller_Base {

  public function before() {
    parent::before();
    if (!Auth::instance()->logged_in()) HTTP::redirect('/signin');
  }

  public function action_jobs() {

    $search = new Search_Engine_Jobs($this->curr_user);
    $jobs = $search
      ->set_is_fave(true)
      ->set_sort('faves_jobs.date', 'DESC')
      ->find()
      ->get_results();

    $fave_count = $search->get_found_count();
    $jobs = new Search_Results_Jobs($jobs);

    $view = View::factory('fave/jobs', [
      'user'       => $this->curr_user,
      'fave_count' => $fave_count,
      'jobs'       => $jobs,
    ]);

    $this->template->content = $view;
    $this->template->title = __('Избранные вакансии');
    $this->main_js = '/js/user/fave.js';
  }

}