<?php

namespace App\Search;

class SearchCompanies extends Search {

  public function find() {

    $query = ORM::factory('Company')
      ->distinct(true)
      ->where('company.active', '=', true);

    //определяем есть ли логотип
    $query->select([DB::expr("IF(company.logo_id, TRUE, FALSE)"), 'has_logo']);

    //определяем есть ли обложка
    $query->select([DB::expr("IF(company.cover_id, TRUE, FALSE)"), 'has_cover']);

    //подписан ли на компанию
    if ($this->_curr_user) {
      $query->select([DB::expr("(SELECT COUNT(*) FROM subscriptions subs WHERE subs.company_id = company.id AND subs.user_id = :curr_user)"), 'subscribed']);
    } else {
      $query->select([DB::expr("FALSE"), 'subscribed']);
    }

    //фильтр по городу
    if ($this->_city_id) {
      $query->and_where('company.hq_city_id', '=', $this->_city_id);
    }

    //фильтр по направлению
    if ($this->_industry_id) {
      $query
        ->join('company_industries', 'LEFT')->on('company.id', '=', 'company_industries.company_id')
        ->and_where('company_industries.industry_id', '=', $this->_industry_id);
    }

    //фильтр по исключаемым id
    if (is_array($this->_exclude_ids) && count($this->_exclude_ids)) {
      $query->and_where('company.id', 'NOT IN', $this->_exclude_ids);
    }

    //фильтр по строке поиска
    if ($q = $this->_q) {
      $query
        ->and_where_open()
        ->where('company.title', 'like', "%$q%")
        ->or_where('company.site', 'like', "%$q%")
        ->and_where_close()
        ->select([DB::expr("POSITION('{$q}' IN company.title)"), 'found_position']);
    }

    //подставляем параметры
    if ($this->_curr_user) $query->param(':curr_user', $this->_curr_user->id);

    //сохраняем количество найденых
    $this->_found_count = $query->reset(false)->count_all();

    //сортировка
    if ($this->_q) $query->order_by('found_position'); //позиция строки поиска
    $query->order_by('has_logo', 'DESC')->order_by('has_cover', 'DESC'); //с лого и обложкой поднять выше

    if ($this->_sort == 'rating') {
      $query
        ->order_by('company.rating', 'DESC')
        ->order_by('company.followers_count', 'DESC');

    } elseif ($this->_sort == 'popular') {
      $query
        ->order_by('company.followers_count', 'DESC')
        ->order_by('company.rating', 'DESC');
    }

    //обязательный сортировки
    $query
      ->order_by('company.reviews_count', 'DESC')
      ->order_by('company.added', 'DESC');

    //лимит и пропуск
    if ($this->_limit) $query->limit($this->_limit);
    if ($this->_skip) $query->offset($this->_skip);

    $this->_results = $query->find_all()->as_array();

    return $this;
  }

  public function get_json_results() {
    // TODO: Implement get_json_results() method.
  }

  /** @return Model_Company[] */
  public function get() {
    return parent::get();
  }

  /** @return Model_Company */
  public function first() {
    return parent::first();
  }

}