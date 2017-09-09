<?php

namespace App\Http\Controllers\Admin;

use App\Model\Faculty;
use App\Model\Chair;
use Illuminate\Http\Request;
use Auth;
use View;

class ChairsController extends AdminController {

  public function __construct() {
    parent::__construct();
    View::share('sidebarActive', 'vocabulary');
  }

  //list of chairs
  public function chairs(Request $request) {

    /** @var Faculty $faculty */
    $faculty = Faculty::find($request->query('faculty'));
    if (!$faculty) {
      session(['message_error' => __('Faculty not found')]);
      return redirect(route('admin.universities.countries'));
    }


    $query = Chair::query();

    //фильтр по факультету
    if ($faculty) {
      $query->ofFaculty($faculty);
    }

    $chairs = $query
      ->orderBy('title')
      ->paginate(100);

    $title = __('admin.chairs_of_faculty', ['faculty' => $faculty->title]);

    return view("admin.chairs.list", [
      'title' => $title,
      'faculty' => $faculty,
      'chairs' => $chairs,
    ]);

    // $this->main_js = '/js/admin/chair/list.js'; //todo
  }

  public function create(Request $request) {

    $faculty = Faculty::find($request->query('faculty'));
    if (!$faculty) {
      session(['message_error' => __("Faculty not found")]);
      return redirect(route('admin.universities.countries'));
    }

    $chair = new Chair();
    $chair->faculty_id = $faculty->id;

    $title = __("admin.add_chair_for_faculty", ['faculty' => $faculty->title]);

    return view("admin.chairs.create", [
      'title' => $title,
      'chair' => $chair,
      'faculty' => $faculty,
    ]);
  }

  public function edit(int $id) {

    /** @var Chair $chair */
    $chair = Chair::findOrFail($id);

    return view("admin.chairs.edit", [
      'title' => $chair->title,
      'chair' => $chair,
      'faculty' => $chair->faculty,
    ]);
  }

  //add, edit chair
  public function store(Request $request) {

    /** @var Chair $chair */
    $chair = Chair::findOrNew($request->input('id'));
    $isNew = !$chair->exists;

    $this->validate($request, [
      'title' => 'required|string',
      'vk_id' => "nullable|unique,chairs,vk_id,$chair->id",
    ]);

    // for new chair need faculty input
    if (!$chair->exists) {
      /** @var Faculty $faculty */
      $faculty = Faculty::find($request->input('faculty'));
      if (!$faculty) {
        session(['message_error', __('Faculty not found')]);
        return redirect(route('admin.universities.countries'));
      }
      $chair->faculty_id = $faculty->id;
    }

    $chair->title = $request->input('title');

    if (Auth::getUser()->is_super_admin) {
      $chair->vk_id = $request->input('vk_id');
    }

    $chair->save();

    $successMessage = $isNew ? __("Chair successfully added") : __('Chair successfully updated');
    session(['message_success' => $successMessage]);
    return redirect(route("admin.chairs", ['faculty' => $chair->faculty_id]));

  }


  public function action_vk_import() {
    $this->auto_render = false;
    $this->response->headers('Content-Type', 'text/plain; charset=utf-8');

    /** @var Model_Faculty $faculty */
    $faculty = ORM::factory('Faculty', $this->request->post('faculty'));
    if (!$faculty->loaded()) {
      Session::instance()->set('message_error', __('Факультет не найден'));
      HTTP::redirect(URL::get_redirect_url("/admin/$this->lower_object_name/countries"));
    }

    $chairs = VK_Import::chairs($faculty);
    $imported_count = chairs_count(count($chairs));

    Session::instance()->set('message_success', __('Импорт успешно осуществлен (:count)', [':count' => $imported_count]));
    HTTP::redirect(URL::get_redirect_url("/admin/chair/list?faculty={$faculty->id}"));
  }

}