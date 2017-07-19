<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_University
 * @property int           $id
 * @property string        $alias
 * @property string        $title         - название учебного заведения
 * @property string        $site          - сайт учебного заведения
 * @property int           $vk_id         - идентификатотор учебного заведения ВКонтакте
 *
 * ------------------ virtual: -----------------------------------------
 * @property string        $url           - ссылка на профиль
 * @property string        $of_university - родительный падеж названия университета
 *
 * ------------------ belongs to: ---------------------------------------
 * @property Model_Country $country       - страна, где находится вуз
 * @property int           $country_id
 *
 * @property Model_City    $city          - город, где находится заведение
 * @property int           $city_id
 *
 * @property Model_Image   $logo          - логотип
 * @property int           $logo_id
 *
 * ------------------ has many: -----------------------
 * @property ORM           $faculties     - факультеты
 */
class University extends Model {

  public function country() {
    return $this->belongsTo('App\Model\Country');
  }

  public function city() {
    return $this->belongsTo('App\Model\City');
  }

  public function logo() {
    return $this->belongsTo('App\Model\Image');
  }

  public function faculties() {
    return $this->hasMany('App\Model\Faculty', 'university_id');
  }

  public function rules() { //todo validation
    return [
      'country_id' => [
        ['not_empty'],
      ],
      'city_id'    => [
        ['not_empty'],
      ],
      'alias'      => [
        [[$this, 'unique'], ['alias', ':value']],
      ],
      'title'      => [
        ['not_empty'],
        [[$this, 'unique'], ['title', ':value']],
      ],
      'site'       => [
        [[$this, 'unique'], ['site', ':value']],
      ],
      'vk_id'      => [
        [[$this, 'unique'], ['vk_id', ':value']],
      ],
    ];
  }

//  public function get($column) {
//    switch ($column) {
//      case 'url':
////        return "http://$_SERVER[HTTP_HOST]/edu/{$this->alias}/"; //todo
//        return $this->site;
//        break;
//      case 'of_university':
//        return I18n::$lang == 'ru' ? Morpher::inflect($this->title, 'Р') : $this->title;
//        break;
//    }
//    return parent::get($column);
//  }
// todo create observer
//  public function delete() {
//
//    //delete faculties
//    foreach ($this->faculties->find_all() as $faculty) $faculty->delete();
//
//    //delete logo
//    if ($this->logo->loaded()) $this->logo->delete();
//
//    return parent::delete();
//  }

}