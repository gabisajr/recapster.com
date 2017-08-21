<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Model_Facebook_Account Аккаунт Facebook
 *
 * @property string        $fb_user_id     - id пользователя Facebook
 * @property string        $firstname      - Имя
 * @property string        $lastname       - Фамилия
 * @property int           $birth_day      - число рождения
 * @property int           $birth_month    - месяц рождения
 * @property int           $birth_year     - год рождения
 * @property string        $sex            - Пол
 * @property string        $email          - Email
 * @property string        $image_url      - ссылка на фотографию пользователя Facebook
 * @property string        $access_token   - токен для обращения к API Facebook
 * @property string        $link           - адрес страницы пользователя Facebook
 *
 * ---------------------- virtual: ------------------------------------
 * @property string        $url            - адрес страницы пользователя Facebook
 * @property string        $fullname       - полное имя
 *
 * ---------------------- belongs to: -------------------------------
 * @property Model_Country $country        - страна
 * @property int           $country_id
 *
 * @property Model_City    $city           - город
 * @property int           $city_id
 */
class Model_Facebook_Account extends ORM {

  protected $_primary_key = 'fb_user_id';

  protected $_belongs_to = [
    'country' => [
      'model'       => 'Country',
      'foreign_key' => 'country_id',
    ],
    'city'    => [
      'model'       => 'City',
      'foreign_key' => 'city_id',
    ],
  ];

  public function get($column) {

    switch ($column) {
      case 'url':
        return $this->get_url();
        break;
      case 'fullname':
        return $this->get_fullname();
        break;
    }

    return parent::get($column);
  }

  function get_fullname() {
    if ($this->firstname || $this->lastname) {
      $parts = [];
      if ($this->firstname) $parts[] = $this->firstname;
      if ($this->lastname) $parts[] = $this->lastname;
      return implode(' ', $parts);
    }
    return null;
  }

  /**
   * получить URL-страницы пользователя Facebook
   * @return string
   */
  public function get_url() {
    return $this->link;
  }

  public function create_account($fb_user_info) {

    /** @var Model_Facebook_Account $fb_account */
    $fb_account = ORM::factory($this->object_name());
    $fb_account->fb_user_id = $fb_user_info->id;
    $fb_account->firstname = isset($fb_user_info->first_name) ? $fb_user_info->first_name : null;
    $fb_account->lastname = isset($fb_user_info->last_name) ? $fb_user_info->last_name : null;

    $bdate = Facebook::extract_bdate($fb_account);
    $fb_account->birth_day = Arr::get($bdate, 'd');
    $fb_account->birth_month = Arr::get($bdate, 'm');
    $fb_account->birth_year = Arr::get($bdate, 'y');

    if (isset($fb_user_info->gender)) {
      switch ($fb_user_info->gender) {
        case 'male':
          $fb_account->sex = Sex::MALE;
          break;
        case 'female':
          $fb_account->sex = Sex::FEMALE;
          break;
      }
    }

    $fb_account->email = isset($fb_user_info->email) ? $fb_user_info->email : null;
    $fb_account->access_token = isset($fb_user_info->access_token) ? $fb_user_info->access_token : null;
    $fb_account->image_url = isset($fb_user_info->picture) ? $fb_user_info->picture->data->url : null;
    $fb_account->link = isset($fb_user_info->link) ? $fb_user_info->link : null;

    //todo country
    //todo city

    $fb_account->create();

    return $fb_account;

  }

}