<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model_Employment форма занятости работника
 *
 * @property int            $id
 * @property string         $alias
 * @property string         $title
 * @property int            $sort
 * @property Model_Review[] $reviews - отзывы с такой формой занятости
 */
class EmploymentForm extends Model {

  const FULL = 'full';            # Постоянная занятость
  const PART = 'part';            # Частичная занятость
  const PROBATION = 'probation';  # Стажировка
  const REMOTE = 'remote';        # Удаленная работа
  const PROJECT = 'project';      # Проектная/Временная работа
  const VOLUNTEER = 'volunteer';  # Волонтерство
  const WATCH = 'watch';          # Вахтовый метод

  public static $all = [
    self::FULL,
    self::PART,
    self::PROBATION,
    self::REMOTE,
    self::PROJECT,
    self::VOLUNTEER,
    self::WATCH,
  ];

  //todo relation
  protected $_has_many = [
    'reviews' => [
      'model'       => 'Review',
      'foreign_key' => 'employment_alias',
    ],
  ];

}