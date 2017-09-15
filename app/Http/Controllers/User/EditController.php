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