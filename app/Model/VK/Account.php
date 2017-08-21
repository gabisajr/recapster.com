<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Model_VK_Account Аккаунт ВКонтакте
 *
 * @see https://vk.com/dev/fields
 *
 * @property string        $vk_user_id     - id пользователя ВКонтакте
 * @property int           $birth_day      - число рождения
 * @property int           $birth_month    - месяц рождения
 * @property int           $birth_year     - год рождения
 * @property int           $sex            - Пол 1 — женский, 2 — мужской, 0 — пол не указан.
 * @property string        $firstname      - Имя
 * @property string        $lastname       - Фамилия
 * @property string        $email          - Email
 * @property string        $image_url      - ссылка на фотографию пользователя ВКонтакте
 * @property string        $access_token   - токен для обращения к API ВКонтакте
 *
 * ----------------------- virtual: ----------------------------------
 * @property string        $url            - адрес страницы пользователя ВКонтакте
 * @property string        $fullname       - полное имя
 *
 *
 * ----------------------- belongs to: -------------------------------
 * @property Model_Country $country        - страна
 * @property int           $country_id
 *
 * @property Model_City    $city           - город
 * @property int           $city_id
 */
class Model_VK_Account extends ORM {

  protected $_primary_key = 'vk_user_id';

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
   * получить URL-страницы пользователя ВКонтакте
   *
   * @return string
   */
  public function get_url() {
    return "https://vk.com/id{$this->vk_user_id}";
  }

  public function create_account($vk_user_info) {

    /** @var Model_VK_Account $vk_account */
    $vk_account = ORM::factory('VK_Account');
    $vk_account->vk_user_id = $vk_user_info->id;
    $vk_account->firstname = isset($vk_user_info->first_name) ? $vk_user_info->first_name : null;
    $vk_account->lastname = isset($vk_user_info->last_name) ? $vk_user_info->last_name : null;


    $bdate = (isset($vk_user_info->bdate) && $vk_user_info->bdate) ? $vk_user_info->bdate : null;
    $bdate = VK::extract_bdate($bdate);

    $vk_account->birth_day = Arr::get($bdate, 'd');
    $vk_account->birth_month = Arr::get($bdate, 'm');
    $vk_account->birth_year = Arr::get($bdate, 'y');
    $vk_account->sex = isset($vk_user_info->sex) ? $vk_user_info->sex : null;
    $vk_account->email = isset($vk_user_info->email) ? $vk_user_info->email : null;
    $vk_account->access_token = isset($vk_user_info->access_token) ? $vk_user_info->access_token : null;
    $vk_account->image_url = isset($vk_user_info->photo_max_orig) ? $vk_user_info->photo_max_orig : null;
    if (isset($vk_user_info->country)) $this->country = ORM::factory('Country', ['vk_id' => $vk_user_info->country->id]);
    if (isset($vk_user_info->city)) $this->city = ORM::factory('City', ['vk_id' => $vk_user_info->city->id]);

    $vk_account->create();

    return $vk_account;
  }


}