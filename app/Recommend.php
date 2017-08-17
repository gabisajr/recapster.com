<?php

namespace App;

use App\Model\EmploymentForm;
use App\Model\Job;
use App\Model\User;

class Recommend {

  /** @var  User */
  protected $user; // пользователь для которого строятся рекомендации

  /**
   * @param User|null $user
   */
  public function __construct($user) {
    $this->user = $user;
  }

  /**
   * @param int $limit
   * @return Model_Company[]
   * @throws Kohana_Exception
   */
  public function get_companies($limit = 6) {
    return ORM::factory('Company')
      ->where('active', '=', true)
      ->and_where('logo_id', 'IS NOT', null)
      ->and_where('rating', '<>', 0)
      ->and_where_open()
      ->or_where('reviews_count', '>', 0)
      ->or_where('salaries_count', '>', 0)
      ->or_where('interviews_count', '>', 0)
      ->or_where('jobs_count', '>', 0)
      ->or_where('internship_count', '>', 0)
      ->or_where('images_count', '>', 0)
      ->or_where('followers_count', '>', 0)
      ->and_where_close()
      ->limit($limit)
      ->order_by(DB::expr('RAND()'))
      ->find_all();
  }

  /**
   * @param int $limit
   * @param array $excludeIds
   * @return \Illuminate\Database\Eloquent\Collection|\App\Model\Job[]
   */
  public function jobs(int $limit = 10, array $excludeIds = []) {

    /** @var Job $query */
    $query = Job::query()
      ->distinct()
      ->approved();


    # убарть исключаемые id
    if (isset($excludeIds) && is_array($excludeIds) && count($excludeIds)) {
      $query->andWhereNotIn('jobs.id', $excludeIds);
    }

    # предпочтения пользователя
    $jobPreferences = $this->user ? $this->user->jobPreferences : null;

    # указана ли зарплата?
    $query->selectHasSalary();

    # посчитать общий комфорт вакансии
    $query->selectTotalComfort($jobPreferences);

    $query
      ->orderBy('total_comfort', 'DESC')
      ->orderBy('is_good_position', 'DESC')
      ->orderBy('is_good_city', 'DESC')
      ->orderBy('is_good_salary', 'DESC')
      ->orderBy('is_good_employment_form', 'DESC')
      ->orderBy('has_salary', 'DESC')
      ->latest()
      ->limit($limit);

    $jobs = $query->get();

    return $jobs;

  }

}