<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_Person Персона
 *
 * @property int           id
 * @property string        firstname
 * @property string        lastname
 * @property string        title
 * @property Model_Image   avatar
 * @property Model_Company company
 */
class Ceo extends Model {

  protected $table = "ceo";

  public function avatar() {
    return $this->belongsTo('App\Model\Image');
  }

  public function company() {
    return $this->belongsTo('App\Model\Company');
  }

  public function rules() { //todo validation
    return [
      'firstname' => [
        ['not_empty'],
      ],
      'lastname'  => [
        ['not_empty'],
      ],
    ];
  }

  //todo observer
  //public function delete() {
  //  if ($this->avatar->loaded()) $this->avatar->delete();
  //
  //  return parent::delete();
  //}

}