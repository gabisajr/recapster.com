<?php

namespace App\Http\Controllers\User\Edit;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class EducationController extends Controller {

  public function showForm() {
    $user = Auth::getUser();
    $educations = $user->educations()->get();

    return view('user.edit.education', [
      'title'          => __('Образование'),
      'user'           => $user,
      'educations'     => $educations,
      'editMenuActive' => 'education',
    ]);
  }

  public function store(Request $request) {

    $errors = [];
    $success = true;

    $educations_data = Arr::get($_POST, 'education', []);
    $arr_id = Arr::get($educations_data, 'id', []);
    $arr_university = Arr::get($educations_data, 'university', []);
    $arr_faculty = Arr::get($educations_data, 'faculty', []);
    $arr_chair = Arr::get($educations_data, 'chair', []);
    $arr_edu_form = Arr::get($educations_data, 'edu_form', []);
    $arr_status = Arr::get($educations_data, 'status', []);
    $arr_start_year = Arr::get($educations_data, 'start_year', []);
    $arr_end_year = Arr::get($educations_data, 'end_year', []);
    $arr_has_text = Arr::get($educations_data, 'has_text', []);
    $arr_text = Arr::get($educations_data, 'text', []);

    foreach ($arr_id as $key => $id) {

      /** @var Model_Education $education */
      $education = ORM::factory('Education', $id);
      $university = ORM::factory('University', Arr::get($arr_university, $key));

      if ($university->loaded()) {

        $has_text = (boolean)Arr::get($arr_has_text, $key);

        $education->university = $university;
        $education->user = $this->curr_user;
        $education->start_year = Arr::get($arr_start_year, $key);
        $education->end_year = Arr::get($arr_end_year, $key);
        $education->faculty_id = Arr::get($arr_faculty, $key);
        $education->chair_id = Arr::get($arr_chair, $key);
        $education->edu_form_id = Arr::get($arr_edu_form, $key);
        $education->status_id = Arr::get($arr_status, $key);
        $education->text = $has_text ? Arr::get($arr_text, $key) : null;
        try {
          $education->save();
        } catch (ORM_Validation_Exception $e) {
          $success = false;
          $errors[$key] = $e->errors('models');
        }

      } elseif ($education->loaded()) {
        $education->delete();
      }

    }

    $response = ['success' => $success];
    if (count($errors)) $response['errors'] = $errors;

    $this->auto_render = false;
    $this->response->body(json_encode($response))->headers('Content-Type', 'application/json; charset=utf-8');

    if ($success) {
      Session::instance()->alert(new Alert_Success('Данные сохранены'));
    }

    return;

  }

}