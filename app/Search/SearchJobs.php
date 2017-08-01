<?php

namespace App\Search;

use DB;

class SearchJobs extends Search {

  /** @var string */
  protected $_job_type;

  /** @var string - форма занятости */
  protected $_employment_alias;

  public function find() {

    $sub_query = DB::select('jobs.*')
      ->distinct(true)
      ->from('jobs')
      ->where('jobs.status', '=', Status::APPROVED);

    //определяем поле сортировки уровня зарплаты
    $sub_query->select([DB::raw('IF(jobs.salary_max, jobs.salary_max, jobs.salary_min)'), 'salary_order']);

    //подключаем теги и собираем их в строку
    $sub_query->join('jobs_tags', 'LEFT')->on('jobs.id', '=', 'jobs_tags.job_id')
      ->join('tags', 'LEFT')->on('jobs_tags.tag_id', '=', 'tags.id')
      ->group_by('jobs.id')
      ->select([DB::expr('GROUP_CONCAT(DISTINCT tags.title)'), 'all_tags']);

    //основной запрос использует подзапрос
    $query = DB::select('jobs.*', 'all_tags', 'is_fave')
      ->from('jobs')
      ->join([$sub_query, 'jobs_tmp'], 'INNER')
      ->on('jobs.id', '=', 'jobs_tmp.id');

    //подкючаем компании
    $query->join('company', 'LEFT')->on('jobs.company_id', '=', 'company.id');

    //является ли избранной
    if ($this->_curr_user) {
      $sub_query->select([DB::expr("(SELECT COUNT(*) FROM faves_jobs fj WHERE fj.job_id = jobs.id AND fj.user_id = :curr_user)"), 'is_fave'])->param(':curr_user', $this->_curr_user->id);
    } else {
      $sub_query->select([DB::expr("FALSE"), 'is_fave']);
    }

    //фильтр по избранному
    if (!is_null($this->_is_fave)) {
      if ($this->_is_fave) {
        $query->where('is_fave', '=', true);
      }
    }

    //фильтр по типу работы: вакансии или стажировки
    if ($this->_job_type == 'job') {

      $sub_query
        ->and_where_open()
        ->or_where('jobs.is_internship', '=', false)
        ->or_where('jobs.is_internship', '=', null)
        ->and_where_close();

    } elseif ($this->_job_type == 'internship') {
      $sub_query->and_where('jobs.is_internship', '=', true);
    }

    //фильтр по городу
    if ($this->_city_id) {
      $query
        ->join('jobs_cities', 'LEFT')->on('jobs.id', '=', 'jobs_cities.job_id')
        ->and_where('jobs_cities.city_id', '=', $this->_city_id);
    }

    //фильтр по форме занятости
    if ($this->_employment_alias) {
      $query->and_where('jobs.employment_alias', '=', $this->_employment_alias);
    }

    //фильтр по направлению деятельности
    if ($this->_industry_id) {
      $query->join('company_industries', 'LEFT')->on('company.id', '=', 'company_industries.company_id')
        ->and_where('company_industries.industry_id', '=', $this->_industry_id);
    }

    //фильтр по компании
    if ($this->_company && $this->_company->loaded()) {
      $query->and_where('jobs.company_id', '=', $this->_company->id);
    }

    //фильтр по id
    if ($this->_id) {
      $query->and_where('jobs.id', '=', $this->_id);
    }

    //фильтр по исключаемым id
    if (is_array($this->_exclude_ids) && count($this->_exclude_ids)) {
      $query->and_where('jobs.id', 'NOT IN', $this->_exclude_ids);
    }

    //фильтр по строке поиска
    if ($q = $this->_q) {

      $query
        ->and_where_open()
        ->or_where('jobs.title', 'LIKE', "%$q%")
        ->or_where('company.title', 'LIKE', "%$q%")
        ->or_where('company.alias', 'LIKE', "%$q%")
        ->or_where('all_tags', 'LIKE', "%$q%")//поиск по тегам
        ->and_where_close();
    }

    //сохраняем количество найденых
    $this->_found_count = count($query->execute()->as_array());

    //<editor-fold desc="сортировка">
    $sort = $this->_sort;
    $sort_dir = $this->_sort_direction;
    if ($sort_dir == 'down') {
      $sort_dir = 'DESC';
    } elseif ($sort_dir == 'up') {
      $sort_dir = 'ASC';
    } else {
      $sort_dir = 'DESC';
    }

    //сортировка по дате добавления
    if ($sort == 'added') {
      $query->order_by('jobs.added', $sort_dir);
    }

    //сортировка по релевантности
    $query
      ->order_by('company.rating', 'DESC')
      ->order_by('salary_order', 'DESC')
      ->order_by('jobs.hot', 'DESC')
      ->order_by('jobs.added', 'DESC');

    //</editor-fold>

    //лимит
    if ($this->_limit) $query->limit($this->_limit);
    if ($this->_skip) $query->offset($this->_skip);

    $this->_results = $query->as_object('Model_Job')->execute()->as_array();

    return $this;

  }

  public function set_job_type($_job_type) {
    $this->_job_type = $_job_type;
    return $this;
  }

  public function set_employment($employment_alias) {
    $this->_employment_alias = $employment_alias;
    return $this;
  }

  public function get_json_results() {
    // TODO: Implement get_json_results() method.
  }

  /**
   * @return Model_Job|null
   */
  public function first() {
    return parent::first();
  }

  /** @return Model_Job[] */
  public function get() {
    return parent::get();
  }
}