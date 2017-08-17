<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\EmploymentForm - форма занятости работника
 *
 * @property int $id
 * @property string|null $alias
 * @property string $title
 * @property int $sort
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\EmploymentForm whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\EmploymentForm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\EmploymentForm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\EmploymentForm whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\EmploymentForm whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\EmploymentForm whereUpdatedAt($value)
 * @mixin \Eloquent
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