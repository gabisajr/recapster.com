<?php

namespace App\Http\Controllers\Admin;

use App\Model\Position;
use Illuminate\Http\Request;
use View;

class PositionsController extends AdminController {

  protected $object_name = 'Position';

  public function __construct() {
    parent::__construct();
    View::share('sidebarActive', 'vocabulary');
  }

  //list of positions
  public function list(Request $request) {

    $q = $request->input('q');

    $orderBy = $request->query('order', 'title');
    if (empty($orderBy) || !in_array($orderBy, ['title', 'reviews_count', 'salaries_count', 'interviews_count', 'jobs_count'])) {
      $orderBy = 'title';
    }


    //направление сортировки
    $orderDirection = $request->query('order_direction');
    if (empty($orderDirection) || !in_array($orderDirection, ['ASC', 'DESC'])) {
      $orderDirection = 'ASC';
    }

    $positions = Position::query()
      //  ->select([DB::expr('(salaries_count + reviews_count + interviews_count + jobs_count)'), 'total_contributions_count'])
      //  ->order_by($order_by, $order_direction)
      ->paginate(100);
    //
    //$total = ORM::factory($this->object_name);
    //
    //if ($qp) {
    //  $positions->where('title', 'LIKE', "%$qp%")->or_where('alias', 'LIKE', "%$qp%");
    //  $total->where('title', 'LIKE', "%$qp%")->or_where('alias', 'LIKE', "%$qp%");
    //}
    //
    //$positions = $positions->find_all();
    //$total = $total->count_all();

    return view("admin.position.list", [
      'title'          => __('Словарь профессий'),
      'orderBy'        => $orderBy,
      'orderDirection' => $orderDirection,
      'positions'      => $positions,
      'q'              => $q,
    ]);

    //$this->main_js = '/js/admin/position/list.js'; //todo add js
  }


  //create new position
  public function create() {
    return view('admin.position.create', [
      'position' => new Position(),
    ]);
  }

  //add, edit position
  public function store(Request $request) {

    /** @var Position $position */
    $position = Position::findOrNew($request->input('id'));

    $this->validate($request, [
      'title' => "required|unique:positions,title,$position->id",
      'alias' => "required|unique:positions,alias,$position->id",
    ], [
      'title.required' => 'Введите название должности',
      'title.unique'   => 'Должность с таким названием уже есть',
      'alias.required' => 'Введите альяс должности',
      'alias.unique'   => 'Должность с таким альясом уже есть',
    ]);

    $is_new = !$position->exists;


    //сохраняем данные
    $position->title = $request->input('title');
    $position->alias = $request->input('alias');

    $position->save();

    if ($is_new) {
      $messageSuccess = __('Должность успешно добавлена');
      $redirectUrl = route('admin.positions');
    } else {
      $messageSuccess = __('Должность успешно сохранена');
      $redirectUrl = route('admin.position.edit', $position);
    }

    session(['message_success' => $messageSuccess]);
    return redirect($redirectUrl);
  }

  //attach position to entity
  public function action_attachToEntity() {

    $this->auto_render = false;

    $success = false;

    $object_name = Arr::get($_POST, 'object_name');
    $object_id = Arr::get($_POST, 'object_id');
    if ($object_name && $object_id) {
      $entity = ORM::factory($object_name, $object_id);
      if ($entity->loaded()) {
        $position = ORM::factory('Position', Arr::get($_POST, 'position'));
        if ($position->loaded()) {
          $entity->position = $position;
          try {
            $entity->save();
            $success = true;
          } catch (Exception $e) {
            $success = false;
          }
        }
      }
    }

    if ($success) {
      Session::instance()->set('message_success', 'Профессия успешно прикреплена');
    } else {
      Session::instance()->set('message_error', 'Не удалось прикрепить профессию');
    }

    HTTP::redirect($_SERVER['HTTP_REFERER']);
  }

}