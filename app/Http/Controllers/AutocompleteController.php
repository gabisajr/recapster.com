<?php

namespace App\Http\Controllers;

use App\Model\Company;
use App\Model\Position;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Collection;

class AutocompleteController extends Controller {

  private $filter;  # строка поиска
  private $limit;   # масимальное кол-во элементов за раз

  /** @var Company */
  private $company; # фильтр по компании

  public function before() {
    $this->filter = Arr::get($_POST, 'filter', Arr::get($_GET, 'filter'));

    $default_limit = 12;
    $this->limit = Arr::get($_POST, 'limit', Arr::get($_GET, 'limit', $default_limit));
    if (empty($this->limit)) $this->limit = $default_limit;

    $this->company = ORM::factory('Company', Arr::get($_POST, 'company', Arr::get($_GET, 'company')));
  }

  public function after() {
    $this->auto_render = false;
    $this->response->headers('Content-Type', 'application/json; charset=utf-8');
  }

  public function action_user() {

    /** @var Model_User[] $users */
    $users = [];

    if (!empty($this->filter)) {

      $query = ORM::factory('User')
        ->select([DB::expr("POSITION('{$this->filter}' IN user.firstname)"), 'found_position'])
        ->or_where_open()
        ->or_where('firstname', 'LIKE', "%$this->filter%")
        ->or_where('lastname', 'LIKE', "%$this->filter%")
        ->or_where('username', 'LIKE', "%$this->filter%")
        ->or_where_close()
        ->and_where('confirmed', '=', true)
        ->order_by('found_position');

      //фильтр подтвержден / нет
      if (isset($_POST['confirmed'])) {
        $confirmed = (boolean)$_POST['confirmed'];
        $query->and_where('confirmed', '=', $confirmed);
      }

      $users = $query->limit($this->limit)->find_all();
    }

    $use_link = (boolean)Arr::get($_POST, 'use_link');
    $admin_link = (boolean)Arr::get($_POST, 'admin_link');

    $arr = [];
    foreach ($users as $user) {

      $html = View::factory('autocomplete/user', [
        'user'       => $user,
        'use_link'   => $use_link,
        'admin_link' => $admin_link,
      ])->render();

      $arr[] = [
        'label' => $user->fullname,
        'html'  => $html,
      ];
    }

    $this->response->body(json_encode($arr));

  }

  public function action_city() {

    /** @var Model_City[] $cities */
    $cities = [];

    if (!empty($this->filter)) {
      $cities = ORM::factory('City')
        ->select([DB::expr("POSITION('{$this->filter}' IN city.title)"), 'found_position'])
        ->where('title', 'LIKE', "%$this->filter%")
        ->or_where('alias', 'LIKE', "%$this->filter%")
        ->order_by('found_position')
        ->limit($this->limit)
        ->find_all();
    }

    $arr = [];
    foreach ($cities as $city) {
      $arr[] = [
        'label' => $city->title,
        'html'  => View::factory('autocomplete/city', ['city' => $city])->render(),
      ];
    }

    $this->response->body(json_encode($arr));
  }

  //<editor-fold desc="должность">
  public function positions(Request $request) {

    $positions = new Collection([]);

    $with = $request->input('with');

    if (!empty($this->filter)) {

      if ($this->company && in_array($with, ['salaries', 'jobs'])) {

        switch ($with) {
          case 'salaries':
            $positions = $this->positions_in_company_with_salaries(); //todo use scopes
            break;

          case 'jobs':
            $positions = $this->positions_in_company_with_jobs(); //todo use scopes
            break;
        }


      } else {

        $positions = Position::query()
          ->select(DB::raw('positions.title as label'))
          ->addSelect([DB::raw("POSITION('{$this->filter}' IN positions.title)"), 'found_position'])
          ->where('title', 'LIKE', "%$this->filter%")
          ->orderBy('found_position')
          ->orderBy('positions.title')
          ->limit($this->limit)
          ->get();

      }

    }

    return response()->json($positions->toJson());
  }

  private function positions_in_company_with_salaries() {
    $positions = [];

    if (!empty($this->filter)) {
      $positions = DB::select('positions.id', 'positions.title', 'positions.alias')
        ->distinct(true)
        ->select([DB::expr('COUNT(salaries.id)'), 'salaries_count'])
        ->from('positions')
        ->join('salaries', 'LEFT')
        ->on('positions.id', '=', 'salaries.position_id')
        ->join('company', 'LEFT')
        ->on('salaries.company_id', '=', 'company.id')
        ->where('company.id', '=', $this->company->id)
        ->and_where('salaries.status', '=', Status::APPROVED)
        ->where('positions.title', 'LIKE', "%$this->filter%")
        ->group_by('positions.id')
        ->having('salaries_count', '>', 0)
        ->order_by('salaries_count', 'DESC')
        ->order_by('positions.title')
        ->limit($this->limit)
        ->as_object()
        ->execute()
        ->as_array();
    }

    return $positions;
  }

  private function positions_in_company_with_jobs() {
    $positions = [];

    if (!empty($this->filter)) {
      $positions = DB::select('positions.id', 'positions.title', 'positions.alias')
        ->distinct(true)
        ->select([DB::expr('COUNT(jobs.id)'), 'jobs_count'])
        ->from('positions')
        ->join('jobs', 'LEFT')
        ->on('positions.id', '=', 'jobs.position_id')
        ->join('company', 'LEFT')
        ->on('jobs.company_id', '=', 'company.id')
        ->where('company.id', '=', $this->company->id)
        ->and_where('jobs.status', '=', Status::APPROVED)
        ->where('positions.title', 'LIKE', "%$this->filter%")
        ->group_by('positions.id')
        ->having('jobs_count', '>', 0)
        ->order_by('jobs_count', 'DESC')
        ->order_by('positions.title')
        ->limit($this->limit)
        ->as_object()
        ->execute()
        ->as_array();
    }

    return $positions;
  }

  //</editor-fold>

  public function action_skill() {
    $skills = [];

    if (!empty($this->filter)) {

      $query = DB::select(['skills.title', 'label'])
        ->select([DB::expr("POSITION('{$this->filter}' IN skills.title)"), 'found_position'])
        ->from('skills')
        ->where('skills.title', 'LIKE', "%$this->filter%")
        ->order_by('found_position')
        ->order_by('skills.title')
        ->limit($this->limit);

      $except = Arr::get($_POST, 'except', []);
      if (count($except)) $query->and_where('skills.title', 'NOT IN', $except);

      $skills = $query->execute()->as_array();
    }

    $this->response->body(json_encode($skills));
  }

  public function action_lang() {

    $langs = [];

    if (!empty($this->filter)) {

      $query = DB::select(['langs.title', 'label'])
        ->select([DB::expr("POSITION('{$this->filter}' IN langs.title)"), 'found_position'])
        ->from('langs')
        ->where('langs.title', 'LIKE', "%$this->filter%")
        ->order_by('found_position')
        ->order_by('langs.title')
        ->limit($this->limit);

      $except = Arr::get($_POST, 'except', []);
      if (count($except)) $query->and_where('langs.title', 'not in', $except);

      $langs = $query->execute()->as_array();
    }

    $this->response->body(json_encode($langs));
  }

  public function action_industry() {

    /** @var Model_Industry[] $industries */
    $industries = [];

    if (!empty($this->filter)) {
      $industries = DB::select(['industries.title', 'label'])
        ->select([DB::expr("POSITION('{$this->filter}' IN industries.title)"), 'found_position'])
        ->from('industries')
        ->where('title', 'LIKE', "%$this->filter%")
        ->order_by('found_position')
        ->limit($this->limit)
        ->execute()
        ->as_array();
    }

    $this->response->body(json_encode($industries));
  }

  public function action_fast() {

    $items = [];

    if (!empty($this->filter)) {


      $query_company = DB::select('id', ['company.title', 'label'])
        ->select(DB::expr('"company" AS type'))
        ->from('company')
        ->where('company.active', '=', true);

      $query_user = DB::select('id', [DB::expr('CONCAT(users.firstname, " ", users.lastname)'), 'label'])
        ->select(DB::expr('"user" AS type'))
        ->from('users')
        ->where('users.confirmed', '=', true);

      $query = DB::select()->from([$query_company->union($query_user), 't1'])
        ->where('label', 'LIKE', "%$this->filter%")
        ->select('id', 'type', 'label')
        ->select([DB::expr("POSITION('{$this->filter}' IN t1.label)"), 'found_position'])
        ->order_by('found_position')
        ->limit($this->limit);

      $items = $query->execute()->as_array();

    }

    $arr = [];
    foreach ($items as $item) {
      $type = Arr::get($item, 'type');
      $id = Arr::get($item, 'id');
      switch ($type) {

        case 'company':
          /** @var Model_Company $company */
          $company = ORM::factory('Company', $id);
          if ($company->loaded()) {
            $arr[] = [
              'label' => $company->title,
              'html'  => View::factory('autocomplete/company', ['company' => $company, 'use_link' => true])->render(),
            ];
          }
          break;

        case 'user':
          /** @var Model_User $user */
          $user = ORM::factory('User', $id);
          if ($user->loaded()) {
            $arr[] = [
              'label' => $user->fullname,
              'html'  => View::factory('autocomplete/user', ['user' => $user, 'use_link' => true])->render(),
            ];
          }
          break;
      }
    }

    $this->response->body(json_encode($arr));

  }

}