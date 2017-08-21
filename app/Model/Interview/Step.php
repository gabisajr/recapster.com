<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Model_Interview_Step
 *
 * @property int                        id
 * @property string                     title      - название шага
 * @property string                     full_title - полное название
 * @property int                        sort       - поле сортировки
 *
 * @property Model_Interview_Step_Group group      - группа к которй относится данный шаг
 * @property int                        group_id
 */
class Model_Interview_Step extends ORM {

  protected $_belongs_to = [
    'group' => [
      'model'       => 'Interview_Step_Group',
      'foreign_key' => 'group_id',
    ],
  ];

}