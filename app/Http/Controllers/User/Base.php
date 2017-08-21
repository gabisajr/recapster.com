<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User_Base extends Controller_Base {

  /** @var Model_User */
  protected $user;

  protected $is_me;

  public function before() {
    parent::before();

    $user = $this->request->user;
    if (!$user->loaded()) throw new HTTP_Exception_404(__('Пользователь не найден'));

    $this->user = $user;
    View::set_global('user', $user);

    $this->is_me = $this->curr_user && ($this->curr_user->id == $this->user->id);
    View::set_global('is_me', $this->is_me);

  }

}