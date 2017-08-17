<?php

namespace App;

use App\Model\Company;
use App\Model\Job;
use App\Model\User;
use DB;

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
   * возвращает рекомендуемые компании для пользователя
   * @param int $limit
   * @param array $exceptIds
   * @return Company[]|\Illuminate\Database\Eloquent\Collection
   */
  public function companies(int $limit = 10, array $exceptIds = []) {

    /** @var Company $query */
    $query = Company::query();

    # убарть исключаемые id
    if (isset($exceptIds) && is_array($exceptIds) && count($exceptIds)) {
      $query->andWhereNotIn('companies.id', $exceptIds);
    }

    //todo algorithm: recommend companies by city, country, industries etc

    $companies = $query
      ->active()
      ->where('logo_id', 'IS NOT', null)
      ->where('rating', '<>', 0)
      ->where(function ($query) {

        $query
          ->whereHas('reviews', function ($query) { $query->approved(); })
          ->orWhereHas('salaries', function ($query) { $query->approved(); })
          ->orWhereHas('interviews', function ($query) { $query->approved(); })
          ->orWhereHas('jobs', function ($query) { $query->approved(); })
          ->orWhereHas('images', function ($query) { $query->approved(); })
          //  ->orWhere('followers_count', '>', 0) //todo
        ;

      })
      ->limit($limit)
      ->orderBy(DB::raw('RAND()'))
      ->get();

    return $companies;
  }

  /**
   * возвращает рекомендуемые вакансии для пользователя
   * @param int $limit
   * @param array $exceptIds
   * @return \Illuminate\Database\Eloquent\Collection|\App\Model\Job[]
   */
  public function jobs(int $limit = 10, array $exceptIds = []) {

    /** @var Job $query */
    $query = Job::query()
      ->distinct()
      ->approved();


    # убарть исключаемые id
    if (isset($exceptIds) && is_array($exceptIds) && count($exceptIds)) {
      $query->andWhereNotIn('jobs.id', $exceptIds);
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