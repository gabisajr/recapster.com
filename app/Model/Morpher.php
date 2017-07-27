<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Morpher - таблица склонений по падежам
 *
 * Иван Родил Девчонку Велел Тащить Пеленку
 *
 * едиснтвенное число:
 * @property string  И
 * @property string  Р
 * @property string  Д
 * @property string  В
 * @property string  Т
 * @property string  П
 *
 * множественное число:
 * @property string  МИ
 * @property string  МР
 * @property string  МД
 * @property string  МВ
 * @property string  МТ
 * @property string  МП
 *
 * @property boolean $approved - одобрен ли
 */
class Morpher extends Model {

  protected $table = "morpher";
  protected $primaryKey = "И";

}