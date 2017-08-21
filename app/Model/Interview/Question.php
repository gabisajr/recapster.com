<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Model_Interview_Question - вопрос собеседования
 *
 * @property int             id
 * @property string          text            - текст вопроса
 * @property int             number          - порядоковый номер вопроса в собеседовании
 * @property string          url             - ссылка на обсуждение вопроса (virtual)
 *
 * @property Model_Interview interview       - собеседование к которому относится вопрос
 * @property int             interview_id
 *
 * @property ORM             answers         - все ответы на вопрос
 *
 */
class Model_Interview_Question extends ORM {

  protected $_belongs_to = [
    'interview' => [
      'model'       => 'Interview',
      'foreign_key' => 'interview_id',
    ],
  ];

  protected $_has_many = [
    'answers' => [
      'model'       => 'Interview_Answer',
      'foreign_key' => 'question_id',
    ],
  ];

  public function filters() {
    return [
      'text' => [
        ['HTML::chars'],
      ],
    ];
  }

  public function get($column) {
    switch ($column) {
      case 'url':
        return $this->get_url();
        break;
    }
    return parent::get($column);
  }

  public function get_url($full = true) {
    $url = "";
    if ($full) $url .= "http://$_SERVER[HTTP_HOST]";
    $url .= "/@{$this->interview->company->alias}/interview/question/{$this->id}";
    return $url;
  }

  public function delete() {

    //delete answers
    foreach ($this->answers->find_all() as $answer) $answer->delete();

    return parent::delete();
  }

}