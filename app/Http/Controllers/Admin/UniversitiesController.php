<?php

namespace App\Http\Controllers\Admin;

use App\Model\City;
use App\Model\Country;
use App\Model\University;
use Illuminate\Http\Request;
use Auth;
use View;

class UniversitiesController extends AdminController {

  public function __construct() {
    parent::__construct();
    View::share('sidebarActive', 'vocabulary');
  }

  public function before() {
    parent::before();
    View::set_global('sidebar_active', 'vocabulary');
  }

  public function countries() {
    $countries = Country::query()
      ->withCount('universities')
      ->orderBy('universities_count', 'desc')
      ->get();

    return view("admin.universities.countries", [
      'title'     => __('Университеты'),
      'countries' => $countries,
    ]);
  }

  public function cities(int $countryId) {

    /** @var Country $country */
    $country = Country::find($countryId);

    if (!$country) {
      session(['message_error' => __('Страна не найдена')]);
      return redirect(route('admin.universities.countries'));
    }

    $cities = City::ofCountry($country)
      ->withCount('universities')
      ->orderBy('universities_count', 'desc')
      ->get();

    $title = __('Университеты') . " " . $country->ofCountry();

    return view("admin.universities.cities", [
      'title'   => $title,
      'cities'  => $cities,
      'country' => $country,
    ]);
  }

  //list of universities
  public function universities(Request $request) {

    $orderBy = $request->query('order', 'title');
    $orderDirection = $request->query('orderDirection', 'asc');

    /** @var City $city */
    $city = City::find($request->query('city'));
    if (!$city) {
      session(['message_error' => __('Город не найден')]);
      return redirect(route('admin.universities.countries'));
    }

    $universities = University::query()
      ->ofCity($city)
      ->withCount('faculties')
      ->orderBy($orderBy, $orderDirection)
      ->paginate(100);

    $title = __('Университеты') . ' ' . $city->of('title');

    return view("admin.universities.list", [
      'title'          => $title,
      'city'           => $city,
      'orderBy'        => $orderBy,
      'orderDirection' => $orderDirection,
      'universities'   => $universities,
    ]);
  }

  public function create(Request $request) {

    /** @var City $city */
    $city = City::find($request->query('city'));
    if (!$city) {
      session(['message_error' => __('Город не найден')]);
      return redirect(route('admin.universities.countries'));
    }

    $university = new University();
    $university->city_id = $city->id;
    $university->country_id = $city->country_id;

    $title = __('Добавить вуз в') . ' ' . $city->in('title');

    $countries = Country::orderBy('title')->get();
    $cities = $city->country->cities()->orderBy('cities.title')->get();

    return view("admin.universities.create", [
      'title'      => $title,
      'city'       => $city,
      'country'    => $city->country,
      'university' => $university,
      'countries'  => $countries,
      'cities'     => $cities,
    ]);
  }

  public function edit(int $id) {
    $university = University::find($id);
    if (!$university) {
      session(['message_error' => __("Университет не найден")]);
      return redirect(route('admin.universities.countries'));
    }

    $countries = Country::orderBy('title')->get();
    $cities = $university->country->cities()->orderBy('cities.title')->get();

    return view('admin.universities.edit', [
      'title'      => $university->title,
      'university' => $university,
      'country'    => $university->country,
      'city'       => $university->city,
      'countries'  => $countries,
      'cities'     => $cities,
    ]);
  }

  //add, edit university
  public function store(Request $request) {

    /** @var University $university */
    $university = University::findOrNew($request->input('id'));

    $this->validate($request, [
      'country_id'   => 'required', //todo from countries table
      'city_id'      => 'required', //todo from cities table
      'slug'         => "required|string|unique:universities,slug,$university->id",
      'title'        => "required|string|unique:universities,title,$university->id",
      'abbreviation' => "nullable|string|unique:universities,abbreviation,$university->id",
      'site'         => "required|string|url|active_url|unique:universities,site,$university->id",
      'vk_id'        => "nullable|unique:universities,vk_id,$university->id",
    ]);


    //сохраняем данные
    $university->country_id = $request->input('country_id');
    $university->city_id = $request->input('city_id');
    $university->title = $request->input('title');
    $university->abbreviation = $request->input('abbreviation');
    $university->slug = $request->input('slug');
    $university->site = $request->input('site');

    if (Auth::getUser()->is_super_admin) {
      $university->vk_id = $request->input('vk_id');
    }

    $university->save();
    $this->uploadImage($university, 'logo');

    session(['message_success' => __('Учебное заведение успешно сохранено')]);
    return redirect(route('admin.university.edit', ['id' => $university->id]));

  }

  public function action_vk_import() {
    $this->auto_render = false;
    $this->response->headers('Content-Type', 'text/plain; charset=utf-8');

    /** @var Model_City $city */
    $city = ORM::factory('City', $this->request->post('city'));
    if (!$city->loaded()) {
      Session::instance()->set('message_error', __('Город не найден'));
      HTTP::redirect(URL::get_redirect_url("/admin/$this->lower_object_name/countries"));
    }

    $universities = VK_Import::universities($city);
    $imported_count = universities_count(count($universities));


    Session::instance()->set('message_success', __('Импорт успешно осуществлен (:count)', [':count' => $imported_count]));
    HTTP::redirect(URL::get_redirect_url("/admin/university/list?country={$city->id}"));
  }

}