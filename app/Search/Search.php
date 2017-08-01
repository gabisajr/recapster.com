<?php

namespace App\Search;

abstract class Search {

  /** @var Model_User|null - тот кто ищет */
  protected $_curr_user;

  /** @var Model_Company */
  protected $_company;

  /** @var int */
  protected $_limit;

  /** @var int */
  protected $_found_count = 0;

  /** @var string строка поиска */
  protected $_q;

  /** @var int - город */
  protected $_city_id;

  /** @var int - пользователь */
  protected $_user_id;

  /** @var int - направления деятельности */
  protected $_industry_id;

  /** @var array - id объектов, которые нужно исключить из поиска */
  protected $_exclude_ids = [];

  /** @var int - кол-во пропустить при поиске */
  protected $_skip;

  /** @var string - поле сортировки */
  protected $_sort;

  /** @var string - направление сортировки */
  protected $_sort_direction;

  /** @var int - фильтр по id */
  protected $_id;

  /** @var array - фильтр по массиву ids */
  protected $_ids = [];

  /** @var boolean|null - фильтр по избранному */
  protected $_is_fave = null;

  /** @var array - результаты поиска */
  protected $_results = [];

  public function __construct($user) {
    $this->_curr_user = $user;

    return $this;
  }

  public function limit($limit) {
    $this->_limit = $limit;

    return $this;
  }

  public function foundCount() {
    return $this->_found_count;
  }

  public function hasMore() {
    return ($this->_skip + count($this->_results)) < $this->_found_count;
  }

  public function setQ($q) {
    $this->_q = $q;

    return $this;
  }

  public function setCityId($city_id) {
    $this->_city_id = $city_id;

    return $this;
  }

  public function setUserId($user_id) {
    $this->_user_id = $user_id;

    return $this;
  }

  public function setSort($sort, $direction = null) {
    $this->_sort = $sort;
    $this->_sort_direction = $direction;

    return $this;
  }

  public function industryId($industry_id) {
    $this->_industry_id = $industry_id;
    return $this;
  }

  public function excludeIds($exclude_ids = []) {
    if (is_array($exclude_ids)) {
      $this->_exclude_ids = $exclude_ids;
    }

    return $this;
  }

  public function company(Model_Company $company) {
    $this->_company = $company;

    return $this;
  }

  public function skip($skip) {
    $this->_skip = (int)$skip;
    return $this;
  }

  public function id($id) {
    $this->_id = $id;
    return $this;
  }

  public function ids($ids) {
    $this->_ids = $ids;
    return $this;
  }

  public function isFave($is_fave) {
    $this->_is_fave = $is_fave;
    return $this;
  }

  public function get() {
    return $this->_results;
  }

  public function first() {
    if (count($this->_results)) return $this->_results[0];
    return null;
  }

  public abstract function find();

  public abstract function get_json_results();

}