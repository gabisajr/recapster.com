<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class EditController extends Controller {

  public function tel() {
    if ($this->request->method() != Request::POST) {
      throw new HTTP_Exception_404;
    }

    $user = $this->curr_user;
    $errors = [];
    $success = false;
    $old_tel = $user->tel;
    $tel = Arr::get($_POST, 'tel');

    try {
      $user->tel = $tel;
      $user->save();
      $success = true;
      if ($old_tel != $user->tel) {
        Session::instance()->alert(new Alert_Success(__('Телефон сохранен')));
      }
    } catch (ORM_Validation_Exception $e) {
      $errors = $e->errors('models');
      Session::instance()->set('errors', $errors);
    }

    $response = [
      'success' => $success,
      'errors'  => $errors,
      'value'   => $tel,
    ];

    $this->auto_render = false;
    $this->response->body(json_encode($response))->headers('Content-Type', 'application/json; charset=utf-8');

  }

  public function education() {

    if ($this->request->is_ajax() && $this->request->method() == Request::POST) {

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

    $user = $this->curr_user;
    $educations = $user->educations->find_all()->as_array();

    $view = View::factory('edit/education', [
      'user'       => $user,
      'educations' => $educations,
    ]);

    $layout = View::factory('edit/layout', [
      'user'             => $user,
      'content'          => $view,
      'edit_menu_active' => 'education',
    ]);

    $this->template->title = __('Образование');
    $this->template->content = $layout;
    $this->main_js = '/js/edit/education.js';

  }

  public function experience() {

    $user = $this->curr_user;

    if ($this->request->is_ajax() && $this->request->method() == Request::POST) {

      $errors = [];
      $success = true;

      $experiences_data = Arr::get($_POST, 'experience', []);
      $arr_id = Arr::get($experiences_data, 'id', []);
      $arr_is_internship = Arr::get($experiences_data, 'is_internship', []);
      $arr_company_title = Arr::get($experiences_data, 'company_title', []);
      $arr_position_title = Arr::get($experiences_data, 'position_title', []);
      $arr_city_title = Arr::get($experiences_data, 'city_title', []);
      $arr_start_month = Arr::get($experiences_data, 'start_month', []);
      $arr_start_year = Arr::get($experiences_data, 'start_year', []);
      $arr_end_month = Arr::get($experiences_data, 'end_month', []);
      $arr_end_year = Arr::get($experiences_data, 'end_year', []);
      $arr_is_current = Arr::get($experiences_data, 'is_current', []);
      $arr_has_text = Arr::get($experiences_data, 'has_text', []);
      $arr_text = Arr::get($experiences_data, 'text', []);

      foreach ($arr_id as $key => $id) {

        $has_text = (boolean)Arr::get($arr_has_text, $key);

        /** @var Model_Experience $experience */
        $experience = ORM::factory('Experience', $id);
        $experience->is_internship = Arr::get($arr_is_internship, $key);
        $experience->company_title = Arr::get($arr_company_title, $key);
        $experience->position_title = Arr::get($arr_position_title, $key);
        $experience->city_title = Arr::get($arr_city_title, $key);
        $experience->start_month = Arr::get($arr_start_month, $key);
        $experience->start_year = Arr::get($arr_start_year, $key);
        $experience->end_month = Arr::get($arr_end_month, $key);
        $experience->end_year = Arr::get($arr_end_year, $key);
        $experience->is_current = Arr::get($arr_is_current, $key);
        $experience->text = $has_text ? Arr::get($arr_text, $key) : null;
        $experience->user = $this->curr_user;

        $validation = $experience->validation();
        $validation
          ->rule('position_title', 'not_empty')
          ->rule('city_title', 'not_empty')
          ->rule('start_month', 'not_empty')
          ->rule('start_year', 'not_empty')
          ->rule('end_month', [$experience, 'need_end'], [':value', ':validation', ':field'])
          ->rule('end_year', [$experience, 'need_end'], [':value', ':validation', ':field']);

        if ($validation->check()) {
          $experience->save();

          if (!$experience->company->loaded()) {
            $html = "<p>Пользователь <a href='{$user->profile_url}'>{$user->fullname}</a> в своем опыте работы указал неизвестную компанию <strong>{$experience->company_title}</strong></p>";
            Email::instance()->send_admin(__('Неизвестная компания'), $html);
          }

        } else {
          $success = false;
          $errors[$key] = $validation->errors('models/experience');
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

    $experiences = $user->experiences->find_all()->as_array();

    $view = View::factory('edit/experience', [
      'user'        => $user,
      'experiences' => $experiences,
    ]);

    $layout = View::factory('edit/layout', [
      'user'             => $user,
      'content'          => $view,
      'edit_menu_active' => 'experience',
    ]);

    $this->template->title = __('Опыт работы');
    $this->template->content = $layout;
    $this->main_js = '/js/edit/experience.js';
    $this->styles[] = CSS::AWESOME_BOOTSTRAP_CHECKBOX;

  }

  public function skills() {

    $user = $this->curr_user;

    if ($this->request->method() == Request::POST) {

      //save skills
      $skill_data = Arr::get($_POST, 'skill', []);
      $arr_skill_title = Arr::get($skill_data, 'title', []);

      foreach ($arr_skill_title as $key => $skill_title) {
        if ($skill_title) {

          /** @var Model_Skill $skill */
          $skill = ORM::factory('Skill')->where('title', 'LIKE', $skill_title)->find();
          if (!$skill->loaded()) {
            $skill = ORM::factory('Skill');
            $skill->title = $skill_title;
            $skill->save();
          }

          /** @var Model_User_Skill $user_skill */
          $user_skill = ORM::factory('User_Skill', ['skill_id' => $skill->id, 'user_id' => $user->id]);
          if (!$user_skill->loaded()) {
            $user_skill = ORM::factory('User_Skill');
            $user_skill->user = $user;
            $user_skill->skill = $skill;
            $user_skill->save();
          }
        }
      }

      $lang_data = Arr::get($_POST, 'lang');
      $arr_lang_id = Arr::get($lang_data, 'id', []);
      $arr_lang_title = Arr::get($lang_data, 'title', []);
      $arr_lang_level = Arr::get($lang_data, 'level', []);

      foreach ($arr_lang_id as $key => $id) {

        $lang_title = Arr::get($arr_lang_title, $key);
        $lang_level = Arr::get($arr_lang_level, $key);

        if ($lang_title) {
          /** @var Model_Lang $lang */
          $lang = ORM::factory('Lang')->where('title', 'LIKE', $lang_title)->find();
          if (!$lang->loaded()) {
            $lang = ORM::factory('Lang');
            $lang->title = $lang_title;
            $lang->save();
          }

          /** @var Model_User_Lang $user_lang */
          $user_lang = ORM::factory('User_Lang', ['lang_id' => $lang->id, 'user_id' => $user->id]);
          if (!$user_lang->loaded()) {
            $user_lang = ORM::factory('User_Lang');
            $user_lang->user = $user;
            $user_lang->lang = $lang;
          }
          $user_lang->level = $lang_level;
          try {
            $user_lang->save();
          } catch (ORM_Validation_Exception $e) {

          }

        }

      }

      Session::instance()->alert(new Alert_Success('Данные сохранены'));
      HTTP::redirect('/edit/skills');
    }

    $skills = $user->skills->find_all();
    $langs = $user->langs->find_all();

    $view = View::factory('edit/skills', [
      'user'   => $user,
      'skills' => $skills,
      'langs'  => $langs,
    ]);

    $layout = View::factory('edit/layout', [
      'user'             => $user,
      'content'          => $view,
      'edit_menu_active' => 'skills',
    ]);

    $this->template->title = __('Профессиональные навыки');
    $this->template->content = $layout;
    $this->main_js = '/js/edit/skills.js';
  }

  public function exams() {

    if ($this->request->is_ajax() && $this->request->method() == Request::POST) {

      $errors = [];
      $success = true;

      $exams_data = Arr::get($_POST, 'exam', []);
      $arr_id = Arr::get($exams_data, 'id', []);
      $arr_title = Arr::get($exams_data, 'title', []);
      $arr_organization = Arr::get($exams_data, 'organization', []);
      $arr_specialization = Arr::get($exams_data, 'specialization', []);
      $arr_year = Arr::get($exams_data, 'year', []);

      foreach ($arr_id as $key => $id) {

        /** @var Model_Exam $exam */
        $exam = ORM::factory('Exam', $id);
        $exam->title = Arr::get($arr_title, $key);
        $exam->organization = Arr::get($arr_organization, $key);
        $exam->specialization = Arr::get($arr_specialization, $key);
        $exam->year = Arr::get($arr_year, $key);
        $exam->user = $this->curr_user;

        try {
          $exam->save();
        } catch (ORM_Validation_Exception $e) {
          $success = false;
          $errors[$key] = $e->errors('models');
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

    $user = $this->curr_user;
    $exams = $user->exams->order_by('year', 'DESC')->find_all()->as_array();

    $view = View::factory('edit/exams', [
      'user'  => $user,
      'exams' => $exams,
    ]);

    $layout = View::factory('edit/layout', [
      'user'             => $user,
      'content'          => $view,
      'edit_menu_active' => 'exams',
    ]);

    $this->template->title = __('Тесты, экзамены и курсы');
    $this->template->content = $layout;
    $this->main_js = '/js/edit/exams.js';

  }

}