<?php

namespace App\Http\Controllers\Admin;

use App\Model\University;
use App\Model\Faculty;
use Illuminate\Http\Request;
use View;
use Auth;

class FacultiesController extends AdminController {

  public function __construct() {
    parent::__construct();
    View::share('sidebarActive', 'vocabulary');
  }

  //faculties of university
  public function faculties(Request $request) {

    /** @var University $university */
    $university = University::find($request->query('university'));

    if (!$university) {
      session(['message_error' => __('Университет не найден')]);
      return redirect(route('admin.universities.countries'));
    }

    /** @var Faculty $query */
    $query = Faculty::query()->withCount('chairs');

    //фильтр по университету
    if ($university) {
      $query->ofUniversity($university);
    }

    $faculties = $query
      ->orderBy('faculties.title')
      ->paginate(100);

    $title = __('Факультеты') . " " . $university->of('title');

    return view("admin.faculties.list", [
      'title'      => $title,
      'university' => $university,
      'faculties'  => $faculties,
    ]);
  }

  public function create(Request $request) {

    $university = University::find($request->query('university'));
    if (!$university) {
      session(['message_error' => __("Faculty not found")]);
      return redirect(route('admin.universities.countries'));
    }

    $faculty = new Faculty();
    $faculty->university_id = $university->id;

    $title = __("admin.add_faculty_for_university", ['university' => $university->abbreviation]);

    return view("admin.faculties.create", [
      'title'      => $title,
      'faculty'    => $faculty,
      'university' => $university,
    ]);
  }

  public function edit(int $id) {
    /** @var Faculty $faculty */
    $faculty = Faculty::findOrFail($id);

    return view("admin.faculties.create", [
      'title'      => $faculty->title,
      'faculty'    => $faculty,
      'university' => $faculty->university,
    ]);
  }

  public function store(Request $request) {

    /** @var Faculty $faculty */
    $faculty = Faculty::findOrNew($request->input('id'));

    $this->validate($request, [
      'title' => 'required|string',
      'vk_id' => "nullable|unique:faculties,vk_id,$faculty->id",
    ]);

    // for new faculty assign university
    if (!$faculty->exists) {
      /** @var University $university */
      $university = University::find($request->input('university'));
      if (!$university) {
        session(['message_error' => __('University not found')]);
        return redirect(route('admin.universities.countries'));
      }
      $faculty->university_id = $university->id;
    }

    //сохраняем данные
    $faculty->title = $request->input('title');

    if (Auth::getUser()->is_super_admin) {
      $faculty->vk_id = $request->input('vk_id');
    }

    $faculty->save();

    session(['message_success' => __('Faculty successfully saved')]);
    return redirect(route('admin.faculties', ['university' => $faculty->university_id]));
  }

  public function action_vk_import() {
    $this->auto_render = false;
    $this->response->headers('Content-Type', 'text/plain; charset=utf-8');

    /** @var Model_University $university */
    $university = ORM::factory('University', $this->request->post('university'));
    if (!$university->loaded()) {
      Session::instance()->set('message_error', __('Университет не найден'));
      HTTP::redirect(URL::get_redirect_url("/admin/$this->lower_object_name/countries"));
    }

    $faculties = VK_Import::faculties($university);
    $imported_count = faculties_count(count($faculties));

    Session::instance()->set('message_success', __('Импорт успешно осуществлен (:count)', [':count' => $imported_count]));
    HTTP::redirect(URL::get_redirect_url("/admin/faculty/list?university={$university->id}"));
  }

}