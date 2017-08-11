<?php

namespace App;

use App\Model\User;

class Username {

  //пробуем добавлять к базовому логину цифры: kosha.industry@gmail.com -> kosha.industry1, kosha.industry2, ...
  private static function addDigit($baseUsername) {
    $username = $baseUsername;
    $i = 1;
    while (self::alreadyTaken($username) && $i <= 100) {
      $username = $baseUsername . $i;
      $i++;
    }
    return $username;
  }

  /**
   * генерирует уникальный логин для пользователя и сохраняет его
   * @param User $user
   */
  public static function generateForUser(User $user) {

    //идем каскадом по разным алгоритмам, до тех пор пока не получим уникальный логин

    $username = null;

    //пробуем как первую часть email
    if (!$username && $user->email) {
      $username = mb_strtolower(explode("@", $user->email)[0]);
      if (self::alreadyTaken($username)) $username = null;
    }

    //пробуем как логин в скайпе
    if (!$username && $user->skype) {
      $username = mb_strtolower($user->skype);
      if (self::alreadyTaken($username)) $username = null;
    }

    //todo as twitter
    //todo as instagram

    //generate as vk alias //todo get user alias from vk
    if (!$username && $user->vkAccount->loaded()) {
      $username = "id{$user->vkAccount->vk_user_id}";
      if (self::alreadyTaken($username)) $username = null;
    }

    //todo generate as facebook alias

    //имя в транслите
    $transFirstname = Text::transliterate(mb_strtolower(trim($user->firstname)));

    //пробуем на основании имени и года рождения
    if (!$username && $transFirstname && $user->birth_year) {
      $username = "{$transFirstname}.{$user->birth_year}";
      if (self::alreadyTaken($username)) $username = null;
    }

    //пробуем через имя и цифру
    if (!$username && $transFirstname) {
      $username = self::addDigit($transFirstname);
      if (self::alreadyTaken($username)) $username = null;
    }

    //последний вариант - использовать 'user1'
    if (!$username) {
      $username = "user{$user->id}";
      if (self::alreadyTaken($username)) $username = null;
    }

    if ($username) {
      $user->username = $username;
      $user->update();
    } else {
      throw new Exception(__('Не удалось сгенерировать логин'));
    }

  }

  public static function alreadyTaken($username) {

    if (in_array($username, [
      'admin',
      'username',
      'about',
      'help',
      'search',
    ])) {
      return true;
    }

    $otherUser = User::where('username', '=', $username)->first();
    if ($otherUser) {
      return true;
    } else {
      return false;
    }
  }


}