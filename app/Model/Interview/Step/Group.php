<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Model_Interview_Step - группа шагов собеседования
 *
 * @property int                    id
 * @property string                 title
 * @property Model_Interview_Step[] steps - шаги собеседования
 */
class Model_Interview_Step_Group extends ORM {

  protected $_table_name = 'interview_steps_groups';

  protected $_has_many = [
    'steps' => [
      'model'       => 'Interview_Step',
      'foreign_key' => 'group_id',
    ],
  ];

}