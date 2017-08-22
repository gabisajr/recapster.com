<?php

namespace App\Http\Controllers\User\Edit;

use App\Http\Controllers\Controller;

class ContactsController extends Controller {

  public function showForm() {

    return "show edit contacts form";

    return view('user.edit.contacts', [
      'errors'    => $errors,
      'user'      => $user,
      'skype'     => $skype,
      'twitter'   => $twitter,
      'site'      => $site,
      'instagram' => $instagram,
    ]);

    $layout = View::factory('edit/layout', [
      'user'             => $user,
      'content'          => $view,
      'edit_menu_active' => 'contacts',
    ]);

    $this->template->title = __('Редактирование контактов');
    $this->template->content = $layout;
    $this->main_js = '/js/edit/contacts.js';
  }

  public function contacts() {
    $errors = [];
    $user = $this->curr_user;

    $skype = Arr::get($_POST, 'skype', $user->skype);
    $twitter = Arr::get($_POST, 'twitter', $user->twitter);
    $instagram = Arr::get($_POST, 'instagram', $user->instagram);
    $site = Arr::get($_POST, 'site', $user->site);

    if ($this->request->method() == Request::POST) {


      try {
        $user->skype = $skype;
        $user->instagram = $instagram;
        $user->twitter = $twitter;
        $user->site = $site;
        $user->save();

        $alert = new Alert_Success(__('Ваши контакты сохранены'));
        Session::instance()->set(Session::ALERT, $alert);
        HTTP::redirect('/edit/contacts');

      } catch (ORM_Validation_Exception $e) {
        $errors = $e->errors('models');
      }
    }
  }

}