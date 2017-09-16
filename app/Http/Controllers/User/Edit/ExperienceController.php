<?php

namespace App\Http\Controllers\User\Edit;

use App\Model\UserExperience;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExperienceController extends Controller {

  public function showForm() {
    $user = Auth::getUser();
    $experiences = $user->experiences()->get();

    return view('user.edit.experience', [
      'title'          => __("My job experience"),
      'user'           => $user,
      'experiences'    => $experiences,
      'editMenuActive' => 'experience',
    ]);
  }

  public function store(Request $request) {

    $this->validate($request, [
      'experience.companyTitle.*'  => 'required|string',
      'experience.positionTitle.*' => 'required|string',
      'experience.cityTitle.*'     => 'required|string',
      'experience.startMonth.*'    => 'required',
      'experience.startYear.*'     => 'required',
    ], [
      'experience.companyTitle.*.required'  => __('Укажите название компании/организации'),
      'experience.positionTitle.*.required' => __("Укажите должность на которой вы работали"),
      'experience.cityTitle.*.required'     => __("Укажите город в котором вы работали"),
      'experience.startMonth.*.required'    => __("Укажите месяц начала работы"),
      'experience.startYear.*.required'     => __("Укажите год начала работы"),
    ]);

    //todo validation
    //$validation
    //  ->rule('end_month', [$experience, 'need_end'], [':value', ':validation', ':field'])
    //  ->rule('end_year', [$experience, 'need_end'], [':value', ':validation', ':field']);

    $arrExperiences = $request->input('experience', []);
    $arrId = array_get($arrExperiences, 'id', []);
    $arrIsInternship = array_get($arrExperiences, 'isInternship', []);
    $arrCompanyTitle = array_get($arrExperiences, 'companyTitle', []);
    $arrPositionTitle = array_get($arrExperiences, 'positionTitle', []);
    $arrCityTitle = array_get($arrExperiences, 'cityTitle', []);
    $arrStartMonth = array_get($arrExperiences, 'startMonth', []);
    $arrStartYear = array_get($arrExperiences, 'startYear', []);
    $arrEndMonth = array_get($arrExperiences, 'endMonth', []);
    $arrEndYear = array_get($arrExperiences, 'endYear', []);
    $arrIsCurrent = array_get($arrExperiences, 'isCurrent', []);
    $arrText = array_get($arrExperiences, 'text', []);

    foreach ($arrId as $key => $id) {

      /** @var UserExperience $experience */
      $experience = UserExperience::query()
        ->where('id', '=', $id)
        ->where('user_id', '=', Auth::getUser()->id)
        ->first();

      //set user_id for new experience
      if (!$experience) {
        $experience = new UserExperience();
        $experience->user_id = Auth::getUser()->id;
      }

      $experience->is_internship = array_get($arrIsInternship, $key);
      $experience->company_title = array_get($arrCompanyTitle, $key);
      $experience->position_title = array_get($arrPositionTitle, $key);
      $experience->city_title = array_get($arrCityTitle, $key);
      $experience->start_month = array_get($arrStartMonth, $key);
      $experience->start_year = array_get($arrStartYear, $key);
      $experience->end_month = array_get($arrEndMonth, $key);
      $experience->end_year = array_get($arrEndYear, $key);
      $experience->is_current = array_get($arrIsCurrent, $key, false);
      $experience->text = array_get($arrText, $key);
      $experience->save();

      //todo admin email notification about new company
      //if (!$experience->company->loaded()) {
      //  $html = "<p>Пользователь <a href='{$user->profile_url}'>{$user->fullname}</a> в своем опыте работы указал неизвестную компанию <strong>{$experience->company_title}</strong></p>";
      //  Email::instance()->send_admin(__('Неизвестная компания'), $html);
      //}

    }

    return ['success' => true];

  }

}